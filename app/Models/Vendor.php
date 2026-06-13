<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model {
    protected $fillable = ['name','email','phone','address','website','notes'];
    public function books() { return $this->hasMany(Book::class); }
    public function getTotalSpentAttribute() {
        return $this->books->sum('purchase_price');
    }
}
