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
      ['key'=>'visa',       'label'=>'VISA',       'color'=>'#1a1f71', 'bg'=>'#eef0ff', 'logo'=>'visa.png'],
      ['key'=>'mastercard', 'label'=>'Mastercard', 'color'=>'#eb001b', 'bg'=>'#fff0f0', 'logo'=>'mastercard.png'],
      ['key'=>'amex',       'label'=>'Amex',       'color'=>'#2e77bc', 'bg'=>'#eef5ff', 'logo'=>'amex.png'],
    ]
  ],
  'banks' => [
    'label' => 'Internet Banking',
    'items' => [
      ['key'=>'dbbl',       'label'=>'DBBL Nexus',  'color'=>'#005bab', 'bg'=>'#eef4ff', 'logo'=>'dbbl.png'],
      ['key'=>'brac',       'label'=>'BRAC Bank',   'color'=>'#e2231a', 'bg'=>'#fff0f0', 'logo'=>'brac.png'],
      ['key'=>'bankasia',   'label'=>'Bank Asia',   'color'=>'#006838', 'bg'=>'#efffef', 'logo'=>'bankasia.png'],
      ['key'=>'citytouch',  'label'=>'CityTouch',   'color'=>'#e4002b', 'bg'=>'#fff0f2', 'logo'=>'citybank.png'],
      ['key'=>'mtb',        'label'=>'MTB',         'color'=>'#c8102e', 'bg'=>'#fff0f2', 'logo'=>'mtb.png'],
      ['key'=>'islamibank', 'label'=>'Islami Bank', 'color'=>'#006a4e', 'bg'=>'#efffef', 'logo'=>'islamibank.png'],
    ]
  ],
  'mfs' => [
    'label' => 'Mobile Banking',
    'items' => [
      ['key'=>'bkash',    'label'=>'bKash',     'color'=>'#e2136e', 'bg'=>'#fff0f7', 'logo'=>'bkash.png'],
      ['key'=>'nagad',    'label'=>'Nagad',     'color'=>'#f6821f', 'bg'=>'#fff7ee', 'logo'=>'nagad.png'],
      ['key'=>'rocket',   'label'=>'Rocket',    'color'=>'#8b2be2', 'bg'=>'#f5f0ff', 'logo'=>'rocket.png'],
      ['key'=>'mycash',   'label'=>'MyCash',    'color'=>'#e2136e', 'bg'=>'#fff0f7', 'logo'=>'mycash.png'],
      ['key'=>'tcash',    'label'=>'T-Cash',    'color'=>'#e2231a', 'bg'=>'#fff0f0', 'logo'=>'tcash.png'],
      ['key'=>'upay',     'label'=>'Upay',      'color'=>'#1a56db', 'bg'=>'#eef4ff', 'logo'=>'upay.png'],
      ['key'=>'ipay',     'label'=>'iPay',      'color'=>'#00aeef', 'bg'=>'#eefaff', 'logo'=>'ipay.png'],
      ['key'=>'okwallet', 'label'=>'OK Wallet', 'color'=>'#f5a623', 'bg'=>'#fffaee', 'logo'=>'okwallet.png'],
      ['key'=>'dmoney',   'label'=>'Dmoney',    'color'=>'#f5a623', 'bg'=>'#fffaee', 'logo'=>'dmoney.png'],
    ]
  ],
];

$selectedInfo = ['key'=>$method,'label'=>ucfirst($method),'color'=>'#1a56db','bg'=>'#eef4ff','logo'=>null];
foreach($methods as $group) {
  foreach($group['items'] as $item) {
    if($item['key'] === $method) { $selectedInfo = $item; break 2; }
  }
}

// Helper: logo path checker
function gatewayLogo($filename) {
  $path = public_path('images/gateways/' . $filename);
  return file_exists($path) ? asset('images/gateways/' . $filename) : null;
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
            @php
              $isActive = $method == $item['key'];
              $logoUrl  = gatewayLogo($item['logo']);
            @endphp
            <a href="{{ route('payments.create',['method'=>$item['key']]) }}"
               style="padding:8px 12px;border-radius:10px;text-decoration:none;font-size:13px;font-weight:600;
                      display:flex;align-items:center;gap:7px;
                      border:2px solid {{ $isActive ? $item['color'] : '#e5e7eb' }};
                      background:{{ $isActive ? $item['bg'] : '#fff' }};
                      color:{{ $isActive ? $item['color'] : '#6b7280' }};
                      transition:.15s">
              @if($logoUrl)
                <img src="{{ $logoUrl }}" alt="{{ $item['label'] }}"
                     style="height:20px;width:auto;max-width:48px;object-fit:contain;
                            {{ !$isActive ? 'filter:grayscale(80%) opacity(.7)' : '' }}">
              @else
                @php
                  $fallback=['bkash'=>'📱','nagad'=>'🟠','rocket'=>'🚀','visa'=>'💳','mastercard'=>'💳',
                    'amex'=>'💳','dbbl'=>'🏦','brac'=>'🏦','bankasia'=>'🏦','mycash'=>'📲',
                    'tcash'=>'📲','upay'=>'📲','ipay'=>'📲','okwallet'=>'👛','dmoney'=>'💰',
                    'citytouch'=>'🏙️','mtb'=>'🏦','islamibank'=>'🕌'];
                @endphp
                <span style="font-size:16px">{{ $fallback[$item['key']] ?? '💳' }}</span>
              @endif
              <span>{{ $item['label'] }}</span>
              @if($isActive)<span style="margin-left:2px">✓</span>@endif
            </a>
            @endforeach
          </div>
        </div>
        @endforeach

      </div>
    </div>

    {{-- SSLCommerz Style Logo Strip --}}
    <div style="background:#111827;border-radius:14px;padding:14px 18px">
      <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;row-gap:8px">

        <span style="color:#fff;font-size:12px;font-weight:700;white-space:nowrap;letter-spacing:.3px">Pay With</span>
        <div style="width:1px;height:30px;background:rgba(255,255,255,.2);flex-shrink:0"></div>

        @php
        $stripLogos = [
          ['key'=>'visa',       'label'=>'VISA',    'color'=>'#1a1f71', 'logo'=>'visa.png'],
          ['key'=>'mastercard', 'label'=>'MC',      'color'=>'#eb001b', 'logo'=>'mastercard.png'],
          ['key'=>'amex',       'label'=>'AMEX',    'color'=>'#2e77bc', 'logo'=>'amex.png'],
          ['key'=>'dbbl',       'label'=>'DBBL',    'color'=>'#005bab', 'logo'=>'dbbl.png'],
          ['key'=>'brac',       'label'=>'BRAC',    'color'=>'#e2231a', 'logo'=>'brac.png'],
          ['key'=>'bankasia',   'label'=>'B.Asia',  'color'=>'#006838', 'logo'=>'bankasia.png'],
          ['key'=>'bkash',      'label'=>'bKash',   'color'=>'#e2136e', 'logo'=>'bkash.png'],
          ['key'=>'nagad',      'label'=>'Nagad',   'color'=>'#f6821f', 'logo'=>'nagad.png'],
          ['key'=>'rocket',     'label'=>'Rocket',  'color'=>'#8b2be2', 'logo'=>'rocket.png'],
          ['key'=>'mycash',     'label'=>'MyCash',  'color'=>'#e2136e', 'logo'=>'mycash.png'],
          ['key'=>'tcash',      'label'=>'T-Cash',  'color'=>'#e2231a', 'logo'=>'tcash.png'],
          ['key'=>'upay',       'label'=>'Upay',    'color'=>'#1a56db', 'logo'=>'upay.png'],
          ['key'=>'ipay',       'label'=>'iPay',    'color'=>'#00aeef', 'logo'=>'ipay.png'],
          ['key'=>'okwallet',   'label'=>'OK',      'color'=>'#f5a623', 'logo'=>'okwallet.png'],
          ['key'=>'mtb',        'label'=>'MTB',     'color'=>'#c8102e', 'logo'=>'mtb.png'],
          ['key'=>'islamibank', 'label'=>'Islami',  'color'=>'#006a4e', 'logo'=>'islamibank.png'],
          ['key'=>'citytouch',  'label'=>'City',    'color'=>'#e4002b', 'logo'=>'citybank.png'],
          ['key'=>'dmoney',     'label'=>'Dmoney',  'color'=>'#d97706', 'logo'=>'dmoney.png'],
        ];
        @endphp

        @foreach($stripLogos as $sl)
        @php $slLogoUrl = gatewayLogo($sl['logo']); @endphp
        <div style="background:{{ $sl['color'] }};border-radius:7px;
                    height:32px;min-width:44px;padding:0 6px;
                    display:flex;align-items:center;justify-content:center;overflow:hidden">
          @if($slLogoUrl)
            <img src="{{ $slLogoUrl }}" alt="{{ $sl['label'] }}"
                 style="height:20px;width:auto;max-width:52px;object-fit:contain;
                        filter:brightness(0) invert(1)">
          @else
            <span style="color:#fff;font-size:9px;font-weight:800;white-space:nowrap">{{ $sl['label'] }}</span>
          @endif
        </div>
        @endforeach

        <div style="margin-left:auto;display:flex;align-items:center;gap:6px;flex-shrink:0">
          <span style="color:#6b7280;font-size:10px">Verified by</span>
          <div style="background:#fff;padding:3px 8px;border-radius:6px;font-size:10px;font-weight:800;color:#1a56db">SIMULATOR</div>
        </div>

      </div>
    </div>
  </div>

  {{-- RIGHT: Payment Form --}}
  <div class="card" style="position:sticky;top:20px">

    {{-- Card Header with Logo --}}
    <div style="background:{{ $selectedInfo['bg'] }};padding:20px;border-radius:14px 14px 0 0;text-align:center;border-bottom:2px solid {{ $selectedInfo['color'] }}22">
      @php $headerLogo = gatewayLogo($selectedInfo['logo'] ?? ''); @endphp
      @if($headerLogo)
        <div style="margin-bottom:8px;height:50px;display:flex;align-items:center;justify-content:center">
          <img src="{{ $headerLogo }}" alt="{{ $selectedInfo['label'] }}"
               style="height:46px;width:auto;max-width:160px;object-fit:contain">
        </div>
      @else
        <div style="font-size:36px;margin-bottom:6px">
          @php
            $icons=['bkash'=>'📱','nagad'=>'🟠','rocket'=>'🚀','visa'=>'💳','mastercard'=>'💳',
                    'amex'=>'💳','dbbl'=>'🏦','brac'=>'🏦','bankasia'=>'🏦','mycash'=>'📲',
                    'tcash'=>'📲','upay'=>'📲','ipay'=>'📲','okwallet'=>'👛','dmoney'=>'💰',
                    'citytouch'=>'🏙️','mtb'=>'🏦','islamibank'=>'🕌'];
            echo $icons[$method] ?? '💳';
          @endphp
        </div>
      @endif
      <div style="font-weight:700;color:{{ $selectedInfo['color'] }};font-size:18px">{{ $selectedInfo['label'] }}</div>
      <div style="font-size:12px;color:#64748b;margin-top:4px">Secure Sandbox Payment</div>
    </div>

    <div class="card-body">
      <form method="POST" action="{{ route('payments.sslPay') }}" id="payForm">
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

        {{-- Submit Button with Logo --}}
        @php $btnLogo = gatewayLogo($selectedInfo['logo'] ?? ''); @endphp
        <button type="submit" id="payBtn"
          style="width:100%;padding:14px;background:{{ $selectedInfo['color'] }};color:#fff;border:none;
                 border-radius:12px;font-size:15px;font-weight:700;cursor:pointer;font-family:inherit;
                 transition:.2s;display:flex;align-items:center;justify-content:center;gap:8px">
          @if($btnLogo)
            <img src="{{ $btnLogo }}" alt=""
                 style="height:20px;width:auto;object-fit:contain;filter:brightness(0) invert(1)">
          @else
            🔐
          @endif
          {{ $selectedInfo['label'] }}-এ পেমেন্ট করুন
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