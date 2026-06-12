<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PaymentRequest;
use App\Models\Subscription;

class PaymentRequestController extends Controller
{
    public function index()
    {
        $requests = PaymentRequest::with(['user', 'package'])->latest()->get();
        return view('admin.payments.index', compact('requests'));
    }

    public function approve(PaymentRequest $paymentRequest)
    {
        $paymentRequest->update(['status' => 'approved']);

        // Mark previous active subscriptions as inactive
        Subscription::where('user_id', $paymentRequest->user_id)
            ->where('status', 'active')
            ->update(['status' => 'inactive']);

        $package = $paymentRequest->package;
        $endDate = null;
        if ($package && !$package->lifetime_license && $package->billing_type !== 'one_time') {
            if ($package->billing_type === 'monthly') {
                $endDate = now()->addMonth();
            } elseif ($package->billing_type === 'yearly') {
                $endDate = now()->addYear();
            }
        }

        Subscription::create([
            'user_id' => $paymentRequest->user_id,
            'package_id' => $paymentRequest->package_id,
            'start_date' => now(),
            'end_date' => $endDate,
            'amount' => $package ? $package->price : 0,
            'status' => 'active',
        ]);

        return back()->with('success', 'Payment approved and subscription activated.');
    }

    public function reject(Request $request, PaymentRequest $paymentRequest)
    {
        $request->validate(['admin_feedback' => 'required|string']);
        $paymentRequest->update([
            'status' => 'rejected',
            'admin_feedback' => $request->admin_feedback,
        ]);

        return back()->with('success', 'Payment rejected.');
    }
}
