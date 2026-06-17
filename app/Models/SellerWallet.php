<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerWallet extends Model
{
    protected $fillable = [
        'seller_id',
        'store_id',
        'subscription_id',
        'c_amount',
        'status',
        'receipt_image',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function store()
    {
        return $this->belongsTo(User::class, 'store_id');
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
