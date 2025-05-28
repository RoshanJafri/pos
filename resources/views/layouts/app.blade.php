<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('') }}assets/libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/css/style.css">
    @stack('styles')
    <title>Kafe Karachi Admin</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light border-bottom bg-light">
        <div class="container d-flex justify-content-between">
            <div class="">
                <a class="navbar-brand heavy" href="#"><img src="{{ asset('') }}assets/images/logo.png"
                        alt="" width="70px">KafeKarachi</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('')}}">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('orders.index')}}">All orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('categories.index')}}">Main Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('subcategories.index')}}">Sub Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('items.index')}}">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('employees.index')}}">Employees</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('orders.accounts')}}">Sales</a>
                    </li>
                    <li class="nav-item">
                        <button id="clearCacheBtn" type="button" class="btn btn-outline-secondaryf">
                            Refresh
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="mt-5"></div>
    @stack('content')
    <script src="{{ asset('') }}assets/libs/jquery/all.min.js"></script>
    <script src="{{ asset('') }}assets/libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{asset('')}}assets/libs/fontawesome/script.js"></script>
    
    @stack('scripts')
    <script>
        document.getElementById('clearCacheBtn').addEventListener('click', function() {
            if (confirm('Are you sure you want to clear cache?')) {
                fetch('{{ route('admin.clear.cache') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Cache cleared successfully!');
                        location.reload(); // Optional: reload page after
                    }
                })
                .catch(error => {
                    console.error('Error clearing cache:', error);
                });
            }
        });
        </script>
</body>

</html>