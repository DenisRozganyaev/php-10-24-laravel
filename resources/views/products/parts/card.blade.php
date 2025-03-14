<div class="col">
    <div class="card shadow-sm product-card @unless($product->in_stock) opacity-50 @endunless" style="width: 18rem; position: relative">
        <img src="{{ $product->thumbnailUrl }}" class="card-img-top w-100 product-card-image"
             alt="{{ $product->title }}">
        <div class="card-body">
            <h5 class="card-title">{{ $product->title }}</h5>
            <div class="row">
                <div class="col-12 col-sm-6">Price:</div>
                <div class="col-12 col-sm-6">{{ $product->finalPrice }} $</div>
            </div>
        </div>
        <div class="card-footer">
            <div class="btn-group btn-group-sm gap-1 w-100 d-flex align-items-center justify-content-between"
                 role="group">
                <a href="{{ route('products.show', $product) }}" class="btn btn-outline-info my-2">Show</a>
                <button class="btn btn-outline-success product-card-buy" data-action="{{ route('ajax.cart.add', $product) }}">Buy</button>
            </div>
        </div>
    </div>
</div>
