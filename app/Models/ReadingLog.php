<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ReadingLog extends Model {
    protected $fillable = ['book_id','start_date','end_date','pages_read','notes'];
    protected $casts = ['start_date'=>'date','end_date'=>'date'];
    public function book() { return $this->belongsTo(Book::class); }
}
