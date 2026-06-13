<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','BookShelf') - আমার বইয়ের ঘর</title>
<link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📚</text></svg>">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Noto+Serif+Bengali:wght@400;700&display=swap" rel="stylesheet">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
<div class="wrapper">

  <!-- Sidebar -->
  <nav class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <div class="logo">📚</div>
      <div class="logo-text">
        <h1>BookShelf</h1>
        <span>আমার বইয়ের ঘর</span>
      </div>
    </div>

    <ul class="sidebar-menu">
      <li>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active':'' }}">
          <i class="fas fa-home"></i><span>Dashboard</span>
        </a>
      </li>

      <li class="menu-header"><span>Library</span></li>
      <li>
        <a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.*') ? 'active':'' }}">
          <i class="fas fa-book"></i><span>সব বই</span>
        </a>
      </li>
      <li>
        <a href="{{ route('books.index') }}?status=reading" class="{{ request()->get('status')=='reading' ? 'active':'' }}">
          <i class="fas fa-book-open"></i><span>পড়ছি</span>
        </a>
      </li>
      <li>
        <a href="{{ route('books.index') }}?status=completed" class="{{ request()->get('status')=='completed' ? 'active':'' }}">
          <i class="fas fa-check-circle"></i><span>পড়া শেষ</span>
        </a>
      </li>
      <li>
        <a href="{{ route('books.index') }}?status=wishlist" class="{{ request()->get('status')=='wishlist' ? 'active':'' }}">
          <i class="fas fa-star"></i><span>Wishlist</span>
        </a>
      </li>
      <li>
        <a href="{{ route('books.index') }}?status=ordered" class="{{ request()->get('status')=='ordered' ? 'active':'' }}">
          <i class="fas fa-truck"></i><span>Order দিয়েছি</span>
        </a>
      </li>
      <li>
        <a href="{{ route('books.create') }}" class="{{ request()->routeIs('books.create') ? 'active':'' }}">
          <i class="fas fa-plus-circle"></i><span>বই যোগ করুন</span>
        </a>
      </li>

      <li class="menu-header"><span>Manage</span></li>
      <li>
        <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active':'' }}">
          <i class="fas fa-tags"></i><span>Categories</span>
        </a>
      </li>
      <li>
        <a href="{{ route('vendors.index') }}" class="{{ request()->routeIs('vendors.*') ? 'active':'' }}">
          <i class="fas fa-store"></i><span>Vendors</span>
        </a>
      </li>

      <li class="menu-header"><span>Finance</span></li>
      <li>
        <a href="{{ route('payments.index') }}" class="{{ request()->routeIs('payments.*') ? 'active':'' }}">
          <i class="fas fa-credit-card"></i><span>Payments</span>
        </a>
      </li>
      <li>
        <a href="{{ route('reports.budget') }}" class="{{ request()->routeIs('reports.*') ? 'active':'' }}">
          <i class="fas fa-chart-bar"></i><span>Budget & Report</span>
        </a>
      </li>
    </ul>

    <div class="sidebar-footer">
      <div class="sidebar-user">
        <div class="sidebar-avatar">{{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}</div>
        <div class="sidebar-user-info">
          <strong>{{ Auth::user()->name ?? 'User' }}</strong>
          <span>৳{{ number_format(Auth::user()->wallet_balance ?? 0, 0) }} wallet</span>
        </div>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="main-content" id="main">
    <header class="topbar">
      <button class="toggle-btn" id="toggleBtn"><i class="fas fa-bars"></i></button>

      <div class="search-bar">
        <form action="{{ route('books.index') }}" method="GET">
          <input type="text" name="search" placeholder="বই খুঁজুন..." value="{{ request('search') }}">
          <button type="submit"><i class="fas fa-search"></i></button>
        </form>
      </div>

      <div class="topbar-right">
        <a href="{{ route('books.create') }}" class="btn-add-quick">
          <i class="fas fa-plus"></i> বই যোগ
        </a>
        <a href="{{ route('payments.create') }}" class="btn-add-quick btn-pay">
          <i class="fas fa-wallet"></i> পেমেন্ট
        </a>

        <!-- User Dropdown -->
        <div class="user-menu" id="userMenu">
          <div class="user-info" onclick="toggleUserMenu()">
            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}</div>
            <span>{{ Auth::user()->name ?? 'User' }}</span>
            <i class="fas fa-chevron-down" style="font-size:11px;margin-left:4px;color:#94a3b8"></i>
          </div>
          <div class="user-dropdown" id="userDropdown">
            <div class="dropdown-header">
              <strong>{{ Auth::user()->name ?? 'User' }}</strong>
              <span>{{ Auth::user()->email ?? '' }}</span>
            </div>
            <a href="{{ route('payments.index') }}" class="dropdown-item">
              <i class="fas fa-wallet" style="color:#0e9f6e"></i> Payments
              <span class="dropdown-badge">৳{{ number_format(Auth::user()->wallet_balance ?? 0, 0) }}</span>
            </a>
            <div class="dropdown-divider"></div>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="dropdown-item dropdown-logout">
                <i class="fas fa-sign-out-alt"></i> লগআউট
              </button>
            </form>
          </div>
        </div>
      </div>
    </header>

    <main class="content">
      @if(session('success'))
        <div class="alert alert-success">
          <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger">
          <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
      @endif
      @if($errors->any())
        <div class="alert alert-danger">
          @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
      @endif

      @yield('content')
    </main>
  </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script>
function toggleUserMenu() {
  document.getElementById('userDropdown').classList.toggle('show');
}
document.addEventListener('click', function(e) {
  if (!document.getElementById('userMenu').contains(e.target)) {
    document.getElementById('userDropdown').classList.remove('show');
  }
});
</script>
@stack('scripts')
</body>
</html>