<x-app-layout>
    @section('title', 'Admin Panel - Employee Leave')
    
    @section('styles')
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
    @endsection

    <div class="page-container">
        <!-- Sidebar menu area start -->
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
        <!-- Sidebar menu area end -->
        
        <!-- Main content area start -->
        <div class="main-content">
            <!-- Header area start -->
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
            <!-- Header area end -->

            <!-- Page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Leave Details</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li><span>Leave Details</span></li>
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
            <!-- Page title area end -->

            <div class="main-content-inner">
                <!-- Row area start -->
                <div class="row">
                    <div class="col-lg-12 mt-5">
                        @if ($error)
                            <div class="alert alert-danger alert-dismissible fade show">
                                <strong>Info: </strong>{{ $error }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @elseif ($msg)
                            <div class="alert alert-success alert-dismissible fade show">
                                <strong>Info: </strong>{{ $msg }} 
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="card">
                            <div class="card-body">
                                <div class="single-table">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover text-center">
                                            <tbody>
                                                @php
                                                    $lid = request()->get('leaveid');
                                                @endphp
                                                @php
                                                    $leaveDetails = \DB::table('tblleaves')
                                                        ->join('tblemployees', 'tblleaves.empid', '=', 'tblemployees.id')
                                                        ->select('tblleaves.*', 'tblemployees.FirstName', 'tblemployees.LastName', 'tblemployees.EmpId', 'tblemployees.Gender', 'tblemployees.Phonenumber', 'tblemployees.EmailId')
                                                        ->where('tblleaves.id', $lid)
                                                        ->first();
                                                @endphp

                                                @if($leaveDetails)
                                                    <tr>
                                                        <td><b>Employee ID:</b></td>
                                                        <td colspan="1">{{ $leaveDetails->EmpId }}</td>
                                                        <td><b>Employee Name:</b></td>
                                                        <td colspan="1">
                                                            <a href="{{ route('admin.update-employee', ['empid' => $leaveDetails->id]) }}" target="_blank">
                                                                {{ $leaveDetails->FirstName . ' ' . $leaveDetails->LastName }}
                                                            </a>
                                                        </td>
                                                        <td><b>Gender:</b></td>
                                                        <td colspan="1">{{ $leaveDetails->Gender }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Employee Email:</b></td>
                                                        <td colspan="1">{{ $leaveDetails->EmailId }}</td>
                                                        <td><b>Employee Contact:</b></td>
                                                        <td colspan="1">{{ $leaveDetails->Phonenumber }}</td>
                                                        <td><b>Leave Type:</b></td>
                                                        <td colspan="1">{{ $leaveDetails->LeaveType }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Leave From:</b></td>
                                                        <td colspan="1">{{ $leaveDetails->FromDate }}</td>
                                                        <td><b>Leave Upto:</b></td>
                                                        <td colspan="1">{{ $leaveDetails->ToDate }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Leave Applied:</b></td>
                                                        <td>{{ $leaveDetails->PostingDate }}</td>
                                                        <td><b>Status:</b></td>
                                                        <td>
                                                            @if ($leaveDetails->Status == 1)
                                                                <span style="color: green">Approved</span>
                                                            @elseif ($leaveDetails->Status == 2)
                                                                <span style="color: red">Declined</span>
                                                            @else
                                                                <span style="color: blue">Pending</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Leave Conditions:</b></td>
                                                        <td colspan="5">{{ $leaveDetails->Description }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Admin Remark:</b></td>
                                                        <td colspan="12">
                                                            {{ $leaveDetails->AdminRemark ?: 'Waiting for Action' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Admin Action On:</b></td>
                                                        <td>
                                                            {{ $leaveDetails->AdminRemarkDate ?: 'NA' }}
                                                        </td>
                                                    </tr>

                                                    @if ($leaveDetails->Status == 0)
                                                        <tr>
                                                            <td colspan="12">
                                                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#actionModal">SET ACTION</button>

                                                                <!-- Modal -->
                                                                <div class="modal fade" id="actionModal" tabindex="-1" role="dialog" aria-labelledby="actionModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="actionModalLabel">SET ACTION</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>

                                                                            <form method="POST" action="{{ route('admin.leave.action', ['leaveid' => $leaveDetails->id]) }}">
                                                                                @csrf
                                                                                <div class="modal-body">
                                                                                    <select class="custom-select" name="status" required>
                                                                                        <option value="">Choose...</option>
                                                                                        <option value="1">Approve</option>
                                                                                        <option value="2">Decline</option>
                                                                                    </select>
                                                                                    <textarea class="form-control mt-2" name="remark" placeholder="Admin Remark" required></textarea>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @else
                                                    <tr>
                                                        <td colspan="12">No leave details found for this employee.</td>
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
                <!-- Row area end -->
            </div>
        </div>
        <!-- Main content area end -->
    </div>

    @section('scripts')
        <script src="{{ asset('assets/js/vendor/jquery-2.2.4.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins.js') }}"></script>
        <script src="{{ asset('assets/js/scripts.js') }}"></script>
    @endsection
</x-app-layout>
