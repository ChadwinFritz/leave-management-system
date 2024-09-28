<x-app-layout>
    <!-- Meta and Styles -->
    <x-slot name="header">
        <title>Admin Panel - Approved Leave History</title>
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/metisMenu.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/slicknav.min.css') }}">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
        <link rel="stylesheet" href="{{ asset('assets/css/typography.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/default-css.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
        <script src="{{ asset('assets/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    </x-slot>

    <!-- Page Container -->
    <div class="page-container">
        <!-- Sidebar -->
        <x-admin.sidebar active="manage-leave" />

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <x-admin.header />

            <!-- Breadcrumbs -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Approved Leaves</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li><span>Approved List</span></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-sm-6 clearfix">
                        <x-admin.profile-dropdown />
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="main-content-inner">
                <!-- Display any Success/Error messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <!-- Approved Leaves Table -->
                <div class="row">
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="single-table">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped table-bordered progress-table text-center" id="approvedLeavesTable">
                                            <thead class="text-uppercase">
                                                <tr>
                                                    <th>S.N</th>
                                                    <th>Employee ID</th>
                                                    <th>Full Name</th>
                                                    <th>Leave Type</th>
                                                    <th>Applied On</th>
                                                    <th>Current Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($approvedLeaves as $index => $leave)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $leave->employee->EmpId }}</td>
                                                        <td><a href="{{ route('admin.employee.details', $leave->employee->id) }}" target="_blank">{{ $leave->employee->full_name }}</a></td>
                                                        <td>{{ $leave->LeaveType }}</td>
                                                        <td>{{ $leave->PostingDate }}</td>
                                                        <td>
                                                            @if($leave->Status == 1)
                                                                <span class="text-success">Approved <i class="fa fa-check-square-o"></i></span>
                                                            @elseif($leave->Status == 2)
                                                                <span class="text-danger">Declined <i class="fa fa-times"></i></span>
                                                            @else
                                                                <span class="text-primary">Pending <i class="fa fa-spinner"></i></span>
                                                            @endif
                                                        </td>
                                                        <td><a href="{{ route('admin.leave.details', $leave->id) }}" class="btn btn-secondary btn-sm">View Details</a></td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7">No approved leaves found</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Row End -->
            </div>

            <!-- Footer -->
            <x-admin.footer />
        </div>
        <!-- Main Content End -->
    </div>
    <!-- Page Container End -->

    <!-- Scripts -->
    <x-slot name="scripts">
        <script src="{{ asset('assets/js/vendor/jquery-2.2.4.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slicknav.min.js') }}"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
        <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#approvedLeavesTable').DataTable();
            });
        </script>
    </x-slot>
</x-app-layout>
