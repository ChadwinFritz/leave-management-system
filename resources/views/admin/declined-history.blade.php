<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Declined Leaves') }}
        </h2>
    </x-slot>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/metisMenu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slicknav.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <!-- Main Content -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <strong>Info:</strong> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @elseif (session('msg'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <strong>Info:</strong> {{ session('msg') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <table class="table table-hover table-striped table-bordered text-center">
                        <thead class="text-uppercase">
                            <tr>
                                <th>S.N</th>
                                <th>Employee ID</th>
                                <th>Full Name</th>
                                <th>Leave Type</th>
                                <th>Applied On</th>
                                <th>Current Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($declinedLeaves as $key => $leave)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $leave->employee->EmpId }}</td>
                                    <td>
                                        <a href="{{ route('admin.update-employee', ['empid' => $leave->employee->id]) }}" target="_blank">
                                            {{ $leave->employee->FirstName }} {{ $leave->employee->LastName }}
                                        </a>
                                    </td>
                                    <td>{{ $leave->LeaveType }}</td>
                                    <td>{{ $leave->PostingDate }}</td>
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
                                        <a href="{{ route('admin.leave-details', ['leaveid' => $leave->id]) }}" class="btn btn-secondary btn-sm">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/vendor/jquery-2.2.4.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/js/slicknav.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

</x-app-layout>
