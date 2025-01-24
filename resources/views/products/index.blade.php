@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 py-5">
                <h1>Products</h1>
            </div>
        </div>
        <form action="{{route('products.index')}}" method="GET" class="row">
            <div class="col-12 py-5 d-flex align-items-center justify-content-end">
                <div class="row w-50">
                    <div class="col-5 d-flex align-items-center justify-content-end w-100">
                        <label for="per_page" class="w-25">Per page</label>
                        <select name="per_page" class="form-control w-50" id="per_page">
                            <option value="1" @if($per_page == 1) selected @endif>1</option>
                            <option value="5" @if($per_page == 5) selected @endif>5</option>
                            <option value="10" @if($per_page == 10) selected @endif>10</option>
                            <option value="12" @if($per_page == 12) selected @endif>12</option>
                            <option value="15" @if($per_page == 15) selected @endif>15</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 col-lg-3">
                    <h4>Categories</h4>
                    <select name="category" class="form-control" id="category">
                        <option value="{{null}}">-</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" @if($selectedCategory == $category->id) selected @endif>{{$category->name}}</option>
                        @endforeach
                    </select>
                <button type="submit" class="btn btn-outline-info mt-3">Use filter</button>
            </div>
            <div class="col-12 col-md-8 col-lg-9">
                <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 g-3">
                    @each('products.parts.card', $products, 'product')
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-12 mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
