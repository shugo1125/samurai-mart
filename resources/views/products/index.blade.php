@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-2">
        @component('components.sidebar', ['categories' => $categories, 'major_categories' => $major_categories])
        @endcomponent
    </div>
    <div class="col-md-9">
        <div class="container">
            @if ($category !== null)
            <a href="{{ route('products.index') }}">トップ</a> > <a href="#">{{ $major_category->name }}</a> > {{ $category->name }}
            <h1>{{ $category->name }}の商品一覧 {{$total_count}}件</h1>
            @elseif ($keyword !== null)
            <a href="{{ route('products.index') }}">トップ</a> > 商品一覧
            <h1>"{{ $keyword }}"の検索結果 {{$total_count}}件</h1>
            @else
            <h1>商品一覧</h1>
            @endif
        </div>
        <div class="d-flex align-items-center mb-4">
            <span class="small me-2">並べ替え</span>
            <form method="GET" action="{{ route('products.index') }}">
                @if ($category)
                <input type="hidden" name="category" value="{{ $category->id }}">
                @endif
                @if ($keyword)
                <input type="hidden" name="keyword" value="{{ $keyword }}">
                @endif
                <select class="form-select form-select-sm" name="select_sort" onChange="this.form.submit();">
                    @foreach ($sorts as $key => $value)
                    <option value="{{ $value }}" {{ $sorted === $value ? 'selected' : '' }}>{{ $key }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="container mt-4">
            <div class="row w-100">
                @foreach($products as $product)
                <div class="col-md-3">
                    <a href="{{ route('products.show', $product) }}">
                        <img src="{{ $product->image ? asset($product->image) : asset('img/dummy.png') }}" class="img-thumbnail samuraimart-product-img">
                    </a>
                    <div class="row">
                        <div class="col-12">
                            <p class="samuraimart-product-label mt-2">
                                {{ $product->name }}<br>
                                <span>
                                    @php
                                    $fullStars = floor($product->reviews()->avg('score') ?: 0);
                                    $halfStar = ($product->reviews()->avg('score') - $fullStars) >= 0.5 ? 1 : 0;
                                    $emptyStars = 5 - ($fullStars + $halfStar);
                                    @endphp

                                    @for ($i = 0; $i < $fullStars; $i++)
                                        <i class="fas fa-star"></i>
                                        @endfor
                                        @for ($i = 0; $i < $halfStar; $i++)
                                            <i class="fas fa-star-half-alt"></i>
                                            @endfor
                                            @for ($i = 0; $i < $emptyStars; $i++)
                                                <i class="far fa-star"></i>
                                                @endfor
                                                {{ number_format($product->reviews()->avg('score') ?: 0, 1) }}
                                </span>
                                <br>
                                <label>￥{{ number_format($product->price) }}</label>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>
@endsection