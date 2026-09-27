@extends('layouts.shop')
@section('title', 'Thực đơn')

@section('content')
<div class="container">
    <h3 class="fw-bold text-coffee mb-4">Thực đơn</h3>

    <div class="row mb-4">
        <div class="col-md-8 mb-2">
            <a href="{{ route('menu') }}"
               class="btn btn-sm {{ !request('category') ? 'btn-coffee' : 'btn-outline-secondary' }}">
                Tất cả
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('menu', ['category' => $cat->slug]) }}"
                   class="btn btn-sm {{ request('category') == $cat->slug ? 'btn-coffee' : 'btn-outline-secondary' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
        <div class="col-md-4">
            <form action="{{ route('menu') }}" method="GET" class="d-flex">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Tìm món..." value="{{ request('search') }}">
                <button class="btn btn-sm btn-coffee ms-2">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>

    @if($products->isEmpty())
        <div class="alert alert-warning">Không tìm thấy món nào phù hợp.</div>
    @else
        <div class="row">
            @foreach($products as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection