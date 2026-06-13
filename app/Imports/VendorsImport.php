<?php
namespace App\Imports;
use App\Models\Vendor;
use Maatwebsite\Excel\Concerns\{ToModel, WithHeadingRow};

class VendorsImport implements ToModel, WithHeadingRow {
    public function model(array $row) {
        return new Vendor(['name'=>$row['name']??'','email'=>$row['email']??null,'phone'=>$row['phone']??null,'address'=>$row['address']??null,'website'=>$row['website']??null,'notes'=>$row['notes']??null]);
    }
}
