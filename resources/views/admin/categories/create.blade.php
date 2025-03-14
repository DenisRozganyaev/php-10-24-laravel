@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3 text-center">
                <h3>Create Category</h3>
            </div>

            <form action="{{route('admin.categories.store')}}" method="POST" class="card col-8 offset-2 fs-5">
                @csrf
                <div class="card-body p-3">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
                               placeholder="Category name" value="{{old('name')}}"/>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="parent_id" class="form-label">Parent Category</label>
                        <select class="form-control @error('parent_id') is-invalid @enderror" name="parent_id" id="parent_id">
                            <option value="{{null}}" selected>No Parent</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>

                        @error('parent_id')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer bg-light d-flex align-items-center justify-content-end">
                    <button type="submit" class="btn btn-primary">Create category</button>
                </div>
            </form>
        </div>
    </div>
@endsection
