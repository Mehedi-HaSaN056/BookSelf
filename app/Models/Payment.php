<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id', 'book_id', 'method', 'amount',
        'transaction_id', 'phone', 'status', 'notes',
        'vendor_name', 'vendor_phone', 'method_number', 'gateway_response',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function book() { return $this->belongsTo(Book::class); }
}