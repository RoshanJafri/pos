@extends('layouts.app')
@push('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="mb-4">All Portions</h2>
                <div class="card shadow-sm">
                    
                    <div class="card-header ">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex">
                                
                            </div>
                            <div class="">
                                <a href="{{ route('kitchen.create') }}" class="btn btn-primary">Add new</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <form action="{{ url('kitchen/updateAll') }}" method="POST">
                            @csrf
                            <table class="table border-bottom">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($portions as $portion)
                                        <tr>
                                            <td>{{ $portion->id }}
                                                <input type="hidden" name="portions[{{ $loop->index }}][id]"
                                                    value="{{ $portion->id }}">
                                            </td>
                                            <td>{{ $portion->name }}</td>
                                            <td><input type="number" class="form-control" style="border:2px solid lightblue; max-width: 80px;" name="portions[{{ $loop->index }}][quantity]"
                                                    value="{{ $portion->quantity }}"></td>
                                            <td><a href="{{ url('kitchen/'.$portion->id.'/edit') }}">Edit</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            <input type="submit" value="UPDATE" class="float-right btn btn-success btn-lg">

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endpush