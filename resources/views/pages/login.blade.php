<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
     <!-- App css -->
     <link href="{{asset('assets/css/bootstrap.css')}}" rel="stylesheet" />
     <link href="{{asset('assets/css/app.css')}}" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <a href="index.html">
                                    <span><img src="{{asset('assets/images/logo-dummin2.png')}}" alt="" height="150"></span>
                                </a>
                                <p class="text-muted mb-4 mt-3">Enter your email address and password to access admin
                                    panel.</p>
                            </div>

                            <h5 class="auth-title text-center">Sign In</h5>

                            <form action="#">

                                <div class="form-group mb-3">
                                    <label for="emailaddress">Email address</label>
                                    <input class="form-control" type="email" id="emailaddress" required=""
                                        placeholder="Enter your email">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password">Password</label>
                                    <input class="form-control" type="password" required="" id="password"
                                        placeholder="Enter your password">
                                </div>

                                <div class="form-group mt-3 text-start" href="/">
                                    <button class="btn btn-primary form-control" type="submit"> Log In </button>
                                </div>

                            </form>


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
    <script src="{{asset('assets/js/app.min.js')}}"></script>
</body>

</html>
