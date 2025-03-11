@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h3 class="card-header">{{ __('home.top_categories') }}</h3>
            <div class="d-flex align-items-center justify-content-start gap-2 p-3 flex-wrap">
                @each('categories.parts.label', $categories, 'category')
            </div>
            <h3 class="card-header">{{ __('home.top_products') }}</h3>
            <div class="d-flex align-items-center justify-content-start gap-2 p-3 flex-wrap">
                @each('products.parts.card', $products, 'product')
            </div>
        </div>
    </div>
</div>
@endsection
