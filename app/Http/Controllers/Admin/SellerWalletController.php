<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SellerWallet;
use Illuminate\Http\Request;

class SellerWalletController extends Controller
{
    public function index()
    {
        $wallets = SellerWallet::with(['seller', 'store', 'subscription.package'])
            ->latest()
            ->get();

        return view('admin.wallets.index', compact('wallets'));
    }

    public function markAsPaid(Request $request, SellerWallet $wallet)
    {
        $request->validate([
            'receipt_image' => 'nullable|image|max:5120'
        ]);

        $data = ['status' => 'paid'];

        if ($request->hasFile('receipt_image')) {
            $path = $request->file('receipt_image')->store('receipts', 'public');
            $data['receipt_image'] = $path;
        }

        $wallet->update($data);

        return back()->with('success', 'Commission marked as paid successfully.');
    }
}
