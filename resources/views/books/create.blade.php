@extends('layouts.app')
@section('title','নতুন বই যোগ')
@section('content')
<div class="page-header">
  <div><h1>➕ নতুন বই যোগ করুন</h1><p>আপনার লাইব্রেরিতে নতুন বই যোগ করুন</p></div>
  <a href="{{ route('books.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> ফিরে যান</a>
</div>
<div class="card">
  <div class="card-body">
    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-grid">
        <div class="form-group">
          <label>📖 বইয়ের নাম *</label>
          <input type="text" name="title" value="{{ old('title') }}" required placeholder="বইয়ের শিরোনাম লিখুন">
        </div>
        <div class="form-group">
          <label>✍️ লেখকের নাম *</label>
          <input type="text" name="author" value="{{ old('author') }}" required placeholder="লেখকের নাম">
        </div>
        <div class="form-group">
          <label>🔢 ISBN</label>
          <input type="text" name="isbn" value="{{ old('isbn') }}" placeholder="ISBN নম্বর">
        </div>
        <div class="form-group">
          <label>🏷️ Category</label>
          <select name="category_id">
            <option value="">Category নির্বাচন করুন</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ old('category_id')==$cat->id?'selected':'' }}>{{ $cat->icon }} {{ $cat->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>🎭 Genre</label>
          <select name="genre">
            @foreach(['fiction'=>'Fiction','non-fiction'=>'Non-Fiction','science'=>'Science','history'=>'History','biography'=>'Biography','self-help'=>'Self-Help','technology'=>'Technology','religion'=>'Religion','poetry'=>'Poetry','other'=>'Other'] as $k=>$v)
              <option value="{{ $k }}" {{ old('genre')==$k?'selected':'' }}>{{ $v }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>📊 Status *</label>
          <select name="status" required>
            <option value="wishlist" {{ old('status')=='wishlist'?'selected':'' }}>🌟 Wishlist</option>
            <option value="ordered" {{ old('status')=='ordered'?'selected':'' }}>📦 Order দিয়েছি</option>
            <option value="to_read" {{ old('status','to_read')=='to_read'?'selected':'' }}>📚 পড়বো</option>
            <option value="reading" {{ old('status')=='reading'?'selected':'' }}>📖 পড়ছি</option>
            <option value="completed" {{ old('status')=='completed'?'selected':'' }}>✅ শেষ</option>
          </select>
        </div>
        <div class="form-group">
          <label>🏪 Vendor (দোকান)</label>
          <select name="vendor_id">
            <option value="">Vendor নির্বাচন করুন</option>
            @foreach($vendors as $v)
              <option value="{{ $v->id }}" {{ old('vendor_id')==$v->id?'selected':'' }}>{{ $v->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>🏢 প্রকাশনী</label>
          <input type="text" name="publisher" value="{{ old('publisher') }}" placeholder="প্রকাশনীর নাম">
        </div>
        <div class="form-group">
          <label>📅 প্রকাশ সাল</label>
          <input type="number" name="published_year" value="{{ old('published_year') }}" min="1000" max="{{ date('Y') }}" placeholder="{{ date('Y') }}">
        </div>
        <div class="form-group">
          <label>🌐 ভাষা</label>
          <select name="language">
            @foreach(['Bangla','English','Hindi','Arabic','Urdu','Other'] as $lang)
              <option value="{{ $lang }}" {{ old('language','Bangla')==$lang?'selected':'' }}>{{ $lang }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>📄 পৃষ্ঠা সংখ্যা</label>
          <input type="number" name="pages" value="{{ old('pages') }}" min="1" placeholder="পৃষ্ঠা সংখ্যা">
        </div>
        <div class="form-group">
          <label>📋 সংস্করণ</label>
          <input type="text" name="edition" value="{{ old('edition') }}" placeholder="যেমন: ৩য় সংস্করণ">
        </div>
        <div class="form-group">
          <label>💰 ক্রয় মূল্য (৳)</label>
          <input type="number" name="purchase_price" value="{{ old('purchase_price',0) }}" step="0.01" min="0">
        </div>
        <div class="form-group">
          <label>🏷️ বাজার মূল্য (৳)</label>
          <input type="number" name="market_price" value="{{ old('market_price',0) }}" step="0.01" min="0">
        </div>
        <div class="form-group">
          <label>📅 কেনার তারিখ</label>
          <input type="date" name="purchase_date" value="{{ old('purchase_date') }}">
        </div>
        <div class="form-group">
          <label>⭐ রেটিং (১-৫)</label>
          <select name="rating">
            <option value="">রেটিং নেই</option>
            @for($i=1;$i<=5;$i++)
              <option value="{{ $i }}" {{ old('rating')==$i?'selected':'' }}>{{ str_repeat('★',$i) }} ({{ $i }})</option>
            @endfor
          </select>
        </div>
        <div class="form-group">
          <label>📍 শেলফের স্থান</label>
          <input type="text" name="location" value="{{ old('location') }}" placeholder="যেমন: Shelf A, Row 2">
        </div>
        <div class="form-group">
          <label>🖼️ বইয়ের ছবি</label>
          <input type="file" name="cover_image" id="cover_image" accept="image/*">
          <img id="cover-preview" style="display:none;max-width:150px;margin-top:10px;border-radius:8px">
        </div>
        <div class="form-group">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
            <input type="checkbox" name="is_ebook" value="1" {{ old('is_ebook')?'checked':'' }} style="width:auto">
            💻 এটি একটি ই-বুক
          </label>
        </div>
        <div class="form-group form-full">
          <label>📝 বইয়ের বিবরণ</label>
          <textarea name="description" rows="3" placeholder="বইয়ের সংক্ষিপ্ত বিবরণ">{{ old('description') }}</textarea>
        </div>
        <div class="form-group form-full">
          <label>💬 নোট</label>
          <textarea name="notes" rows="3" placeholder="আপনার ব্যক্তিগত নোট">{{ old('notes') }}</textarea>
        </div>
      </div>
      <div style="display:flex;gap:12px;margin-top:24px">
        <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> বই সংরক্ষণ করুন</button>
        <a href="{{ route('books.index') }}" class="btn btn-outline btn-lg">বাতিল</a>
      </div>
    </form>
  </div>
</div>
@endsection
