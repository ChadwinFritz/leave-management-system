<x-app-layout>
    @php
        if (isset($userId)) {
            $user = \App\Models\User::find($userId);
            $leaveInfo = \App\Models\Leave::where('empid', $user->id)->first();
            $totalLeave = $leaveInfo ? $leaveInfo->totalleave : 0;
        }
    @endphp

    <div class="page-content-wrap">
        <div class="row">
            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-body profile" style="padding-top: 100px; background: #ffffff">
                        <div class="profile-image">
                            <img style="width: 180px; height: 180px" src="{{ asset('profileimg/' . $user->image) }}" alt="{{ $user->username }}" />
                        </div>
                        <div class="profile-data">
                            <div class="profile-data-name" style="color: #002240;">{{ $user->name }}</div>
                            <div class="profile-data-title" style="color: #002240;">{{ $user->designation }}</div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('employee.edit', ['id' => $userId]) }}">
                                    <button class="btn btn-info btn-rounded btn-block"><span class="fa fa-edit"></span> Edit</button>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-primary btn-rounded btn-block"><span class="fa fa-window-close"></span> Delete</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body list-group border-bottom">
                        <a href="#" class="list-group-item active"><span class="fa fa-bar-chart-o"></span> General Info</a>
                        <a href="#" class="list-group-item"><span class="fa fa-users"></span> Username <span class="badge badge-danger">{{ $user->username }}</span></a>
                        <a href="#" class="list-group-item"><span class="fa fa-users"></span> Email <span class="badge badge-danger">{{ $user->email }}</span></a>
                        <a href="#" class="list-group-item"><span class="fa fa-users"></span> Total Leave in this Year <span class="badge badge-danger">{{ \App\Http\Controllers\AdminController::calculateTotalLeave($userId) }}</span></a>
                        <a href="#" class="list-group-item"><span class="fa fa-folder"></span> Duty <span class="badge badge-danger">{{ $user->duty }}</span></a>
                    </div>
                    <div class="panel-body list-group border-bottom">
                        <a href="#" class="list-group-item active"><span class="fa fa-bar-chart-o"></span> Leave Details</a>
                        @php
                            $leaveTypes = \App\Models\LeaveType::all();
                        @endphp
                        @foreach ($leaveTypes as $leaveType)
                            <a href="#" class="list-group-item"><span class="fa fa-users"></span> {{ $leaveType->name }} <span class="badge badge-danger">{{ \App\Http\Controllers\UserController::getEachLeaveCount($userId, $leaveType->id) }}</span></a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div style="margin-top: 20px" class="col-md-5">
                <div style="margin-bottom: 30px" class="panel-heading">
                    <h3 class="panel-title">Employee Leave Dates</h3>
                </div>
                <!-- START TIMELINE -->
                <form class="form-horizontal" method="POST" action="{{ route('employee.leaveDates', ['id' => $userId]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-5 control-label">Start Date</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                        <input name="start_date" type="text" class="form-control datepicker" data-date-format="dd-mm-yyyy" value="" data-date-viewmode="years">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-5 control-label">End Date</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                        <input name="end_date" type="text" class="form-control datepicker" data-date-format="dd-mm-yyyy" value="" data-date-viewmode="years">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button style="margin-top: 20px" class="btn btn-primary">Apply</button>
                </form>

                <!-- START CONTENT FRAME BODY -->
                @if (isset($userId) && isset($totalDays) && isset($leaveDates))
                    <div style="margin-top: 50px" class="content-frame-body padding-bottom-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div style="margin-bottom: 15px" class="calendar">
                                    <div id="calendar"></div>
                                </div>
                                <h1 class="panel-title">Total Days: {{ $totalDays }}</h1>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- END CONTENT FRAME BODY -->
                <!-- END TIMELINE -->
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT WRAPPER -->

    <!-- START PLUGINS -->
    <script type="text/javascript" src="{{ asset('js/plugins/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/jquery/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/bootstrap/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
    <!-- END THIS PAGE PLUGINS -->
    <!-- END PLUGINS -->

    @if (isset($userId) && isset($totalDays) && isset($leaveDates))
        <script>
            var dates = @json($leaveDates);

            var events = dates.map(date => ({
                title: 'Leave',
                start: date
            }));

            $(document).ready(function() {
                $('#calendar').fullCalendar({
                    defaultDate: events.length ? events[0].start : new Date(),
                    events: events
                });
            });
        </script>
    @endif
</x-app-layout>
