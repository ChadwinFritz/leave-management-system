<x-app-layout>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Admin Panel - Employee Leave</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/icon/favicon.ico') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/metisMenu.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/slicknav.min.css') }}">
        <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
        <link rel="stylesheet" href="{{ asset('assets/css/typography.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/default-css.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
        <script src="{{ asset('assets/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    </head>

    <div class="page-container">
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="{{ route('admin.dashboard') }}"><img src="{{ asset('assets/images/icon/logo.png') }}" alt="logo"></a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    @include('admin.admin-sidebar')
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="header-area">
                <div class="row align-items-center">
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area pull-right">
                            <li id="full-view"><i class="ti-fullscreen"></i></li>
                            <li id="full-view-exit"><i class="ti-zoom-out"></i></li>
                            @include('admin.admin-notification')
                        </ul>
                    </div>
                </div>
            </div>

            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Update Employee Section</h4>
                            <ul class="breadcrumbs pull-left"> 
                                <li><a href="{{ route('admin.employees') }}">Employee</a></li>
                                <li><span>Update</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <img class="avatar user-thumb" src="{{ asset('assets/images/admin.png') }}" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown">ADMIN <i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('logout') }}">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-content-inner">
                <div class="row">
                    <div class="col-lg-6 col-ml-12">
                        <div class="row">
                            <div class="col-12 mt-5">
                                @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <strong>Error:</strong> {{ implode('', $errors->all(':message')) }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                @if(session('msg'))
                                    <div class="alert alert-success alert-dismissible fade show">
                                        <strong>Info:</strong> {{ session('msg') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <div class="card">
                                    <form action="{{ route('admin.updateEmployee', $employee->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="card-body">
                                            <p class="text-muted font-14 mb-4">Please make changes on the form below in order to update your profile</p>

                                            <div class="form-group">
                                                <label for="firstName" class="col-form-label">First Name</label>
                                                <input class="form-control" name="firstName" value="{{ old('firstName', $employee->FirstName) }}" type="text" required id="firstName">
                                            </div>

                                            <div class="form-group">
                                                <label for="lastName" class="col-form-label">Last Name</label>
                                                <input class="form-control" name="lastName" value="{{ old('lastName', $employee->LastName) }}" type="text" required id="lastName">
                                            </div>

                                            <div class="form-group">
                                                <label for="email" class="col-form-label">Email</label>
                                                <input class="form-control" name="email" type="email" value="{{ $employee->EmailId }}" readonly required id="email">
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label">Gender</label>
                                                <select class="custom-select" name="gender" required>
                                                    <option value="{{ $employee->Gender }}">{{ $employee->Gender }}</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="dob" class="col-form-label">D.O.B</label>
                                                <input class="form-control" type="date" name="dob" id="dob" value="{{ old('dob', $employee->Dob) }}" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="mobileno" class="col-form-label">Contact Number</label>
                                                <input class="form-control" name="mobileno" type="tel" value="{{ old('mobileno', $employee->Phonenumber) }}" maxlength="10" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="empcode" class="col-form-label">Employee ID</label>
                                                <input class="form-control" name="empcode" type="text" readonly value="{{ $employee->EmpId }}" id="empcode">
                                            </div>

                                            <div class="form-group">
                                                <label for="country" class="col-form-label">Country</label>
                                                <input class="form-control" name="country" type="text" value="{{ old('country', $employee->Country) }}" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="address" class="col-form-label">Address</label>
                                                <input class="form-control" name="address" type="text" value="{{ old('address', $employee->Address) }}" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="city" class="col-form-label">City</label>
                                                <input class="form-control" name="city" type="text" value="{{ old('city', $employee->City) }}" required>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label">Your Department</label>
                                                <select class="custom-select" name="department" required>
                                                    <option value="{{ $employee->Department }}">{{ $employee->Department }}</option>
                                                    @foreach($departments as $department)
                                                        <option value="{{ $department->DepartmentName }}">{{ $department->DepartmentName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <button class="btn btn-primary" name="update" type="submit">MAKE CHANGES</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('admin.footer')
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/vendor/jquery-2.2.4.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/slicknav.min.js') }}"></script>
    <script src="{{ asset('assets/js/Chart.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</x-app-layout>
