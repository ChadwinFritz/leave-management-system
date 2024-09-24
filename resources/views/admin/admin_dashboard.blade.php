<x-app-layout>
    <!-- PAGE TITLE -->
    <div class="page-title py-4">
        <h2 class="text-2xl font-semibold text-gray-800">
            <span class="fa fa-arrow-circle-o-left"></span> Employees
        </h2>
    </div>
    <!-- END PAGE TITLE -->

    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap py-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white shadow-md rounded-lg p-6">

                <!-- Panel Header -->
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-gray-800">Employee List</h3>
                    <div class="space-x-4">
                        <a href="{{ route('admin.employees.add') }}" class="text-gray-500 hover:text-blue-600 transition duration-300">
                            <i class="fa fa-plus"></i> Add Employee
                        </a>
                        <a href="#" class="text-gray-500 hover:text-gray-800 transition duration-300">
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-gray-800 transition duration-300">
                            <i class="fa fa-refresh"></i>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-red-600 transition duration-300">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>

                <!-- Employee Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 text-left">
                                <th class="py-2 px-4">Name</th>
                                <th class="py-2 px-4">Designation</th>
                                <th class="py-2 px-4">Duty</th>
                                <th class="py-2 px-4">Total Leave</th>
                                <th class="py-2 px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach($users as $user)
                                <tr class="border-t border-gray-200">
                                    <td class="py-2 px-4">{{ $user->name }}</td>
                                    <td class="py-2 px-4">{{ $user->designation }}</td>
                                    <td class="py-2 px-4">{{ $user->duty }}</td>
                                    <td class="py-2 px-4">{{ \App\Http\Controllers\AdminLeaveController::calculateTotalLeave($user->id) }}</td>
                                    <td class="py-2 px-4 flex space-x-2">
                                        <!-- Info Button -->
                                        <a href="{{ route('admin.employees.details', ['id' => $user->id]) }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">Info</a>
                                        
                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.employees.edit', ['id' => $user->id]) }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-yellow-500 transition duration-300">Edit</a>
                                        
                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.employees.delete', ['id' => $user->id]) }}" method="POST" onsubmit="return confirm('Do you really want to delete this employee?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-300">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- End Employee Table -->

            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT WRAPPER -->
</x-app-layout>
