<?php
namespace App\Http\Controllers;
use App\Models\{Book, Category, Vendor, MonthlyBudget};
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {
    public function __construct() { $this->middleware('auth'); }

    public function index() {
        $stats = [
            'total_books'      => Book::count(),
            'total_spent'      => Book::sum('purchase_price'),
            'completed'        => Book::where('status','completed')->count(),
            'reading'          => Book::where('status','reading')->count(),
            'wishlist'         => Book::where('status','wishlist')->count(),
            'to_read'          => Book::where('status','to_read')->count(),
            'ordered'          => Book::where('status','ordered')->count(),
            'total_categories' => Category::count(),
            'total_vendors'    => Vendor::count(),
        ];
        $genreStats    = Book::selectRaw('genre, count(*) as count')->groupBy('genre')->orderByDesc('count')->get();
        $categoryStats = Category::withCount('books')->orderByDesc('books_count')->take(8)->get();
        $monthlySpend  = Book::selectRaw('MONTH(purchase_date) as month, SUM(purchase_price) as total')
            ->whereNotNull('purchase_date')->whereYear('purchase_date', date('Y'))
            ->groupBy('month')->orderBy('month')->get();
        $recentBooks    = Book::with('category')->latest()->take(8)->get();
        $currentBudget  = MonthlyBudget::where('year', date('Y'))->where('month', date('n'))->first();
        $thisMonthSpent = Book::whereYear('purchase_date', date('Y'))->whereMonth('purchase_date', date('n'))->sum('purchase_price');
        return view('dashboard.index', compact(
            'stats','genreStats','categoryStats','monthlySpend','recentBooks','currentBudget','thisMonthSpent'
        ));
    }
}