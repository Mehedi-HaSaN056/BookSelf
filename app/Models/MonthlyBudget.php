<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MonthlyBudget extends Model {
    protected $fillable = ['year','month','budget_amount','notes'];
    public function getMonthNameAttribute() {
        return date('F', mktime(0,0,0,$this->month,1));
    }
    public function getActualSpentAttribute() {
        return Book::whereYear('purchase_date', $this->year)
                   ->whereMonth('purchase_date', $this->month)
                   ->sum('purchase_price');
    }
}
