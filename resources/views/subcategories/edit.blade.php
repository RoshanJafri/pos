@extends('layouts.app')
@push('content')
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header ">
                    <h5 class="mb-0">Edit {{$cat->name}}</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('subcategories.update', $cat->id)}}" method="POST">
                        <!-- Food Name -->
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="foodName" class="form-label">Sub Category Name</label>
                            <input type="text" class="form-control" id="CategoryName" name="name" value="{{$cat->name}}" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Main Category</label>
                            <select class="form-control" id="category" name="category_id" required>
                                <option value="" disabled>Select a category</option>
                                @foreach ($categories as $cat)
                                    <option {{$cat->category_id == $cat->id? 'selected="selected"' :''}} value="{{$cat->id}}">{{ucfirst($cat->name)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Submit Button -->
                        <div class="text-end">
                            <button type="submit" class="btn bg-primary text-white">Add Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endpush