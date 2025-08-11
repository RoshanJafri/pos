@extends('layouts.app')
@push('content')


  <div id="password-overlay">
    <h2>Enter Password</h2>
    <input type="password" id="page-password" placeholder="Password">
    <button id="submit-password">Unlock</button>
	
        <a href="{{url('')}}">Go back</a>
    <div id="wrong-pass">Wrong password</div>
  </div>
    <div class="container locked">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-header ">
                        <div class="d-flex justify-content-between">
                            <div class="">
                                <h5 class="mb-0">All Orders</h5>
                            </div>
                            <div class="">
                                <a href="{{ route('orders.create') }}" class="btn btn-primary"><i
                                        class="fa-solid fa-receipt"></i> New Order</a>

                            </div>
                        </div>

                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Server</th>
                                    <th>Table No.</th>
                                    <th>Subtotal</th>
                                    <th>Tax</th>
                                    <th>Discount</th>
                                    <th>Payable</th>
                                    <th>Order Type</th>
                                    <th>Created</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->employee ? $order->employee->name : 'employee deleted' }}</td>
                                        <td>{{ $order->table_no }}</td>
                                        <td> Rs. {{ $order->subtotal }}</td>
                                        <td> Rs. {{ $order->tax }}</td>
                                        <td> Rs. {{ $order->discount ? $order->discount : '0' }}</td>
                                        <td> Rs. {{ $order->payable }} <br> <small
                                                class="text-primary">{{ $order->payment_method }}</small></td>
                                        <td>{{ $order->order_type }}</td>
                                        <td>{{ date('h:i A jS \o\f M, Y', strtotime($order->created_at)) }}</td>

                                        {{-- Action buttons for edit and delete --}}
                                        <td><a href="{{ route('orders.edit', $order->id) }}"
                                                class="btn border">edit</a>&nbsp;
                                            <button class="btn btn-danger btn-delete" data-id="{{ $order->id }}"
                                                data-action="{{ route('orders.destroy', $order->id) }}"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>

                                    {{-- Dropdown for order details (items) --}}
                                    <tr>
                                        <td colspan="10">

                                            <button class="btn mb-2 btn-sm btn-secondary-outline" data-bs-toggle="collapse"
                                                data-bs-target="#order-details-{{ $order->id }}">Show Details
                                            </button>
                                            <div id="order-details-{{ $order->id }}" class="collapse">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Item Name</th>
                                                            <th>Quantity</th>
                                                            <th>cost</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($order->details as $item)
                                                            <!-- Assuming you have a relationship for the order details -->
                                                            <tr>
                                                                <td>{{ $item->name }}</td>
                                                                <td>{{ $item->quantity }}</td>
                                                                <td> Rs. {{ $item->finalCost }} {!! $item->finalCost != $item->originalCost
                                                                    ? '<s style="font-size:14px"> Rs. ' . $item->originalCost . '</s>'
                                                                    : '' !!}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
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
        </div>
    </div>
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
                        <input type="text" name="admin_code" class="form-control" placeholder="Enter password" autocomplete="off" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endpush
@push('scripts')
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
    <script src="{{ asset('') }}assets/libs/bootstrap/js/bootstrap-bundle.min.js"></script>
      <script>
    const correctPassword = "0881"; // 🔐 Change this to your desired password

    $('#submit-password').click(function () {

      const input = $('#page-password').val();

      if (input === correctPassword) {
        $('#password-overlay').fadeOut();
        $('body').removeClass('locked');
      } else {
        $('#wrong-pass').fadeIn();
      }
    });

    $('#page-password').on('keypress', function (e) {
      if (e.which === 13) {
        $('#submit-password').click();
      }
    });
  </script>
@endpush
