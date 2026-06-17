<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function payment()
    {
        $user = auth()->user();
        
        if ($user->type === 'admin') {
            return redirect()->route('admin.users.index');
        }
        if ($user->type === 'seller') {
            return redirect()->route('seller.dashboard');
        }

        $storeId = $user->type === 'store' ? $user->id : $user->parent_id;
        $storeUser = \App\Models\User::find($storeId);



        // 30-day Free Trial Check
        $isGracePeriod = false;
        if ($storeUser) {
            // Check if user was created within the last 30 days
            if ($storeUser->created_at && $storeUser->created_at->addDays(30)->isFuture()) {
                $isGracePeriod = true;
            }
        }

        $lastSubscription = \App\Models\Subscription::where('user_id', $storeId)->latest()->first();

        $isActive = false;
        if ($lastSubscription && $lastSubscription->status === 'active') {
            if (!$lastSubscription->end_date || now()->lessThanOrEqualTo($lastSubscription->end_date)) {
                $isActive = true;
            }
        }

        if ($isActive || $isGracePeriod) {
            return redirect()->route('dashboard');
        }

        $paymentRequest = \App\Models\PaymentRequest::where('user_id', $storeId)->latest()->first();

        $packages = null;
        if (!$storeUser->package_id || $storeUser->package_id == 1) {
            $packages = \App\Models\Package::where('id', '!=', 1)->where('status', 'active')->get();
        }

        return view('subscription.payment', compact('paymentRequest', 'packages', 'storeUser', 'lastSubscription'));
    }

    public function uploadProof(Request $request)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:5120',
            'description' => 'nullable|string|max:1000',
            'package_id' => 'nullable|exists:packages,id'
        ]);

        $user = auth()->user();
        $storeId = $user->type === 'store' ? $user->id : $user->parent_id;

        $store = \App\Models\User::find($storeId);
        
        $packageId = $store->package_id;
        if (!$packageId || $packageId == 1) {
            if (!$request->package_id) {
                return redirect()->back()->with('error', 'Please select a package to subscribe to.');
            }
            $packageId = $request->package_id;
            
            // Also update the store's package to the newly selected one
            $store->package_id = $packageId;
            $store->save();
        }

        $path = $request->file('payment_proof')->store('payments', 'public');

        \App\Models\PaymentRequest::create([
            'user_id' => $storeId,
            'package_id' => $packageId,
            'payment_proof' => $path,
            'description' => $request->description,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Payment screenshot uploaded! An administrator will review your payment and activate your subscription shortly.');
    }
}
