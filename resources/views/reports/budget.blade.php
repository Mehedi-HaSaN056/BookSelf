@extends('layouts.app')
@section('title','Budget & Reports')
@section('content')
<div class="page-header">
  <div><h1>💰 Budget & Reports</h1><p>মাসিক বাজেট ও খরচের হিসাব</p></div>
  <div class="header-actions">
    <form method="GET" style="display:flex;gap:8px;align-items:center">
      <select name="year" class="filter-group select" style="padding:9px 14px;border:1.5px solid var(--border);border-radius:8px">
        @for($y=date('Y');$y>=date('Y')-5;$y--)
          <option value="{{ $y }}" {{ $year==$y?'selected':'' }}>{{ $y }}</option>
        @endfor
      </select>
      <button type="submit" class="btn btn-primary">দেখুন</button>
    </form>
    <a href="{{ route('reports.budget.pdf') }}?year={{ $year }}" class="btn btn-danger"><i class="fas fa-file-pdf"></i> PDF</a>
    <button data-modal="setBudgetModal" class="btn btn-success"><i class="fas fa-plus"></i> বাজেট সেট</button>
  </div>
</div>

<!-- Summary -->
@php
  $totalBudget = collect($monthlyData)->sum('budget');
  $totalSpent  = collect($monthlyData)->sum('spent');
  $pctUsed = $totalBudget>0?min(100,($totalSpent/$totalBudget)*100):0;
@endphp
<div class="stats-grid" style="grid-template-columns:repeat(3,1fr)">
  <div class="stat-card">
    <div class="stat-icon" style="background:#d1fae5">💰</div>
    <div class="stat-info"><h3>৳{{ number_format($totalBudget,0) }}</h3><p>মোট বাজেট ({{ $year }})</p></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#fee2e2">💸</div>
    <div class="stat-info"><h3>৳{{ number_format($totalSpent,0) }}</h3><p>মোট খরচ ({{ $year }})</p></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#e0e7ff">📊</div>
    <div class="stat-info"><h3 style="color:{{ $pctUsed>=100?'#ef4444':'#10b981' }}">{{ number_format($pctUsed,1) }}%</h3><p>বাজেট ব্যবহার</p></div>
  </div>
</div>

<!-- Monthly Table -->
<div class="card">
  <div class="card-header"><h2>📅 {{ $year }} সালের মাসিক বাজেট</h2></div>
  <div class="card-body" style="padding:0">
    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>মাস</th>
            <th>বাজেট (৳)</th>
            <th>খরচ (৳)</th>
            <th>বাকি (৳)</th>
            <th>অগ্রগতি</th>
            <th>অবস্থা</th>
          </tr>
        </thead>
        <tbody>
          @foreach($monthlyData as $m)
            @php
              $remaining = $m['budget'] - $m['spent'];
              $pct = $m['budget']>0?min(100,($m['spent']/$m['budget'])*100):($m['spent']>0?100:0);
              $isOver = $m['spent'] > $m['budget'] && $m['budget'] > 0;
            @endphp
            <tr class="{{ $isOver?'budget-over':($m['spent']>0&&!$isOver?'budget-good':'') }}">
              <td><strong>{{ $m['month_name'] }}</strong></td>
              <td>৳{{ number_format($m['budget'],2) }}</td>
              <td>৳{{ number_format($m['spent'],2) }}</td>
              <td style="color:{{ $remaining<0?'#ef4444':'#10b981' }};font-weight:700">
                {{ $remaining < 0 ? '-' : '' }}৳{{ number_format(abs($remaining),2) }}
              </td>
              <td style="min-width:150px">
                <div class="budget-bar">
                  <div class="budget-bar-fill {{ $isOver?'over':'' }}" style="width:{{ $pct }}%"></div>
                </div>
                <span style="font-size:11px;color:var(--text-muted)">{{ number_format($pct,1) }}%</span>
              </td>
              <td>
                @if($m['budget']==0 && $m['spent']==0)
                  <span class="badge badge-secondary">কোনো কার্যক্রম নেই</span>
                @elseif($isOver)
                  <span class="badge badge-danger">⚠️ বাজেট অতিক্রম</span>
                @elseif($pct>=80)
                  <span class="badge badge-warning">⚡ সতর্কতা</span>
                @else
                  <span class="badge badge-success">✅ ঠিক আছে</span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr style="background:#f8fafc;font-weight:700">
            <td>মোট</td>
            <td>৳{{ number_format($totalBudget,2) }}</td>
            <td>৳{{ number_format($totalSpent,2) }}</td>
            <td style="color:{{ ($totalBudget-$totalSpent)<0?'#ef4444':'#10b981' }}">৳{{ number_format(abs($totalBudget-$totalSpent),2) }}</td>
            <td colspan="2"></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>

<!-- Set Budget Modal -->
<div class="modal-overlay" id="setBudgetModal">
  <div class="modal">
    <div class="modal-header">
      <h3>💰 বাজেট সেট করুন</h3>
      <button class="modal-close" onclick="document.getElementById('setBudgetModal').classList.remove('show')">✕</button>
    </div>
    <form action="{{ route('reports.budget.set') }}" method="POST">
      @csrf
      <div class="form-grid">
        <div class="form-group">
          <label>বছর</label>
          <select name="year">
            @for($y=date('Y');$y>=date('Y')-5;$y--)
              <option value="{{ $y }}" {{ date('Y')==$y?'selected':'' }}>{{ $y }}</option>
            @endfor
          </select>
        </div>
        <div class="form-group">
          <label>মাস</label>
          <select name="month">
            @for($m=1;$m<=12;$m++)
              <option value="{{ $m }}" {{ date('n')==$m?'selected':'' }}>{{ date('F',mktime(0,0,0,$m,1)) }}</option>
            @endfor
          </select>
        </div>
        <div class="form-group form-full">
          <label>বাজেট পরিমাণ (৳)</label>
          <input type="number" name="budget_amount" required min="0" step="0.01" placeholder="0.00">
        </div>
        <div class="form-group form-full">
          <label>নোট</label>
          <textarea name="notes" rows="2" placeholder="যেকোনো নোট..."></textarea>
        </div>
      </div>
      <button type="submit" class="btn btn-primary" style="margin-top:12px;width:100%"><i class="fas fa-save"></i> সেট করুন</button>
    </form>
  </div>
</div>
@endsection
