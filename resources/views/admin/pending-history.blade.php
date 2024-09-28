<x-app-layout>
    @section('title', 'Admin Panel - Pending Leaves')

    @section('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/metisMenu.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/slicknav.min.css') }}">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    @endsection

    @section('content')
        <div class="page-container">
            <div class="sidebar-menu">
                <div class="sidebar-header">
                    <div class="logo">
                        <a href="{{ url('dashboard') }}"><img src="{{ asset('assets/images/icon/logo.png') }}" alt="logo"></a>
                    </div>
                </div>
                <div class="main-menu">
                    <div class="menu-inner">
                        @php
                            $page = 'manage-leave';
                            include resource_path('views/includes/admin-sidebar.blade.php');
                        @endphp
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
                                @include resource_path('views/includes/admin-notification.blade.php')
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="page-title-area">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <div class="breadcrumbs-area clearfix">
                                <h4 class="page-title pull-left">Pending Leaves</h4>
                                <ul class="breadcrumbs pull-left">
                                    <li><a href="{{ url('dashboard') }}">Home</a></li>
                                    <li><span>Pending List</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6 clearfix">
                            <div class="user-profile pull-right">
                                <img class="avatar user-thumb" src="{{ asset('assets/images/admin.png') }}" alt="avatar">
                                <h4 class="user-name dropdown-toggle" data-toggle="dropdown">ADMIN <i class="fa fa-angle-down"></i></h4>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ url('logout') }}">Log Out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="main-content-inner">
                    <div class="row">
                        <div class="col-12 mt-5">
                            <div class="card">
                                <div class="card-body">
                                    <div class="single-table">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped table-bordered progress-table text-center">
                                                <thead class="text-uppercase">
                                                    <tr>
                                                        <td>S.N</td>
                                                        <td>Employee ID</td>
                                                        <td width="120">Full Name</td>
                                                        <td>Leave Type</td>
                                                        <td>Applied On</td>
                                                        <td>Current Status</td>
                                                        <td></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $status = 0;
                                                        $leaves = DB::table('tblleaves')
                                                                    ->join('tblemployees', 'tblleaves.empid', '=', 'tblemployees.id')
                                                                    ->select('tblleaves.id as lid', 'tblemployees.FirstName', 'tblemployees.LastName', 'tblemployees.EmpId', 'tblemployees.id', 'tblleaves.LeaveType', 'tblleaves.PostingDate', 'tblleaves.Status')
                                                                    ->where('tblleaves.Status', $status)
                                                                    ->orderBy('lid', 'desc')
                                                                    ->get();
                                                        $cnt = 1;
                                                    @endphp

                                                    @if ($leaves->count() > 0)
                                                        @foreach ($leaves as $leave)
                                                            <tr>
                                                                <td><b>{{ $cnt }}</b></td>
                                                                <td>{{ htmlentities($leave->EmpId) }}</td>
                                                                <td><a href="{{ url('update-employee', ['empid' => $leave->id]) }}" target="_blank">{{ htmlentities($leave->FirstName . " " . $leave->LastName) }}</a></td>
                                                                <td>{{ htmlentities($leave->LeaveType) }}</td>
                                                                <td>{{ htmlentities($leave->PostingDate) }}</td>
                                                                <td>
                                                                    @if ($leave->Status == 1)
                                                                        <span style="color: green">Approved <i class="fa fa-thumbs-o-up"></i></span>
                                                                    @elseif ($leave->Status == 2)
                                                                        <span style="color: red">Declined <i class="fa fa-thumbs-o-down"></i></span>
                                                                    @else
                                                                        <span style="color: blue">Pending <i class="fa fa-spinner"></i></span>
                                                                    @endif
                                                                </td>
                                                                <td><a href="{{ url('employeeLeave-details', ['leaveid' => $leave->lid]) }}" class="btn btn-secondary btn-sm">View Details</a></td>
                                                            </tr>
                                                            @php $cnt++; @endphp
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="7">No pending leaves found.</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include resource_path('views/includes/footer.blade.php')
            </div>
        </div>
    @endsection

    @section('scripts')
        <script src="{{ asset('assets/js/vendor/jquery-2.2.4.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('assets/js/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slicknav.min.js') }}"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
        <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

        <script>
            $(document).ready(function () {
                $('.table').DataTable();
            });
        </script>
    @endsection
</x-app-layout>
