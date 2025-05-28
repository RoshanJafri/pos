@extends('layouts.app')
@push('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header ">
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <h5 class="mb-0">All Sub Categories</h5>
                        </div>
                        <div class="">
                            <a href="{{route('subcategories.create')}}" class="btn btn-primary">Add new</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Category</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $cat)
                            <tr>
                                <td></td>
                                <td>{{ucfirst($cat->name)}}</td>
                                <td>{{ucfirst($cat->category->name)}}</td>
                                <td><a href="" class="btn border">edit</a>&nbsp;<a href="" class="btn border">delete</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endpush