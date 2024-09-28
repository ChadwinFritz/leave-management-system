<x-app-layout>
    @php
        error_reporting(0);
        use Illuminate\Support\Facades\DB;

        // Session validation
        if (!session('alogin')) {
            header('Location: {{ route('admin.login') }}');
            exit();
        }

        // Delete department logic
        if (request()->has('del')) {
            $id = request()->query('del');
            DB::table('tbldepartments')->where('id', $id)->delete();
            $msg = "The selected department has been deleted";
        }
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Department Management
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(isset($msg))
                <div class="alert alert-success">
                    {{ $msg }}
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-4">
                    <a href="{{ route('admin.addDepartment') }}" class="btn btn-primary">Add New Department</a>
                </div>

                <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Department</th>
                                <th>Shortform</th>
                                <th>Code</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $departments = DB::table('tbldepartments')->get();
                                $cnt = 1;
                            @endphp
                            @foreach ($departments as $department)
                                <tr>
                                    <td>{{ $cnt++ }}</td>
                                    <td>{{ $department->DepartmentName }}</td>
                                    <td>{{ $department->DepartmentShortName }}</td>
                                    <td>{{ $department->DepartmentCode }}</td>
                                    <td>{{ $department->CreationDate }}</td>
                                    <td>
                                        <a href="{{ route('admin.editDepartment', ['deptid' => $department->id]) }}" class="text-green-600">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.department', ['del' => $department->id]) }}" onclick="return confirm('Do you want to delete?');" class="text-red-600">
                                            <i class="fa fa-trash"></i>
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

    <!-- Add necessary scripts -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>

</x-app-layout>
