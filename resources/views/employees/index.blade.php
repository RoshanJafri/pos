@extends('layouts.app')
@push('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header ">
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <h5 class="mb-0">All Employees</h5>
                        </div>
                        <div class="">
                            <a href="{{route('employees.create')}}" class="btn btn-primary">Add new</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Name</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                            <tr>
                                <td>#KKEID-{{$employee->id}}</td>
                                <td>{{ucfirst($employee->name)}}</td>
                                <td><a href="{{route('employees.edit', $employee->id)}}" class="btn border">edit</a>&nbsp;<form class="d-inline" action="{{route('employees.destroy', $employee->id)}}" method="post">@csrf @method('DELETE') <button type="submit" value="" class="btn border">delete</button></form></td>
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