@extends('layouts.admin')
@section('title', $category->exists ? 'Sửa danh mục' : 'Thêm danh mục')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
                      method="POST">
                    @csrf
                    @if($category->exists) @method('PUT') @endif

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $category->name) }}">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Thứ tự hiển thị</label>
                        <input type="number" name="sort_order" class="form-control"
                               value="{{ old('sort_order', $category->sort_order ?? 0) }}" min="0">
                    </div>

                    <button class="btn btn-dark">{{ $category->exists ? 'Cập nhật' : 'Thêm mới' }}</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Huỷ</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection