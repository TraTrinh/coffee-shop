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
                    @auth
                <h5 class="fw-bold text-coffee mt-4 mb-3">Đơn hàng của bạn</h5>
                       @forelse($myOrders as $o)
                    <div class="card mb-2">
                        <div class="card-body d-flex justify-content-between align-items-center"
                             data-bs-toggle="collapse" data-bs-target="#order-{{ $o->id }}"
                             style="cursor:pointer">
                            <span>
                                <strong>{{ $o->order_code }}</strong>
                                <span class="small text-muted ms-2">{{ $o->created_at->format('H:i d/m/Y') }}</span>
                            </span>
                            <span>
                                <span class="badge bg-primary">{{ $o->status_label }}</span>
                                <span class="fw-bold text-coffee ms-2">{{ number_format($o->total_amount, 0, ',', '.') }}đ</span>
                                <i class="bi bi-chevron-down ms-2"></i>
                            </span>
                        </div>
                        <div class="collapse" id="order-{{ $o->id }}">
                            <div class="px-3 pb-3">
                                <table class="table table-sm mb-0">
                                    @foreach($o->items as $item)
                                        <tr>
                                            <td>{{ $item->product_name }}
                                                @if($item->note)
                                                    <div class="small text-muted">{{ $item->note }}</div>
                                                @endif
                                                <span class="badge bg-secondary">{{ $item->size }}</span>
                                                × {{ $item->quantity }}</td>
                                            <td class="text-end">{{ number_format($item->subtotal, 0, ',', '.') }}đ</td>
                                        </tr>
                                    @endforeach
                                </table>
                                     <div class="small text-muted mt-2">
                                    <div><strong>Người nhận:</strong> {{ $o->customer_name }} — {{ $o->customer_phone }}</div>
                                    @if($o->address)
                                        <div><strong>Địa chỉ:</strong> {{ $o->address }}</div>
                                    @else
                                        <div><strong>Hình thức:</strong> Lấy tại quầy</div>
                                    @endif
                                    @if($o->note)
                                        <div><strong>Ghi chú:</strong> {{ $o->note }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Bạn chưa có đơn hàng nào.</p>
                @endforelse
            @endauth
         </div>
    </div>
</div>
@endsection