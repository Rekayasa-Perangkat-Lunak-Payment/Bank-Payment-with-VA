<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome | Login</title>
    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('assets/images/background.jpg') }}') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 150px 20px;
            text-align: center;
            position: relative;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.5rem;
        }

        .navbar {
            background-color: transparent;
            position: sticky;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .login-section {
            background-color: #f8f9fa;
            padding: 50px 20px;
            text-align: center;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 0px;
            position: relative;
            text-align: center;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #ffffff;">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="Logo" height="65"
                    style=" width: 140px; height: 50px; object-fit: cover">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero">
        <h1>Welcome to Instipay</h1>
        <p>Your invoice payment solution with ease using virtual accounts.</p>
        <a href="#login" class="btn btn-primary mt-4">Get Started</a>
    </div>

    <div id="login" class="login-section">
        <h2>Sign In</h2>
        <p class="text-muted mb-4">Access your account by logging in below.</p>
        <form id="loginForm" class="w-50 mx-auto">
            <div class="form-group mb-3">
                {{-- <label for="emailaddress">Email Address</label> --}}
                <input class="form-control" type="email" id="emailaddress" name="email" required
                    placeholder="Enter your email">
            </div>

            <div class="form-group mb-3">
                {{-- <label for="password">Password</label> --}}
                <input class="form-control" type="password" id="password" name="password" required
                    placeholder="Enter your password">
            </div>

            <div class="form-group mt-3 text-center">
                <button class="btn btn-primary form-control" type="submit">Log In</button>
            </div>
        </form>

        <div id="errorMessage" class="alert alert-danger mt-3 d-none"></div>
    </div>

    <footer class="footer">
        <div class="row" style="background-color: black; padding: 20px">
            <div class="col-md-4" style="color: white">
                <h5 style="color: white">Contact Us</h5>
                <p>Email: support@instipay.com</p>
                <p>Phone: +62 894 0154 4377</p>
            </div>
            <div class="col-md-4" style="color: white">
                <h5 style="color: white">Address</h5>
                <p>Jl. Dr. Wahidin Sudirohusodo No.5-25, Kotabaru</p>
                <p>Gondokusuman, Yogyakarta, Daerah Istimewa Yogyakarta</p>
            </div>
            <div class="col-md-4" style="color: white">
                <h5 style="color: white">Have Questions?</h5>
                <p>Reach out to our team anytime.</p>
                <p><a href="#" class="btn btn-link">Contact Us</a></p>
            </div>
        </div>
        <p class="mt-4">&copy; 2024 Instipay. All rights reserved with love of RPL <3.< /p>
    </footer>

    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault(); // Prevent default form submission

            const email = document.getElementById('emailaddress').value;
            const password = document.getElementById('password').value;

            try {
                const response = await axios.post('http://127.0.0.1:8000/api/login', {
                    email: email,
                    password: password
                });

                if (response.data && response.data.data && response.data.data.token && response.data.data
                    .role) {
                    localStorage.setItem('authToken', response.data.data.token);
                    localStorage.setItem('role', response.data.data.role);
                    localStorage.setItem('username', response.data.data.user.username);
                    localStorage.setItem('email', response.data.data.user.email);
                    localStorage.setItem('id', response.data.data.user.id);
                    if (response.data.data.user.bank_admin) {
                        localStorage.setItem('name', response.data.data.user.bank_admin.name);
                    }else{
                        localStorage.setItem('name', response.data.data.user.institution_admin.name);
                        localStorage.setItem('institution_id', response.data.data.user.institution_admin.institution_id);
                    }
                    window.location.href = '/dashboard';

                } else {
                    alert('Unexpected response format.');
                }

            } catch (error) {
                console.error('Error during login:', error);

                if (error.response) {
                    const errorMessage = error.response.data.message || 'Login failed. Please try again.';
                    alert(errorMessage);
                } else if (error.request) {
                    alert('No response from server. Please try again.');
                } else {
                    alert('Error during login. Please try again.');
                }
            }
        });
    </script>
</body>

</html>
