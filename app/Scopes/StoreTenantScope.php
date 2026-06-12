<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class StoreTenantScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Admins can see all data
            if ($user->type === 'admin') {
                return;
            }
            
            // The store's ID is the tenant ID. 
            // If the user has a parent_id, they are staff for that parent store.
            $storeId = $user->parent_id ? $user->parent_id : $user->id;
            
            $builder->where($model->getTable() . '.user_id', $storeId);
        }
    }
}
