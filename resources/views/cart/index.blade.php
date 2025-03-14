@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 py-5 text-center">
                <h1>Cart</h1>
            </div>
        </div>
        @if ($cart->content()->isEmpty())
            <div class="row">
                <div class="col text-center">
                    <h3>The cart is empty</h3>
                    <a href="{{route('products.index')}}" class="btn btn-outline-primary mt-3">Go shopping</a>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-12 col-sm-9">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                            <th>Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($cart->content() as $row)
                            @if ($row->model)
                                <tr>
                                    <td><img src="{{ $row->model->thumbnailUrl }}" alt="{{ $row->name }}" width="50"></td>
                                    <td>
                                        <a class="link-info"
                                           href="{{ route('products.show', $row->id) }}"><strong>{{ $row->name }}</strong></a>
                                    </td>
                                    <td>
                                        <form action="{{ route('cart.update', $row->model) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="rowId" value="{{ $row->rowId }}">
                                            <input type="number" class="form-control product-qty" name="qty"
                                                   value="{{ $row->qty }}"
                                                   min="0"
                                                   step="1"
                                                   max="{{ $row->model->quantity }}"/>
                                        </form>
                                    </td>
                                    <td>$ {{ $row->price }}</td>
                                    <td>$ {{ $row->total }}</td>
                                    <td>
                                        <form action="{{route('cart.remove')}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="rowId" value="{{ $row->rowId }}">

                                            <button type="submit" class="btn btn-outline-danger"><i
                                                    class="fa-regular fa-trash-can"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="col-12 col-sm-3">
                    <h3 class="mb-3">Summary</h3>
                    <table class="table table-striped table-hover">
                        <tbody>
                        <tr>
                            <td>Subtotal</td>
                            <td>{{ Cart::subtotal() }}</td>
                        </tr>
                        <tr>
                            <td>Tax</td>
                            <td>{{ Cart::tax() }}</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td>{{ Cart::total() }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <br>
                    <a href="{{ route('checkout') }}" class="btn btn-outline-success btn-lg w-100">Processing to checkout</a>
                </div>
            </div>
        @endif
    </div>
@endsection
