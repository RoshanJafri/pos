@extends('layouts.app')
@push('content')
    <div class="container">
        <h2 class="bg-primary text-light p-3 rounded">
            Sales Summary
        </h2>
        <div class="row">
            <div class="col-lg-6 mb-4 mt-5 mb-3 border-right">
                <div class="row sales-container">
                    {{-- TODAY'S SALE --}}
                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        Today's Sale
                                    </div>
                                    <div class="col">

                                        <a
                                            href="{{ url('accounts/sales?start_date=' . date('Y-m-d') . '&end_date=' . date('Y-m-d') . '&app=all_sales&order_type=all&item_id=') }}">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h1>Rs {{ number_format($todaySale) }}</h1>
                            </div>
                        </div>
                    </div>

                    {{-- YESTERDAY'S SALE --}}
                    <div class="col-lg-6 mb-4 mb-2">

                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        Yesterday's Sale
                                    </div>
                                    <div class="col">
                                        <a href="">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h1>Rs {{ number_format($yesterdaySale) }}</h1>
                            </div>
                        </div>
                    </div>
                    {{-- THIS WEEK --}}
                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        Last 7 Days
                                    </div>
                                    <div class="col">
                                        <a href="">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h1>Rs {{ number_format($last7DaysSale) }}</h1>
                            </div>
                        </div>
                    </div>

                    {{-- ALL TIME --}}
                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        All Time Sales
                                    </div>
                                    <div class="col">
                                        <a href="">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h1>Rs {{ number_format($allTimeSale) }}</h1>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            {{-- --}}

            <div class="col-lg-6 mb-4 mt-5 mb-3 border-right">
                <div class="row sales-container">
                    {{-- Uber SALE --}}
                    <div class="col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <img src="{{ asset('assets/images/ubereats.png') }}" style="width: 100px" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h4>Total Sales: {{ $uberOrdersCount }}</h4>
                                <h1>Rs {{ number_format($uberSales) }}</h1>
                            </div>
                        </div>
                    </div>

                    {{-- Pick me SALE --}}
                    <div class="col-lg-6 mb-4 mb-2">

                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <img src="{{ asset('assets/images/pickme2.png') }}" style="width: 100px" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h4>Total Sales: {{ $pickmeOrdersCount }}</h4>
                                <h1>Rs {{ number_format($pickmeSales) }}</h1>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <h2 class="bg-success text-light p-3 rounded mb-5 mt-4">
            Sales Report
        </h2>



        <div class="row d-flex justify-content-center">
            <div class="col-lg-6">
                <a href="{{route('accounts.sales.show')}}" class="button-gr bg-blue"><i class="fa-regular fa-square-plus"></i> Sales Report</a>
            </div>
            <div class="col-lg-6">
                <a href="{{route('accounts.items.sold')}}" class="button-gr bg-green"><i class="fa-solid fa-list-ul"></i> Items Sold</a>
            </div>
        </div>
    </div>

@endpush
@push('scripts')
    <script src="{{ asset('') }}assets/libs/bootstrap/js/bootstrap-bundle.min.js"></script>
@endpush