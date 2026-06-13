@extends('layouts.app')
@section('title','Vendors')
@section('content')
<div class="page-header">
  <div><h1>🏪 Vendors (দোকান)</h1><p>মোট {{ $vendors->count() }} টি Vendor</p></div>
  <div class="header-actions">
    <button data-modal="addVendorModal" class="btn btn-primary"><i class="fas fa-plus"></i> নতুন Vendor</button>
    <a href="{{ route('vendors.export.excel') }}" class="btn btn-success"><i class="fas fa-file-excel"></i> Export</a>
    <button data-modal="importVendorModal" class="btn btn-info"><i class="fas fa-upload"></i> Import</button>
  </div>
</div>
<div class="vendor-grid">
  @foreach($vendors as $vendor)
  <div class="vendor-card">
    <div class="vendor-name">🏪 {{ $vendor->name }}</div>
    @if($vendor->phone)
      <div class="vendor-detail"><i class="fas fa-phone"></i> {{ $vendor->phone }}</div>
    @endif
    @if($vendor->email)
      <div class="vendor-detail"><i class="fas fa-envelope"></i> {{ $vendor->email }}</div>
    @endif
    @if($vendor->address)
      <div class="vendor-detail"><i class="fas fa-map-marker-alt"></i> {{ $vendor->address }}</div>
    @endif
    @if($vendor->website)
      <div class="vendor-detail"><i class="fas fa-globe"></i> <a href="{{ $vendor->website }}" target="_blank" style="color:var(--primary)">{{ $vendor->website }}</a></div>
    @endif
    <div style="display:flex;gap:12px;margin-top:12px;padding-top:12px;border-top:1px solid var(--border)">
      <div style="text-align:center;flex:1">
        <div style="font-size:20px;font-weight:800;color:var(--primary)">{{ $vendor->books_count }}</div>
        <div style="font-size:11px;color:var(--text-muted)">বই</div>
      </div>
      <div style="text-align:center;flex:1">
        <div style="font-size:18px;font-weight:800;color:var(--success)">৳{{ number_format($vendor->books_sum_purchase_price??0,0) }}</div>
        <div style="font-size:11px;color:var(--text-muted)">মোট খরচ</div>
      </div>
    </div>
    <div style="display:flex;gap:8px;margin-top:12px">
      <a href="{{ route('books.index') }}?vendor={{ $vendor->id }}" class="btn btn-sm btn-outline" style="flex:1"><i class="fas fa-book"></i> বই দেখুন</a>
      <button data-modal="editVendor{{ $vendor->id }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
      <form action="{{ route('vendors.destroy',$vendor) }}" method="POST" onsubmit="return confirm('Delete?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
      </form>
    </div>
  </div>
  <!-- Edit Modal -->
  <div class="modal-overlay" id="editVendor{{ $vendor->id }}">
    <div class="modal">
      <div class="modal-header">
        <h3>✏️ Vendor Edit</h3>
        <button class="modal-close" onclick="document.getElementById('editVendor{{ $vendor->id }}').classList.remove('show')">✕</button>
      </div>
      <form action="{{ route('vendors.update',$vendor) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-grid">
          <div class="form-group"><label>নাম *</label><input type="text" name="name" value="{{ $vendor->name }}" required></div>
          <div class="form-group"><label>Phone</label><input type="text" name="phone" value="{{ $vendor->phone }}"></div>
          <div class="form-group"><label>Email</label><input type="email" name="email" value="{{ $vendor->email }}"></div>
          <div class="form-group"><label>Website</label><input type="url" name="website" value="{{ $vendor->website }}"></div>
          <div class="form-group form-full"><label>ঠিকানা</label><textarea name="address" rows="2">{{ $vendor->address }}</textarea></div>
          <div class="form-group form-full"><label>নোট</label><textarea name="notes" rows="2">{{ $vendor->notes }}</textarea></div>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top:12px;width:100%">Update করুন</button>
      </form>
    </div>
  </div>
  @endforeach
</div>

<!-- Add Modal -->
<div class="modal-overlay" id="addVendorModal">
  <div class="modal">
    <div class="modal-header">
      <h3>➕ নতুন Vendor</h3>
      <button class="modal-close" onclick="document.getElementById('addVendorModal').classList.remove('show')">✕</button>
    </div>
    <form action="{{ route('vendors.store') }}" method="POST">
      @csrf
      <div class="form-grid">
        <div class="form-group"><label>নাম *</label><input type="text" name="name" required placeholder="Vendor নাম"></div>
        <div class="form-group"><label>Phone</label><input type="text" name="phone" placeholder="01XXXXXXXXX"></div>
        <div class="form-group"><label>Email</label><input type="email" name="email" placeholder="email@example.com"></div>
        <div class="form-group"><label>Website</label><input type="url" name="website" placeholder="https://..."></div>
        <div class="form-group form-full"><label>ঠিকানা</label><textarea name="address" rows="2" placeholder="পূর্ণ ঠিকানা"></textarea></div>
        <div class="form-group form-full"><label>নোট</label><textarea name="notes" rows="2"></textarea></div>
      </div>
      <button type="submit" class="btn btn-primary" style="margin-top:12px;width:100%"><i class="fas fa-plus"></i> যোগ করুন</button>
    </form>
  </div>
</div>

<!-- Import Modal -->
<div class="modal-overlay" id="importVendorModal">
  <div class="modal">
    <div class="modal-header">
      <h3>📥 Vendor Import</h3>
      <button class="modal-close" onclick="document.getElementById('importVendorModal').classList.remove('show')">✕</button>
    </div>
    <form action="{{ route('vendors.import') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="import-box">
        <i class="fas fa-cloud-upload-alt"></i>
        <h4>Excel/CSV Import</h4>
        <p class="import-filename" style="color:var(--text-muted);font-size:13px">name, email, phone, address, website, notes</p>
        <input type="file" name="file" accept=".xlsx,.xls,.csv" style="display:none" required>
      </div>
      <button type="submit" class="btn btn-primary" style="margin-top:12px;width:100%">Import করুন</button>
    </form>
  </div>
</div>
@endsection
