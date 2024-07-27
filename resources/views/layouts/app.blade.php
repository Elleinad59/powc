<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            margin: 0;
        }
        .container-fluid {
            flex: 1;
        }
        .header {
            width: 100%;
            background-color: #343a40;
            color: white;
            padding: 10px 0;
            position: fixed;
            top: 0;
            z-index: 1000;
        }
        .header .logo {
            font-size: 24px;
            padding-left: 20px;
        }
        .header .logout {
            float: right;
            padding-right: 20px;
        }
        .sidebar {
            position: fixed;
            top: 50px; /* Adjusted to be below the header */
            left: 0;
            width: 200px; /* Changed width */
            height: calc(100vh - 50px); /* Adjusted to account for the header height */
            background-color: #f8f9fa;
            padding-top: 20px;
            overflow-y: auto; /* Ensures the sidebar is scrollable if content overflows */
        }
        .content {
            margin-left: 200px; /* Changed to match the sidebar width */
            padding: 20px;
            padding-top: 70px; /* Adjusted to be below the header */
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 logo">
                    ATC
                </div>
                <div class="col-md-6 text-right logout">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-light">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <!-- Add the Purchase Order link -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('purchase_order.index') }}">Purchase Order</a>
            </li>
            <!-- Add more sidebar items here -->
        </ul>
    </div>
    <div class="content">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
