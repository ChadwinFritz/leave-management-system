<x-guest-layout>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Admin Registration - Leave Management System</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/metisMenu.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/slicknav.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/typography.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/default-css.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
        <script src="{{ asset('assets/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    </head>

    <body>
        <div id="preloader">
            <div class="loader"></div>
        </div>

        <div class="login-area login-s2">
            <div class="container">
                <div class="login-box ptb--100">
                    <form method="POST" action="{{ route('admin.register') }}">
                        @csrf
                        <div class="login-form-head">
                            <h4>Admin Registration</h4>
                            <p>Create a new admin account</p>
                        </div>
                        <div class="login-form-body">
                            <div class="form-gp">
                                <label for="username">Username</label>
                                <input type="text" id="username" name="UserName" required autofocus>
                                <i class="ti-user"></i>
                                @error('UserName')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-gp">
                                <label for="fullname">Full Name</label>
                                <input type="text" id="fullname" name="fullname" required>
                                <i class="ti-user"></i>
                                @error('fullname')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-gp">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" required>
                                <i class="ti-email"></i>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-gp">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="Password" required>
                                <i class="ti-lock"></i>
                                @error('Password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="submit-btn-area">
                                <button id="form_submit" type="submit">Register <i class="ti-arrow-right"></i></button>
                            </div>
                            <div class="form-footer text-center mt-5">
                                <p class="text-muted"><a href="{{ route('admin.login') }}">Already have an account? Login here</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="{{ asset('assets/js/vendor/jquery-2.2.4.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('assets/js/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slicknav.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins.js') }}"></script>
        <script src="{{ asset('assets/js/scripts.js') }}"></script>
    </body>
</x-guest-layout>
