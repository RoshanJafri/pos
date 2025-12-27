@extends('layouts.app')

@push('content')
<div class="container">
            <a href="{{ url('accounts') }}" class="btn btn-primary mb-3">GO BACK</a>

    <h2 class="mb-4">Items sales Report</h2>

    {{-- Date Filter --}}
    <form method="GET" action="{{ route('accounts.items.sold') }}" class="row mb-4">
        <div class="col-md-4">
            <label>From Date</label>
            <input type="date" name="from_date" class="form-control"
                   value="{{ $from ?? '' }}" required>
        </div>

        <div class="col-md-4">
            <label>To Date</label>
            <input type="date" name="to_date" class="form-control"
                   value="{{ $to ?? '' }}" required>
        </div>

        <div class="col-md-4 d-flex align-items-end">
            <button class="btn btn-primary w-100">Show Sales</button>
        </div>
    </form>

    {{-- Results --}}
    @if($items->count())
        <div class="card">
            <div class="card-header">
                <strong>
                    Sales from {{ \Carbon\Carbon::parse($from)->format('d M Y') }}
                    to {{ \Carbon\Carbon::parse($to)->format('d M Y') }}
                </strong>
            </div>

            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item Name</th>
                            <th>Total Sold</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td><strong>{{ $item->total_sold }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @elseif($from && $to)
        <div class="alert alert-warning">
            No sales found for selected date range.
        </div>
    @endif

</div>
@endpush
