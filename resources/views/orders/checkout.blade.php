@extends('layouts.shop')
@section('title', 'Đặt hàng')

@section('content')
<div class="container">
    <h3 class="fw-bold text-coffee mb-4">Thông tin đặt hàng</h3>

    <form action="{{ route('order.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-7">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Họ tên <span class="text-danger">*</span></label>
                            <input type="text" name="customer_name"
                                   class="form-control @error('customer_name') is-invalid @enderror"
                                   value="{{ old('customer_name', auth()->user()->name ?? '') }}">
                            @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" name="customer_phone"
                                   class="form-control @error('customer_phone') is-invalid @enderror"
                                   value="{{ old('customer_phone') }}" placeholder="0912345678">
                            @error('customer_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Hình thức nhận hàng</label>
                            <div>
                                <input type="radio" class="btn-check" name="order_type" id="delivery"
                                       value="delivery" {{ old('order_type', 'delivery') === 'delivery' ? 'checked' : '' }}>
                                <label class="btn btn-outline-secondary" for="delivery">
                                    <i class="bi bi-truck"></i> Giao hàng
                                </label>

                                <input type="radio" class="btn-check" name="order_type" id="pickup"
                                       value="pickup" {{ old('order_type') === 'pickup' ? 'checked' : '' }}>
                                <label class="btn btn-outline-secondary" for="pickup">
                                    <i class="bi bi-shop"></i> Lấy tại quầy
                                </label>
                            </div>
                        </div>

                        <div class="mb-3" id="address-block">
                            <label class="form-label fw-bold">Địa chỉ giao hàng</label>
                            <input type="text" name="address"
                                   class="form-control @error('address') is-invalid @enderror"
                                   value="{{ old('address') }}">
                            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-bold">Ghi chú</label>
                            <textarea name="note" rows="2" class="form-control"
                                      placeholder="Ít đường, nhiều đá...">{{ old('note') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Đơn hàng của bạn</h6>
                        @foreach($items as $item)
                            <div class="d-flex justify-content-between small mb-2">
                                <span>{{ $item['name'] }} ({{ $item['size'] }}) × {{ $item['quantity'] }}</span>
                                <span>{{ number_format($item['subtotal'], 0, ',', '.') }}đ</span>
                            </div>
                        @endforeach
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5 text-coffee">
                            <span>Tổng cộng</span>
                            <span>{{ number_format($total, 0, ',', '.') }}đ</span>
                        </div>
                        <p class="small text-muted mt-2 mb-3">
                            <i class="bi bi-cash"></i> Thanh toán khi nhận hàng
                        </p>
                        <button type="submit" class="btn btn-coffee w-100">Xác nhận đặt hàng</button>
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                            Quay lại giỏ hàng
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function toggleAddress() {
    const isPickup = document.getElementById('pickup').checked;
    document.getElementById('address-block').style.display = isPickup ? 'none' : 'block';
}
document.querySelectorAll('input[name="order_type"]').forEach(el => {
    el.addEventListener('change', toggleAddress);
});
toggleAddress();
</script>
@endsection