@extends('layouts.admin')
@section('title', 'Danh mục')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-dark">
                <i class="bi bi-plus-lg"></i> Thêm danh mục
            </a>
        </div>

        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr><th>Thứ tự</th><th>Tên</th><th>Slug</th><th>Số món</th><th style="width:130px"></th></tr>
            </thead>
            <tbody>
            @forelse($categories as $c)
                <tr>
                    <td>{{ $c->sort_order }}</td>
                    <td class="fw-bold">{{ $c->name }}</td>
                    <td class="text-muted small">{{ $c->slug }}</td>
                    <td>{{ $c->products_count }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $c) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.categories.destroy', $c) }}" method="POST"
                              class="d-inline" onsubmit="return confirm('Xoá danh mục này?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Chưa có danh mục</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection