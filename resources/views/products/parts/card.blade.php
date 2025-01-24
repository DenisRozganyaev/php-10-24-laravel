<div class="col">
    <div class="card shadow-sm product-card" style="width: 18rem; position: relative">
{{--        @if($product->withDiscount)--}}
{{--            <span class="badge rounded-pill text-bg-danger discount-badge">--}}
{{--                {{$product->discount}}%--}}
{{--            </span>--}}
{{--        @endif--}}
        <img src="{{ $product->thumbnailUrl }}" class="card-img-top w-100 product-card-image"
             alt="{{ $product->title }}">
        <div class="card-body">
            <h5 class="card-title">{{ $product->title }}</h5>
{{--            @if($product->withDiscount)--}}
{{--                <div class="row" style="color: rgba(107,29,29,0.89)">--}}
{{--                    <small class="col-12 col-sm-6">Old Price: </small>--}}
{{--                    <small class="col-12 col-sm-6 text-decoration-line-through">{{ $product->price }} $</small>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--            @if($product->isSimple)--}}
                <div class="row">
                    <div class="col-12 col-sm-6">Price:</div>
                    <div class="col-12 col-sm-6">{{ $product->finalPrice }} $</div>
                </div>
{{--            @else--}}
{{--                <div class="row">--}}
{{--                    <div class="col-12">--}}
{{--                        Product with options--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
        </div>
        <div class="card-footer">
{{--            @if($product->isSimple)--}}
{{--                <a href="#" class="btn btn-outline-success my-2">Buy</a>--}}
{{--            @endif--}}
            <a href="{{ route('products.show', $product) }}" class="btn btn-outline-info my-2">Show</a>
        </div>
    </div>
</div>
