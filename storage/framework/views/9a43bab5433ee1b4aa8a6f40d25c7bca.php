<?php $__env->startSection('title','Categories'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header">
  <div><h1>🏷️ Categories</h1><p>মোট <?php echo e($categories->count()); ?> টি Category</p></div>
  <button data-modal="addCategoryModal" class="btn btn-primary"><i class="fas fa-plus"></i> নতুন Category</button>
</div>
<div class="category-grid">
  <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <div class="category-card" style="border-top-color:<?php echo e($cat->color); ?>">
    <div class="category-icon"><?php echo e($cat->icon); ?></div>
    <div class="category-name"><?php echo e($cat->name); ?></div>
    <div class="category-count"><?php echo e($cat->books_count); ?> টি বই</div>
    <?php if($cat->description): ?>
      <div style="font-size:13px;color:var(--text-muted);margin-top:6px"><?php echo e($cat->description); ?></div>
    <?php endif; ?>
    <div style="display:flex;gap:8px;margin-top:14px;justify-content:center">
      <a href="<?php echo e(route('books.index')); ?>?category=<?php echo e($cat->id); ?>" class="btn btn-sm btn-outline"><i class="fas fa-eye"></i> বই দেখুন</a>
      <button data-modal="editCat<?php echo e($cat->id); ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
      <form action="<?php echo e(route('categories.destroy',$cat)); ?>" method="POST" onsubmit="return confirm('Delete করবেন?')">
        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
      </form>
    </div>
  </div>
  <!-- Edit Modal per category -->
  <div class="modal-overlay" id="editCat<?php echo e($cat->id); ?>">
    <div class="modal">
      <div class="modal-header">
        <h3>✏️ Category Edit</h3>
        <button class="modal-close" onclick="document.getElementById('editCat<?php echo e($cat->id); ?>').classList.remove('show')">✕</button>
      </div>
      <form action="<?php echo e(route('categories.update',$cat)); ?>" method="POST">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="form-grid" style="grid-template-columns:1fr 1fr">
          <div class="form-group form-full">
            <label>নাম *</label>
            <input type="text" name="name" value="<?php echo e($cat->name); ?>" required>
          </div>
          <div class="form-group">
            <label>Icon (Emoji)</label>
            <input type="text" name="icon" value="<?php echo e($cat->icon); ?>">
          </div>
          <div class="form-group">
            <label>Color</label>
            <input type="color" name="color" value="<?php echo e($cat->color); ?>" style="height:42px;cursor:pointer">
          </div>
          <div class="form-group form-full">
            <label>বিবরণ</label>
            <textarea name="description" rows="2"><?php echo e($cat->description); ?></textarea>
          </div>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top:12px;width:100%">Update করুন</button>
      </form>
    </div>
  </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<!-- Add Category Modal -->
<div class="modal-overlay" id="addCategoryModal">
  <div class="modal">
    <div class="modal-header">
      <h3>➕ নতুন Category</h3>
      <button class="modal-close" onclick="document.getElementById('addCategoryModal').classList.remove('show')">✕</button>
    </div>
    <form action="<?php echo e(route('categories.store')); ?>" method="POST">
      <?php echo csrf_field(); ?>
      <div class="form-grid" style="grid-template-columns:1fr 1fr">
        <div class="form-group form-full">
          <label>নাম *</label>
          <input type="text" name="name" required placeholder="Category নাম">
        </div>
        <div class="form-group">
          <label>Icon (Emoji)</label>
          <input type="text" name="icon" placeholder="📚" value="📚">
        </div>
        <div class="form-group">
          <label>Color</label>
          <input type="color" name="color" value="#6366f1" style="height:42px;cursor:pointer">
        </div>
        <div class="form-group form-full">
          <label>বিবরণ</label>
          <textarea name="description" rows="2" placeholder="Category সম্পর্কে..."></textarea>
        </div>
      </div>
      <button type="submit" class="btn btn-primary" style="margin-top:12px;width:100%"><i class="fas fa-plus"></i> যোগ করুন</button>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\bookshelf\resources\views/categories/index.blade.php ENDPATH**/ ?>