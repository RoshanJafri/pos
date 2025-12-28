@extends('layouts.app')
@push('content')
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header ">
                    <h5 class="mb-0">Edit {{$item->name}}</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('items.update', $item->id)}}" method="POST">
                        <!-- Food Name -->
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <label for="foodName" class="form-label">Food Name</label>
                            <input type="text" class="form-control" id="foodName" name="name" required value="{{$item->name}}">
                        </div>
            
                        <!-- Category -->
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-control" id="category" name="subcategory_id" required>
                                <option value="" disabled>Select a category</option>
                                @foreach ($categories as $cat)
                                    <option {{$item->subcategory_id == $cat->id? 'selected="selected"' :''}} value="{{$cat->id}}">{{ucfirst($cat->name)}}</option>
                                @endforeach
                            </select>
                        </div>
            
                        <!-- Portion Type -->
                        <div class="mb-3">
                            <label for="portion" class="form-label">Portion Category</label>
                            <select class="form-control" id="portion" name="portion_id" required>
                                <option value="" selected>Select a category</option>
                                @foreach ($portions as $portion)
                                    <option {{$item->portion_id == $portion->id? 'selected="selected"' :''}} value="{{$portion->id}}">{{ucfirst($portion->name)}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Portion Multiplier -->
                        <div class="mb-3">
                            <label for="portion" class="form-label">Portion Multiplier</label>
                            <input type="number" name="portion_multiplier" value="{{ $item->portion_multiplier }}" class="form-control" placeholder="1">
                        </div>
            
                        <!-- Price -->
                        <div class="mb-3">
                            <label for="price" class="form-label">Price (Rs)</label>
                            <input type="number" class="form-control" id="price" name="cost" min="0" step="0.01" required value="{{$item->cost}}">
                        </div>
            
                        <!-- Submit Button -->
                        <div class="text-end">
                            <button type="submit" class="btn bg-primary text-white">Edit Food Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endpush