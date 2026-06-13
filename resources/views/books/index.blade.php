@extends('layouts.app')
@section('title','সব বই')
@section('content')
<div class="page-header">
  <div>
    <h1>📚 সব বই</h1>
    <p>মোট {{ $books->total() }} টি বই পাওয়া গেছে</p>
  </div>
  <div class="header-actions">
    <a href="{{ route('books.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> বই যোগ</a>
    <button onclick="document.getElementById('importModal').classList.add('show')" class="btn btn-info"><i class="fas fa-file-excel"></i> Excel Import</button>
    <a href="{{ route('books.export.excel') }}" class="btn btn-success"><i class="fas fa-download"></i> Excel Export</a>
    <a href="{{ route('books.export.pdf') }}" class="btn btn-danger"><i class="fas fa-file-pdf"></i> PDF</a>
  </div>
</div>

<!-- Filters -->
<div class="card" style="margin-bottom:20px">
  <div class="card-body">
    <form method="GET" action="{{ route('books.index') }}">
      <div class="filters-bar">
        <div class="filter-group">
          <label>🔍 খুঁজুন</label>
          <input type="text" name="search" value="{{ request('search') }}" placeholder="নাম, লেখক, ISBN...">
        </div>
        <div class="filter-group">
          <label>🏷️ Category</label>
          <select name="category">
            <option value="">সব Category</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ request('category')==$cat->id?'selected':'' }}>{{ $cat->icon }} {{ $cat->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="filter-group">
          <label>📊 Status</label>
          <select name="status">
            <option value="">সব Status</option>
            <option value="wishlist" {{ request('status')=='wishlist'?'selected':'' }}>🌟 Wishlist</option>
            <option value="ordered" {{ request('status')=='ordered'?'selected':'' }}>📦 Order দিয়েছি</option>
            <option value="to_read" {{ request('status')=='to_read'?'selected':'' }}>📚 পড়বো</option>
            <option value="reading" {{ request('status')=='reading'?'selected':'' }}>📖 পড়ছি</option>
            <option value="completed" {{ request('status')=='completed'?'selected':'' }}>✅ শেষ</option>
          </select>
        </div>
        <div class="filter-group">
          <label>🎭 Genre</label>
          <select name="genre">
            <option value="">সব Genre</option>
            @foreach(['fiction','non-fiction','science','history','biography','self-help','technology','religion','poetry','other'] as $g)
              <option value="{{ $g }}" {{ request('genre')==$g?'selected':'' }}>{{ ucfirst($g) }}</option>
            @endforeach
          </select>
        </div>
        <div class="filter-group">
          <label>⬆ Sort</label>
          <select name="sort">
            <option value="created_at" {{ request('sort')=='created_at'?'selected':'' }}>সর্বশেষ</option>
            <option value="title" {{ request('sort')=='title'?'selected':'' }}>শিরোনাম</option>
            <option value="author" {{ request('sort')=='author'?'selected':'' }}>লেখক</option>
            <option value="purchase_price" {{ request('sort')=='purchase_price'?'selected':'' }}>দাম</option>
            <option value="purchase_date" {{ request('sort')=='purchase_date'?'selected':'' }}>কেনার তারিখ</option>
          </select>
        </div>
        <div class="filter-group" style="justify-content:flex-end">
          <label>&nbsp;</label>
          <button type="submit" class="btn btn-primary">Filter করুন</button>
        </div>
        @if(request()->anyFilled(['search','category','status','genre']))
          <div class="filter-group" style="justify-content:flex-end">
            <label>&nbsp;</label>
            <a href="{{ route('books.index') }}" class="btn btn-outline">Reset</a>
          </div>
        @endif
      </div>
    </form>
  </div>
</div>

<!-- Books Grid -->
@if($books->isEmpty())
  <div style="text-align:center;padding:60px;color:var(--text-muted)">
    <div style="font-size:64px;margin-bottom:16px">📭</div>
    <h3 style="font-size:20px;margin-bottom:8px">কোনো বই পাওয়া যায়নি</h3>
    <p>নতুন বই যোগ করুন অথবা Excel থেকে Import করুন</p>
    <div style="display:flex;gap:12px;justify-content:center;margin-top:16px">
      <a href="{{ route('books.create') }}" class="btn btn-primary">বই যোগ করুন</a>
      <button onclick="document.getElementById('importModal').classList.add('show')" class="btn btn-info">Excel Import</button>
    </div>
  </div>
@else
<div class="books-grid">
  @foreach($books as $book)
  <div class="book-card">
    <div class="book-cover">
      @if($book->cover_image)
        <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}">
      @else
        📚
      @endif
      <span class="book-status-badge">{{ $book->status_label }}</span>
    </div>
    <div class="book-info">
      <div class="book-title">{{ $book->title }}</div>
      <div class="book-author"><i class="fas fa-pen-nib" style="font-size:11px"></i> {{ $book->author }}</div>
      @if($book->category)
        <div style="margin-bottom:6px">
          <span class="badge" style="background:{{ $book->category->color }}20;color:{{ $book->category->color }};border:1px solid {{ $book->category->color }}40;font-size:11px">
            {{ $book->category->icon }} {{ $book->category->name }}
          </span>
        </div>
      @endif
      <div class="book-meta">
        <span class="book-price">৳{{ number_format($book->purchase_price,0) }}</span>
        @if($book->rating)
          <span class="book-rating">{{ str_repeat('★',$book->rating) }}</span>
        @endif
      </div>
    </div>
    <div class="book-actions">
      <a href="{{ route('books.show',$book) }}" style="background:#e0e7ff;color:#4f46e5" title="দেখুন"><i class="fas fa-eye"></i></a>
      <a href="{{ route('books.edit',$book) }}" style="background:#fef3c7;color:#92400e" title="Edit"><i class="fas fa-edit"></i></a>
      <button onclick="deleteBook({{ $book->id }})" style="background:#fee2e2;color:#991b1b" title="Delete"><i class="fas fa-trash"></i></button>
    </div>
  </div>
  @endforeach
</div>
<div style="margin-top:24px">{{ $books->links() }}</div>
@endif

<!-- ===== IMPORT MODAL ===== -->
<div class="modal-overlay" id="importModal" style="display:flex ;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:2000;align-items:center;justify-content:center;">
  <div class="modal" style="background:#fff;border-radius:16px;padding:28px;max-width:580px;width:90%;box-shadow:0 20px 60px rgba(0,0,0,.2)">
    <div class="modal-header" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
      <div>
        <h3 style="font-size:20px;font-weight:700">📥 Excel থেকে বই Import করুন</h3>
        <p style="color:#64748b;font-size:13px;margin-top:4px">আপনার Excel/CSV ফাইল থেকে বই যোগ করুন</p>
      </div>
      <button onclick="document.getElementById('importModal').classList.remove('show');document.getElementById('importModal').style.display='none'" style="background:none;border:none;font-size:24px;cursor:pointer;color:#64748b;line-height:1">✕</button>
    </div>

    <!-- Excel Format Info -->
    <div style="background:#f0f9ff;border:1px solid #bae6fd;border-radius:10px;padding:14px;margin-bottom:18px">
      <p style="font-weight:700;color:#0369a1;margin-bottom:8px">📋 Excel এর Column গুলো এই ক্রমে থাকতে হবে:</p>
      <div style="display:flex;flex-wrap:wrap;gap:6px">
        @foreach(['title','author','isbn','category','genre','publisher','published_year','language','pages','purchase_price','market_price','purchase_date','status','rating','location','notes'] as $col)
          <span style="background:#e0f2fe;color:#0369a1;padding:3px 8px;border-radius:4px;font-size:12px;font-family:monospace">{{ $col }}</span>
        @endforeach
      </div>
      <p style="font-size:12px;color:#64748b;margin-top:8px">
        ⚠️ <strong>status</strong> এর মান: wishlist / ordered / to_read / reading / completed<br>
        ⚠️ <strong>purchase_date</strong> format: YYYY-MM-DD (যেমন: 2024-01-15)<br>
        ⚠️ প্রথম row তে heading থাকতে হবে
      </p>
    </div>

    <!-- Download Sample -->
    <div style="margin-bottom:18px">
      <a href="{{ route('books.sample.excel') }}" style="display:inline-flex;align-items:center;gap:6px;background:#f0fdf4;color:#166534;border:1px solid #86efac;padding:8px 14px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none">
        <i class="fas fa-download"></i> Sample Excel ডাউনলোড করুন
      </a>
      <span style="font-size:12px;color:#64748b;margin-left:8px">← এই format এ ফাইল তৈরি করুন</span>
    </div>

    <!-- Upload Form -->
    <form action="{{ route('books.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
      @csrf
      <div id="dropZone" style="border:2px dashed #6366f1;border-radius:12px;padding:32px;text-align:center;cursor:pointer;transition:all .2s;background:#fafafa" onclick="document.getElementById('importFile').click()">
        <div style="font-size:48px;margin-bottom:10px">📊</div>
        <h4 style="font-size:16px;font-weight:700;margin-bottom:6px">ফাইল টানুন অথবা Click করুন</h4>
        <p id="fileName" style="color:#64748b;font-size:13px">XLSX, XLS, CSV সমর্থিত (সর্বোচ্চ 5MB)</p>
        <input type="file" id="importFile" name="file" accept=".xlsx,.xls,.csv" style="display:none" required>
      </div>

      <div style="display:flex;gap:10px;margin-top:16px">
        <button type="submit" class="btn btn-primary" style="flex:1;padding:12px">
          <i class="fas fa-upload"></i> Import শুরু করুন
        </button>
        <button type="button" onclick="document.getElementById('importModal').style.display='none'" class="btn btn-outline" style="padding:12px 20px">বাতিল</button>
      </div>
    </form>
  </div>
</div>

@endsection

@push('scripts')
<script>
// Import Modal
document.getElementById('importFile').addEventListener('change', function() {
  if (this.files[0]) {
    document.getElementById('fileName').textContent = '✅ ' + this.files[0].name + ' নির্বাচিত';
    document.getElementById('dropZone').style.borderColor = '#10b981';
    document.getElementById('dropZone').style.background = '#f0fdf4';
  }
});

// Drag and drop
const dropZone = document.getElementById('dropZone');
dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.style.borderColor='#6366f1'; dropZone.style.background='#eef2ff'; });
dropZone.addEventListener('dragleave', () => { dropZone.style.borderColor='#6366f1'; dropZone.style.background='#fafafa'; });
dropZone.addEventListener('drop', e => {
  e.preventDefault();
  const file = e.dataTransfer.files[0];
  if (file) {
    const dt = new DataTransfer();
    dt.items.add(file);
    document.getElementById('importFile').files = dt.files;
    document.getElementById('fileName').textContent = '✅ ' + file.name + ' নির্বাচিত';
    dropZone.style.borderColor = '#10b981';
    dropZone.style.background = '#f0fdf4';
  }
});

// Close modal on overlay click
document.getElementById('importModal').addEventListener('click', function(e) {
  if (e.target === this) this.style.display = 'none';
});
</script>
@endpush
