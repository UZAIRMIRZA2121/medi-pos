<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    protected $fillable = [
        'purchase_order_id', 'medicine_id', 'quantity', 'purchase_price', 'subtotal'
    ];

    public function order() {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    public function medicine() {
        return $this->belongsTo(Medicine::class);
    }
}
