<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPrivilege
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $privilege): Response
    {
        if (session()->has('staff_id')) {
            $staff = \App\Models\Staff::find(session('staff_id'));
            
            \Log::info('CheckPrivilege middleware hit.', [
                'session_staff_id' => session('staff_id'),
                'staff_found' => $staff ? true : false,
                'staff_session_id' => $staff ? $staff->session_id : null,
                'current_session_id' => session()->getId(),
                'request_url' => $request->url()
            ]);

            // Validate staff session
            if (!$staff || $staff->session_id !== session()->getId()) {
                \Log::warning('Staff session mismatch. Logging out.');
                auth()->logout();
                session()->flush();
                return redirect()->route('staff.login')->with('error', 'Your session has been terminated or logged in from another location.');
            }
            
            // Update last_active_at if it's been more than a minute
            if (!$staff->last_active_at || $staff->last_active_at->diffInMinutes(now()) >= 1) {
                $staff->update(['last_active_at' => now()]);
            }
            
            $privileges = $staff->privileges ?? [];
            
            if (!in_array($privilege, $privileges)) {
                \Log::info('Staff lacks privilege: ' . $privilege);
                // If this is an AJAX request, return JSON
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['error' => 'You do not have permission.'], 403);
                }

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

                // Redirect to the first available privilege they have
                foreach ($privileges as $p) {
                    if (isset($routeMap[$p])) {
                        \Log::info('Redirecting staff to available privilege: ' . $p);
                        return redirect()->route($routeMap[$p])->with('error', 'You do not have permission to access that page.');
                    }
                }

                // If no valid privileges found, log them out
                \Log::warning('No valid privileges found for staff. Logging out.');
                auth()->logout();
                session()->flush();
                return redirect()->route('login')->with('error', 'You have no assigned privileges.');
            }
        }
        
        return $next($request);
    }
}
