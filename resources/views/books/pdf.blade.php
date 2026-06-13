<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>BookShelf Export</title>
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #333; }
    h1 { text-align: center; color: #4f46e5; margin-bottom: 4px; font-size: 18px; }
    .subtitle { text-align: center; color: #888; margin-bottom: 16px; font-size: 10px; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #4f46e5; color: #fff; padding: 6px 8px; text-align: left; font-size: 9px; }
    td { padding: 5px 8px; border-bottom: 1px solid #e2e8f0; }
    tr:nth-child(even) td { background: #f8f9ff; }
    .badge { display: inline-block; padding: 2px 6px; border-radius: 3px; font-size: 8px; font-weight: bold; }
    .status-reading { background: #dbeafe; color: #1d4ed8; }
    .status-completed { background: #dcfce7; color: #15803d; }
    .status-wishlist { background: #f1f5f9; color: #475569; }
    .status-ordered { background: #e0f2fe; color: #0369a1; }
    .status-paused { background: #fee2e2; color: #b91c1c; }
</style>
</head>
<body>
<h1>📚 BookShelf — Personal Library</h1>
<p class="subtitle">Exported on {{ now()->format('d M Y, H:i') }} | Total: {{ $books->count() }} books</p>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Author</th>
            <th>Category</th>
            <th>Status</th>
            <th>Price (৳)</th>
            <th>Purchase Date</th>
            <th>Rating</th>
        </tr>
    </thead>
    <tbody>
        @foreach($books as $i => $book)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td><strong>{{ $book->title }}</strong></td>
            <td>{{ $book->author }}</td>
            <td>{{ $book->category->name ?? '-' }}</td>
            <td><span class="badge status-{{ $book->status }}">{{ $book->status_label }}</span></td>
            <td>{{ number_format($book->purchase_price, 0) }}</td>
            <td>{{ $book->purchase_date?->format('d/m/Y') ?? '-' }}</td>
            <td>{{ $book->rating ? str_repeat('★', $book->rating) : '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<p style="text-align:right;margin-top:12px;color:#888;font-size:9px;">Total Spent: ৳{{ number_format($books->sum('purchase_price'), 2) }}</p>
</body>
</html>
