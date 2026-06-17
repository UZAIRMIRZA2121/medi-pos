<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckActiveSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if (!$user) {
            return $next($request);
        }

        if ($user->type === 'admin') {
            return $next($request);
        }

        // Allow access to subscription payment routes, profile, logout, etc.
        if ($request->is('subscription/payment*') || $request->is('profile*') || $request->is('logout')) {
            return $next($request);
        }

        $storeId = $user->type === 'store' ? $user->id : $user->parent_id;

        if ($storeId) {
            $storeUser = $user->type === 'store' ? $user : \App\Models\User::find($storeId);

            // 30-day grace period for ALL new users
            if ($storeUser) {
                // Check if user was created within the last 30 days
                if ($storeUser->created_at && $storeUser->created_at->addDays(30)->isFuture()) {
                    return $next($request);
                }
            }

            $subscription = \App\Models\Subscription::where('user_id', $storeId)
                ->where('status', 'active')
                ->latest()
                ->first();

            $isExpired = false;
            if ($subscription && $subscription->end_date) {
                if (now()->greaterThan($subscription->end_date)) {
                    $isExpired = true;
                }
            }

            if (!$subscription || $isExpired) {
                return redirect()->route('subscription.payment');
            }
        }

        return $next($request);
    }
}
