<x-app-layout>
    @php  
        $userId = \Illuminate\Support\Facades\Auth::user()->id;
        $user = DB::table('users')->where('id', $userId)->first();
    @endphp

    <div class="page-content-wrap">
        <div class="row">
            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-body profile" style="padding-top: 100px; background: #ffffff;">
                        <div class="profile-image">
                            <img style="width: 180px; height: 180px;" src="{{ asset('profileimg/' . $user->image) }}" alt="{{ $user->username }}"/>
                        </div>
                        <div class="profile-data">
                            <div class="profile-data-name" style="color: #002240;">{{ $user->name }}</div>
                            <div class="profile-data-title" style="color: #002240;">{{ $user->designation }}</div>
                        </div>
                    </div>

                    <div class="panel-body list-group border-bottom">
                        <a href="#" class="list-group-item active"><span class="fa fa-bar-chart-o"></span> Activity</a>
                        <a href="#" class="list-group-item"><span class="fa fa-users"></span> Username <span class="badge badge-danger">{{ $user->username }}</span></a>
                        <a href="#" class="list-group-item"><span class="fa fa-users"></span> Email <span class="badge badge-danger">{{ $user->email }}</span></a>
                        <a href="#" class="list-group-item"><span class="fa fa-users"></span> Total Leave in this Year <span class="badge badge-danger">{{ \App\Http\Controllers\AdminController::calculateTotalLeave($userId) }}</span></a>
                        <a href="#" class="list-group-item"><span class="fa fa-folder"></span> Duty <span class="badge badge-danger">{{ $user->duty }}</span></a>
                    </div>

                    <div class="panel-body list-group border-bottom">
                        <a href="#" class="list-group-item active"><span class="fa fa-bar-chart-o"></span> Leave Details</a>
                        @php $leaveTypes = DB::table('leave_types')->get(); @endphp
                        @foreach($leaveTypes as $leaveType)
                            <a href="#" class="list-group-item"><span class="fa fa-users"></span> {{ $leaveType->name }} <span class="badge badge-danger">{{ \App\Http\Controllers\UserController::getEachLeaveCount($userId, $leaveType->lid) }}</span></a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div style="margin-top: 20px;" class="col-md-5">
                <div style="margin-bottom: 30px;" class="panel-heading">
                    <h3 class="panel-title">Employee Leave Dates</h3>
                </div>

                <!-- START TIMELINE -->
                <form class="form-horizontal" method="post" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
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
                    <button style="margin-top: 20px;" class="btn btn-primary">Apply</button>
                </form>

                <!-- START CONTENT FRAME BODY -->
                @if(isset($totalDays) && isset($leaveDates))
                    <div style="margin-top: 50px;" class="content-frame-body padding-bottom-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="calendar">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- END TIMELINE -->
            </div>
        </div>
    </div>
</x-app-layout>
