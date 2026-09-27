@extends('layouts.admin')
@section('title', 'Đơn ' . $order->order_code)

@section('content')
<a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
    <i class="bi bi-arrow-left"></i> Quay lại
</a>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Chi tiết món</h6>
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr><th>Món</th><th>Size</th><th>Đơn giá</th><th>SL</th><th class="text-end">Thành tiền</th></tr>
                    </thead>
                    <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product_name }}
                            @if($item->note)
                            <div class="small text-muted">{{ $item->note }}</div>
                        @endif
                            </td>
                            <td><span class="badge bg-secondary">{{ $item->size }}</span></td>
                            <td>{{ number_format($item->unit_price,0,',','.') }}đ</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="text-end">{{ number_format($item->subtotal,0,',','.') }}đ</td>
                        </tr>
                    @endforeach
                    <tr class="fw-bold">
                        <td colspan="4">Tổng cộng</td>
                        <td class="text-end fs-5" style="color:#6F4E37">
                            {{ number_format($order->total_amount,0,',','.') }}đ
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Cập nhật trạng thái</h6>
                <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                    @csrf @method('PATCH')
                    <select name="status" class="form-select mb-2">
                        @foreach(\App\Models\Order::STATUSES as $key => $label)
                            <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn-dark w-100">Lưu thay đổi</button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Thông tin khách hàng</h6>
                <table class="table table-sm mb-0">
                    <tr><td class="text-muted">Mã đơn</td><td class="fw-bold">{{ $order->order_code }}</td></tr>
                    <tr><td class="text-muted">Họ tên</td><td>{{ $order->customer_name }}</td></tr>
                    <tr><td class="text-muted">SĐT</td><td>{{ $order->customer_phone }}</td></tr>
                    <tr>
                        <td class="text-muted">Hình thức</td>
                        <td>{{ $order->order_type === 'delivery' ? 'Giao hàng' : 'Lấy tại quầy' }}</td>
                    </tr>
                    @if($order->address)
                        <tr><td class="text-muted">Địa chỉ</td><td>{{ $order->address }}</td></tr>
                    @endif
                    @if($order->note)
                        <tr><td class="text-muted">Ghi chú</td><td>{{ $order->note }}</td></tr>
                    @endif
                    <tr><td class="text-muted">Đặt lúc</td><td>{{ $order->created_at->format('H:i d/m/Y') }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection