@extends('layouts.app')
@push('content')
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header ">
                    <h5 class="mb-0">Add New Category</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('categories.store')}}" method="POST">
                        <!-- Food Name -->
                        @csrf
                        <div class="mb-3">
                            <label for="foodName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="CategoryName" name="name" required>
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