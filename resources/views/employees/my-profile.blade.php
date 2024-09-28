<x-app-layout>
    @section('title', 'My Profile')
    
    @section('styles')
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/icon/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/metisMenu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slicknav.min.css') }}">
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/typography.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/default-css.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    @endsection

    <div class="page-container">
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="{{ route('leave.index') }}"><img src="{{ asset('assets/images/icon/logo.png') }}" alt="logo"></a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            <li>
                                <a href="{{ route('leave.create') }}" aria-expanded="true"><i class="ti-user"></i><span>Apply Leave</span></a>
                            </li>
                            <li>
                                <a href="{{ route('leave.history') }}" aria-expanded="true"><i class="ti-agenda"></i><span>View My Leave History</span></a>
                            </li>
                        </ul>
                    </nav>
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
                        </ul>
                    </div>
                </div>
            </div>

            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">My Profile</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        @include('includes.employee-profile-section')
                    </div>
                </div>
            </div>

            <div class="main-content-inner">
                <div class="row">
                    <div class="col-lg-6 col-ml-12">
                        <div class="row">
                            <div class="col-12 mt-5">
                                @if($error)
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <strong>Info: </strong>{{ htmlentities($error) }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @elseif($msg)
                                    <div class="alert alert-success alert-dismissible fade show">
                                        <strong>Info: </strong>{{ htmlentities($msg) }} 
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                <div class="card">
                                    <form name="addemp" method="POST">
                                        @csrf
                                        <div class="card-body">
                                            <h4 class="header-title">Update My Profile</h4>
                                            <p class="text-muted font-14 mb-4">Please make changes on the form below in order to update your profile</p>

                                            @php
                                                $eid = session('emplogin');
                                                $sql = "SELECT * from tblemployees where EmailId=:eid";
                                                $query = DB::select($sql, ['eid' => $eid]);
                                            @endphp

                                            @if(count($query) > 0)
                                                @foreach($query as $result)
                                                    <div class="form-group">
                                                        <label for="example-text-input" class="col-form-label">First Name</label>
                                                        <input class="form-control" name="firstName" value="{{ htmlentities($result->FirstName) }}" type="text" required id="example-text-input">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="example-text-input" class="col-form-label">Last Name</label>
                                                        <input class="form-control" name="lastName" value="{{ htmlentities($result->LastName) }}" type="text" autocomplete="off" required id="example-text-input">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="example-email-input" class="col-form-label">Email</label>
                                                        <input class="form-control" name="email" type="email" value="{{ htmlentities($result->EmailId) }}" readonly autocomplete="off" required id="example-email-input">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-form-label">Gender</label>
                                                        <select class="custom-select" name="gender" autocomplete="off">
                                                            <option value="{{ htmlentities($result->Gender) }}">{{ htmlentities($result->Gender) }}</option>
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                            <option value="Other">Other</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="example-date-input" class="col-form-label">D.O.B</label>
                                                        <input class="form-control" type="date" name="dob" id="birthdate" value="{{ htmlentities($result->Dob) }}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="example-text-input" class="col-form-label">Contact Number</label>
                                                        <input class="form-control" name="mobileno" type="tel" value="{{ htmlentities($result->Phonenumber) }}" maxlength="10" autocomplete="off" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="example-text-input" class="col-form-label">Employee ID</label>
                                                        <input class="form-control" name="empcode" type="text" autocomplete="off" readonly required value="{{ htmlentities($result->EmpId) }}" id="example-text-input">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="example-text-input" class="col-form-label">Country</label>
                                                        <input class="form-control" name="country" type="text" value="{{ htmlentities($result->Country) }}" autocomplete="off" required id="example-text-input">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="example-text-input" class="col-form-label">Address</label>
                                                        <input class="form-control" name="address" type="text" value="{{ htmlentities($result->Address) }}" autocomplete="off" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="example-text-input" class="col-form-label">City</label>
                                                        <input class="form-control" name="city" type="text" value="{{ htmlentities($result->City) }}" autocomplete="off" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-form-label">Selected Department</label>
                                                        <select class="custom-select" name="department" autocomplete="off">
                                                            <option value="{{ htmlentities($result->Department) }}">{{ htmlentities($result->Department) }}</option>
                                                            @foreach(DB::table('tbldepartments')->select('DepartmentName')->get() as $resultt)
                                                                <option value="{{ htmlentities($resultt->DepartmentName) }}">{{ htmlentities($resultt->DepartmentName) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-ml-12">
                        <div class="row">
                            <div class="col-12 mt-5">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Change Password</h4>
                                        <form method="POST" action="{{ route('password.update') }}">
                                            @csrf
                                            <div class="form-group">
                                                <label for="old_password">Old Password</label>
                                                <input type="password" class="form-control" id="old_password" name="old_password" required autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <label for="new_password">New Password</label>
                                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="confirm_password">Confirm Password</label>
                                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Change Password</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer>
                <div class="footer-area">
                    <p>© {{ date('Y') }} Leave Management System. All Rights Reserved.</p>
                </div>
            </footer>
        </div>
    </div>

    @section('scripts')
    <script src="{{ asset('assets/js/vendor/jquery-2.2.4.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.cookie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/slicknav.min.js') }}"></script>
    <script src="{{ asset('assets/js/metisMenu.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/chart.amcharts.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/responsive.bootstrap.min.js') }}"></script>
    @endsection
</x-app-layout>
