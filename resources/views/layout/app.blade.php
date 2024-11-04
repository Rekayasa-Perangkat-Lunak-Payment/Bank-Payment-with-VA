<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>LOGO EDUPAY</h2>
        <nav>
            <a>Home</a>
            {{-- <a href="{{ route('profile') }}">Profile</a>
            <a href="{{ route('settings') }}">Settings</a>
            <a href="{{ route('logout') }}">Logout</a> --}}
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header class="header">
            <div class="title">
                @yield('page-title', 'Dashboard')
            </div>
            <div class="user-info">
                {{-- <span>{{ Auth::user()->name }}</span> --}}
                <span>Name</span>
                {{-- <img src="{{ Auth::user()->profile_picture }}" alt="Profile Picture" width="35" height="35" style="border-radius: 50%;"> --}}
                <img src="" alt="Profile Picture" width="35" height="35" style="border-radius: 50%;">
            </div>
        </header>

        <!-- Page Content -->
        <div class="content">
            @yield('content')
        </div>
    </div>

    {{-- Script --}}
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
</body>

</html>
