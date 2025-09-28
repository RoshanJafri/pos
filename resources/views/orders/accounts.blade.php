@extends('layouts.app')

@push('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="mb-3">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <h4>Error:</h4>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="card-header">
                        <h2>Sales Sort & Filter</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('orders.accounts') }}" method="GET" class="row g-3">

                            {{-- Date Range --}}
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">From</label>
                                <input type="date" class="form-control" name="start_date"
                                    value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">To</label>
                                <input type="date" class="form-control" name="end_date"
                                    value="{{ request('end_date') }}">
                            </div>

                            {{-- App Filter --}}
                            <div class="col-md-6">
                                <label for="app" class="form-label">Delivery App</label>
                                <select name="app" class="form-control">
                                    <option value="all_sales"
                                        {{ request('app', 'all_sales') == 'all_sales' ? 'selected' : '' }}>All sales (with
                                        or without delivery app)
                                    </option>
                                    <option value="all" {{ request('app') == 'all' ? 'selected' : '' }}>All apps (only sales from food delivery apps)</option>
                                    <option value="uber_eats" {{ request('app') == 'uber_eats' ? 'selected' : '' }}>Uber
                                        Eats</option>
                                    <option value="pick_me" {{ request('app') == 'pick_me' ? 'selected' : '' }}>PickMe
                                    </option>
                                </select>
                            </div>
                            {{-- Order Type Filter --}}
                            <div class="col-md-6">
                                <label for="order_type" class="form-label">Order Type</label>
                                <select name="order_type" class="form-control">
                                    <option value="all" {{ request('order_type', 'all') == 'all' ? 'selected' : '' }}>All
                                    </option>
                                    <option value="dine_in" {{ request('order_type') == 'dine_in' ? 'selected' : '' }}>Dine
                                        In</option>
                                    <option value="takeaway" {{ request('order_type') == 'takeaway' ? 'selected' : '' }}>
                                        Takeaway</option>
                                </select>
                            </div>
                            {{-- Item Filter --}}
                            <div class="col-md-6">
                                <label for="item_id" class="form-label">Item</label>
                                <select name="item_id" class="form-control">
                                    <option value="">All Items</option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}"
                                            {{ request('item_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Submit Button --}}
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100">Search</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            {{-- Sales Summary --}}
            <div class="col-lg-4">
                @if (strlen($start_date) < 1)
                    <h4>Total Sales {{ $period ? ucfirst(str_replace('_', ' ', $period)) : 'Today' }}</h4>
                    Today's date: {{ date('jS \o\f M, Y') }}
                    <h1>Rs. {{ $total }}</h1>
                @else
                    <h4>Total Sales From {{ date('d M Y', strtotime($start_date)) }} to
                        {{ date('d M Y', strtotime($end_date)) }}</h4>
                    Today's date: {{ date('jS \o\f M, Y') }}
                    <h1>Rs. {{ $total }}</h1>
                @endif
            </div>
        </div>
    </div>
@endpush
