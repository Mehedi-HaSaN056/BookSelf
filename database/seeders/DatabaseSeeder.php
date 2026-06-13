<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\{Category, Vendor, Book};
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // Categories
        $categories = [
            ['name'=>'উপন্যাস','icon'=>'📖','color'=>'#6366f1'],
            ['name'=>'বিজ্ঞান','icon'=>'🔬','color'=>'#10b981'],
            ['name'=>'ইতিহাস','icon'=>'🏛️','color'=>'#f59e0b'],
            ['name'=>'আত্মজীবনী','icon'=>'👤','color'=>'#3b82f6'],
            ['name'=>'ধর্ম','icon'=>'🕌','color'=>'#8b5cf6'],
            ['name'=>'প্রযুক্তি','icon'=>'💻','color'=>'#ef4444'],
            ['name'=>'কবিতা','icon'=>'🎭','color'=>'#ec4899'],
            ['name'=>'শিশু সাহিত্য','icon'=>'🧸','color'=>'#14b8a6'],
        ];
        foreach ($categories as $cat) {
            Category::create(['name'=>$cat['name'],'slug'=>Str::slug($cat['name']),'icon'=>$cat['icon'],'color'=>$cat['color']]);
        }

        // Vendors
        $vendors = [
            ['name'=>'রকমারি','phone'=>'16297','website'=>'https://rokomari.com','address'=>'ঢাকা, বাংলাদেশ'],
            ['name'=>'বই বাজার','phone'=>'01700000000','address'=>'নীলক্ষেত, ঢাকা'],
            ['name'=>'Pathok Samabesh','phone'=>'01800000000','address'=>'বাংলাবাজার, ঢাকা'],
        ];
        foreach ($vendors as $v) { Vendor::create($v); }

        // Sample Books
        $books = [
            ['title'=>'পদ্মা নদীর মাঝি','author'=>'মানিক বন্দ্যোপাধ্যায়','category_id'=>1,'vendor_id'=>1,'purchase_price'=>320,'status'=>'completed','genre'=>'fiction','rating'=>5,'language'=>'Bangla','pages'=>280,'purchase_date'=>'2024-01-15'],
            ['title'=>'ব্রিফ হিস্ট্রি অব টাইম','author'=>'স্টিফেন হকিং','category_id'=>2,'vendor_id'=>1,'purchase_price'=>450,'status'=>'completed','genre'=>'science','rating'=>5,'language'=>'Bangla','pages'=>212,'purchase_date'=>'2024-02-10'],
            ['title'=>'হুমায়ূন আহমেদ রচনাসমগ্র','author'=>'হুমায়ূন আহমেদ','category_id'=>1,'vendor_id'=>2,'purchase_price'=>1200,'status'=>'reading','genre'=>'fiction','rating'=>4,'language'=>'Bangla','pages'=>890,'purchase_date'=>'2024-03-05'],
            ['title'=>'আমার ছেলেবেলা','author'=>'হুমায়ূন আহমেদ','category_id'=>4,'vendor_id'=>1,'purchase_price'=>280,'status'=>'completed','genre'=>'biography','rating'=>5,'language'=>'Bangla','pages'=>160,'purchase_date'=>'2024-04-20'],
            ['title'=>'Clean Code','author'=>'Robert C. Martin','category_id'=>6,'vendor_id'=>1,'purchase_price'=>800,'status'=>'reading','genre'=>'technology','rating'=>5,'language'=>'English','pages'=>464,'purchase_date'=>'2024-05-01'],
            ['title'=>'রবীন্দ্রনাথের কবিতা','author'=>'রবীন্দ্রনাথ ঠাকুর','category_id'=>7,'vendor_id'=>2,'purchase_price'=>350,'status'=>'to_read','genre'=>'poetry','language'=>'Bangla','pages'=>320,'purchase_date'=>'2024-06-10'],
            ['title'=>'Python Programming','author'=>'Mark Lutz','category_id'=>6,'vendor_id'=>1,'purchase_price'=>950,'status'=>'wishlist','genre'=>'technology','language'=>'English','pages'=>1594],
            ['title'=>'মুক্তিযুদ্ধের ইতিহাস','author'=>'মেজর রফিকুল ইসলাম','category_id'=>3,'vendor_id'=>3,'purchase_price'=>420,'status'=>'ordered','genre'=>'history','language'=>'Bangla','pages'=>380,'purchase_date'=>'2024-07-15'],
        ];
        foreach ($books as $b) { Book::create($b); }

        echo "Seeding complete!\n";
    }
}
