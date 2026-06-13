<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model {
    use SoftDeletes;
    protected $fillable = [
        'title','author','isbn','category_id','vendor_id','publisher',
        'published_year','language','pages','edition','purchase_price',
        'market_price','purchase_date','cover_image','status','genre',
        'rating','notes','description','location','is_ebook','ebook_path',
    ];
    protected $casts = [
        'purchase_date'=>'date','is_ebook'=>'boolean',
        'purchase_price'=>'decimal:2','market_price'=>'decimal:2',
    ];
    public function category() { return $this->belongsTo(Category::class); }
    public function vendor()   { return $this->belongsTo(Vendor::class); }
    public function readingLogs() { return $this->hasMany(ReadingLog::class); }

    public function getStatusLabelAttribute() {
        return match($this->status) {
            'wishlist'  => 'Wishlist',
            'ordered'   => 'Order Diyechi',
            'to_read'   => 'Porbo',
            'reading'   => 'Porcchi (In Progress)',
            'completed' => 'Sesh Korechi',
            default     => $this->status,
        };
    }
    public function getStatusColorAttribute() {
        return match($this->status) {
            'wishlist'  => '#f59e0b',
            'ordered'   => '#6366f1',
            'to_read'   => '#6b7280',
            'reading'   => '#3b82f6',
            'completed' => '#10b981',
            default     => '#6b7280',
        };
    }
    public function scopeSearch($query, $s) {
        return $query->where(function($q) use ($s) {
            $q->where('title','like',"%$s%")->orWhere('author','like',"%$s%")
              ->orWhere('isbn','like',"%$s%")->orWhere('publisher','like',"%$s%");
        });
    }
}
