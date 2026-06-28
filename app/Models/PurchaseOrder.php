<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'supplier_id', 'user_id', 'order_number', 'status', 'total_items', 'total_amount', 'notes'
    ];

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    public function items() {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
