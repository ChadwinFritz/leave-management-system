<x-app-layout>
    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" method="post" action="{{ route('user.leave.request') }}" enctype="multipart/form-data">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>Apply </strong> for Leave</h3>
                            <ul class="panel-controls">
                                <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                            </ul>
                        </div>

                        <div class="panel-body">
                            @if(session('success'))
                                <div style="margin-bottom: 40px" class="alert alert-success" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">
                                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                    </button>
                                    <strong>Success!</strong>
                                    <p class="alert-material-red">{{ session('success') }}</p>
                                </div>
                            @endif
                            @if($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">
                                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                    </button>
                                    <strong>Oh snap!</strong>
                                    @foreach($errors->all() as $error)
                                        <p class="alert-material-red">{{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    @php $leaveTypes = \App\Models\LeaveType::all(); @endphp

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Leave Type</label>
                                        <div class="col-md-9">
                                            <select name="leave_type" class="form-control" required>
                                                @foreach($leaveTypes as $leaveType)
                                                    <option value="{{ $leaveType->id }}">{{ $leaveType->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block">Select Leave Type</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Start Date</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                <input name="start_date" type="date" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Name</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required/>
                                            </div>
                                            <span class="help-block">Name of employee</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Username</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                                <input type="text" name="username" class="form-control" value="{{ Auth::user()->username }}" required/>
                                            </div>
                                            <span class="help-block">Username of employee</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Leave Reason</label>
                                        <div class="col-md-9 col-xs-12">
                                            <textarea class="form-control" name="reason" rows="5" required></textarea>
                                            <span class="help-block">Reason and additional notes on Leave</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Contact Number</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-mobile-phone"></span></span>
                                                <input type="text" class="form-control" name="contact_number" placeholder="Mobile number" required/>
                                            </div>
                                            <span class="help-block">Employee contact number</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">End Date</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                <input name="end_date" type="date" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    @csrf
                                </div>
                            </div>
                        </div>
                        <!-- panel body end -->
                        <div class="panel-footer">
                            <button class="btn btn-default">Clear Form</button>
                            <button class="btn btn-primary pull-right">Apply Leave</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
