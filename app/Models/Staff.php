<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'otp',
        'role',
        'privileges',
        'session_id',
        'last_active_at',
    ];

    protected $casts = [
        'privileges' => 'array',
        'last_active_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
