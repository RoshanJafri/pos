@extends('layouts.app')

@push('content')
<div class="container">
    {{-- TOTAL SALE --}}
    <div class="row mb-4">
        <div class="col-lg-12">
            <a href="{{ url('accounts') }}" class="btn btn-primary mb-3">GO BACK</a>
            <div class="card border-success">
                <div class="card-body text-center">
                    <h5 class="text-muted mb-1">Total Sale</h5>
                    <small>
                        @if (isset($_GET['start_date']) && !empty($_GET['end_date']))
                            from {{date('dS \o\f M Y', strtotime($_GET['start_date']))}} to {{date('dS \o\f M Y', strtotime($_GET['end_date']))}}
                        @endif
                    </small>
                    <h1 class="text-success">
                        Rs {{ number_format($totalSale ?? 0) }}
                    </h1>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER FORM --}}
    <div class="card mb-4">
        <div class="card-header">
            <strong>Filter Orders</strong>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ url()->current() }}" class="row g-3">

                {{-- Date Range --}}
                <div class="col-md-6">
                    <label class="form-label">From</label>
                    <input type="date" name="start_date" class="form-control"
                        value="{{ request('start_date') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">To</label>
                    <input type="date" name="end_date" class="form-control"
                        value="{{ request('end_date') }}">
                </div>

                {{-- Delivery App --}}
                <div class="col-md-6">
                    <label class="form-label">Delivery App</label>
                    <select name="app" class="form-control">
                        <option value="all_sales" {{ request('app','all_sales') == 'all_sales' ? 'selected' : '' }}>
                            All sales
                        </option>
                        <option value="all" {{ request('app') == 'all' ? 'selected' : '' }}>
                            All delivery apps
                        </option>
                        <option value="uber_eats" {{ request('app') == 'uber_eats' ? 'selected' : '' }}>
                            Uber Eats
                        </option>
                        <option value="pick_me" {{ request('app') == 'pick_me' ? 'selected' : '' }}>
                            PickMe
                        </option>
                    </select>
                </div>

                {{-- Order Type --}}
                <div class="col-md-6">
                    <label class="form-label">Order Type</label>
                    <select name="order_type" class="form-control">
                        <option value="all" {{ request('order_type','all') == 'all' ? 'selected' : '' }}>
                            All
                        </option>
                        <option value="dine_in" {{ request('order_type') == 'dine_in' ? 'selected' : '' }}>
                            Dine In
                        </option>
                        <option value="takeaway" {{ request('order_type') == 'takeaway' ? 'selected' : '' }}>
                            Takeaway
                        </option>
                    </select>
                </div>

                {{-- Item --}}
                <div class="col-md-6">
                    <label class="form-label">Item</label>
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

                {{-- Buttons --}}
                <div class="col-12 d-flex gap-2 mt-2">
                    <button class="btn btn-primary w-100 m-2">Search</button>
                    <a href="{{ url()->current() }}" class="m-2 btn btn-outline-secondary w-100">
                        Reset
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- ORDERS TABLE --}}
    <div class="card">
        <div class="card-header">
            <strong>Orders</strong>
        </div>

        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Server</th>
                        <th>Table</th>
                        <th>Subtotal</th>
                        <th>Tax</th>
                        <th>Discount</th>
                        <th>Payable</th>
                        <th>Type</th>
                        <th>Created</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                @forelse ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->employee?->name ?? 'Deleted' }}</td>
                        <td>{{ $order->table_no }}</td>
                        <td>Rs {{ $order->subtotal }}</td>
                        <td>Rs {{ $order->tax }}</td>
                        <td>Rs {{ $order->discountPercentage ?? 0 }}</td>
                        <td>
                            <strong>Rs {{ $order->payable }}</strong><br>
                            <small class="text-primary">{{ $order->payment_method }}</small>
                        </td>
                        <td>
                            {{ $order->order_type }}<br>
                            <small class="text-success">{{ $order->app }}</small>
                        </td>
                        <td>{{ $order->created_at->format('h:i A jS M Y') }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary"
                                data-bs-toggle="collapse"
                                data-bs-target="#details-{{ $order->id }}">
                                Details
                            </button>
                        </td>
                    </tr>

                    {{-- ORDER DETAILS --}}
                    <tr class="collapse" id="details-{{ $order->id }}">
                        <td colspan="10">
                            <table class="table table-sm table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Qty</th>
                                        <th>Cost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->details as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>
                                                Rs {{ $item->finalCost }}
                                                {!! $item->finalCost != $item->originalCost
                                                    ? '<s class="text-muted">Rs '.$item->originalCost.'</s>'
                                                    : '' !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted">
                            No orders found.
                        </td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>
    </div>

</div>
@endpush
@push('scripts')
    <script src="{{ asset('') }}assets/libs/bootstrap/js/bootstrap-bundle.min.js"></script>
@endpush
