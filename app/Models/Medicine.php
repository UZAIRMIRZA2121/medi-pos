<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Medicine extends Model {
    use \App\Traits\BelongsToStore, SoftDeletes;
    protected $guarded = [];
    public function category() { return $this->belongsTo(Category::class); }
    public function supplier() { return $this->belongsTo(Supplier::class); }
}