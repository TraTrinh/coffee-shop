@extends('layouts.admin')
@section('title', $product->exists ? 'Sửa sản phẩm' : 'Thêm sản phẩm')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">

                <form action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    @if($product->exists) @method('PUT') @endif

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $product->name) }}">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Danh mục <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">— Chọn —</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Giá (đ) <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price', $product->price) }}" min="0" step="1000">
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Mô tả</label>
                        <textarea name="description" rows="3" class="form-control">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Ảnh sản phẩm</label>
                        @if($product->image)
                            <div class="mb-2">
                                <img src="{{ $product->image_url }}" width="100" class="rounded">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                               accept="image/*">
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">JPG, PNG hoặc WEBP, tối đa 2MB.</div>
                    </div>

                    <div class="form-check mb-4">
                        <input type="checkbox" name="is_available" value="1" id="avail" class="form-check-input"
                               {{ old('is_available', $product->exists ? $product->is_available : true) ? 'checked' : '' }}>
                        <label for="avail" class="form-check-label fw-bold">Đang bán</label>
                    </div>

                    <button class="btn btn-dark">
                        {{ $product->exists ? 'Cập nhật' : 'Thêm mới' }}
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Huỷ</a>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection