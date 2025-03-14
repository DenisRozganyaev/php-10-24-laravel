@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3 d-flex align-items-center justify-content-between">
                <h3>Categories</h3>
                <a class="btn btn-outline-primary" href="{{route('admin.categories.create')}}">Create category</a>
            </div>
            <div class="col-12 table-responsive fs-5">
                <table class="table table-dark table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Parent</th>
                        <th>Products</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->parent?->name ?? '-'}}</td>
                            <td>{{ $category->products_count }}</td>
                            <td>{{ $category->created_at }}</td>
                            <td>{{ $category->updated_at }}</td>
                            <td>
                                <form action="{{route('admin.categories.destroy', $category)}}" method="POST" class="btn-group btn-group-sm gap-1" role="group">
                                    @csrf
                                    @method('DELETE')

                                    <a href="{{route('admin.categories.edit', $category)}}" class="btn btn-outline-info"><i class="fa-regular fa-pen-to-square"></i></a>
                                    <button type="submit" class="btn btn-outline-danger"><i class="fa-regular fa-trash-can"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="col-12">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
