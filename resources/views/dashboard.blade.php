@extends('layouts.app')
@push('content')
    <div class="container">
        <div class="col-lg-12 mb-3">

            <div class="mb-3">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h4>Errors:</h4>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="card shadow-sm">
                <div class="card-header ">
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <h5 class="mb-0">All Open Orders</h5>
                        </div>
                        <div class="">
                            <a href="{{ route('orders.create') }}" class="btn btn-primary">Add new</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Table</th>
                                <th>Payable</th>
                                <th>Order Type</th>
                                <th>Last Updated</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr class="oi{{$order->id}}">
                                    <td><span class="bg-light border p-2" style="font-weight:600;">{{ $order->id }}</span></td>
                                    <td>{{ $order->table_no }}</td>
                                    <td> Rs. <span class="text-success"
                                            style="font-weight:600">{{ number_format($order->payable) }}</span>
                                        <br> <small class="text-primary">{{$order->payment_method}}</small>
                                    </td>
                                    <td>{{ucfirst(str_replace('_', ' ', $order->order_type))}}</td>
                                    <td>{{ date('h:iA', strtotime($order->updated_at)) }} <br>
                                        <small>{{   date('jS M, \'y', strtotime($order->updated_at)) }} </small>
                                    </td>

                                    {{-- Action buttons for edit and delete --}}
                                    <td>
                                        <a href=""></a>
                                        <a data-orderId="{{$order->id}}" href="#"
                                            class="btn-print-client btn border btn-success"><i class="fa-solid fa-receipt"></i>
                                            CLIENT RECEIPT</a>&nbsp;
                                        <button data-orderId="{{$order->id}}" class="office-receipt-btn btn border btn-primary"
                                            data-toggle="modal" data-target="#paymentModal"><i class="fa-solid fa-receipt"></i>
                                            OFFICE RECEIPT</button>&nbsp;
                                        <a href="{{route('orders.edit', $order->id)}}" class="btn border btn-primary"><i
                                                class="fa-solid fa-pencil"></i> EDIT</a>
                                        {{-- <button class="btn btn-danger btn-delete" data-id="{{ $order->id }}"
                                            data-action="{{ route('orders.destroy', $order->id) }}" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal">
                                            Delete
                                        </button> --}}
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>

                    </table>

                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center">
                        {!! $orders->links('pagination::bootstrap-5') !!} <!-- This will render Bootstrap pagination -->
                    </div>
                </div>
            </div>
        </div>


        <div class="row d-flex justify-content-center">
            <div class="col-lg-6">
                <a href="{{route('orders.create')}}" class="button-gr bg-blue"><i class="fa-regular fa-square-plus"></i> New
                    Order</a>
            </div>
            <div class="col-lg-6">
                <a href="{{route('orders.index')}}" class="button-gr bg-green"><i class="fa-solid fa-list-ul"></i> All
                    Orders</a>
            </div>
        </div>
    </div>

    {{-- delete modal --}}
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" id="deleteForm" autocomplete="off">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Deletion</h5>
                    </div>
                    <div class="modal-body">
                        <input type="password" name="admin_code" class="form-control" placeholder="Enter password"
                            autocomplete="off" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Hidden modal for payment method -->
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Payment Method</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" name="orderid" id="orderIdInput">
                <div class="modal-body">
                    <select class="form-control" name="" id="paymentMethodInput">
                        <option value="credit_card">Credit Card</option>
                        <option value="cash">Cash</option>
                        <option value="online_transfer">Online Bank Transfer</option>
                        <option value="on_credit">On Credit (to pay later)</option>
                    </select>

                    <div class="row">
                        <div class="col-lg-6 ">
                            <label for="print_yes" class="label btn btn-secondary p-2" style="cursor:pointer">Print
                                Receipt</label>
                            <input type="radio" name="print_receipt" id="print_yes" value="1" checked
                                style="cursor:pointer">
                        </div>
                        <div class="col-lg-6 ">
                            <label for="print_no" class="label btn btn-secondary p-2" style="cursor:pointer">No
                                Print</label>
                            <input type="radio" name="print_receipt" id="print_no" value="0" style="cursor:pointer">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-print-office">Save changes</button>
                </div>
            </div>
        </div>
    </div>

@endpush
@push('scripts')
    {{-- {{route('orders.print', $order->id)}} --}}

    <script src="{{ asset('') }}assets/libs/bootstrap/js/bootstrap-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.btn-delete').forEach(function (button) {
                button.addEventListener('click', function () {
                    var action = this.getAttribute('data-action');
                    document.getElementById('deleteForm').setAttribute('action', action);
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            // Click event for the print button
            $('.office-receipt-btn').click(function (e) {
                let orderid = $(this).data('orderid');
                $('#orderIdInput').val(orderid);
            });
            $('.btn-print-client').click(function (e) {

                e.preventDefault();  // Prevent default link action

                var orderId = $(this).data('orderid');  // Get the order ID from the data attribute

                // Generate the URL for the print route using Laravel's route() helper
                var url = "{{ route('orders.printClient', ':orderId') }}".replace(':orderId', orderId);

                // Send AJAX request
                $.ajax({
                    url: url,  // Use the dynamically generated URL
                    method: 'GET',  // HTTP method
                    success: function (response) {
                        alert('printing client receipt.');

                    },
                    error: function (xhr, status, error) {
                        // Handle error
                        alert('Failed to print the order. Please try again.');
                    }
                });
            });
            $('#btn-print-office').click(function (e) {
                var paymentMethod = $('#paymentMethodInput').val();
                var orderId = $('#orderIdInput').val();
                var printReceipt = $('input[name="print_receipt"]:checked').val();  // ✅ Get selected radio value
                // Generate the URL for the print route using Laravel's route() helper
                var url = "{{ route('orders.printOffice', ':orderId') }}".replace(':orderId', orderId);

                // Send AJAX request
                $.ajax({
                    url: url,  // Use the dynamically generated URL
                    method: 'GET',  // HTTP method
                    data: {
                        payment_method: paymentMethod,
                        print_receipt: printReceipt
                    },
                    success: function (response) {
                        $('#paymentModal').removeClass('show').hide();
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');

                        alert('Order processed & saved.');
                        $('tr.oi' + orderId).remove();

                    },
                    error: function (xhr, status, error) {
                        // Handle error
                        $('#paymentModal').removeClass('show').hide();
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');
                        alert('Failed to process the office receipt. Please try again.');
                    }
                });
            });
        });


    </script>
@endpush