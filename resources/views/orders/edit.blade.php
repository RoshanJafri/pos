@extends('layouts.app')
@push('content')
    <div class="container">
        <div class="mb-3">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }} &nbsp; &nbsp;
                    <a href="{{ url('') }}" class="">Go Home</a>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-lg-7">
                <h3>Editing Order # {{ $order->id }} <small>(Rs. {{ $order->subtotal }})</small></h3>
                <ul class=" shadow border orders-nav nav nav-tabs nav-justified" id="myTab" role="tablist">
                    @foreach ($categories as $cat)
                        <li class="nav-item">
                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ \Str::slug($cat->name) }}-tab"
                                data-toggle="tab" href="#nav-{{ \Str::slug($cat->name) }}" role="tab"
                                aria-controls="{{ \Str::slug($cat->name) }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $cat->name }}</a>
                        </li>
                    @endforeach
                </ul>

                <div class=" shadow border tab-content border rounded p-2 mt-2" id="myTabContent">
                    @foreach ($categories as $cat)
                        <div class="tab-pane show {{ $loop->first ? 'active' : '' }}"
                            id="nav-{{ \Str::slug($cat->name) }}" role="tabpanel"
                            aria-labelledby="{{ \Str::slug($cat->name) }}-tab">

                            @foreach ($cat->subCategories as $subCategory)
                                <div class="mb-3 subcategory-listing">
                                    <h5 class="border-bottom pb-1">{{ $subCategory->name }}</h5>
                                    <!-- Subcategory name with line -->
                                    <div class="row">
                                        @foreach ($subCategory->items as $item)
                                            <div class="col-lg-3">
                                                <div class="card mb-2 item-card" data-cost="{{ $item->cost }}"
                                                    data-item-id="{{ $item->id }}" data-name="{{ $item->name }}">
                                                    <div class=" card-body" style="min-height:8em">
                                                        <div><strong>{{ $item->name }}</strong></div>
                                                        <div class="border-top-dark mt-2 pt-2">
                                                            <i>Rs. {{ $item->cost }}</i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header">
                        {{-- <div class="existing-order-box mb-4">
                            <div>
                                <label for="existing-checkbox">Existing order?</label>
                                <input type="checkbox" name="" id="existing-checkbox">
                            </div>
                            <div class="d-hidden" class="open-orders-list-container">
                                <select name="" id="" class="form-control">
                                    <option value="">New Order</option>
                                    <option value="">Orderid - 2</option>
                                    <option value="">Orderid - 3</option>
                                </select>
                            </div>
                        </div> --}}
                        <h5>Order #{{ $order->id }} Details</h5>
                        <p><span class="text-secondary">Last updated:
                            </span>{{ date('h:ia jS \o\f M, Y', strtotime($order->updated_at)) }}</p>
                    </div>
                    <div class="card-body order-details-container">
                        <table class="table order-details-table">
                            <tbody class="">

                            </tbody>
                        </table>
                        <div class="mt-3 border-top pt-3 order-summary-container d-none">
                            <h6>Order Summary</h6>
                            <table class="table order-summary-table">
                                <tbody>
                                    <tr>
                                        <th>SubTotal</th>
                                        <td class="text-right">Rs. <span class="subtotal"></span></td>
                                    </tr>
                                    <tr>
                                        <th>Discount</th>
                                        <td>
                                            <div>
                                                <span class="btn mt-1 border btn-discount" data-discount-value="0">0%</span>
                                                <span class="btn mt-1 border btn-discount"
                                                    data-discount-value=".05">5%</span>
                                                <span class="btn mt-1 border btn-discount"
                                                    data-discount-value=".1">10%</span>
                                                <span class="btn mt-1 border btn-discount"
                                                    data-discount-value=".15">15%</span>
                                                <span class="btn mt-1 border btn-discount"
                                                    data-discount-value=".20">20%</span>
                                                <span class="btn mt-1 border btn-discount"
                                                    data-discount-value=".25">25%</span>
                                                <span class="btn mt-1 border btn-discount"
                                                    data-discount-value=".30">30%</span>
                                                <span class="btn mt-1 border btn-discount"
                                                    data-discount-value=".35">35%</span>
                                                <span class="btn mt-1 border btn-discount"
                                                    data-discount-value=".40">40%</span>
                                            </div>
                                            <div class="mt-2">
                                                Rs. <input class="d-inline discount-input" style="max-width: 100px"
                                                    type="number" value="0" autocomplete="off" placeholder="100"
                                                    onchange="setDiscount()"> &nbsp; <br> Discount Percentage = <span
                                                    class="discount-percentage">0%</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Taxes</th>
                                        <td class="text-right"><small>37% of <span class="subtotal"></span></small><br>Rs.
                                            <span class="tax"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><strong>Payable</strong></th>
                                        <td class="text-right">Rs <h4 class="d-inline payable">0</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                            <div class="border p-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="employee_id" class="label">Server/Handler</label>
                                        <select name="employee_id" id="employee_id" class="form-control">
                                            <option value="none-selected" disabled selected>Select a Server</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="table_no">Tabel No.</label>
                                        <select name="table_no" id="table_no" class="form-control">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="row ">
                                    <div class="col-lg-4">
                                        <label for="order_type_dinein" class="label">Dine in</label>
                                        <input type="radio" name="order_type" id="order_type_dinein" value="dine_in"
                                            checked>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="order_type_takeaway" class="label">Take away</label>
                                        <input type="radio" name="order_type" id="order_type_takeaway"
                                            value="takeaway">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="delivery_app_select" class="label">Food Delivery App</label>
                                        <select name="delivery_app" id="delivery_app_select" class="form-control">
                                            <option value="">In House (Takeaway/DineIn)</option>
                                            <option {{$order->app=='uber_eats'?'selected':''}} value="uber_eats">Uber Eats</option>
                                            <option  {{$order->app=='pick_me'?'selected':''}} value="pick_me">Pick Me</option>
                                        </select>
                                    </div>
                                    <div class="border-top border-bottom mt-2 py-2 col-lg-12">

                                        <div class="row">
                                            <div class="col-lg-6 ">
                                                <label for="print_yes" class="label btn btn-secondary p-2" style="cursor:pointer">Print
                                                    Receipt</label>
                                                <input type="radio" name="print_receipt" id="print_yes" value="1"
                                                    checked style="cursor:pointer">
                                            </div>
                                            <div class="col-lg-6 ">
                                                <label for="print_no" class="label btn btn-secondary p-2" style="cursor:pointer">No
                                                    Print</label>
                                                <input type="radio" name="print_receipt" id="print_no" value="0"
                                                    style="cursor:pointer">
                                            </div>
                                        </div>
                                        {{-- <input type="checkbox" name="print_receipt" id="print_receipt" style="cursor:pointer">
                                        <label for="print_receipt" class=" label"  style="cursor:pointer;text-decoration:underline"><i class="fa-regular fa-file"></i>&nbsp;&nbsp;Print Receipt?</label> --}}
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <label for="order_note">Notes:</label>
                                        <textarea class="form-control" name="" id="order_note" cols="30" rows="2"
                                            placeholder="Add any notes..."></textarea>
                                    </div>
                                </div>
                                <br>
                                <button type="button" id="btn_generate_receipt" class="btn btn-block btn-primary"><i
                                        class="fa-regular fa-paper-plane"></i> Proceed</button>
                            </div>
                            <div>
                                <form id="orderDetailsForm" action="{{ route('orders.update', $order->id) }}"
                                    method="POST">
                                    @method('PUT')
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush
@push('scripts')
    <script>
        const orderFromServer = @json($order);
        const orderDetailsFromServer = @json($order->details ?? []);
    </script>
    <script>
        orderItems = {}; // reset just in case

        orderDetailsFromServer.forEach(detail => {
            orderItems[detail.item_id] = {
                id: detail.item_id,
                name: detail.item.name, // ← now accessible via the relation
                cost: detail.finalCost,
                originalCost: detail.originalCost,
                qty: detail.quantity,
                discount: Math.round((1 - (detail.finalCost / detail.originalCost)) * 100)
            };
        });

        // Fill summary fields
        subtotal = orderFromServer.subtotal;
        tax = orderFromServer.tax;
        taxRate = 0;
        discountPercentage = orderFromServer.discountPercentage;
        discount = subtotal * (discountPercentage / 100);
        payable = orderFromServer.payable;

        // Fill order meta fields
        $('#order_note').val(orderFromServer.note);
        $('input[name="order_type"][value="' + orderFromServer.order_type + '"]').prop('checked', true);
        $('select[name="employee_id"]').val(orderFromServer.employee_id);
        $('select[name="table_no"]').val(orderFromServer.table_no);

        // now render order table with data from controller
        renderOrderTable();

        $('.order-summary-container').removeClass('d-none');

        function calculate() {
            subtotal = 0;
            tax = 0;
            payable = 0;


            Object.keys(orderItems).forEach(key => {
                subtotal += orderItems[key].cost * orderItems[key].qty;
            })

            discount = subtotal * (discountPercentage / 100);
            tax = Math.round((subtotal * taxRate));
            payable = Math.round(((tax + subtotal) - discount));
        }


        // Function to render all items in the table
        function renderOrderTable() {

            calculate();

            $('.order-details-table tbody').empty(); // Clear table before re-rendering

            var i = 1;
            Object.keys(orderItems).forEach(key => {
                let item = orderItems[key];
                $('.order-details-table tbody').append(
                    `
                    <tr class="order-details-item">
                        <td class="small">${i}</td>
                        <td>${item.name} <br> Rs. <input class="border item-price-input" style="max-width:80px" type="number"  value="${item.cost}" data-item-id="${item.id}"> <br> ` +
                    (item.discount > 0 ? `<s>Rs. ${item.originalCost}</s>` : '') + ` </td>
                        <td>

                            Qty. <input class="border item-qty-input" style="max-width:65px" type="number"  value="${item.qty}" data-item-id="${item.id}"> 
                            <br> 
                            Discount % <input class="border item-discount-input" style="max-width:65px" type="number"  value="${item.discount}" data-item-id="${item.id}" placeholder="0">

                        </td>
                        <td><span class="btn-delete item-delete text-danger" data-item-id="${item.id}">
                            <i class="fa-regular fa-square-minus"></i></span></td>
                    </tr>
                `);
                i++;
            });


            $('.order-summary-table .subtotal').html(subtotal);
            $('.order-summary-table .tax').html(tax);
            $('.order-summary-table .discount-input').val(discount);
            $('.order-summary-table .payable').html(payable);
            $('.order-summary-table .discount-percentage').html(
                discountPercentage +
                '%'
            );

            // Attach delete event again after rendering
            attachDeleteEvent();
        }

        // Click event for adding items
        $('.item-card').click(function() {
            $('.order-summary-container').removeClass('d-none');
            let itemName = $(this).data('name');
            let itemCost = $(this).data('cost');
            let itemId = $(this).data('item-id');

            if (orderItems[itemId]) {
                orderItems[itemId].qty++; // Increase quantity
                renderOrderTable();
            } else {
                orderItems[itemId] = {
                    id: itemId,
                    name: itemName,
                    cost: itemCost,
                    originalCost: itemCost,
                    qty: 1,
                }; // Add item to array

            }


            renderOrderTable(); // Re-render table
        });

        // order summary discount buttons handler
        $('.btn-discount').click(function() {
            discount_percentage = $(this).data('discount-value');
            discount = Math.round((subtotal * discount_percentage) * 100) / 100;
            $('.discount-input').val(discount);

            discountPercentage = Math.round(((discount / subtotal) * 100) * 100) / 100;
            renderOrderTable();

        })

        // order summary discount input handler
        function setDiscount() {
            discount = Number($('.discount-input').val());

            discountPercentage = Math.round(((discount / subtotal) * 100) * 100) / 100;
            renderOrderTable();

        }

        // individual discount handler
        $(document).on('change', '.item-discount-input', function() {
            let discount = parseFloat($(this).val()) || 0; // Ensure it's a valid number
            let targetId = $(this).data('item-id');

            if (orderItems[targetId]) {
                cost = orderItems[targetId].cost;
                orderItems[targetId].cost = cost - (cost * (discount / 100)); // Update discount in the array
                orderItems[targetId].discount = discount; // Update discount in the array
                renderOrderTable(); // Re-render table if needed
            }
        });

        // qty input handler
        $(document).on('change', '.item-qty-input', function() {
            let newQty = parseFloat($(this).val()) || 0; // Ensure it's a valid number
            let targetId = $(this).data('item-id');

            if (orderItems[targetId]) {
                orderItems[targetId].qty = newQty; // Update qty in the array
                renderOrderTable(); // Re-render table if needed
            }
        });

        // changing individual item price
        $(document).on('change', '.item-price-input', function() {
            let newPrice = parseFloat($(this).val()) || 0; // Ensure it's a valid number
            let targetId = $(this).data('item-id');


            if (orderItems[targetId]) {
                orderItems[targetId].cost = newPrice; // Update cost in the array
                renderOrderTable(); // Re-render table if needed
            }
        });

        // Function to attach delete event
        function attachDeleteEvent() {
            $('.item-delete').off('click').on('click', function() {
                let itemId = $(this).data('item-id');
                delete orderItems[itemId]; // Remove item from array

                Object.keys(orderItems).forEach(key => {
                    subtotal += orderItems[key].cost;
                })

                renderOrderTable(); // Re-render table
            });
        }

        // AJAX REQUEST
        $('#btn_generate_receipt').on('click', function(e) {
            e.preventDefault();

            let note = $('#order_note').val();
            let order_type = $('input[name="order_type"]:checked').val();
            let employee_id = $('select[name="employee_id"]').val();
            let table_no = $('select[name="table_no"]').val();
            let payment_method = $('select[name="payment_method"]').val();
            let print_receipt = $('input[name="print_receipt"]:checked').val();
            let delivery_app = $('select[name="delivery_app"]').val();

            let orderSummary = {
                items: orderItems,
                subtotal: subtotal,
                tax: tax,
                payable: payable,
                discount: discount,
                discountPercentage: discountPercentage,
                note: note,
                order_type: order_type,
                delivery_app: delivery_app,
            }
            $('#orderForm').empty();
            $("#orderDetailsForm").append(`
                <input type="hidden" name="subtotal" value="${subtotal}">
                <input type="hidden" name="tax" value="${tax}">
                <input type="hidden" name="payable" value="${payable}">
                <input type="hidden" name="discount" value="${discount}">
                <input type="hidden" name="discountPercentage" value="${discountPercentage}">
                <input type="hidden" name="note" value="${note}">
                <input type="hidden" name="order_type" value="${order_type}">
                <input type="hidden" name="table_no" value="${table_no}">
                <input type="hidden" name="employee_id" value="${employee_id}">
                <input type="hidden" name="payment_method" value="${payment_method}">
                <input type="hidden" name="print_receipt" value="${print_receipt}">
                <input type="hidden" name="delivery_app" value="${delivery_app}">
            `);

            // Loop through orderItems object
            Object.keys(orderItems).forEach((key, index) => {
                const item = orderItems[key];
                $('#orderDetailsForm').append(`
                    <input type="hidden" name="items[${index}][id]" value="${item.id}">
                    <input type="hidden" name="items[${index}][name]" value="${item.name}">
                    <input type="hidden" name="items[${index}][cost]" value="${item.cost}">
                    <input type="hidden" name="items[${index}][originalCost]" value="${item.originalCost}">
                    <input type="hidden" name="items[${index}][qty]" value="${item.qty}">
                `);
            });
            $('#orderDetailsForm').submit();

        });
    </script>
@endpush
