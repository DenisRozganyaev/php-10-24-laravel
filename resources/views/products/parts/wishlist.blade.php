@php
    $icon = match($type) {
        'in_stock' => 'fa-regular fa-heart',
        default => 'fa-solid fa-chart-line'
    };
@endphp
@if ($isFollowed)
    <form action="{{ route('products.wishlist.remove', $productId) }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="hidden" value="{{ $type }}" name="type"/>
        <button id="btn-add-exist" type="submit" class="btn btn-outline-danger">
            <i class="{{ $icon }}"></i>
        </button>
    </form>
@else
    <form action="{{ route('products.wishlist.add', $productId) }}" method="POST">
        @csrf
        <input type="hidden" value="{{ $type }}" name="type"/>
        <button id="btn-add-exist" type="submit" class="btn btn-outline-success border-0">
            <i class="{{ $icon }}"></i>
        </button>
    </form>
@endif
