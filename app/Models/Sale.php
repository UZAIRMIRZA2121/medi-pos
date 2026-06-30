<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Sale extends Model {
    use \App\Traits\BelongsToStore;
    protected $guarded = [];
    public function customer() { return $this->belongsTo(Customer::class); }
    public function staff() { return $this->belongsTo(Staff::class, 'staff_id'); }
    public function items() { return $this->hasMany(SaleItem::class); }
}