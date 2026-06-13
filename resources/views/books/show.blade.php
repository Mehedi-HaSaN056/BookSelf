@extends('layouts.app')
@section('title',$book->title)
@section('content')
<div class="page-header">
  <div><h1>📖 বইয়ের বিস্তারিত</h1></div>
  <div class="header-actions">
    <a href="{{ route('books.edit',$book) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
    <button onclick="deleteBook({{ $book->id }})" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
    <a href="{{ route('books.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> ফিরে যান</a>
  </div>
</div>

<div class="book-detail">
  <!-- Cover -->
  <div>
    <div class="book-detail-cover">
      @if($book->cover_image)
        <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}">
      @else
        📚
      @endif
    </div>
    <!-- Quick Status Update -->
    <div class="card" style="margin-top:16px">
      <div class="card-body">
        <p style="font-size:13px;font-weight:700;margin-bottom:8px;color:var(--text-muted)">STATUS পরিবর্তন করুন</p>
        <form action="{{ route('books.status',$book) }}" method="POST">
          @csrf @method('PATCH')
          <select name="status" class="status-select" style="width:100%">
            <option value="wishlist" {{ $book->status=='wishlist'?'selected':'' }}>🌟 Wishlist</option>
            <option value="ordered" {{ $book->status=='ordered'?'selected':'' }}>📦 Order দিয়েছি</option>
            <option value="to_read" {{ $book->status=='to_read'?'selected':'' }}>📚 পড়বো</option>
            <option value="reading" {{ $book->status=='reading'?'selected':'' }}>📖 পড়ছি</option>
            <option value="completed" {{ $book->status=='completed'?'selected':'' }}>✅ শেষ</option>
          </select>
        </form>
      </div>
    </div>
  </div>

  <!-- Details -->
  <div>
    <div class="card">
      <div class="card-header">
        <div>
          <h2 style="font-size:22px">{{ $book->title }}</h2>
          <p style="color:var(--text-muted);margin-top:4px">by {{ $book->author }}</p>
        </div>
        <span class="badge" style="background:{{ $book->status_color }}20;color:{{ $book->status_color }};border:1px solid {{ $book->status_color }}40">{{ $book->status_label }}</span>
      </div>
      <div class="card-body">
        @if($book->rating)
          <div style="margin-bottom:16px">
            <span class="stars" style="font-size:22px">{{ str_repeat('★',$book->rating) }}{{ str_repeat('☆',5-$book->rating) }}</span>
            <span style="color:var(--text-muted);font-size:13px;margin-left:8px">{{ $book->rating }}/5</span>
          </div>
        @endif
        <div class="info-grid">
          @if($book->category)
          <div class="info-item">
            <label>🏷️ Category</label>
            <span>{{ $book->category->icon }} {{ $book->category->name }}</span>
          </div>
          @endif
          <div class="info-item">
            <label>🎭 Genre</label>
            <span>{{ ucfirst($book->genre) }}</span>
          </div>
          @if($book->isbn)
          <div class="info-item">
            <label>🔢 ISBN</label>
            <span>{{ $book->isbn }}</span>
          </div>
          @endif
          @if($book->publisher)
          <div class="info-item">
            <label>🏢 প্রকাশনী</label>
            <span>{{ $book->publisher }}</span>
          </div>
          @endif
          @if($book->published_year)
          <div class="info-item">
            <label>📅 প্রকাশ সাল</label>
            <span>{{ $book->published_year }}</span>
          </div>
          @endif
          <div class="info-item">
            <label>🌐 ভাষা</label>
            <span>{{ $book->language }}</span>
          </div>
          @if($book->pages)
          <div class="info-item">
            <label>📄 পৃষ্ঠা</label>
            <span>{{ $book->pages }} পৃষ্ঠা</span>
          </div>
          @endif
          @if($book->edition)
          <div class="info-item">
            <label>📋 সংস্করণ</label>
            <span>{{ $book->edition }}</span>
          </div>
          @endif
          <div class="info-item">
            <label>💰 ক্রয় মূল্য</label>
            <span style="color:var(--primary);font-weight:700">৳{{ number_format($book->purchase_price,2) }}</span>
          </div>
          @if($book->market_price)
          <div class="info-item">
            <label>🏷️ বাজার মূল্য</label>
            <span>৳{{ number_format($book->market_price,2) }}</span>
          </div>
          @endif
          @if($book->purchase_date)
          <div class="info-item">
            <label>🗓️ কেনার তারিখ</label>
            <span>{{ $book->purchase_date->format('d M Y') }}</span>
          </div>
          @endif
          @if($book->vendor)
          <div class="info-item">
            <label>🏪 Vendor</label>
            <span>{{ $book->vendor->name }}</span>
          </div>
          @endif
          @if($book->location)
          <div class="info-item">
            <label>📍 শেলফের স্থান</label>
            <span>{{ $book->location }}</span>
          </div>
          @endif
          <div class="info-item">
            <label>💻 ই-বুক</label>
            <span>{{ $book->is_ebook ? '✅ হ্যাঁ' : '❌ না' }}</span>
          </div>
        </div>
        @if($book->description)
          <div style="margin-top:20px;padding-top:20px;border-top:1px solid var(--border)">
            <h4 style="margin-bottom:8px;font-size:14px;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted)">📝 বইয়ের বিবরণ</h4>
            <p style="line-height:1.7;color:var(--text)">{{ $book->description }}</p>
          </div>
        @endif
        @if($book->notes)
          <div style="margin-top:16px;padding:16px;background:#f8fafc;border-radius:8px;border-left:4px solid var(--primary)">
            <h4 style="margin-bottom:8px;font-size:14px;color:var(--text-muted)">💬 আমার নোট</h4>
            <p style="line-height:1.7">{{ $book->notes }}</p>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
