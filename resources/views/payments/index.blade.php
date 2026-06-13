@extends('layouts.app')
@section('title','Payments')
@section('content')

<div class="page-header">
  <div>
    <h1 class="page-title">💳 পেমেন্ট ইতিহাস</h1>
    <p class="page-sub">মোট পেমেন্ট: ৳{{ number_format($total,2) }}</p>
  </div>
  <a href="{{ route('payments.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> নতুন পেমেন্ট</a>
</div>

{{-- Quick Payment Buttons with Logos --}}
<div style="display:flex;gap:12px;margin-bottom:24px;flex-wrap:wrap">

  {{-- bKash --}}
  <a href="{{ route('payments.create',['method'=>'bkash']) }}"
     style="flex:1;min-width:140px;padding:16px;background:#fff0f7;border:2px solid #e2136e33;border-radius:14px;text-align:center;text-decoration:none;transition:.15s"
     onmouseover="this.style.transform='translateY(-2px)';this.style.borderColor='#e2136e'"
     onmouseout="this.style.transform='translateY(0)';this.style.borderColor='#e2136e33'">
    @if(file_exists(public_path('images/gateways/bkash.png')))
      <img src="{{ asset('images/gateways/bkash.png') }}" alt="bKash"
           style="height:34px;width:auto;max-width:90px;object-fit:contain">
    @else
      <div style="font-size:28px">📱</div>
      <div style="font-weight:700;color:#e2136e;margin-top:4px">bKash</div>
    @endif
  </a>

  {{-- Nagad --}}
  <a href="{{ route('payments.create',['method'=>'nagad']) }}"
     style="flex:1;min-width:140px;padding:16px;background:#fff7ee;border:2px solid #f6821f33;border-radius:14px;text-align:center;text-decoration:none;transition:.15s"
     onmouseover="this.style.transform='translateY(-2px)';this.style.borderColor='#f6821f'"
     onmouseout="this.style.transform='translateY(0)';this.style.borderColor='#f6821f33'">
    @if(file_exists(public_path('images/gateways/nagad.png')))
      <img src="{{ asset('images/gateways/nagad.png') }}" alt="Nagad"
           style="height:34px;width:auto;max-width:90px;object-fit:contain">
    @else
      <div style="font-size:28px">🟠</div>
      <div style="font-weight:700;color:#f6821f;margin-top:4px">Nagad</div>
    @endif
  </a>

  {{-- Rocket --}}
  <a href="{{ route('payments.create',['method'=>'rocket']) }}"
     style="flex:1;min-width:140px;padding:16px;background:#f5f0ff;border:2px solid #8b2be233;border-radius:14px;text-align:center;text-decoration:none;transition:.15s"
     onmouseover="this.style.transform='translateY(-2px)';this.style.borderColor='#8b2be2'"
     onmouseout="this.style.transform='translateY(0)';this.style.borderColor='#8b2be233'">
    @if(file_exists(public_path('images/gateways/rocket.png')))
      <img src="{{ asset('images/gateways/rocket.png') }}" alt="Rocket"
           style="height:34px;width:auto;max-width:90px;object-fit:contain">
    @else
      <div style="font-size:28px">🚀</div>
      <div style="font-weight:700;color:#8b2be2;margin-top:4px">Rocket</div>
    @endif
  </a>

  {{-- VISA --}}
  <a href="{{ route('payments.create',['method'=>'visa']) }}"
     style="flex:1;min-width:140px;padding:16px;background:#eef0ff;border:2px solid #1a1f7133;border-radius:14px;text-align:center;text-decoration:none;transition:.15s"
     onmouseover="this.style.transform='translateY(-2px)';this.style.borderColor='#1a1f71'"
     onmouseout="this.style.transform='translateY(0)';this.style.borderColor='#1a1f7133'">
    @if(file_exists(public_path('images/gateways/visa.png')))
      <img src="{{ asset('images/gateways/visa.png') }}" alt="VISA"
           style="height:34px;width:auto;max-width:90px;object-fit:contain">
    @else
      <div style="font-size:28px">💳</div>
      <div style="font-weight:700;color:#1a1f71;margin-top:4px">VISA</div>
    @endif
  </a>

  {{-- More --}}
  <a href="{{ route('payments.create') }}"
     style="flex:1;min-width:140px;padding:16px;background:#f8fafc;border:2px dashed #cbd5e1;border-radius:14px;text-align:center;text-decoration:none;transition:.15s"
     onmouseover="this.style.transform='translateY(-2px)'"
     onmouseout="this.style.transform='translateY(0)'">
    <div style="font-size:28px">➕</div>
    <div style="font-weight:600;color:#64748b;margin-top:4px;font-size:14px">আরো</div>
  </a>

</div>

{{-- Payments Table --}}
<div class="card">
  <div class="card-body" style="padding:0">
    <table style="width:100%;border-collapse:collapse;font-size:14px">
      <thead>
        <tr style="background:#f8fafc;border-bottom:2px solid #e2e8f0">
          <th style="padding:12px 16px;text-align:left">Transaction ID</th>
          <th style="padding:12px 16px;text-align:left">Method</th>
          <th style="padding:12px 16px;text-align:left">Vendor</th>
          <th style="padding:12px 16px;text-align:left">Phone</th>
          <th style="padding:12px 16px;text-align:right">Amount</th>
          <th style="padding:12px 16px;text-align:center">Status</th>
          <th style="padding:12px 16px;text-align:left">Date</th>
        </tr>
      </thead>
      <tbody>
        @forelse($payments as $p)
        @php
          $methodLogos = [
            'bkash'=>'bkash.png','nagad'=>'nagad.png','rocket'=>'rocket.png',
            'visa'=>'visa.png','mastercard'=>'mastercard.png','amex'=>'amex.png',
            'dbbl'=>'dbbl.png','islamibank'=>'islamibank.png','citytouch'=>'citybank.png',
          ];
          $methodColors = [
            'bkash'=>'#e2136e','nagad'=>'#f6821f','rocket'=>'#8b2be2',
            'visa'=>'#1a1f71','mastercard'=>'#eb001b','amex'=>'#2e77bc',
            'dbbl'=>'#005bab','brac'=>'#e2231a','bankasia'=>'#006838',
            'citytouch'=>'#e4002b','mtb'=>'#c8102e','islamibank'=>'#006a4e',
            'mycash'=>'#e2136e','tcash'=>'#e2231a','upay'=>'#1a56db',
            'ipay'=>'#00aeef','okwallet'=>'#f5a623','dmoney'=>'#d97706',
          ];
          $logoFile  = $methodLogos[$p->method] ?? null;
          $logoUrl   = $logoFile && file_exists(public_path('images/gateways/'.$logoFile))
                       ? asset('images/gateways/'.$logoFile) : null;
          $badgeColor = $methodColors[$p->method] ?? '#64748b';
        @endphp
        <tr style="border-bottom:1px solid #f1f5f9">
          <td style="padding:12px 16px;font-family:monospace;font-size:12px;color:#64748b">
            {{ $p->transaction_id }}
          </td>
          <td style="padding:12px 16px">
            <div style="display:flex;align-items:center;gap:7px">
              @if($logoUrl)
                <div style="background:{{ $badgeColor }};border-radius:6px;padding:3px 5px;display:flex;align-items:center;height:26px">
                  <img src="{{ $logoUrl }}" alt="{{ $p->method }}"
                       style="height:18px;width:auto;max-width:40px;object-fit:contain;filter:brightness(0) invert(1)">
                </div>
              @else
                <div style="background:{{ $badgeColor }};color:#fff;border-radius:6px;padding:3px 7px;font-size:10px;font-weight:800">
                  {{ strtoupper($p->method) }}
                </div>
              @endif
              <span style="font-size:13px;color:#374151">{{ $p->method_label ?? ucfirst($p->method) }}</span>
            </div>
          </td>
          <td style="padding:12px 16px;color:#374151;font-size:13px">
            {{ $p->vendor_name ?? '—' }}
          </td>
          <td style="padding:12px 16px;color:#64748b;font-size:13px">
            {{ $p->method_number ?? $p->vendor_phone ?? '—' }}
          </td>
          <td style="padding:12px 16px;text-align:right;font-weight:700;color:#1e3a5f">
            ৳{{ number_format($p->amount,2) }}
          </td>
          <td style="padding:12px 16px;text-align:center">
            <span style="padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600;
              background:{{ $p->status=='success'?'#d1fae5':($p->status=='failed'?'#fee2e2':'#fef3c7') }};
              color:{{ $p->status=='success'?'#065f46':($p->status=='failed'?'#991b1b':'#92400e') }}">
              {{ $p->status }}
            </span>
          </td>
          <td style="padding:12px 16px;color:#64748b;font-size:13px">
            {{ $p->created_at->format('d M Y') }}
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" style="padding:40px;text-align:center;color:#94a3b8">কোনো পেমেন্ট নেই</td>
        </tr>
        @endforelse
      </tbody>
    </table>
    <div style="padding:16px">{{ $payments->links() }}</div>
  </div>
</div>

@endsection