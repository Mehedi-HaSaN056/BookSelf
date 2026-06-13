<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SampleBooksExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    public function headings(): array {
        return [
            'title', 'author', 'isbn', 'category', 'genre', 'publisher',
            'published_year', 'language', 'pages', 'purchase_price',
            'market_price', 'purchase_date', 'status', 'rating', 'location', 'notes'
        ];
    }

    public function array(): array {
        return [
            [
                'পদ্মা নদীর মাঝি',
                'মানিক বন্দ্যোপাধ্যায়',
                '978-984-00-0001-1',
                'উপন্যাস',
                'fiction',
                'বিশ্বসাহিত্য কেন্দ্র',
                '1936',
                'Bangla',
                '280',
                '320',
                '450',
                '2024-01-15',
                'completed',
                '5',
                'Shelf A, Row 1',
                'অসাধারণ বই'
            ],
            [
                'Clean Code',
                'Robert C. Martin',
                '978-0-13-235088-4',
                'প্রযুক্তি',
                'technology',
                'Prentice Hall',
                '2008',
                'English',
                '464',
                '800',
                '1200',
                '2024-02-20',
                'reading',
                '4',
                'Shelf B, Row 2',
                'Must read for developers'
            ],
            [
                'হুমায়ূন আহমেদ সমগ্র',
                'হুমায়ূন আহমেদ',
                '',
                'উপন্যাস',
                'fiction',
                'অনন্যা',
                '2010',
                'Bangla',
                '500',
                '600',
                '800',
                '2024-03-10',
                'to_read',
                '',
                '',
                ''
            ],
        ];
    }

    public function styles(Worksheet $sheet) {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '6366f1']], 'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']]],
        ];
    }
}
