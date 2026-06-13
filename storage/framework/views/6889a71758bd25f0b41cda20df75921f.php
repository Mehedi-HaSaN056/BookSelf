<?php $__env->startSection('title','Dashboard'); ?>
<?php $__env->startSection('content'); ?>

<div class="page-header">
  <div>
    <h1 class="page-title">📊 Dashboard</h1>
    <p class="page-sub">আপনার বইয়ের জগতের সম্পূর্ণ চিত্র — <?php echo e(date('d F Y')); ?></p>
  </div>
  <div class="header-actions">
    <a href="<?php echo e(route('payments.create')); ?>" class="btn btn-primary" style="background:linear-gradient(135deg,#e2136e,#c4115e)">
      <i class="fas fa-credit-card"></i> পেমেন্ট
    </a>
    <a href="<?php echo e(route('books.create')); ?>" class="btn btn-primary">
      <i class="fas fa-plus"></i> নতুন বই
    </a>
    <a href="<?php echo e(route('books.export.excel')); ?>" class="btn btn-success">
      <i class="fas fa-file-excel"></i> Excel
    </a>
    <a href="<?php echo e(route('books.export.pdf')); ?>" class="btn btn-danger">
      <i class="fas fa-file-pdf"></i> PDF
    </a>
  </div>
</div>


<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon" style="background:#e0e7ff">📚</div>
    <div class="stat-info"><h3><?php echo e($stats['total_books']); ?></h3><p>মোট বই</p></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#d1fae5">✅</div>
    <div class="stat-info"><h3><?php echo e($stats['completed']); ?></h3><p>পড়া শেষ</p></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#dbeafe">📖</div>
    <div class="stat-info"><h3><?php echo e($stats['reading']); ?></h3><p>পড়ছি এখন</p></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#fef3c7">🌟</div>
    <div class="stat-info"><h3><?php echo e($stats['wishlist']); ?></h3><p>Wishlist</p></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#f3e8ff">📦</div>
    <div class="stat-info"><h3><?php echo e($stats['ordered']); ?></h3><p>Order দিয়েছি</p></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#fee2e2">💰</div>
    <div class="stat-info"><h3>৳<?php echo e(number_format($stats['total_spent'],0)); ?></h3><p>মোট খরচ</p></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#ecfdf5">🏷️</div>
    <div class="stat-info"><h3><?php echo e($stats['total_categories']); ?></h3><p>Categories</p></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#fff7ed">🏪</div>
    <div class="stat-info"><h3><?php echo e($stats['total_vendors']); ?></h3><p>Vendors</p></div>
  </div>
</div>


<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px">

  
  <div class="card">
    <div class="card-header">
      <h2>💰 এই মাসের বাজেট (<?php echo e(date('F Y')); ?>)</h2>
      <a href="<?php echo e(route('reports.budget')); ?>" class="btn btn-sm btn-outline">সব দেখুন</a>
    </div>
    <div class="card-body">
      <?php if($currentBudget): ?>
        <?php $pct = $currentBudget->budget_amount > 0 ? min(100,($thisMonthSpent/$currentBudget->budget_amount)*100) : 0; ?>
        <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:14px">
          <span>খরচ: <strong style="color:#ef4444">৳<?php echo e(number_format($thisMonthSpent,0)); ?></strong></span>
          <span>বাজেট: <strong>৳<?php echo e(number_format($currentBudget->budget_amount,0)); ?></strong></span>
        </div>
        <div class="progress-bar">
          <div class="progress-fill" style="width:<?php echo e($pct); ?>%;background:<?php echo e($pct>=100?'#ef4444':'#10b981'); ?>"></div>
        </div>
        <p style="margin-top:8px;font-size:12px;color:var(--text-muted)">
          <?php echo e(number_format($pct,1)); ?>% ব্যবহার | বাকি: ৳<?php echo e(number_format(max(0,$currentBudget->budget_amount-$thisMonthSpent),0)); ?>

        </p>
      <?php else: ?>
        <p style="color:var(--text-muted);font-size:14px">
          এই মাসের কোনো বাজেট নেই।
          <a href="<?php echo e(route('reports.budget')); ?>" style="color:var(--primary)">এখনই সেট করুন</a>
        </p>
      <?php endif; ?>
    </div>
  </div>

  
  <div class="card">
    <div class="card-header">
      <h2>💳 দ্রুত পেমেন্ট</h2>
      <a href="<?php echo e(route('payments.index')); ?>" class="btn btn-sm btn-outline">History</a>
    </div>
    <div class="card-body">

      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:12px">

        
        <a href="<?php echo e(route('payments.create',['method'=>'bkash'])); ?>"
           style="padding:10px 6px;background:#fff0f7;border:2px solid #e2136e33;border-radius:12px;text-align:center;text-decoration:none;display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:56px;transition:.15s"
           onmouseover="this.style.transform='translateY(-2px)';this.style.borderColor='#e2136e'"
           onmouseout="this.style.transform='translateY(0)';this.style.borderColor='#e2136e33'">
          <?php if(file_exists(public_path('images/gateways/bkash.png'))): ?>
            <img src="<?php echo e(asset('images/gateways/bkash.png')); ?>" alt="bKash"
                 style="height:26px;width:auto;max-width:68px;object-fit:contain">
          <?php else: ?>
            <div style="font-size:20px">📱</div>
            <div style="font-weight:700;color:#e2136e;font-size:11px;margin-top:2px">bKash</div>
          <?php endif; ?>
        </a>

        
        <a href="<?php echo e(route('payments.create',['method'=>'nagad'])); ?>"
           style="padding:10px 6px;background:#fff7ee;border:2px solid #f6821f33;border-radius:12px;text-align:center;text-decoration:none;display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:56px;transition:.15s"
           onmouseover="this.style.transform='translateY(-2px)';this.style.borderColor='#f6821f'"
           onmouseout="this.style.transform='translateY(0)';this.style.borderColor='#f6821f33'">
          <?php if(file_exists(public_path('images/gateways/nagad.png'))): ?>
            <img src="<?php echo e(asset('images/gateways/nagad.png')); ?>" alt="Nagad"
                 style="height:26px;width:auto;max-width:68px;object-fit:contain">
          <?php else: ?>
            <div style="font-size:20px">🟠</div>
            <div style="font-weight:700;color:#f6821f;font-size:11px;margin-top:2px">Nagad</div>
          <?php endif; ?>
        </a>

        
        <a href="<?php echo e(route('payments.create',['method'=>'rocket'])); ?>"
           style="padding:10px 6px;background:#f5f0ff;border:2px solid #8b2be233;border-radius:12px;text-align:center;text-decoration:none;display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:56px;transition:.15s"
           onmouseover="this.style.transform='translateY(-2px)';this.style.borderColor='#8b2be2'"
           onmouseout="this.style.transform='translateY(0)';this.style.borderColor='#8b2be233'">
          <?php if(file_exists(public_path('images/gateways/rocket.png'))): ?>
            <img src="<?php echo e(asset('images/gateways/rocket.png')); ?>" alt="Rocket"
                 style="height:26px;width:auto;max-width:68px;object-fit:contain">
          <?php else: ?>
            <div style="font-size:20px">🚀</div>
            <div style="font-weight:700;color:#8b2be2;font-size:11px;margin-top:2px">Rocket</div>
          <?php endif; ?>
        </a>

        
        <a href="<?php echo e(route('payments.create',['method'=>'visa'])); ?>"
           style="padding:10px 6px;background:#eef0ff;border:2px solid #1a1f7133;border-radius:12px;text-align:center;text-decoration:none;display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:56px;transition:.15s"
           onmouseover="this.style.transform='translateY(-2px)';this.style.borderColor='#1a1f71'"
           onmouseout="this.style.transform='translateY(0)';this.style.borderColor='#1a1f7133'">
          <?php if(file_exists(public_path('images/gateways/visa.png'))): ?>
            <img src="<?php echo e(asset('images/gateways/visa.png')); ?>" alt="VISA"
                 style="height:26px;width:auto;max-width:68px;object-fit:contain">
          <?php else: ?>
            <div style="font-size:20px">💳</div>
            <div style="font-weight:700;color:#1a1f71;font-size:11px;margin-top:2px">VISA</div>
          <?php endif; ?>
        </a>

        
        <a href="<?php echo e(route('payments.create',['method'=>'mastercard'])); ?>"
           style="padding:10px 6px;background:#fff0f0;border:2px solid #eb001b33;border-radius:12px;text-align:center;text-decoration:none;display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:56px;transition:.15s"
           onmouseover="this.style.transform='translateY(-2px)';this.style.borderColor='#eb001b'"
           onmouseout="this.style.transform='translateY(0)';this.style.borderColor='#eb001b33'">
          <?php if(file_exists(public_path('images/gateways/mastercard.png'))): ?>
            <img src="<?php echo e(asset('images/gateways/mastercard.png')); ?>" alt="Mastercard"
                 style="height:26px;width:auto;max-width:68px;object-fit:contain">
          <?php else: ?>
            <div style="font-size:20px">💳</div>
            <div style="font-weight:700;color:#eb001b;font-size:11px;margin-top:2px">Mastercard</div>
          <?php endif; ?>
        </a>

        
        <a href="<?php echo e(route('payments.create')); ?>"
           style="padding:10px 6px;background:#f8fafc;border:2px dashed #cbd5e1;border-radius:12px;text-align:center;text-decoration:none;display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:56px;transition:.15s"
           onmouseover="this.style.transform='translateY(-2px)'"
           onmouseout="this.style.transform='translateY(0)'">
          <div style="font-size:20px">➕</div>
          <div style="font-weight:600;color:#64748b;font-size:11px;margin-top:2px">আরো</div>
        </a>

      </div>

      <div style="font-size:13px;color:var(--text-muted);display:flex;align-items:center;gap:6px">
        <i class="fas fa-wallet" style="color:#0e9f6e"></i>
        Wallet: <strong style="color:#0e9f6e">৳<?php echo e(number_format(Auth::user()->wallet_balance ?? 0, 2)); ?></strong>
      </div>

    </div>
  </div>

</div>


<div class="charts-grid">

  
  <div class="chart-card">
    <div class="chart-title">📊 Genre অনুযায়ী বই</div>
    <div style="display:flex;align-items:center;gap:20px">
      <canvas id="genreChart" width="160" height="160"></canvas>
      <div style="flex:1">
        <?php $colors=['#6366f1','#f59e0b','#10b981','#3b82f6','#ef4444','#8b5cf6','#ec4899','#14b8a6','#f97316','#84cc16']; ?>
        <?php $__currentLoopData = $genreStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;font-size:13px">
            <div style="width:10px;height:10px;border-radius:3px;background:<?php echo e($colors[$i%10]); ?>;flex-shrink:0"></div>
            <span><?php echo e(ucfirst($g->genre)); ?></span>
            <span style="margin-left:auto;font-weight:700;color:var(--primary)"><?php echo e($g->count); ?></span>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
  </div>

  
  <div class="chart-card">
    <div class="chart-title">📈 মাসিক খরচ (<?php echo e(date('Y')); ?>)</div>
    <canvas id="monthChart" height="180"></canvas>
  </div>

  
  <div class="chart-card">
    <div class="chart-title">🏷️ Category অনুযায়ী বই</div>
    <?php $__currentLoopData = $categoryStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php $pct2 = $stats['total_books']>0 ? ($cat->books_count/$stats['total_books'])*100 : 0; ?>
      <div style="margin-bottom:12px">
        <div style="display:flex;justify-content:space-between;margin-bottom:4px;font-size:13px">
          <span><?php echo e($cat->icon); ?> <?php echo e($cat->name); ?></span>
          <span style="font-weight:700"><?php echo e($cat->books_count); ?></span>
        </div>
        <div class="progress-bar">
          <div class="progress-fill" style="width:<?php echo e($pct2); ?>%;background:<?php echo e($cat->color); ?>"></div>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>

  
  <div class="chart-card">
    <div class="chart-title">📚 Status অনুযায়ী</div>
    <?php
      $statuses=[
        ['label'=>'Wishlist',     'key'=>'wishlist', 'color'=>'#f59e0b','icon'=>'🌟'],
        ['label'=>'Order দিয়েছি','key'=>'ordered',  'color'=>'#6366f1','icon'=>'📦'],
        ['label'=>'পড়বো',        'key'=>'to_read',  'color'=>'#64748b','icon'=>'📚'],
        ['label'=>'পড়ছি',        'key'=>'reading',  'color'=>'#3b82f6','icon'=>'📖'],
        ['label'=>'পড়া শেষ',     'key'=>'completed','color'=>'#10b981','icon'=>'✅'],
      ];
    ?>
    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php $cnt=$stats[$s['key']]; $pct3=$stats['total_books']>0?($cnt/$stats['total_books'])*100:0; ?>
      <div style="margin-bottom:12px">
        <div style="display:flex;justify-content:space-between;margin-bottom:4px;font-size:13px">
          <span><?php echo e($s['icon']); ?> <?php echo e($s['label']); ?></span>
          <span style="font-weight:700"><?php echo e($cnt); ?></span>
        </div>
        <div class="progress-bar">
          <div class="progress-fill" style="width:<?php echo e($pct3); ?>%;background:<?php echo e($s['color']); ?>"></div>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>

</div>


<div class="card" style="margin-top:20px">
  <div class="card-header">
    <h2>📖 সম্প্রতি যোগ করা বই</h2>
    <a href="<?php echo e(route('books.index')); ?>" class="btn btn-sm btn-outline">সব দেখুন</a>
  </div>
  <div class="card-body">
    <div class="books-grid">
      <?php $__empty_1 = true; $__currentLoopData = $recentBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <a href="<?php echo e(route('books.show',$book)); ?>" class="book-card" style="text-decoration:none;color:inherit">
        <div class="book-cover">
          <?php if($book->cover_image): ?>
            <img src="<?php echo e(Storage::url($book->cover_image)); ?>" alt="<?php echo e($book->title); ?>">
          <?php else: ?>
            📚
          <?php endif; ?>
          <div class="book-status-badge"><?php echo e($book->status_label); ?></div>
        </div>
        <div class="book-info">
          <div class="book-title"><?php echo e($book->title); ?></div>
          <div class="book-author"><?php echo e($book->author); ?></div>
          <div class="book-meta">
            <span class="book-price">৳<?php echo e(number_format($book->purchase_price,0)); ?></span>
            <?php if($book->rating): ?>
              <span class="book-rating"><?php echo e(str_repeat('★',$book->rating)); ?></span>
            <?php endif; ?>
          </div>
        </div>
      </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p style="color:var(--text-muted);grid-column:1/-1;text-align:center;padding:30px">
          এখনো কোনো বই যোগ করা হয়নি। <a href="<?php echo e(route('books.create')); ?>">এখনই যোগ করুন</a>
        </p>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
<script>
window.genreData = <?php echo json_encode($genreStats, 15, 512) ?>;
<?php
  $monthChartData = $monthlySpend->map(fn($m) => [
    'month_short' => date('M', mktime(0,0,0,$m->month,1)),
    'total' => $m->total
  ]);
?>
window.monthData = <?php echo json_encode($monthChartData, 15, 512) ?>;

document.addEventListener('DOMContentLoaded', function () {
  const gCtx = document.getElementById('genreChart')?.getContext('2d');
  if (gCtx && window.genreData?.length) {
    new Chart(gCtx, {
      type: 'doughnut',
      data: {
        labels: genreData.map(g => g.genre),
        datasets: [{
          data: genreData.map(g => g.count),
          backgroundColor: ['#6366f1','#f59e0b','#10b981','#3b82f6','#ef4444','#8b5cf6','#ec4899','#14b8a6'],
          borderWidth: 2,
          borderColor: '#fff'
        }]
      },
      options: { plugins: { legend: { display: false } }, cutout: '65%' }
    });
  }

  const mCtx = document.getElementById('monthChart')?.getContext('2d');
  if (mCtx && window.monthData?.length) {
    new Chart(mCtx, {
      type: 'bar',
      data: {
        labels: monthData.map(m => m.month_short),
        datasets: [{
          label: 'খরচ (৳)',
          data: monthData.map(m => m.total),
          backgroundColor: '#1a56db',
          borderRadius: 6
        }]
      },
      options: {
        plugins: { legend: { display: false } },
        scales: {
          y: { grid: { color: '#f1f5f9' }, ticks: { callback: v => '৳' + v } },
          x: { grid: { display: false } }
        }
      }
    });
  }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\bookshelf\resources\views/dashboard/index.blade.php ENDPATH**/ ?>