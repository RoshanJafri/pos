@extends('layouts.app')
@push('content')

  <div id="password-overlay">
    <h2>Enter Password</h2>
    <input type="password" id="page-password" placeholder="Password">
    <button id="submit-password">Unlock</button>

        <a href="{{url('')}}">Go back</a>
    <div id="wrong-pass">Wrong password</div>
  </div>
    <div class="container locked"><div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h2>Time Frame</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{route('orders.accounts')}}">
                            <label for="">Select time frame</label>
                            <select name="period" id="" class="form-control">
                                <option value="">Select an option</option>
                                <option value="today">Today</option>
                                <option value="all_time">All Time</option>
                                <option value="week">This Week</option>
                            </select>
                            <br>
                        <input type="submit" value="Search" class="btn btn-primary">

                        </form>
                        <br>
                    </div>
                </div>
                <br>
                <h2 class="text-center">OR</h2>
                <div class="card">
                    <div class="card-header">
                        <h2>Custom Date Range</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{route('orders.accounts')}}">
                            <label for="">From</label>
                            <input type="date" class="form-control" name="start_date">
                            <label for="">To</label>
                            <input type="date" class="form-control" name="end_date">
                            <br>
                        <input type="submit" value="Search" class="btn btn-primary">

                        </form>
                        <br>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                @if (strlen($start_date)<1)
                    
                    <h4>Total Sales {{ $period?ucfirst(str_replace('_', ' ', $period)):'Today' }}</h4>
                    today's date: {{ date('jS \o\f M, Y') }}
                    <h1>Rs. {{ $total }}</h1>
                @else
                    
                    <h4>Total Sales From {{date('d M Y', strtotime($start_date))}} to  {{date('d M Y', strtotime($end_date))}}</h4>
                    today's date: {{ date('jS \o\f M, Y') }}
                    
                    <h1>Rs. {{ $total }}</h1>
                @endif
            </div>
        </div>
    </div>
@endpush

@push('scripts')
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

