<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Budget Report {{ $year }}</title>
<style>
body{font-family:sans-serif;font-size:12px;color:#333}
h1{text-align:center;color:#4f46e5}
table{width:100%;border-collapse:collapse;margin-top:20px}
th{background:#4f46e5;color:#fff;padding:8px;text-align:left}
td{padding:8px;border-bottom:1px solid #eee}
.over{background:#fff1f2;color:#ef4444}
.ok{background:#f0fdf4}
</style>
</head>
<body>
<h1>💰 Budget Report - {{ $year }}</h1>
<table>
<thead><tr><th>মাস</th><th>বাজেট (৳)</th><th>খরচ (৳)</th><th>বাকি (৳)</th><th>অবস্থা</th></tr></thead>
<tbody>
@foreach($monthlyData as $m)
  @php $rem=$m['budget']-$m['spent'];$over=$m['spent']>$m['budget']&&$m['budget']>0; @endphp
  <tr class="{{ $over?'over':($m['spent']>0?'ok':'') }}">
    <td>{{ $m['month_name'] }}</td>
    <td>৳{{ number_format($m['budget'],2) }}</td>
    <td>৳{{ number_format($m['spent'],2) }}</td>
    <td>{{ $rem<0?'-':'' }}৳{{ number_format(abs($rem),2) }}</td>
    <td>{{ $over?'বাজেট অতিক্রম':'ঠিক আছে' }}</td>
  </tr>
@endforeach
</tbody>
</table>
</body>
</html>
