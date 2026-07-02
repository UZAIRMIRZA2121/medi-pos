<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.staff-login');
    }

    public function login(Request $request)
    {
        \Log::info('Staff login attempt:', ['email' => $request->email, 'otp' => $request->otp]);
        
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);

        $staff = Staff::where('email', $request->email)
                      ->where('otp', $request->otp)
                      ->whereNotNull('otp')
                      ->first();

        if (!$staff) {
            try {
                $apiUrl = config('app.cloud_api_url', 'http://127.0.0.1:8000/api');
                $response = \Illuminate\Support\Facades\Http::post($apiUrl . '/sync/verify-staff', [
                    'email' => $request->email,
                    'otp' => $request->otp,
                ]);

                if ($response->successful() && $response->json('status') === 'success') {
                    $staffData = $response->json('staff');
                    $userData = $response->json('user');

                    // 1. Create or update the Store Owner locally
                    \App\Models\User::updateOrCreate(
                        ['email' => $userData['email']],
                        [
                            'id' => $userData['id'],
                            'type' => $userData['type'] ?? 'owner',
                            'name' => $userData['name'],
                            'password' => $userData['password'], 
                        ]
                    );

                    // 2. Create or update the Staff member locally
                    $staff = Staff::updateOrCreate(
                        ['email' => $staffData['email']],
                        [
                            'id' => $staffData['id'],
                            'user_id' => $userData['id'],
                            'name' => $staffData['name'],
                            'role' => $staffData['role'] ?? 'staff',
                            'privileges' => $staffData['privileges'] ?? [],
                            'otp' => $staffData['otp'], // Valid OTP
                        ]
                    );

                    // 3. Force initial sync
                    \Illuminate\Support\Facades\Artisan::call('sync:run');
                }
            } catch (\Exception $e) {
                \Log::error('Cloud staff verification exception: ' . $e->getMessage());
            }
        }

        if ($staff) {
            \Log::info('Staff found, logging in user ID: ' . $staff->user_id);
            
            // Log in as the parent store user first (this regenerates the session ID!)
            Auth::loginUsingId($staff->user_id);
            
            $newSessionId = session()->getId();
            \Log::info('New session ID generated: ' . $newSessionId);

            // Nullify the OTP so it can't be reused, and set NEW session ID
            $staff->update([
                'otp' => null,
                'session_id' => $newSessionId,
                'last_active_at' => now()
            ]);

            // Store staff context in session
            session([
                'staff_id' => $staff->id,
                'staff_name' => $staff->name,
                'staff_role' => $staff->role,
            ]);

            \Log::info('Staff session variables set. Determining redirect route based on privileges.');
            
            $routeMap = [
                'dashboard' => 'dashboard',
                'pos' => 'pos.index',
                'invoices' => 'invoices.index',
                'sales_history' => 'sales.index',
                'expenses' => 'expenses.index',
                'medicines' => 'medicines.index',
                'categories' => 'categories.index',
                'alerts' => 'alerts.index',
                'purchase_orders' => 'purchase_orders.index',
                'suppliers' => 'suppliers.index',
                'customers' => 'customers.index',
                'staff' => 'staff.index',
                'settings_store' => 'settings.store',
                'profile' => 'profile.edit',
            ];

            $privileges = is_array($staff->privileges) ? $staff->privileges : json_decode($staff->privileges, true) ?? [];
            $redirectRoute = 'dashboard'; // fallback

            foreach ($privileges as $p) {
                if (isset($routeMap[$p])) {
                    $redirectRoute = $routeMap[$p];
                    break; // Pick the first available privilege
                }
            }

            return redirect()->route($redirectRoute)->with('success', 'Logged in successfully as ' . $staff->name);
        }

        \Log::info('Staff login failed (not found or OTP invalid).');
        return back()->withErrors([
            'email' => 'The provided email and OTP do not match our records or the OTP has expired.',
        ])->onlyInput('email');
    }
}
