@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-12 text-center">
                <h2>{{ $product->title }}</h2>
                <hr class="w-25 m-auto">
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12 col-sm-6 col-md-5">
                @include('products.parts.carousel', ['gallery' => $gallery])
            </div>
            <div class="col-12 col-sm-6 col-md-7">
                <div class="row mb-1">
                    <div class="col-6 col-sm-3"><b>SKU</b></div>
                    <div class="col-6 col-sm-9">
                        <b><small>{{ $product->SKU }}</small></b>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-6 col-sm-3"><b>Quantity</b></div>
                    <div class="col-6 col-sm-9">{{ $product->quantity }}</div>
                </div>
                <div class="row mb-1">
                    <div class="col-6 col-sm-3"><b>Categories</b></div>
                    <div class="col-6 col-sm-9">
                        @each('categories.parts.label', $product->categories, 'category')
                    </div>
                </div>

{{--                @auth()--}}
{{--                    <div class="row mt-5">--}}
{{--                        <div class="col-12">--}}
{{--                            <h4>Wish List</h4>--}}
{{--                        </div>--}}
{{--                        <div class="col-12 col-sm-6">--}}
{{--                            @include('products.parts.wishlist.exist', ['product' => $product, 'isFollowed' => $wishes['in_stock'], 'mini' => false])--}}
{{--                        </div>--}}
{{--                        <div class="col-12 col-sm-6">--}}
{{--                            @include('products.parts.wishlist.price', ['product' => $product, 'isFollowed' => $wishes['price'], 'mini' => false])--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endauth--}}

{{--                @if ($attributes)--}}
{{--                    <div class="row mt-5">--}}
{{--                        <div class="col-12 col-sm-6">{{ $attributeKey }}</div>--}}
{{--                        <div class="col-12 col-sm-6">--}}
{{--                            <div class="card">--}}
{{--                                <form method="GET" action="{{ route('products.show', $product) }}"--}}
{{--                                      class="card-body d-flex align-items-center justify-content-between">--}}

{{--                                    <table class="table table-striped-columns">--}}
{{--                                        <thead>--}}
{{--                                        <tr>--}}
{{--                                            <th>Attribute</th>--}}
{{--                                            <th>Quantity</th>--}}
{{--                                            <th>Price</th>--}}
{{--                                        </tr>--}}
{{--                                        </thead>--}}
{{--                                        <tbody>--}}
{{--                                        @foreach($attributes as $attr)--}}
{{--                                            <tr>--}}
{{--                                                <td>--}}
{{--                                                    <input type="radio"--}}
{{--                                                           class="btn-check product-attr-radio"--}}
{{--                                                           name="option"--}}
{{--                                                           value="{{$attr->id}}"--}}
{{--                                                           id="option-{{$attr->value}}"--}}
{{--                                                           autocomplete="off"--}}
{{--                                                           @if ($selectedOption == $attr->id) checked @endif--}}
{{--                                                    >--}}
{{--                                                    <label class="btn"--}}
{{--                                                           for="option-{{$attr->value}}">{{$attr->value}}</label>--}}
{{--                                                </td>--}}
{{--                                                <td>{{$attr->pivot->quantity}}</td>--}}
{{--                                                <td>{{$product->finalPrice($attr->pivot->price)}} $</td>--}}
{{--                                            </tr>--}}
{{--                                        @endforeach--}}
{{--                                        </tbody>--}}
{{--                                    </table>--}}
{{--                                </form>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                <div class="row mt-5">--}}
{{--                    <div class="col-12 col-sm-6"></div>--}}
{{--                    <div class="col-12 col-sm-6">--}}
{{--                        <div class="card">--}}
{{--                            <form method="POST" action="{{ route('cart.add', $product) }}"--}}
{{--                                  class="card-body d-flex align-items-center justify-content-between">--}}
{{--                                @csrf--}}
{{--                                <input type="hidden" name="option" value="{{$selectedOption}}" />--}}
{{--                                <div class="card-title">Price: <strong class="fs-5">{{ $price }} $</strong></div>--}}
{{--                                <button type="submit" class="btn btn-outline-success">Buy</button>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
            <div class="col-12 mt-3">
                <hr>
            </div>
            <div class="col-12 text-center fs-4 mt-3">
                {{ $product->description }}
            </div>
        </div>
    </div>
@endsection
