<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>BookShelf - Book List</title>
<style>
body { font-family: 'SolaimanLipi', 'Bangla', sans-serif; font-size:11px; color:#333; }
h1 { font-size:18px; text-align:center; margin-bottom:4px; }
.subtitle { text-align:center; color:#666; margin-bottom:16px; }
table { width:100%; border-collapse:collapse; }
th { background:#4f46e5; color:#fff; padding:8px 6px; text-align:left; font-size:10px; }
td { padding:7px 6px; border-bottom:1px solid #eee; font-size:10px; }
tr:nth-child(even) td { background:#f8fafc; }
.footer { margin-top:20px; text-align:center; color:#999; font-size:10px; }
</style>
</head>
<body>
<h1>📚 BookShelf - আমার বইয়ের তালিকা</h1>
<p class="subtitle">Generated: {{ date('d M Y') }} | Total Books: {{ $books->count() }}</p>
<table>
<thead>
  <tr><th>#</th><th>বইয়ের নাম</th><th>লেখক</th><th>Category</th><th>Status</th><th>দাম</th><th>কেনার তারিখ</th><th>Vendor</th></tr>
</thead>
<tbody>
@foreach($books as $i=>$book)
<tr>
  <td>{{ $i+1 }}</td>
  <td><strong>{{ $book->title }}</strong></td>
  <td>{{ $book->author }}</td>
  <td>{{ $book->category?->name ?? '-' }}</td>
  <td>{{ $book->status_label }}</td>
  <td>৳{{ number_format($book->purchase_price,2) }}</td>
  <td>{{ $book->purchase_date?->format('d/m/Y') ?? '-' }}</td>
  <td>{{ $book->vendor?->name ?? '-' }}</td>
</tr>
@endforeach
</tbody>
<tfoot>
<tr><td colspan="5" style="text-align:right;font-weight:bold">মোট:</td><td colspan="3" style="font-weight:bold">৳{{ number_format($books->sum('purchase_price'),2) }}</td></tr>
</tfoot>
</table>
<p class="footer">BookShelf - Personal Library Management System | {{ date('Y') }}</p>
</body>
</html>
