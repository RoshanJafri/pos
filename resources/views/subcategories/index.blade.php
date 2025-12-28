@extends('layouts.app')
@push('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-2">
                    {{-- ❌ ERROR --}}
                    @if ($errors->has('delete_error'))
                        <div class="alert alert-danger">
                            <strong>{{ $errors->first('delete_error') }}</strong>

                            @if (session('blocked_items'))
                                <hr>
                                <p class="mb-1">Items inside this category:</p>
                                <ul class="mb-0">
                                    @foreach (session('blocked_items') as $item)
                                        <li>{{ $item->name }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endif

                    {{-- ✅ SUCCESS --}}
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                </div>
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
                                        <td><a href="{{route('subcategories.edit', $cat->id)}}"
                                                class="btn border">edit</a>&nbsp;

                                            <form class="d-inline" action="{{ route('subcategories.destroy', $cat->id) }}"
                                                method="post">@csrf @method('DELETE') <button type="submit" value=""
                                                    class="btn border">delete</button></form>
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