@extends('layouts.app')
@section('title','Payment Successful')
@section('content')

<div style="max-width:500px;margin:40px auto;text-align:center">

  {{-- Success Animation --}}
  <div style="width:90px;height:90px;background:linear-gradient(135deg,#d1fae5,#a7f3d0);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:40px">
    ✅
  </div>

  <h1 style="font-size:24px;font-weight:700;color:#065f46;margin-bottom:8px">পেমেন্ট সফল!</h1>
  <p style="color:#6b7280;font-size:14px;margin-bottom:28px">আপনার transaction সম্পন্ন হয়েছে</p>

  <div class="card" style="text-align:left">
    <div style="background:linear-gradient(135deg,#065f46,#047857);padding:20px;border-radius:14px 14px 0 0">
      <div style="color:rgba(255,255,255,.7);font-size:12px;margin-bottom:4px">Transaction ID</div>
      <div style="color:#fff;font-size:16px;font-weight:700;font-family:monospace">{{ $payment->transaction_id }}</div>
    </div>
    <div class="card-body">
      <table style="width:100%;font-size:14px;border-collapse:collapse">
        <tr style="border-bottom:1px solid #f1f5f9">
          <td style="padding:10px 0;color:#6b7280">Method</td>
          <td style="padding:10px 0;font-weight:600;text-align:right">{{ $payment->method_label }}</td>
        </tr>
        <tr style="border-bottom:1px solid #f1f5f9">
          <td style="padding:10px 0;color:#6b7280">Vendor</td>
          <td style="padding:10px 0;font-weight:600;text-align:right">{{ $payment->vendor_name }}</td>
        </tr>
        <tr style="border-bottom:1px solid #f1f5f9">
          <td style="padding:10px 0;color:#6b7280">Vendor Phone</td>
          <td style="padding:10px 0;font-weight:600;text-align:right">{{ $payment->vendor_phone }}</td>
        </tr>
        @if($payment->method_number)
        <tr style="border-bottom:1px solid #f1f5f9">
          <td style="padding:10px 0;color:#6b7280">{{ $payment->method_label }} নম্বর</td>
          <td style="padding:10px 0;font-weight:600;text-align:right">{{ $payment->method_number }}</td>
        </tr>
        @endif
        @if($payment->book)
        <tr style="border-bottom:1px solid #f1f5f9">
          <td style="padding:10px 0;color:#6b7280">বই</td>
          <td style="padding:10px 0;font-weight:600;text-align:right">{{ $payment->book->title }}</td>
        </tr>
        @endif
        @if($payment->notes)
        <tr style="border-bottom:1px solid #f1f5f9">
          <td style="padding:10px 0;color:#6b7280">নোট</td>
          <td style="padding:10px 0;font-weight:600;text-align:right">{{ $payment->notes }}</td>
        </tr>
        @endif
        <tr>
          <td style="padding:12px 0;color:#374151;font-weight:700;font-size:16px">মোট পরিমাণ</td>
          <td style="padding:12px 0;font-weight:800;font-size:20px;color:#065f46;text-align:right">৳{{ number_format($payment->amount,2) }}</td>
        </tr>
      </table>

      <div style="margin-top:16px;padding:10px;background:#f0fdf4;border-radius:10px;font-size:12px;color:#065f46;text-align:center">
        <i class="fas fa-check-circle"></i> {{ $payment->created_at->format('d M Y, h:i A') }}
      </div>
    </div>
  </div>

  <div style="display:flex;gap:10px;margin-top:20px">
    <a href="{{ route('payments.index') }}" class="btn btn-outline" style="flex:1;text-align:center">
      <i class="fas fa-list"></i> সব পেমেন্ট
    </a>
    <a href="{{ route('payments.create') }}" class="btn btn-primary" style="flex:1;text-align:center">
      <i class="fas fa-plus"></i> নতুন পেমেন্ট
    </a>
    <a href="{{ route('dashboard') }}" class="btn btn-primary" style="flex:1;text-align:center;background:#0e9f6e">
      <i class="fas fa-home"></i> Dashboard
    </a>
  </div>

</div>

@endsection