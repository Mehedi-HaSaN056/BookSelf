<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — BookShelf</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Hind Siliguri',sans-serif;min-height:100vh;background:linear-gradient(135deg,#1e3a5f 0%,#0f2027 50%,#1a1a2e 100%);display:flex;align-items:center;justify-content:center;padding:20px}
.auth-card{background:#fff;border-radius:20px;padding:40px;width:100%;max-width:420px;box-shadow:0 25px 60px rgba(0,0,0,.4)}
.auth-logo{text-align:center;margin-bottom:28px}
.auth-logo .icon{font-size:48px;display:block;margin-bottom:8px}
.auth-logo h1{font-size:22px;font-weight:700;color:#1e3a5f}
.auth-logo p{font-size:13px;color:#94a3b8;margin-top:4px}
.form-group{margin-bottom:18px}
.form-group label{display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px}
.form-group input{width:100%;padding:11px 14px;border:2px solid #e5e7eb;border-radius:10px;font-size:14px;font-family:inherit;transition:.2s;outline:none}
.form-group input:focus{border-color:#1a56db;box-shadow:0 0 0 3px rgba(26,86,219,.1)}
.form-group.has-error input{border-color:#ef4444}
.error-msg{font-size:12px;color:#ef4444;margin-top:4px}
.btn-login{width:100%;padding:13px;background:linear-gradient(135deg,#1a56db,#1e3a5f);color:#fff;border:none;border-radius:10px;font-size:15px;font-weight:600;font-family:inherit;cursor:pointer;transition:.2s}
.btn-login:hover{opacity:.92;transform:translateY(-1px)}
.auth-footer{text-align:center;margin-top:20px;font-size:13px;color:#6b7280}
.auth-footer a{color:#1a56db;text-decoration:none;font-weight:600}
.alert-danger{background:#fef2f2;border:1px solid #fecaca;color:#dc2626;padding:10px 14px;border-radius:8px;font-size:13px;margin-bottom:16px}
.remember-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;font-size:13px}
.remember-row label{display:flex;align-items:center;gap:6px;cursor:pointer;color:#374151}
.remember-row a{color:#1a56db;text-decoration:none}
.divider{text-align:center;color:#94a3b8;font-size:12px;margin:16px 0;position:relative}
.divider::before,.divider::after{content:'';position:absolute;top:50%;width:42%;height:1px;background:#e5e7eb}
.divider::before{left:0}.divider::after{right:0}
</style>
</head>
<body>
<div class="auth-card">
  <div class="auth-logo">
    <span class="icon">📚</span>
    <h1>BookShelf</h1>
    <p>আমার বইয়ের ঘর — লগইন করুন</p>
  </div>

  @if($errors->any())
    <div class="alert-danger"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
  @endif

  <form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group {{ $errors->has('email') ? 'has-error':'' }}">
      <label>ইমেইল</label>
      <input type="email" name="email" value="{{ old('email') }}" placeholder="your@email.com" required autofocus>
    </div>
    <div class="form-group">
      <label>পাসওয়ার্ড</label>
      <input type="password" name="password" placeholder="••••••••" required>
    </div>
    <div class="remember-row">
      <label><input type="checkbox" name="remember"> মনে রাখো</label>
    </div>
    <button type="submit" class="btn-login">🔐 লগইন করুন</button>
  </form>

  <div class="auth-footer">
    অ্যাকাউন্ট নেই? <a href="{{ route('register') }}">রেজিস্ট্রেশন করুন</a>
  </div>
</div>
</body>
</html>