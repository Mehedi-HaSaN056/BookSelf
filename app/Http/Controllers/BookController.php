<?php
namespace App\Http\Controllers;
use App\Models\{Book, Category, Vendor};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BooksExport;
use App\Imports\BooksImport;
use Barryvdh\DomPDF\Facade\Pdf;

class BookController extends Controller {

    public function index(Request $request) {
        $query = Book::with(['category','vendor']);
        if ($request->search)   $query->where(function($q) use ($request) {
            $q->where('title','like',"%{$request->search}%")->orWhere('author','like',"%{$request->search}%")->orWhere('isbn','like',"%{$request->search}%");
        });
        if ($request->category) $query->where('category_id', $request->category);
        if ($request->status)   $query->where('status', $request->status);
        if ($request->genre)    $query->where('genre', $request->genre);
        $books      = $query->orderBy(request('sort','created_at'), 'desc')->paginate(12)->appends($request->all());
        $categories = Category::all();
        $vendors    = Vendor::all();
        return view('books.index', compact('books','categories','vendors'));
    }

    public function create() {
        $categories = Category::all();
        $vendors    = Vendor::all();
        return view('books.create', compact('categories','vendors'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'author'         => 'required|string|max:255',
            'isbn'           => 'nullable|string|unique:books',
            'category_id'    => 'nullable|exists:categories,id',
            'vendor_id'      => 'nullable|exists:vendors,id',
            'publisher'      => 'nullable|string|max:255',
            'published_year' => 'nullable|integer|min:1000|max:'.date('Y'),
            'language'       => 'nullable|string|max:50',
            'pages'          => 'nullable|integer|min:1',
            'edition'        => 'nullable|string|max:50',
            'purchase_price' => 'nullable|numeric|min:0',
            'market_price'   => 'nullable|numeric|min:0',
            'purchase_date'  => 'nullable|date',
            'cover_image'    => 'nullable|image|max:2048',
            'status'         => 'required|in:wishlist,ordered,to_read,reading,completed',
            'genre'          => 'nullable|string|max:50',
            'rating'         => 'nullable|integer|min:1|max:5',
            'notes'          => 'nullable|string',
            'description'    => 'nullable|string',
            'location'       => 'nullable|string|max:100',
            'is_ebook'       => 'boolean',
        ]);
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('covers','public');
        }
        $validated['is_ebook'] = $request->boolean('is_ebook');
        $book = Book::create($validated);
        return redirect()->route('books.show', $book)->with('success','বই সফলভাবে যোগ হয়েছে!');
    }

    public function show(Book $book) {
        $book->load(['category','vendor','readingLogs']);
        return view('books.show', compact('book'));
    }

    public function edit(Book $book) {
        $categories = Category::all();
        $vendors    = Vendor::all();
        return view('books.edit', compact('book','categories','vendors'));
    }

    public function update(Request $request, Book $book) {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'author'         => 'required|string|max:255',
            'isbn'           => 'nullable|string|unique:books,isbn,'.$book->id,
            'category_id'    => 'nullable|exists:categories,id',
            'vendor_id'      => 'nullable|exists:vendors,id',
            'publisher'      => 'nullable|string|max:255',
            'published_year' => 'nullable|integer|min:1000|max:'.date('Y'),
            'language'       => 'nullable|string|max:50',
            'pages'          => 'nullable|integer|min:1',
            'edition'        => 'nullable|string|max:50',
            'purchase_price' => 'nullable|numeric|min:0',
            'market_price'   => 'nullable|numeric|min:0',
            'purchase_date'  => 'nullable|date',
            'cover_image'    => 'nullable|image|max:2048',
            'status'         => 'required|in:wishlist,ordered,to_read,reading,completed',
            'genre'          => 'nullable|string|max:50',
            'rating'         => 'nullable|integer|min:1|max:5',
            'notes'          => 'nullable|string',
            'description'    => 'nullable|string',
            'location'       => 'nullable|string|max:100',
            'is_ebook'       => 'boolean',
        ]);
        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) Storage::disk('public')->delete($book->cover_image);
            $validated['cover_image'] = $request->file('cover_image')->store('covers','public');
        }
        $validated['is_ebook'] = $request->boolean('is_ebook');
        $book->update($validated);
        return redirect()->route('books.show', $book)->with('success','বই আপডেট হয়েছে!');
    }

    public function destroy(Book $book) {
        if ($book->cover_image) Storage::disk('public')->delete($book->cover_image);
        $book->delete();
        return redirect()->route('books.index')->with('success','বই মুছে ফেলা হয়েছে!');
    }

    public function exportExcel() {
        return Excel::download(new BooksExport, 'bookshelf_'.date('Y-m-d').'.xlsx');
    }

    public function exportPdf() {
        $books = Book::with(['category','vendor'])->orderBy('title')->get();
        $pdf = Pdf::loadView('reports.books_pdf', compact('books'))->setPaper('a4','landscape');
        return $pdf->download('bookshelf_'.date('Y-m-d').'.pdf');
    }

    public function importExcel(Request $request) {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv|max:5120']);
        try {
            Excel::import(new BooksImport, $request->file('file'));
            return back()->with('success','বই সফলভাবে import হয়েছে!');
        } catch (\Exception $e) {
            return back()->with('error','Import এ সমস্যা হয়েছে: '.$e->getMessage());
        }
    }

    public function sampleExcel() {
        // Generate a sample Excel file for download
        return Excel::download(new \App\Exports\SampleBooksExport, 'sample_books_import.xlsx');
    }

    public function updateStatus(Request $request, Book $book) {
        $request->validate(['status' => 'required|in:wishlist,ordered,to_read,reading,completed']);
        $book->update(['status' => $request->status]);
        return back()->with('success','Status আপডেট হয়েছে!');
    }
}
