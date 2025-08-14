@extends('layouts.app')
@push('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if ($search)
                <h2>Searching for <strong>{{$search}}</strong></h2>
                <a href="{{route("items.index")}}">See all Items / Reset Search</a>
                @else
                <h2 class="mb-4">All Items</h2>
                @endif
                <div class="card shadow-sm">
                    <div class="card-header ">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex">
                                <form action="{{route('items.index')}}">
                                    <div class="input-group ml-3">
                                        <input type="text" class="form-control" placeholder="Search Item..." name="search" value="{{$search?$search:''}}">
                                        <div class="">
                                            <button class="btn btn-outline-success" type="button"><i
                                                    class="fas fa-search"></i> Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="">
                                <a href="{{ route('items.create') }}" class="btn btn-primary">Add new</a>
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
                                    <th>Price</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ ucfirst($item->name) }}</td>
                                        <td>{{ $item->category->name }}</td>
                                        <td>Rs. {{ $item->cost }}</td>
                                        <td><a href="{{ route('items.edit', $item->id) }}" class="btn border">edit</a>&nbsp;
                                            <form class="d-inline" action="{{ route('items.destroy', $item->id) }}"
                                                method="post">@csrf @method('DELETE') <button type="submit" value=""
                                                    class="btn border">delete</button></form>
                                        </td>
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
