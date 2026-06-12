<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function payment()
    {
        $user = auth()->user();
        $storeId = $user->type === 'store' ? $user->id : $user->parent_id;

        $paymentRequest = \App\Models\PaymentRequest::where('user_id', $storeId)->latest()->first();

        return view('subscription.payment', compact('paymentRequest'));
    }

    public function uploadProof(Request $request)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:5120',
            'description' => 'nullable|string|max:1000'
        ]);

        $user = auth()->user();
        $storeId = $user->type === 'store' ? $user->id : $user->parent_id;

        $store = \App\Models\User::find($storeId);
        if (!$store->package_id) {
            return redirect()->back()->with('error', 'You do not have an assigned package. Please contact admin to assign a package first.');
        }

        $path = $request->file('payment_proof')->store('payments', 'public');

        \App\Models\PaymentRequest::create([
            'user_id' => $storeId,
            'package_id' => $store->package_id,
            'payment_proof' => $path,
            'description' => $request->description,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Payment screenshot uploaded! An administrator will review your payment and activate your subscription shortly.');
    }
}
