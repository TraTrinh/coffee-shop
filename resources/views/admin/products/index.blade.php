@extends('layouts.admin')
@section('title', 'Sản phẩm')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">

        <div class="d-flex justify-content-between mb-3">
            <form method="GET" class="d-flex" style="max-width:320px">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Tìm sản phẩm..." value="{{ request('search') }}">
                <button class="btn btn-sm btn-dark ms-2">Tìm</button>
            </form>
            <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-dark">
                <i class="bi bi-plus-lg"></i> Thêm sản phẩm
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr><th style="width:70px"></th><th>Tên</th><th>Danh mục</th>
                        <th>Giá</th><th>Trạng thái</th><th style="width:130px"></th></tr>
                </thead>
                <tbody>
                @forelse($products as $p)
                    <tr>
                        <td><img src="{{ $p->image_url }}" width="50" height="50"
                                 class="rounded object-fit-cover" alt=""></td>
                        <td class="fw-bold">{{ $p->name }}</td>
                        <td>{{ $p->category->name ?? '—' }}</td>
                        <td>{{ number_format($p->price,0,',','.') }}đ</td>
                        <td>
                            <span class="badge bg-{{ $p->is_available ? 'success' : 'secondary' }}">
                                {{ $p->is_available ? 'Đang bán' : 'Ngừng bán' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $p) }}" method="POST"
                                  class="d-inline" onsubmit="return confirm('Xoá sản phẩm này?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Chưa có sản phẩm</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $products->links() }}
    </div>
</div>
@endsection