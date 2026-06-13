<?php
namespace App\Exports;
use App\Models\Book;
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping, ShouldAutoSize};

class BooksExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize {
    public function collection() {
        return Book::with(['category','vendor'])->orderBy('title')->get();
    }
    public function headings(): array {
        return ['ID','Title','Author','ISBN','Category','Genre','Publisher','Year','Language','Pages','Edition','Purchase Price','Market Price','Purchase Date','Status','Rating','Location','Vendor','Notes','Created At'];
    }
    public function map($book): array {
        return [$book->id,$book->title,$book->author,$book->isbn,$book->category?->name,$book->genre,$book->publisher,$book->published_year,$book->language,$book->pages,$book->edition,$book->purchase_price,$book->market_price,$book->purchase_date?->format('Y-m-d'),$book->status,$book->rating,$book->location,$book->vendor?->name,$book->notes,$book->created_at->format('Y-m-d')];
    }
}
