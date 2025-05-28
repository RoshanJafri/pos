@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{asset('assets/libs/jquery-ui/jquery-ui.min.css')}}">
@endpush
@push('content')<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Order & Sort Food Categories</h4>
                </div>
                <div class="card-body" id="sortable">
                    @foreach ($categories as $category)
                        <div class="border p-3 rounded my-2 bg-light sortable-item" data-id="{{ $category->id }}">
                            {{ $category->name }}
                        </div>
                    @endforeach
                </div>
                <div class="card-footer text-center">
                    <a href="{{route('categories.index')}}" class="btn btn-secondary" id="saveOrder">Go Back</a>
                    <button class="btn btn-primary" id="saveOrder">Save Order</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endpush
@push('scripts')
<script src="{{asset('assets/libs/jquery-ui/jquery-ui.min.js')}}"></script>
<script>
$(function() {
    $("#sortable").sortable();

    $('#saveOrder').click(function() {
        var order = [];
        $('.sortable-item').each(function(index) {
            order.push({
                id: $(this).data('id'),
                order: index + 1
            });
        });

        $.ajax({
            url: "{{ route('categories.updateOrder') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                order: order
            },
            success: function(response) {
                alert('Order updated!');
            }
        });
    });
});
</script>
@endpush