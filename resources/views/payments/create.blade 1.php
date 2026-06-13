@extends('layouts.app')
@section('title','পেমেন্ট করুন')
@section('content')

<div class="page-header">
  <div>
    <h1 class="page-title">💳 পেমেন্ট করুন</h1>
    <p class="page-sub">Secure Payment Gateway Simulator</p>
  </div>
  <a href="{{ route('payments.index') }}" class="btn btn-outline">
    <i class="fas fa-arrow-left"></i> Back
  </a>
</div>

@php
$methods = [
  'cards' => [
    'label' => 'Credit / Debit Card',
    'items' => [
      ['key'=>'visa',       'label'=>'VISA',         'color'=>'#1a1f71', 'bg'=>'#eef0ff'],
      ['key'=>'mastercard', 'label'=>'Mastercard',   'color'=>'#eb001b', 'bg'=>'#fff0f0'],
      ['key'=>'amex',       'label'=>'Amex',         'color'=>'#2e77bc', 'bg'=>'#eef5ff'],
    ]
  ],
  'banks' => [
    'label' => 'Internet Banking',
    'items' => [
      ['key'=>'dbbl',      'label'=>'DBBL Nexus',  'color'=>'#005bab', 'bg'=>'#eef4ff'],
      ['key'=>'brac',      'label'=>'BRAC Bank',   'color'=>'#e2231a', 'bg'=>'#fff0f0'],
      ['key'=>'bankasia',  'label'=>'Bank Asia',   'color'=>'#006838', 'bg'=>'#efffef'],
      ['key'=>'citytouch', 'label'=>'CityTouch',   'color'=>'#e4002b', 'bg'=>'#fff0f2'],
      ['key'=>'mtb',       'label'=>'MTB',         'color'=>'#c8102e', 'bg'=>'#fff0f2'],
      ['key'=>'islamibank','label'=>'Islami Bank', 'color'=>'#006a4e', 'bg'=>'#efffef'],
    ]
  ],
  'mfs' => [
    'label' => 'Mobile Banking',
    'items' => [
      ['key'=>'bkash',    'label'=>'bKash',     'color'=>'#e2136e', 'bg'=>'#fff0f7'],
      ['key'=>'nagad',    'label'=>'Nagad',     'color'=>'#f6821f', 'bg'=>'#fff7ee'],
      ['key'=>'rocket',   'label'=>'Rocket',    'color'=>'#8b2be2', 'bg'=>'#f5f0ff'],
      ['key'=>'mycash',   'label'=>'MyCash',    'color'=>'#e2136e', 'bg'=>'#fff0f7'],
      ['key'=>'tcash',    'label'=>'T-Cash',    'color'=>'#e2231a', 'bg'=>'#fff0f0'],
      ['key'=>'upay',     'label'=>'Upay',      'color'=>'#1a56db', 'bg'=>'#eef4ff'],
      ['key'=>'ipay',     'label'=>'iPay',      'color'=>'#00aeef', 'bg'=>'#eefaff'],
      ['key'=>'okwallet', 'label'=>'OK Wallet', 'color'=>'#f5a623', 'bg'=>'#fffaee'],
      ['key'=>'dmoney',   'label'=>'Dmoney',    'color'=>'#f5a623', 'bg'=>'#fffaee'],
    ]
  ],
];

// Find selected method info
$selectedInfo = ['key'=>$method,'label'=>ucfirst($method),'color'=>'#1a56db','bg'=>'#eef4ff'];
foreach($methods as $group) {
  foreach($group['items'] as $item) {
    if($item['key'] === $method) { $selectedInfo = $item; break 2; }
  }
}
@endphp

<div style="display:grid;grid-template-columns:1fr 380px;gap:24px;align-items:start">

  {{-- LEFT: Method Selection --}}
  <div>
    <div class="card" style="margin-bottom:20px">
      <div class="card-header"><h2>💳 Payment Method সিলেক্ট করুন</h2></div>
      <div class="card-body">

        @foreach($methods as $groupKey => $group)
        <div style="margin-bottom:20px">
          <div style="font-size:12px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px">
            {{ $group['label'] }}
          </div>
          <div style="display:flex;flex-wrap:wrap;gap:8px">
            @foreach($group['items'] as $item)
            <a href="{{ route('payments.create',['method'=>$item['key']]) }}"
               style="padding:10px 14px;border-radius:10px;text-decoration:none;font-size:13px;font-weight:600;
                      border:2px solid {{ $method==$item['key'] ? $item['color'] : '#e5e7eb' }};
                      background:{{ $method==$item['key'] ? $item['bg'] : '#fff' }};
                      color:{{ $method==$item['key'] ? $item['color'] : '#6b7280' }};
                      transition:.15s">
              {{ $item['label'] }}
            </a>
            @endforeach
          </div>
        </div>
        @endforeach

      </div>
    </div>

    {{-- Logos Strip (SSLCommerz style) --}}
    <div style="background:#111;border-radius:14px;padding:16px 20px;display:flex;align-items:center;gap:12px;flex-wrap:wrap">
      <span style="color:#fff;font-size:13px;font-weight:600;white-space:nowrap">Pay With</span>
      <div style="width:1px;height:40px;background:rgba(255,255,255,.2)"></div>
      @foreach([
        ['VISA','#fff','#1a1f71'],['MC','#fff','#eb001b'],['AMEX','#fff','#2e77bc'],
        ['DBBL','#fff','#005bab'],['BRAC','#fff','#e2231a'],['B.Asia','#fff','#006838'],
        ['bKash','#fff','#e2136e'],['Nagad','#fff','#f6821f'],['Rocket','#fff','#8b2be2'],
        ['MyCash','#fff','#e2136e'],['T-Cash','#fff','#e2231a'],['Upay','#fff','#1a56db'],
        ['iPay','#fff','#00aeef'],['OK','#fff','#f5a623'],['MTB','#fff','#c8102e'],
        ['Islami','#fff','#006a4e'],['City','#fff','#e4002b'],['Dmoney','#fff','#f5a623'],
      ] as $logo)
      <div style="background:{{ $logo[2] }};color:{{ $logo[0] }};padding:5px 8px;border-radius:7px;font-size:10px;font-weight:800;min-width:36px;text-align:center;white-space:nowrap">
        {{ $logo[0] }}
      </div>
      @endforeach
      <div style="margin-left:auto;display:flex;align-items:center;gap:6px">
        <span style="color:#94a3b8;font-size:10px">Verified by</span>
        <div style="background:#fff;padding:4px 8px;border-radius:6px;font-size:11px;font-weight:800;color:#1a56db">SIMULATOR</div>
      </div>
    </div>
  </div>

  {{-- RIGHT: Payment Form --}}
  <div class="card" style="position:sticky;top:20px">
    <div style="background:{{ $selectedInfo['bg'] }};padding:20px;border-radius:14px 14px 0 0;text-align:center;border-bottom:2px solid {{ $selectedInfo['color'] }}22">
      <div style="font-size:36px;margin-bottom:6px">
        @php
          $icons=['bkash'=>'📱','nagad'=>'🟠','rocket'=>'🚀','visa'=>'💳','mastercard'=>'💳',
                  'amex'=>'💳','dbbl'=>'🏦','brac'=>'🏦','bankasia'=>'🏦','mycash'=>'📲',
                  'tcash'=>'📲','upay'=>'📲','ipay'=>'📲','okwallet'=>'👛','dmoney'=>'💰',
                  'citytouch'=>'🏙️','mtb'=>'🏦','islamibank'=>'🕌'];
          echo $icons[$method] ?? '💳';
        @endphp
      </div>
      <div style="font-weight:700;color:{{ $selectedInfo['color'] }};font-size:18px">{{ $selectedInfo['label'] }}</div>
      <div style="font-size:12px;color:#64748b;margin-top:4px">Secure Sandbox Payment</div>
    </div>

    <div class="card-body">
      <form method="POST" action="{{ route('payments.store') }}" id="payForm">
        @csrf
        <input type="hidden" name="method" value="{{ $method }}">

        {{-- Vendor Name --}}
        <div style="margin-bottom:14px">
          <label style="display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:.3px">
            🏪 Vendor / দোকানের নাম
          </label>
          <input type="text" name="vendor_name" required
            value="{{ old('vendor_name') }}"
            placeholder="যেমন: Rokomari, Pathak Shamabesh..."
            style="width:100%;padding:10px 12px;border:2px solid #e5e7eb;border-radius:10px;font-size:14px;font-family:inherit;outline:none;transition:.2s"
            onfocus="this.style.borderColor='{{ $selectedInfo['color'] }}'"
            onblur="this.style.borderColor='#e5e7eb'">
        </div>

        {{-- Vendor Phone --}}
        <div style="margin-bottom:14px">
          <label style="display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:.3px">
            📞 Vendor ফোন নম্বর
          </label>
          <input type="text" name="vendor_phone" required
            value="{{ old('vendor_phone') }}"
            placeholder="01XXXXXXXXX"
            style="width:100%;padding:10px 12px;border:2px solid #e5e7eb;border-radius:10px;font-size:14px;font-family:inherit;outline:none;transition:.2s"
            onfocus="this.style.borderColor='{{ $selectedInfo['color'] }}'"
            onblur="this.style.borderColor='#e5e7eb'">
        </div>

        {{-- Amount --}}
        <div style="margin-bottom:14px">
          <label style="display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:.3px">
            💰 পরিমাণ (৳)
          </label>
          <input type="number" name="amount" step="0.01" min="1" required
            value="{{ old('amount') }}"
            placeholder="0.00"
            style="width:100%;padding:10px 12px;border:2px solid #e5e7eb;border-radius:10px;font-size:18px;font-weight:700;font-family:inherit;outline:none;transition:.2s"
            onfocus="this.style.borderColor='{{ $selectedInfo['color'] }}'"
            onblur="this.style.borderColor='#e5e7eb'">
        </div>

        {{-- Method Number (for MFS) --}}
        @if(in_array($method,['bkash','nagad','rocket','mycash','tcash','upay','ipay','okwallet','dmoney']))
        <div style="margin-bottom:14px">
          <label style="display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:.3px">
            📱 {{ $selectedInfo['label'] }} নম্বর
          </label>
          <input type="text" name="method_number"
            value="{{ old('method_number') }}"
            placeholder="01XXXXXXXXX"
            style="width:100%;padding:10px 12px;border:2px solid #e5e7eb;border-radius:10px;font-size:14px;font-family:inherit;outline:none;transition:.2s"
            onfocus="this.style.borderColor='{{ $selectedInfo['color'] }}'"
            onblur="this.style.borderColor='#e5e7eb'">
        </div>
        @endif

        {{-- Book --}}
        <div style="margin-bottom:14px">
          <label style="display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:.3px">
            📚 বই (optional)
          </label>
          <select name="book_id"
            style="width:100%;padding:10px 12px;border:2px solid #e5e7eb;border-radius:10px;font-size:13px;font-family:inherit;outline:none;background:#fff">
            <option value="">— বই সিলেক্ট করুন —</option>
            @foreach($books as $book)
              <option value="{{ $book->id }}" {{ old('book_id')==$book->id?'selected':'' }}>
                {{ $book->title }} — ৳{{ number_format($book->purchase_price,0) }}
              </option>
            @endforeach
          </select>
        </div>

        {{-- Notes --}}
        <div style="margin-bottom:18px">
          <label style="display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:5px;text-transform:uppercase;letter-spacing:.3px">
            📝 নোট
          </label>
          <textarea name="notes" rows="2"
            placeholder="পেমেন্টের বিবরণ..."
            style="width:100%;padding:10px 12px;border:2px solid #e5e7eb;border-radius:10px;font-size:13px;font-family:inherit;outline:none;resize:none">{{ old('notes') }}</textarea>
        </div>

        <button type="submit" id="payBtn"
          style="width:100%;padding:14px;background:{{ $selectedInfo['color'] }};color:#fff;border:none;border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;font-family:inherit;transition:.2s">
          🔐 {{ $selectedInfo['label'] }}-এ পেমেন্ট করুন
        </button>

        <div style="text-align:center;margin-top:12px;font-size:11px;color:#94a3b8">
          <i class="fas fa-lock"></i> This is a sandbox simulator — no real transaction
        </div>
      </form>
    </div>
  </div>

</div>

@endsection
@push('scripts')
<script>
document.getElementById('payForm').addEventListener('submit', function() {
  const btn = document.getElementById('payBtn');
  btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
  btn.disabled = true;
});
</script>
@endpush