@extends('layouts.shop')
@section('title', $product->name)

@section('content')
<div class="container">
    <nav class="mb-4">
        <a href="{{ route('menu') }}" class="text-coffee text-decoration-none">
            <i class="bi bi-arrow-left"></i> Quay lại thực đơn
        </a>
    </nav>

    <div class="row">
        <div class="col-md-5">
            <img src="{{ $product->image_url }}" class="img-fluid rounded shadow-sm" alt="{{ $product->name }}">
        </div>
        <div class="col-md-7">
            <span class="badge bg-secondary mb-2">{{ $product->category->name }}</span>
            <h2 class="fw-bold text-coffee">{{ $product->name }}</h2>
            <p class="text-muted">{{ $product->description }}</p>

            <h4 class="fw-bold text-coffee mb-4" id="price-display">
                {{ number_format($product->price, 0, ',', '.') }}đ
            </h4>

            <div class="mb-3">
<form action="{{ route('cart.add') }}" method="POST">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">

    <div class="mb-3">
        <label class="form-label fw-bold">Kích cỡ</label>
        <div class="btn-group d-block" role="group">
            @foreach(['S' => 0, 'M' => 5000, 'L' => 10000] as $size => $extra)
                <input type="radio" class="btn-check" name="size" id="size{{ $size }}"
                       value="{{ $size }}" data-extra="{{ $extra }}"
                       {{ $size === 'M' ? 'checked' : '' }}>
                <label class="btn btn-outline-secondary" for="size{{ $size }}">
                    {{ $size }} {{ $extra > 0 ? '(+'.number_format($extra,0,',','.').'đ)' : '' }}
                </label>
            @endforeach
        </div>
    </div>

    <div class="mb-4" style="max-width: 150px">
        <label class="form-label fw-bold">Số lượng</label>
        <input type="number" name="quantity" class="form-control" value="1" min="1" max="20">
    </div>

    <button type="submit" class="btn btn-coffee btn-lg">
        <i class="bi bi-cart-plus"></i> Thêm vào giỏ
    </button>
</form>
        </div>
    </div>

    @if($related->isNotEmpty())
        <h5 class="fw-bold text-coffee mt-5 mb-3">Món tương tự</h5>
        <div class="row">
            @foreach($related as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    @endif
</div>

<script>
const basePrice = {{ $product->price }};
document.querySelectorAll('input[name="size"]').forEach(el => {
    el.addEventListener('change', function () {
        const total = basePrice + parseInt(this.dataset.extra);
        document.getElementById('price-display').textContent =
            total.toLocaleString('vi-VN') + 'đ';
    });
});
</script>
@endsection