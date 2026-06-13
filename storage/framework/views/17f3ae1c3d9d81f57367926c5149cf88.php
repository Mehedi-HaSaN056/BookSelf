<?php $__env->startSection('title','Vendors'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header">
  <div><h1>🏪 Vendors (দোকান)</h1><p>মোট <?php echo e($vendors->count()); ?> টি Vendor</p></div>
  <div class="header-actions">
    <button data-modal="addVendorModal" class="btn btn-primary"><i class="fas fa-plus"></i> নতুন Vendor</button>
    <a href="<?php echo e(route('vendors.export.excel')); ?>" class="btn btn-success"><i class="fas fa-file-excel"></i> Export</a>
    <button data-modal="importVendorModal" class="btn btn-info"><i class="fas fa-upload"></i> Import</button>
  </div>
</div>
<div class="vendor-grid">
  <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <div class="vendor-card">
    <div class="vendor-name">🏪 <?php echo e($vendor->name); ?></div>
    <?php if($vendor->phone): ?>
      <div class="vendor-detail"><i class="fas fa-phone"></i> <?php echo e($vendor->phone); ?></div>
    <?php endif; ?>
    <?php if($vendor->email): ?>
      <div class="vendor-detail"><i class="fas fa-envelope"></i> <?php echo e($vendor->email); ?></div>
    <?php endif; ?>
    <?php if($vendor->address): ?>
      <div class="vendor-detail"><i class="fas fa-map-marker-alt"></i> <?php echo e($vendor->address); ?></div>
    <?php endif; ?>
    <?php if($vendor->website): ?>
      <div class="vendor-detail"><i class="fas fa-globe"></i> <a href="<?php echo e($vendor->website); ?>" target="_blank" style="color:var(--primary)"><?php echo e($vendor->website); ?></a></div>
    <?php endif; ?>
    <div style="display:flex;gap:12px;margin-top:12px;padding-top:12px;border-top:1px solid var(--border)">
      <div style="text-align:center;flex:1">
        <div style="font-size:20px;font-weight:800;color:var(--primary)"><?php echo e($vendor->books_count); ?></div>
        <div style="font-size:11px;color:var(--text-muted)">বই</div>
      </div>
      <div style="text-align:center;flex:1">
        <div style="font-size:18px;font-weight:800;color:var(--success)">৳<?php echo e(number_format($vendor->books_sum_purchase_price??0,0)); ?></div>
        <div style="font-size:11px;color:var(--text-muted)">মোট খরচ</div>
      </div>
    </div>
    <div style="display:flex;gap:8px;margin-top:12px">
      <a href="<?php echo e(route('books.index')); ?>?vendor=<?php echo e($vendor->id); ?>" class="btn btn-sm btn-outline" style="flex:1"><i class="fas fa-book"></i> বই দেখুন</a>
      <button data-modal="editVendor<?php echo e($vendor->id); ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
      <form action="<?php echo e(route('vendors.destroy',$vendor)); ?>" method="POST" onsubmit="return confirm('Delete?')">
        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
      </form>
    </div>
  </div>
  <!-- Edit Modal -->
  <div class="modal-overlay" id="editVendor<?php echo e($vendor->id); ?>">
    <div class="modal">
      <div class="modal-header">
        <h3>✏️ Vendor Edit</h3>
        <button class="modal-close" onclick="document.getElementById('editVendor<?php echo e($vendor->id); ?>').classList.remove('show')">✕</button>
      </div>
      <form action="<?php echo e(route('vendors.update',$vendor)); ?>" method="POST">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="form-grid">
          <div class="form-group"><label>নাম *</label><input type="text" name="name" value="<?php echo e($vendor->name); ?>" required></div>
          <div class="form-group"><label>Phone</label><input type="text" name="phone" value="<?php echo e($vendor->phone); ?>"></div>
          <div class="form-group"><label>Email</label><input type="email" name="email" value="<?php echo e($vendor->email); ?>"></div>
          <div class="form-group"><label>Website</label><input type="url" name="website" value="<?php echo e($vendor->website); ?>"></div>
          <div class="form-group form-full"><label>ঠিকানা</label><textarea name="address" rows="2"><?php echo e($vendor->address); ?></textarea></div>
          <div class="form-group form-full"><label>নোট</label><textarea name="notes" rows="2"><?php echo e($vendor->notes); ?></textarea></div>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top:12px;width:100%">Update করুন</button>
      </form>
    </div>
  </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<!-- Add Modal -->
<div class="modal-overlay" id="addVendorModal">
  <div class="modal">
    <div class="modal-header">
      <h3>➕ নতুন Vendor</h3>
      <button class="modal-close" onclick="document.getElementById('addVendorModal').classList.remove('show')">✕</button>
    </div>
    <form action="<?php echo e(route('vendors.store')); ?>" method="POST">
      <?php echo csrf_field(); ?>
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
    <form action="<?php echo e(route('vendors.import')); ?>" method="POST" enctype="multipart/form-data">
      <?php echo csrf_field(); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\bookshelf\resources\views/vendors/index.blade.php ENDPATH**/ ?>