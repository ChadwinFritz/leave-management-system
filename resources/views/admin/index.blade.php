<x-guest-layout>
    <!-- Meta and Stylesheets -->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Admin Panel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/icon/favicon.ico') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/metisMenu.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/slicknav.min.css') }}">
        <!-- amchart css -->
        <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
        <!-- others css -->
        <link rel="stylesheet" href="{{ asset('assets/css/typography.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/default-css.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
        <!-- modernizr css -->
        <script src="{{ asset('assets/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    </head>

    <!-- Body -->
    <body>
        <!-- Preloader Area Start -->
        <div id="preloader">
            <div class="loader"></div>
        </div>
        <!-- Preloader Area End -->

        <!-- Login Area Start -->
        <div class="login-area">
            <div class="container">
                <div class="login-box ptb--100">
                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf
                        <div class="login-form-head">
                            <h4>ADMIN PANEL</h4>
                            <p>Employee Leave Management System</p>
                        </div>
                        
                        <!-- Display any error messages -->
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="login-form-body">
                            <div class="form-gp">
                                <label for="username">Username</label>
                                <input type="text" id="username" name="username" autocomplete="off" required>
                                <i class="ti-user"></i>
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-gp">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" autocomplete="off" required>
                                <i class="ti-lock"></i>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="submit-btn-area">
                                <button type="submit">Submit <i class="ti-arrow-right"></i></button>
                            </div>

                            <div class="form-footer text-center mt-5">
                                <p class="text-muted"><a href="{{ url('/') }}"><i class="ti-arrow-left"></i> Go Back</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Login Area End -->

        <!-- Scripts -->
        <script src="{{ asset('assets/js/vendor/jquery-2.2.4.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('assets/js/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slicknav.min.js') }}"></script>
        <!-- Others Plugins -->
        <script src="{{ asset('assets/js/plugins.js') }}"></script>
        <script src="{{ asset('assets/js/scripts.js') }}"></script>
    </body>
</x-guest-layout>
