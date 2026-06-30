<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessSetting extends Model
{
    protected $fillable = [
        'user_id',
        'tax',
        'discount',
        'auto_print',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
