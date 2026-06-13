<?php
namespace App\Imports;
use App\Models\{Book, Category};
use Maatwebsite\Excel\Concerns\{ToModel, WithHeadingRow, SkipsOnError, SkipsErrors};

class BooksImport implements ToModel, WithHeadingRow, SkipsOnError {
    use SkipsErrors;
    public function model(array $row) {
        $category = null;
        if (!empty($row['category'])) {
            $category = Category::firstOrCreate(['name'=>$row['category']],['slug'=>\Str::slug($row['category']),'color'=>'#3B82F6','icon'=>'📚']);
        }
        return new Book([
            'title'          => $row['title'] ?? '',
            'author'         => $row['author'] ?? '',
            'isbn'           => $row['isbn'] ?? null,
            'category_id'    => $category?->id,
            'genre'          => $row['genre'] ?? 'other',
            'publisher'      => $row['publisher'] ?? null,
            'published_year' => $row['year'] ?? null,
            'language'       => $row['language'] ?? 'Bangla',
            'pages'          => $row['pages'] ?? null,
            'purchase_price' => $row['purchase_price'] ?? 0,
            'market_price'   => $row['market_price'] ?? 0,
            'purchase_date'  => $row['purchase_date'] ?? null,
            'status'         => $row['status'] ?? 'to_read',
            'notes'          => $row['notes'] ?? null,
        ]);
    }
}
