<?php

namespace App\Traits;

use App\Scopes\StoreTenantScope;
use Illuminate\Support\Facades\Auth;

trait BelongsToStore
{
    protected static function bootBelongsToStore()
    {
        static::addGlobalScope(new StoreTenantScope);

        static::creating(function ($model) {
            if (Auth::check() && !$model->user_id) {
                $user = Auth::user();
                $storeId = $user->parent_id ? $user->parent_id : $user->id;
                $model->user_id = $storeId;
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
