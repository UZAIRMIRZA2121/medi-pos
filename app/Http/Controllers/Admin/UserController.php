<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        // Get all users, potentially paginated if there are many. We'll use all for now as per POS scale, or paginate.
        $users = User::with(['package', 'parent', 'subscriptions'])->latest()->get()->where('type', '!=', 'admin');
        $packages = \App\Models\Package::orderBy('name')->get();
        return view('admin.users.index', compact('users', 'packages'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'type' => ['required', 'string', 'in:admin,store,pharmacist,cashier'], // Adjust roles as per your system
            'password' => ['nullable', 'string', 'min:8'],
            'package_id' => ['nullable', 'integer'],
            'parent_id' => ['nullable', 'integer'],
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'type' => $validated['type'],
            'package_id' => $validated['package_id'] ?? null,
            'parent_id' => $validated['parent_id'] ?? null,
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $oldPackageId = $user->package_id;
        $user->update($data);

        // Manage subscription if package changed
        if ($oldPackageId != $user->package_id && $user->package_id) {
            $package = \App\Models\Package::find($user->package_id);
            if ($package) {
                // Mark previous active subscriptions as inactive
                \App\Models\Subscription::where('user_id', $user->id)
                    ->where('status', 'active')
                    ->update(['status' => 'inactive']);

                // Determine end_date
                $endDate = null;
                if (!$package->lifetime_license && $package->billing_type !== 'one_time') {
                    if ($package->billing_type === 'monthly') {
                        $endDate = now()->addMonth();
                    } elseif ($package->billing_type === 'yearly') {
                        $endDate = now()->addYear();
                    }
                }

                \App\Models\Subscription::create([
                    'user_id' => $user->id,
                    'package_id' => $package->id,
                    'start_date' => now(),
                    'end_date' => $endDate,
                    'amount' => $package->price,
                    'status' => 'active',
                ]);
            }
        } elseif ($oldPackageId != $user->package_id && is_null($user->package_id)) {
            // Package was removed, cancel active subscriptions
            \App\Models\Subscription::where('user_id', $user->id)
                ->where('status', 'active')
                ->update(['status' => 'inactive']);
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Toggle the active subscription via AJAX.
     */
    public function toggleSubscription(Request $request, User $user)
    {
        $subscription = \App\Models\Subscription::where('user_id', $user->id)->latest()->first();
        
        if ($subscription) {
            $newStatus = $subscription->status === 'active' ? 'inactive' : 'active';
            
            // Ensure only one active subscription
            if ($newStatus === 'active') {
                \App\Models\Subscription::where('user_id', $user->id)
                    ->where('status', 'active')
                    ->update(['status' => 'inactive']);
            }
            
            $subscription->status = $newStatus;
            $subscription->save();
            
            return response()->json([
                'success' => true, 
                'status' => $newStatus,
                'message' => 'Subscription status updated to ' . $newStatus
            ]);
        }
        
        return response()->json(['success' => false, 'message' => 'No subscription found for this user'], 404);
    }
}
