# 📚 BookShelf - Personal Book Library

## ⚡ XAMPP এ Setup (Windows)

### Step 1 — PHP GD Extension চালু করুন
`C:\xampp\php\php.ini` ফাইল খুলুন, খুঁজুন ও সেমিকোলন সরান:
```
;extension=gd   →   extension=gd
;extension=zip  →   extension=zip
```
XAMPP Apache **Restart** করুন।

### Step 2 — phpMyAdmin এ Database তৈরি
```
Database name: bookshelf_db
Collation: utf8mb4_unicode_ci
```

### Step 3 — .env ফাইল সেট করুন
```
DB_DATABASE=bookshelf_db
DB_USERNAME=root
DB_PASSWORD=        ← XAMPP এ সাধারণত খালি
```

### Step 4 — Terminal এ চালান (project folder এ)
```bash
composer update --ignore-platform-req=ext-gd
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan serve
```

### Step 5 — Browser এ খুলুন
```
http://localhost:8000
```

---
## Features
- ✅ বই Add/Edit/View/Delete + Cover Image Upload
- ✅ Category ও Vendor Management
- ✅ Excel Export/Import ও PDF Download
- ✅ Dashboard: Genre chart, Monthly spend chart
- ✅ Monthly Budget Tracking
- ✅ Status: Wishlist / Ordered / To Read / Reading / Completed
- ✅ Search & Filter (Category, Genre, Vendor, Status)
- ✅ Star Rating ও Shelf Location

## Excel Import Format (Books)
| Column | Example |
|--------|---------|
| title | পদ্মা নদীর মাঝি |
| author | মানিক বন্দ্যোপাধ্যায় |
| category | উপন্যাস |
| genre | fiction |
| purchase_price | 320 |
| status | reading |

## Tech Stack
- Laravel 10 + MySQL
- HTML/CSS/JS (Vanilla, no framework)
- maatwebsite/excel (Excel)
- barryvdh/laravel-dompdf (PDF)
