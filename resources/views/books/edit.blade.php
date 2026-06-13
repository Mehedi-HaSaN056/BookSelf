@extends('layouts.app')
@section('title','বই Edit করুন')
@section('content')
<div class="page-header">
  <div><h1>✏️ বই Edit করুন</h1><p>{{ $book->title }}</p></div>
  <a href="{{ route('books.show',$book) }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> ফিরে যান</a>
</div>
<div class="card">
  <div class="card-body">
    <form action="{{ route('books.update',$book) }}" method="POST" enctype="multipart/form-data">
      @csrf @method('PUT')
      <div class="form-grid">
        <div class="form-group">
          <label>📖 বইয়ের নাম *</label>
          <input type="text" name="title" value="{{ old('title',$book->title) }}" required>
        </div>
        <div class="form-group">
          <label>✍️ লেখকের নাম *</label>
          <input type="text" name="author" value="{{ old('author',$book->author) }}" required>
        </div>
        <div class="form-group">
          <label>🔢 ISBN</label>
          <input type="text" name="isbn" value="{{ old('isbn',$book->isbn) }}">
        </div>
        <div class="form-group">
          <label>🏷️ Category</label>
          <select name="category_id">
            <option value="">Category নির্বাচন</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ old('category_id',$book->category_id)==$cat->id?'selected':'' }}>{{ $cat->icon }} {{ $cat->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>🎭 Genre</label>
          <select name="genre">
            @foreach(['fiction'=>'Fiction','non-fiction'=>'Non-Fiction','science'=>'Science','history'=>'History','biography'=>'Biography','self-help'=>'Self-Help','technology'=>'Technology','religion'=>'Religion','poetry'=>'Poetry','other'=>'Other'] as $k=>$v)
              <option value="{{ $k }}" {{ old('genre',$book->genre)==$k?'selected':'' }}>{{ $v }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>📊 Status *</label>
          <select name="status" required>
            <option value="wishlist" {{ old('status',$book->status)=='wishlist'?'selected':'' }}>🌟 Wishlist</option>
            <option value="ordered" {{ old('status',$book->status)=='ordered'?'selected':'' }}>📦 Order দিয়েছি</option>
            <option value="to_read" {{ old('status',$book->status)=='to_read'?'selected':'' }}>📚 পড়বো</option>
            <option value="reading" {{ old('status',$book->status)=='reading'?'selected':'' }}>📖 পড়ছি</option>
            <option value="completed" {{ old('status',$book->status)=='completed'?'selected':'' }}>✅ শেষ</option>
          </select>
        </div>
        <div class="form-group">
          <label>🏪 Vendor</label>
          <select name="vendor_id">
            <option value="">Vendor নির্বাচন</option>
            @foreach($vendors as $v)
              <option value="{{ $v->id }}" {{ old('vendor_id',$book->vendor_id)==$v->id?'selected':'' }}>{{ $v->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>🏢 প্রকাশনী</label>
          <input type="text" name="publisher" value="{{ old('publisher',$book->publisher) }}">
        </div>
        <div class="form-group">
          <label>📅 প্রকাশ সাল</label>
          <input type="number" name="published_year" value="{{ old('published_year',$book->published_year) }}" min="1000" max="{{ date('Y') }}">
        </div>
        <div class="form-group">
          <label>🌐 ভাষা</label>
          <select name="language">
            @foreach(['Bangla','English','Hindi','Arabic','Urdu','Other'] as $lang)
              <option value="{{ $lang }}" {{ old('language',$book->language)==$lang?'selected':'' }}>{{ $lang }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>📄 পৃষ্ঠা সংখ্যা</label>
          <input type="number" name="pages" value="{{ old('pages',$book->pages) }}" min="1">
        </div>
        <div class="form-group">
          <label>💰 ক্রয় মূল্য (৳)</label>
          <input type="number" name="purchase_price" value="{{ old('purchase_price',$book->purchase_price) }}" step="0.01" min="0">
        </div>
        <div class="form-group">
          <label>🏷️ বাজার মূল্য (৳)</label>
          <input type="number" name="market_price" value="{{ old('market_price',$book->market_price) }}" step="0.01" min="0">
        </div>
        <div class="form-group">
          <label>📅 কেনার তারিখ</label>
          <input type="date" name="purchase_date" value="{{ old('purchase_date',$book->purchase_date?->format('Y-m-d')) }}">
        </div>
        <div class="form-group">
          <label>⭐ রেটিং</label>
          <select name="rating">
            <option value="">রেটিং নেই</option>
            @for($i=1;$i<=5;$i++)
              <option value="{{ $i }}" {{ old('rating',$book->rating)==$i?'selected':'' }}>{{ str_repeat('★',$i) }}</option>
            @endfor
          </select>
        </div>
        <div class="form-group">
          <label>📍 শেলফের স্থান</label>
          <input type="text" name="location" value="{{ old('location',$book->location) }}">
        </div>
        <div class="form-group">
          <label>🖼️ বইয়ের ছবি</label>
          @if($book->cover_image)
            <img src="{{ Storage::url($book->cover_image) }}" style="max-width:150px;border-radius:8px;margin-bottom:8px;display:block">
          @endif
          <input type="file" name="cover_image" id="cover_image" accept="image/*">
        </div>
        <div class="form-group">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
            <input type="checkbox" name="is_ebook" value="1" {{ old('is_ebook',$book->is_ebook)?'checked':'' }} style="width:auto">
            💻 ই-বুক
          </label>
        </div>
        <div class="form-group form-full">
          <label>📝 বিবরণ</label>
          <textarea name="description" rows="3">{{ old('description',$book->description) }}</textarea>
        </div>
        <div class="form-group form-full">
          <label>💬 নোট</label>
          <textarea name="notes" rows="3">{{ old('notes',$book->notes) }}</textarea>
        </div>
      </div>
      <div style="display:flex;gap:12px;margin-top:24px">
        <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> পরিবর্তন সংরক্ষণ</button>
        <a href="{{ route('books.show',$book) }}" class="btn btn-outline btn-lg">বাতিল</a>
      </div>
    </form>
  </div>
</div>
@endsection
