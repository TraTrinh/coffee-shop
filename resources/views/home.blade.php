@extends('layouts.shop')
@section('title', 'Trang chủ')

@section('content')
<div class="container">

    <div class="p-5 mb-5 rounded text-center text-white" style="background: var(--brown)">
        <h1 class="fw-bold">Cà phê ngon mỗi ngày</h1>
        <p class="lead">Đặt hàng online, nhận nhanh trong 20 phút</p>
        <a href="{{ route('menu') }}" class="btn btn-light btn-lg mt-2">Xem thực đơn</a>
    </div>

    <h4 class="fw-bold text-coffee mb-4">Món nổi bật</h4>
    <div class="row">
        @foreach($featured as $product)
            @include('partials.product-card', ['product' => $product])
        @endforeach
    </div>

    <h4 class="fw-bold text-coffee mb-4 mt-5">Danh mục</h4>
    <div class="row g-3">
        @foreach($categories as $cat)
            <div class="col-6 col-md-3">
                <a href="{{ route('menu', ['category' => $cat->slug]) }}"
                   class="text-decoration-none">
                    <div class="card text-center py-4 h-100">
                        <div class="card-body">
                            <i class="bi bi-cup-hot fs-1 text-coffee"></i>
                            <h6 class="mt-2 fw-bold text-coffee">{{ $cat->name }}</h6>
                            <small class="text-muted">{{ $cat->available_products_count ?? $cat->availableProducts->count() }} món</small>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

</div>
@endsection