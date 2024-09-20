<x-app-layout>
    <!-- PAGE TITLE -->
    <div class="page-title">
        <h2><span class="fa fa-arrow-circle-o-left"></span> Employees</h2>
    </div>
    <!-- END PAGE TITLE -->

    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">
        <div class="row">
            <div class="col-md-12">
                <!-- START DEFAULT DATATABLE -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Employee List</h3>
                        <ul class="panel-controls">
                            <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                            <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                            <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>

                    <div class="panel-body">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Duty</th>
                                    <th>Total Leave</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->designation }}</td>
                                        <td>{{ $user->duty }}</td>
                                        <td>{{ \App\Http\Controllers\AdminLeaveController::calculateTotalLeave($user->id) }}</td>
                                        <td>
                                            <a href="{{ route('admin.employees.details', ['id' => $user->id]) }}" class="btn btn-info">Info</a>
                                            <a href="{{ route('admin.employees.edit', ['id' => $user->id]) }}" class="btn btn-warning">Edit</a>
                                            <!-- Delete action -->
                                            <form action="{{ route('admin.employees.delete', ['id' => $user->id]) }}" method="POST" style="display:inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Do you really want to delete this user?');" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END DEFAULT DATATABLE -->
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT WRAPPER -->
</x-app-layout>
