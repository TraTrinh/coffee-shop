@extends('layouts.shop')
@section('title', 'Tra cứu đơn hàng')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <h4 class="fw-bold text-coffee mb-4">Tra cứu đơn hàng</h4>

            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('order.track.post') }}" method="POST" class="row g-2">
                        @csrf
                        <div class="col-md-5">
                            <input type="text" name="order_code" class="form-control"
                                   placeholder="Mã đơn (VD: CF20260823-1234)"
                                   value="{{ old('order_code') }}">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="phone" class="form-control"
                                   placeholder="Số điện thoại" value="{{ old('phone') }}">
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-coffee w-100">Tra cứu</button>
                        </div>
                    </form>
                </div>
            </div>

            @isset($order)
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-coffee mb-0">{{ $order->order_code }}</h5>
                            <span class="badge bg-primary fs-6">{{ $order->status_label }}</span>
                        </div>
                        <div class="small text-muted mb-3">
                            Đặt lúc {{ $order->created_at->format('H:i d/m/Y') }}
                        </div>

                        <table class="table table-sm">
                            <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product_name }}
                                        <span class="badge bg-secondary">{{ $item->size }}</span>
                                        × {{ $item->quantity }}</td>
                                    <td class="text-end">{{ number_format($item->subtotal, 0, ',', '.') }}đ</td>
                                </tr>
                            @endforeach
                            <tr class="fw-bold text-coffee">
                                <td>Tổng cộng</td>
                                <td class="text-end">{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endisset
        </div>
    </div>
</div>
@endsection