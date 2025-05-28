@extends('layouts.app')
@push('content')
<div class="container">
    <div class="col-lg-12 mb-3">
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
                            <th>Table No.</th>
                            <th>Payable</th>
                            <th>Order Type</th>
                            <th>Last Updated</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="oi{{$order->id}}">
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->table_no }}</td>
                                <td> Rs. {{ $order->payable }} <br> <small class="text-primary">{{$order->payment_method}}</small></td>
                                <td>{{ucfirst(str_replace( '_',' ',$order->order_type ))}}</td>
                                <td>{{ date('h:iA, jS \o\f M, Y', strtotime($order->updated_at)) }}</td>

                                {{-- Action buttons for edit and delete --}}
                                <td>
                                    <a href=""></a>
                                    <a data-orderId="{{$order->id}}" href="#" class="btn-print-client btn border btn-success"><i class="fa-solid fa-receipt"></i> CLIENT RECEIPT</a>&nbsp;
                                    <button data-orderId="{{$order->id}}" class="office-receipt-btn btn border btn-primary" data-toggle="modal" data-target="#paymentModal"><i class="fa-solid fa-receipt"></i> OFFICE RECEIPT</button>&nbsp;
                                    <a href="{{route('orders.edit', $order->id)}}"
                                        class="btn border btn-primary"><i class="fa-solid fa-pencil"></i> EDIT</a></td>
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
            <a href="{{route('orders.create')}}" class="button-gr bg-blue"><i class="fa-regular fa-square-plus"></i> New Order</a>
        </div>
        <div class="col-lg-6">
            <a href="{{route('orders.index')}}" class="button-gr bg-green"><i class="fa-solid fa-list-ul"></i> All Orders</a>
        </div>
    </div>
</div><!-- Hidden modal for payment method -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
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
    <script>
$(document).ready(function() {
    // Click event for the print button
    $('.office-receipt-btn').click(function(e){
        let orderid = $(this).data('orderid');
        $('#orderIdInput').val(orderid);
    });
    $('.btn-print-client').click(function(e) {
        
        e.preventDefault();  // Prevent default link action

        var orderId = $(this).data('orderid');  // Get the order ID from the data attribute

        // Generate the URL for the print route using Laravel's route() helper
        var url = "{{ route('orders.printClient', ':orderId') }}".replace(':orderId', orderId);

        // Send AJAX request
        $.ajax({
            url: url,  // Use the dynamically generated URL
            method: 'GET',  // HTTP method
            success: function(response) {
                alert('printing client receipt.');
                // Assuming the response contains the URL for download
                var downloadUrl = response.downloadUrl;

                // Trigger the download by creating a hidden anchor element
                var link = document.createElement('a');
                link.href = downloadUrl;
                link.download = '';  // This can specify a filename if needed, otherwise it'll use the default
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                window.open(url, '_blank');

            },
            error: function(xhr, status, error) {
                // Handle error
                alert('Failed to print the order. Please try again.');
            }
        });
    });
    $('#btn-print-office').click(function(e) {
        var paymentMethod = $('#paymentMethodInput').val();
        var orderId = $('#orderIdInput').val();

        // Generate the URL for the print route using Laravel's route() helper
        var url = "{{ route('orders.printOffice', ':orderId') }}".replace(':orderId', orderId);

        // Send AJAX request
        $.ajax({
            url: url,  // Use the dynamically generated URL
            method: 'GET',  // HTTP method
            data: { payment_method: paymentMethod },
            success: function(response) {
                $('#paymentModal').modal('hide');
                alert('printing office receipt.');
                // Assuming the response contains the URL for download
                var downloadUrl = response.downloadUrl;

                // Trigger the download by creating a hidden anchor element
                var link = document.createElement('a');
                link.href = downloadUrl;
                link.download = '';  // This can specify a filename if needed, otherwise it'll use the default
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                window.open(url, '_blank');
                // Optionally: You can remove the corresponding row after printing
                $('tr.oi' + orderId).remove();
            },
            error: function(xhr, status, error) {
                // Handle error
                $('#paymentModal').modal('hide');
                alert('Failed to print the office receipt. Please try again.');
            }
        });
    });
});


    </script>
@endpush