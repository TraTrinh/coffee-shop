@extends('layouts.admin')
@section('title', 'Đơn hàng')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">

        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Mã đơn hoặc SĐT..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">— Tất cả trạng thái —</option>
                    @foreach(\App\Models\Order::STATUSES as $key => $label)
                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-sm btn-dark">Lọc</button>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">Xoá lọc</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Mã đơn</th><th>Khách hàng</th><th>SĐT</th>
                        <th>Món</th><th>Tổng tiền</th><th>Hình thức</th>
                        <th>Trạng thái</th><th>Thời gian</th><th></th>
                    </tr>
                </thead>
                <tbody>
                @forelse($orders as $o)
                    <tr>
                        <td class="fw-bold">{{ $o->order_code }}</td>
                        <td>{{ $o->customer_name }}</td>
                        <td>{{ $o->customer_phone }}</td>
                        <td>{{ $o->items_count }}</td>
                        <td class="fw-bold">{{ number_format($o->total_amount,0,',','.') }}đ</td>
                        <td>
                            <span class="badge bg-light text-dark">
                                {{ $o->order_type === 'delivery' ? 'Giao hàng' : 'Tại quầy' }}
                            </span>
                        </td>
                        <td>
                            @php
                                $colors = ['pending'=>'warning','confirmed'=>'info','preparing'=>'primary',
                                           'completed'=>'success','cancelled'=>'danger'];
                            @endphp
                            <span class="badge bg-{{ $colors[$o->status] ?? 'secondary' }}">
                                {{ $o->status_label }}
                            </span>
                        </td>
                        <td class="small text-muted">{{ $o->created_at->format('H:i d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $o) }}" class="btn btn-sm btn-outline-primary">
                                Chi tiết
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center text-muted py-4">Chưa có đơn hàng nào</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $orders->links() }}
    </div>
</div>
@endsection