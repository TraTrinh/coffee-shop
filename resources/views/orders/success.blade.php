@extends('layouts.shop')
@section('title', 'Đặt hàng thành công')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card text-center">
                <div class="card-body py-5">
                    <i class="bi bi-check-circle-fill text-success" style="font-size:4rem"></i>
                    <h4 class="fw-bold text-coffee mt-3">Đặt hàng thành công!</h4>
                    <p class="text-muted">Cảm ơn bạn đã đặt hàng. Quán sẽ liên hệ xác nhận sớm.</p>

                    <div class="bg-light rounded p-3 my-4">
                        <div class="small text-muted">Mã đơn hàng</div>
                        <div class="fs-4 fw-bold text-coffee">{{ $order->order_code }}</div>
                        <div class="small text-muted mt-1">Lưu mã này để tra cứu đơn</div>
                    </div>

                    <table class="table table-sm">
                        <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td class="text-start">
                                    {{ $item->product_name }}
                                    @if($item->note)
                                    <div class="small text-muted">{{ $item->note }}</div>
                                @endif
                                    <span class="badge bg-secondary">{{ $item->size }}</span>
                                    × {{ $item->quantity }}
                                </td>
                                <td class="text-end">{{ number_format($item->subtotal, 0, ',', '.') }}đ</td>
                            </tr>
                        @endforeach
                        <tr class="fw-bold text-coffee">
                            <td class="text-start">Tổng cộng</td>
                            <td class="text-end">{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="text-start small text-muted">
                        <div><strong>Người nhận:</strong> {{ $order->customer_name }} — {{ $order->customer_phone }}</div>
                        @if($order->address)
                            <div><strong>Địa chỉ:</strong> {{ $order->address }}</div>
                        @else
                            <div><strong>Hình thức:</strong> Lấy tại quầy</div>
                        @endif
                        @if($order->note)
                            <div><strong>Ghi chú:</strong> {{ $order->note }}</div>
                        @endif
                    </div>

                    <a href="{{ route('menu') }}" class="btn btn-coffee mt-4">Tiếp tục mua hàng</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection