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
        // if ($package && !$package->lifetime_license && $package->billing_type !== 'one_time') {
            if ($package->active_days > 0) {
                $endDate = now()->addDays($package->active_days);
            } else {
                // Fallback just in case active_days is 0 but it's not a lifetime license
                $endDate = now()->addMonth();
            }
        // }

        $subscription = Subscription::create([
            'user_id' => $paymentRequest->user_id,
            'package_id' => $paymentRequest->package_id,
            'start_date' => now(),
            'end_date' => $endDate,
            'amount' => $package ? $package->price : 0,
            'status' => 'active',
        ]);

        // Generate seller commission if applicable (Only on First Payment)
        $storeUser = $paymentRequest->user;
        if ($storeUser && $storeUser->parent_id && $package && $package->commission > 0) {
            $seller = \App\Models\User::find($storeUser->parent_id);
            if ($seller && $seller->type === 'seller') {
                // Check if seller already received commission for this store
                $alreadyGenerated = \App\Models\SellerWallet::where('store_id', $storeUser->id)->exists();
                
                if (!$alreadyGenerated) {
                    \App\Models\SellerWallet::create([
                        'seller_id' => $seller->id,
                        'store_id' => $storeUser->id,
                        'subscription_id' => $subscription->id,
                        'c_amount' => $package->commission,
                        'status' => 'unpaid'
                    ]);
                }
            }
        }

        $endDateString = $endDate ? $endDate->format('M d, Y') : 'Lifetime';
        return back()->with('success', "Payment approved and subscription activated! The end date is now $endDateString.");
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
