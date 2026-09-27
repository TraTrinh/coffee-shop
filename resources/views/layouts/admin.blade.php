<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Quản trị') — Coffee Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --brown:#6F4E37; }
        body { background:#f5f6fa; }
        .sidebar { background:var(--brown); min-height:100vh; width:230px; }
        .sidebar a { color:rgba(255,255,255,.8); text-decoration:none; display:block;
                     padding:12px 20px; border-left:3px solid transparent; }
        .sidebar a:hover, .sidebar a.active { color:#fff; background:rgba(0,0,0,.15);
                                              border-left-color:#fff; }
        .stat-card { border:none; border-radius:10px; }
    </style>
</head>
<body>
<div class="d-flex">

    <div class="sidebar d-none d-md-block">
        <div class="p-3 text-white fw-bold border-bottom border-light border-opacity-25">
            <i class="bi bi-cup-hot-fill"></i> Quản trị
        </div>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Tổng quan
        </a>
        <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i> Đơn hàng
        </a>
        <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="bi bi-cup-straw"></i> Sản phẩm
        </a>
        <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i> Danh mục
        </a>
        <hr class="text-white opacity-25 my-2">
        <a href="{{ route('home') }}"><i class="bi bi-house"></i> Xem website</a>
    </div>

    <div class="flex-grow-1">
        <nav class="navbar bg-white shadow-sm px-4">
            <span class="fw-bold" style="color:var(--brown)">@yield('title', 'Tổng quan')</span>
            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="small text-muted">{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-box-arrow-right"></i> Đăng xuất
                    </button>
                </form>
            </div>
        </nav>

        <div class="p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>