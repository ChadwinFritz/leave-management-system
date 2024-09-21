<x-app-layout>
    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap py-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white shadow-md rounded-lg p-8 space-y-6">

                <!-- Form Heading -->
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-800">Add Employee</h3>
                    <a href="#" class="text-gray-500 hover:text-red-600 transition duration-300">
                        <i class="fa fa-times"></i>
                    </a>
                </div>

                <!-- Success Message -->
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                        <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <span class="text-green-500">&times;</span>
                        </button>
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Oh snap!</strong>
                        <ul class="list-disc ml-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form start -->
                <form action="{{ route('admin.employees.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf <!-- CSRF protection -->

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name Field -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Name</label>
                            <input type="text" name="name" class="form-input w-full border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm" required/>
                            <span class="text-sm text-gray-500">Enter the employee's name</span>
                        </div>

                        <!-- Designation Field -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Designation</label>
                            <input type="text" name="designation" class="form-input w-full border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm" required/>
                            <span class="text-sm text-gray-500">Enter the employee's designation</span>
                        </div>

                        <!-- Duty Field -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Duty</label>
                            <input type="text" name="duty" class="form-input w-full border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm" required/>
                            <span class="text-sm text-gray-500">Enter the employee's duty</span>
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Email</label>
                            <input type="email" name="email" class="form-input w-full border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm" required/>
                            <span class="text-sm text-gray-500">Enter the employee's email</span>
                        </div>

                        <!-- Username Field -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Username</label>
                            <input type="text" name="username" class="form-input w-full border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm" required/>
                            <span class="text-sm text-gray-500">Choose a username for login</span>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Password</label>
                            <input type="password" name="password" class="form-input w-full border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm" required/>
                            <span class="text-sm text-gray-500">Choose a strong password</span>
                        </div>

                        <!-- Note Field -->
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 font-medium mb-2">Note</label>
                            <textarea name="note" class="form-textarea w-full border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm" rows="4"></textarea>
                            <span class="text-sm text-gray-500">Additional notes about the employee</span>
                        </div>

                        <!-- Image Upload -->
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 font-medium mb-2">Image</label>
                            <input type="file" name="proimg" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border file:border-gray-300 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                            <span class="text-sm text-gray-500">Upload a profile image</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-6 flex justify-end space-x-4">
                        <button type="reset" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600 transition duration-200">Clear Form</button>
                        <button type="submit" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">Add Employee</button>
                    </div>
                </form>
                <!-- Form end -->

            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT WRAPPER -->
</x-app-layout>
