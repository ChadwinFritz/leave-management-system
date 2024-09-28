<x-app-layout>
    @section('title', 'Apply for Leave')

    @section('styles')
        <link rel="shortcut icon" type="image/png" href="../assets/images/icon/favicon.ico">
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="../assets/css/themify-icons.css">
        <link rel="stylesheet" href="../assets/css/metisMenu.css">
        <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="../assets/css/slicknav.min.css">
        <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
        <link rel="stylesheet" href="../assets/css/typography.css">
        <link rel="stylesheet" href="../assets/css/default-css.css">
        <link rel="stylesheet" href="../assets/css/styles.css">
        <link rel="stylesheet" href="../assets/css/responsive.css">
    @endsection

    @php
        session_start();
        error_reporting(0);
        include('../includes/dbconn.php');

        if (strlen($_SESSION['emplogin']) == 0) {
            return redirect('../index.php');
        }

        $msg = '';
        $error = '';

        if (request()->isMethod('post') && request()->has('apply')) {
            $empid = $_SESSION['eid'];
            $leavetype = request('leavetype');
            $fromdate = request('fromdate');
            $todate = request('todate');
            $description = request('description');
            $status = 0;
            $isread = 0;

            if ($fromdate > $todate) {
                $error = "Please enter correct details: End Date should be ahead of Starting Date in order to be valid!";
            } else {
                $sql = "INSERT INTO tblleaves(LeaveType, ToDate, FromDate, Description, Status, IsRead, empid) VALUES(:leavetype, :fromdate, :todate, :description, :status, :isread, :empid)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':leavetype', $leavetype, PDO::PARAM_STR);
                $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
                $query->bindParam(':todate', $todate, PDO::PARAM_STR);
                $query->bindParam(':description', $description, PDO::PARAM_STR);
                $query->bindParam(':status', $status, PDO::PARAM_STR);
                $query->bindParam(':isread', $isread, PDO::PARAM_STR);
                $query->bindParam(':empid', $empid, PDO::PARAM_STR);
                $query->execute();
                $lastInsertId = $dbh->lastInsertId();

                if ($lastInsertId) {
                    $msg = "Your leave application has been applied, Thank You.";
                } else {
                    $error = "Sorry, could not process this time. Please try again later.";
                }
            }
        }
    @endphp

    <div class="page-container">
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="leave.php"><img src="../assets/images/icon/logo.png" alt="logo"></a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            <li class="active">
                                <a href="leave.php" aria-expanded="true"><i class="ti-user"></i><span>Apply Leave</span></a>
                            </li>
                            <li>
                                <a href="leave-history.php" aria-expanded="true"><i class="ti-agenda"></i><span>View My Leave History</span></a>
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
                            <h4 class="page-title pull-left">Apply For Leave Days</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><span>Leave Form</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        @include('../includes/employee-profile-section')
                    </div>
                </div>
            </div>

            <div class="main-content-inner">
                <div class="row">
                    <div class="col-lg-6 col-ml-12">
                        <div class="row">
                            <div class="col-12 mt-5">
                                @if ($error)
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <strong>Info: </strong>{{ htmlentities($error) }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @elseif ($msg)
                                    <div class="alert alert-success alert-dismissible fade show">
                                        <strong>Info: </strong>{{ htmlentities($msg) }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <div class="card">
                                    <form method="POST">
                                        @csrf
                                        <div class="card-body">
                                            <h4 class="header-title">Employee Leave Form</h4>
                                            <p class="text-muted font-14 mb-4">Please fill up the form below.</p>

                                            <div class="form-group">
                                                <label for="fromdate" class="col-form-label">Starting Date</label>
                                                <input class="form-control" type="date" required id="fromdate" name="fromdate" value="{{ old('fromdate') }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="todate" class="col-form-label">End Date</label>
                                                <input class="form-control" type="date" required id="todate" name="todate" value="{{ old('todate') }}">
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label">Your Leave Type</label>
                                                <select class="custom-select" name="leavetype" required>
                                                    <option value="">Click here to select any ...</option>
                                                    @php
                                                        $sql = "SELECT LeaveType from tblleavetype";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                    @endphp
                                                    @foreach($results as $result)
                                                        <option value="{{ htmlentities($result->LeaveType) }}">{{ htmlentities($result->LeaveType) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="description" class="col-form-label">Describe Your Conditions</label>
                                                <textarea class="form-control" name="description" id="description" rows="5" required>{{ old('description') }}</textarea>
                                            </div>

                                            <button class="btn btn-primary" name="apply" type="submit">SUBMIT</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('../includes/footer')
    </div>

    <script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/owl.carousel.min.js"></script>
    <script src="../assets/js/metisMenu.min.js"></script>
    <script src="../assets/js/jquery.slimscroll.min.js"></script>
    <script src="../assets/js/jquery.slicknav.min.js"></script>
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/scripts.js"></script>
</x-app-layout>
