<x-app-layout>
    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">
        <div class="row">
            <div class="col-md-12">

                <!-- Form start -->
                <form action="{{ route('admin.employees.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf <!-- CSRF protection -->

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>Add Employees</strong></h3>
                            <ul class="panel-controls">
                                <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                            </ul>
                        </div>

                        <div class="panel-body">
                            <!-- Success Message -->
                            @if (session('success'))
                                <div style="margin-bottom: 40px" class="alert alert-success" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">
                                        <span aria-hidden="true">&times;</span>
                                        <span class="sr-only">Close</span>
                                    </button>
                                    <strong>Success!</strong>
                                    <p class="alert-material-red">{{ session('success') }}</p>
                                </div>
                            @endif

                            <!-- Validation Errors -->
                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">
                                        <span aria-hidden="true">&times;</span>
                                        <span class="sr-only">Close</span>
                                    </button>
                                    <strong>Oh snap!</strong>
                                    @foreach ($errors->all() as $error)
                                        <p class="alert-material-red">{{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Form Fields -->
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Name Field -->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Name</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="name" class="form-control" required/>
                                            </div>
                                            <span class="help-block">Name of employee</span>
                                        </div>
                                    </div>

                                    <!-- Designation Field -->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Designation</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="designation" class="form-control" required/>
                                            </div>
                                            <span class="help-block">Designation of employee</span>
                                        </div>
                                    </div>

                                    <!-- Duty Field -->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Duty</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="duty" class="form-control" required/>
                                            </div>
                                            <span class="help-block">Duty of employee</span>
                                        </div>
                                    </div>

                                    <!-- Note Field -->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Note</label>
                                        <div class="col-md-9 col-xs-12">
                                            <textarea class="form-control" name="note" rows="5"></textarea>
                                            <span class="help-block">Note about employee</span>
                                        </div>
                                    </div>

                                    <!-- Image Field -->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Image</label>
                                        <div class="col-md-9">
                                            <input type="file" class="fileinput btn-primary" name="proimg" id="proimg" title="Browse file"/>
                                            <span class="help-block">Image of employee</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <!-- Email Field -->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Email</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-addon">@</span>
                                                <input type="email" class="form-control" name="email" placeholder="E-mail" required/>
                                            </div>
                                            <span class="help-block">Employee email</span>
                                        </div>
                                    </div>

                                    <!-- Username Field -->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Username</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" class="form-control" name="username" required/>
                                            </div>
                                            <span class="help-block">Username for employee login</span>
                                        </div>
                                    </div>

                                    <!-- Password Field -->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Password</label>
                                        <div class="col-md-9 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                                                <input type="password" class="form-control" name="password" required/>
                                            </div>
                                            <span class="help-block">Password for employee login</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-footer">
                            <button type="reset" class="btn btn-default">Clear Form</button>
                            <button type="submit" class="btn btn-primary pull-right">Add Employee</button>
                        </div>
                    </div>
                </form>
                <!-- Form end -->

            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT WRAPPER -->
</x-app-layout>
