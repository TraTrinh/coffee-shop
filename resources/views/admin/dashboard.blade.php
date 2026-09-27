@extends('layouts.admin')
@section('title', 'Tổng quan')

@section('content')
<div class="row g-3 mb-4">
    @foreach([
        ['Đơn hôm nay', $stats['orders_today'], 'bi-receipt', 'primary'],
        ['Doanh thu hôm nay', number_format($stats['revenue_today'],0,',','.').'đ', 'bi-cash-coin', 'success'],
        ['Chờ xác nhận', $stats['pending'], 'bi-hourglass-split', 'warning'],
        ['Tổng sản phẩm', $stats['products'], 'bi-cup-straw', 'info'],
    ] as [$label, $value, $icon, $color])
        <div class="col-6 col-lg-3">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="small text-muted">{{ $label }}</div>
                            <div class="fs-4 fw-bold">{{ $value }}</div>
                        </div>
                        <i class="bi {{ $icon }} fs-3 text-{{ $color }}"></i>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Doanh thu 7 ngày gần nhất</h6>
                <canvas id="revenueChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Top 5 món bán chạy</h6>
                @forelse($topProducts as $i => $p)
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <span><span class="badge bg-secondary">{{ $i+1 }}</span> {{ $p->product_name }}</span>
                        <span class="fw-bold">{{ $p->sold }}</span>
                    </div>
                @empty
                    <p class="text-muted small">Chưa có dữ liệu</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Đơn hàng gần đây</h6>
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Mã đơn</th><th>Khách</th><th>SĐT</th>
                                <th>Tổng tiền</th><th>Trạng thái</th><th>Thời gian</th><th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($recentOrders as $o)
                            <tr>
                                <td class="fw-bold">{{ $o->order_code }}</td>
                                <td>{{ $o->customer_name }}</td>
                                <td>{{ $o->customer_phone }}</td>
                                <td>{{ number_format($o->total_amount,0,',','.') }}đ</td>
                                <td><span class="badge bg-secondary">{{ $o->status_label }}</span></td>
                                <td class="small text-muted">{{ $o->created_at->format('H:i d/m') }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $o) }}" class="btn btn-sm btn-outline-primary">
                                        Xem
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted py-3">Chưa có đơn hàng nào</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: @json($revenueChart->pluck('date')),
        datasets: [{
            label: 'Doanh thu (đ)',
            data: @json($revenueChart->pluck('total')),
            borderColor: '#6F4E37',
            backgroundColor: 'rgba(111,78,55,.1)',
            fill: true,
            tension: .3
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } } }
});
</script>
@endpush