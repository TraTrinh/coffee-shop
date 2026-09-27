<div class="col-6 col-md-4 col-lg-3 mb-4">
    <div class="card card-product h-100 shadow-sm">
        <img src="{{ $product->image_url }}" class="card-img-top product-img" alt="{{ $product->name }}">
        <div class="card-body d-flex flex-column">
            <h6 class="card-title fw-bold">{{ $product->name }}</h6>
            <p class="card-text small text-muted flex-grow-1">
                {{ Str::limit($product->description, 50) }}
            </p>
            <div class="d-flex justify-content-between align-items-center">
                <span class="fw-bold text-coffee">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                <a href="{{ route('product.show', $product->slug) }}" class="btn btn-sm btn-coffee">
                    Chi tiết
                </a>
            </div>
        </div>
    </div>
</div>