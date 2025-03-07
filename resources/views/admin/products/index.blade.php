@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3 d-flex align-items-center justify-content-between">
                <h3>Products</h3>
                <div class="d-flex align-items-center justify-content-between gap-2">
                    <button id="export-products" data-url="{{route('admin.products.export')}}" class="btn btn-outline-warning">Export</button>
                    <a class="btn btn-outline-primary" href="{{route('admin.products.create')}}">Create product</a>
                </div>
            </div>
            <div class="col-12 table-responsive fs-5">
                <table class="table table-dark table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Categories</th>
                        <th>SKU</th>
                        <th>Qty</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td><img src="{{ $product->thumbnailUrl }}" alt="{{ $product->title }}" width="50"></td>
                            <td>{{ $product->title }}</td>
                            <td class="gap-1">
                                @forelse($product->categories as $category)
                                    <a class="link-light" href="{{route('admin.categories.edit', $category)}}">{{$category->name}}</a>
                                @empty
                                    -
                                @endforelse
                            </td>
                            <td>{{ $product->SKU }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>{{ $product->created_at }}</td>
                            <td>{{ $product->updated_at }}</td>
                            <td>
                                <form action="{{route('admin.products.destroy', $product)}}" method="POST" class="btn-group btn-group-sm gap-1" role="group">
                                    @csrf
                                    @method('DELETE')

                                    <a href="{{route('admin.products.edit', $product)}}" class="btn btn-outline-light" target="_blank"><i class="fa-regular fa-window-restore"></i></a>
                                    <a href="{{route('admin.products.edit', $product)}}" class="btn btn-outline-info"><i class="fa-regular fa-pen-to-square"></i></a>
                                    <button type="submit" class="btn btn-outline-danger"><i class="fa-regular fa-trash-can"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="col-12">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
