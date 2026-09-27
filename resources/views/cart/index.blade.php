@extends('layouts.shop')
@section('title', 'Giỏ hàng')

@section('content')
<div class="container">
    <h3 class="fw-bold text-coffee mb-4">Giỏ hàng</h3>

    @if(empty($items))
        <div class="text-center py-5">
            <i class="bi bi-cart-x fs-1 text-muted"></i>
            <p class="text-muted mt-3">Giỏ hàng đang trống</p>
            <a href="{{ route('menu') }}" class="btn btn-coffee">Xem thực đơn</a>
        </div>
    @else
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Món</th>
                                    <th>Size</th>
                                    <th>Đơn giá</th>
                                    <th style="width:130px">SL</th>
                                    <th>Thành tiền</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $key => $item)
                                <tr>
                                  <td class="fw-bold">
                                        {{ $item['name'] }}
                                        @if(!empty($item['note']))
                                            <div class="small text-muted fw-normal">{{ $item['note'] }}</div>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-secondary">{{ $item['size'] }}</span></td>
                                    <td>{{ number_format($item['unit_price'], 0, ',', '.') }}đ</td>
                                    <td>
                                        <form action="{{ route('cart.update', $key) }}" method="POST" class="d-flex">
                                            @csrf @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                                   min="1" max="20" class="form-control form-control-sm"
                                                   onchange="this.form.submit()">
                                        </form>
                                    </td>
                                    <td class="fw-bold text-coffee">
                                        {{ number_format($item['subtotal'], 0, ',', '.') }}đ
                                    </td>
                                    <td>
                                        <form action="{{ route('cart.remove', $key) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="card">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Tổng đơn hàng</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tạm tính</span>
                            <span>{{ number_format($total, 0, ',', '.') }}đ</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5 text-coffee">
                            <span>Tổng cộng</span>
                            <span>{{ number_format($total, 0, ',', '.') }}đ</span>
                        </div>
                        <a href="{{ route('checkout') }}" class="btn btn-coffee w-100 mt-3">Tiến hành đặt hàng</a>                        <a href="{{ route('menu') }}" class="btn btn-outline-secondary w-100 mt-2">
                            Tiếp tục chọn món
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection