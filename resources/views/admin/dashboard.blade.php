<x-app-layout>
    @section('title', 'Admin Dashboard')

    <!-- Styles -->
    @push('styles')
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
    @endpush

    <!-- Content -->
    <div class="page-container">
        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            @include('admin.partials.header')

            <!-- Page Title Area -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Dashboard</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li><span>Admin's Dashboard</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <img class="avatar user-thumb" src="{{ asset('assets/images/admin.png') }}" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown">ADMIN <i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('admin.logout') }}">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Widgets -->
            <div class="main-content-inner">
                <div class="sales-report-area mt-5 mb-5">
                    <div class="row">
                        <x-admin.dashboard-widget
                            title="Available Leave Types"
                            count="{{ $leaveTypesCount }}"
                            icon="fa-briefcase"
                        />
                        <x-admin.dashboard-widget
                            title="Registered Employees"
                            count="{{ $employeesCount }}"
                            icon="fa-users"
                        />
                        <x-admin.dashboard-widget
                            title="Available Departments"
                            count="{{ $departmentsCount }}"
                            icon="fa-th-large"
                        />
                    </div>
                    
                    <div class="row mt-4">
                        <x-admin.dashboard-widget
                            title="Pending Applications"
                            count="{{ $pendingApplicationsCount }}"
                            icon="fa-spinner"
                        />
                        <x-admin.dashboard-widget
                            title="Declined Applications"
                            count="{{ $declinedApplicationsCount }}"
                            icon="fa-times"
                        />
                        <x-admin.dashboard-widget
                            title="Approved Applications"
                            count="{{ $approvedApplicationsCount }}"
                            icon="fa-check-square-o"
                        />
                    </div>
                </div>

                <!-- Recent Leave Applications Table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Recent Leave Applications</h4>
                                <div class="single-table">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered table-striped text-center">
                                            <thead class="text-uppercase">
                                                <tr>
                                                    <th>S.N</th>
                                                    <th>Employee ID</th>
                                                    <th>Full Name</th>
                                                    <th>Leave Type</th>
                                                    <th>Applied On</th>
                                                    <th>Current Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($recentLeaves as $key => $leave)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $leave->employee->EmpId }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.employee.edit', $leave->employee->id) }}" target="_blank">
                                                            {{ $leave->employee->fullName() }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $leave->LeaveType }}</td>
                                                    <td>{{ $leave->PostingDate->format('Y-m-d') }}</td>
                                                    <td>
                                                        @if($leave->Status == 1)
                                                            <span style="color: green">Approved <i class="fa fa-check-square-o"></i></span>
                                                        @elseif($leave->Status == 2)
                                                            <span style="color: red">Declined <i class="fa fa-times"></i></span>
                                                        @else
                                                            <span style="color: blue">Pending <i class="fa fa-spinner"></i></span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.leave.show', $leave->id) }}" class="btn btn-secondary btn-sm">View Details</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            @include('admin.partials.footer')
        </div>
    </div>

    <!-- Scripts -->
    @push('scripts')
        <script src="{{ asset('assets/js/vendor/jquery-2.2.4.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('assets/js/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slicknav.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
        <script> ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"]; </script>
        <script src="{{ asset('assets/js/line-chart.js') }}"></script>
        <script src="{{ asset('assets/js/pie-chart.js') }}"></script>
        <script src="{{ asset('assets/js/plugins.js') }}"></script>
        <script src="{{ asset('assets/js/scripts.js') }}"></script>
    @endpush
</x-app-layout>
