<x-app-layout>
    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" method="POST" action="{{ route('admin.employees.update', $employee->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Specify the PUT method -->

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>Update</strong> Employee</h3>
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
                                    <!-- Name Input -->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Name</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="name" class="form-control" value="{{ old('name', $employee->name) }}" />
                                            </div>
                                            <span class="help-block">Name of employee</span>
                                        </div>
                                    </div>

                                    <!-- Designation Input -->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Designation</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="designation" class="form-control" value="{{ old('designation', $employee->designation) }}" />
                                            </div>
                                            <span class="help-block">Designation of employee</span>
                                        </div>
                                    </div>

                                    <!-- Duty Input -->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Duty</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="duty" class="form-control" value="{{ old('duty', $employee->duty) }}" />
                                            </div>
                                            <span class="help-block">Duty of employee</span>
                                        </div>
                                    </div>

                                    <!-- Note Input -->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Note</label>
                                        <div class="col-md-9 col-xs-12">
                                            <textarea class="form-control" name="note" rows="5">{{ old('note', $employee->note) }}</textarea>
                                            <span class="help-block">Note about employee</span>
                                        </div>
                                    </div>

                                    <!-- Image Upload -->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Image</label>
                                        <div class="col-md-9">
                                            <input type="file" class="fileinput btn-primary" name="profile_image" id="profile_image" title="Browse file" />
                                            <span class="help-block">Image of employee</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <!-- Email Input -->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Email</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-addon">@</span>
                                                <input type="email" class="form-control" name="email" value="{{ old('email', $employee->email) }}" />
                                            </div>
                                            <span class="help-block">Employee email</span>
                                        </div>
                                    </div>

                                    <!-- Username Input -->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Username</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" class="form-control" name="username" value="{{ old('username', $employee->username) }}" />
                                            </div>
                                            <span class="help-block">Username for employee login</span>
                                        </div>
                                    </div>

                                    <!-- Password Input -->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Password</label>
                                        <div class="col-md-9 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                                                <input type="password" class="form-control" name="password" />
                                            </div>
                                            <span class="help-block">Password for employee login (leave blank if not changing)</span>
                                        </div>
                                    </div>

                                    <!-- Hidden Inputs -->
                                    <input type="hidden" name="id" value="{{ $employee->id }}">
                                </div>
                            </div>
                        </div>

                        <div class="panel-footer">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-primary pull-right">Update Employee</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT WRAPPER -->
</x-app-layout>
