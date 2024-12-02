<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
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
                                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="Logo" height="150"
                                    style="object-fit: cover">
                                <p class="text-muted mb-4 mt-3">Please log in with your email and password.</p>
                            </div>
                            <h5 class="auth-title text-center">Sign In</h5>
                            <form id="loginForm">
                                <div class="form-group mb-3">
                                    <label for="emailaddress">Email Address</label>
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

                            <div id="errorMessage" class="alert alert-danger mt-3 d-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

                if (response.data && response.data.data && response.data.data.token) {
                    localStorage.setItem('authToken', response.data.data.token);
                    window.location.href = '/dashboard'; // Redirect to dashboard
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
