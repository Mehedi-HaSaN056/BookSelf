<?php
namespace App\Exports;
use App\Models\Vendor;
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, ShouldAutoSize};

class VendorsExport implements FromCollection, WithHeadings, ShouldAutoSize {
    public function collection() { return Vendor::withCount('books')->withSum('books','purchase_price')->get(); }
    public function headings(): array { return ['ID','Name','Email','Phone','Address','Website','Total Books','Total Spent','Notes']; }
}
