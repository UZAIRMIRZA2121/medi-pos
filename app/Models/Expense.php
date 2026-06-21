<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'store_id',
        'name',
        'amount',
        'desc',
        'img',
        'status',
        'paid_at'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function store()
    {
        return $this->belongsTo(\App\Models\User::class, 'store_id');
    }
}
