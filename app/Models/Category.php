<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Category extends Model {
    use \App\Traits\BelongsToStore, SoftDeletes;
    protected $guarded = [];
    public function medicines() { return $this->hasMany(Medicine::class); }
}