<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <!-- App css -->
    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="text-center w-75 m-auto">
                                <span><img src="{{ asset('assets/images/logo-dark.png') }}" alt=""
                                        height="150" style="object-fit: cover"></span>
                                <p class="text-muted mb-4 mt-3">Enter your username and password.</p>
                            </div>
                            <h5 class="auth-title text-center">Sign In</h5>

                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="emailaddress">Email address</label>
                                    <input class="form-control" type="email" id="emailaddress" name="email" required
                                        placeholder="Enter your email">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password">Password</label>
                                    <input class="form-control" type="password" id="password" name="password" required
                                        placeholder="Enter your password">
                                </div>

                                <div class="form-group mt-3 text-start">
                                    <button class="btn btn-primary form-control" type="submit">Log In</button>
                                </div>
                            </form>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif


                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->


                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- App js -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
</body>

</html>
