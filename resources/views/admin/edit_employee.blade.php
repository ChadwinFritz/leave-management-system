<x-app-layout>
    <div class="max-w-7xl mx-auto py-8">
        <form method="POST" action="{{ route('admin.employees.update', $employee->id) }}" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6">
            @csrf
            @method('PUT')

            <h3 class="text-xl font-semibold mb-4"><strong>Update</strong> Employee</h3>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded" role="alert">
                    <strong>Oh snap!</strong>
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <!-- Name Input -->
                    <div class="mb-4">
                        <label class="block text-gray-700">Name</label>
                        <input type="text" name="name" class="mt-1 block w-full border-gray-300 rounded-md" value="{{ old('name', $employee->name) }}" />
                        <span class="text-sm text-gray-500">Name of employee</span>
                    </div>

                    <!-- Designation Input -->
                    <div class="mb-4">
                        <label class="block text-gray-700">Designation</label>
                        <input type="text" name="designation" class="mt-1 block w-full border-gray-300 rounded-md" value="{{ old('designation', $employee->designation) }}" />
                        <span class="text-sm text-gray-500">Designation of employee</span>
                    </div>

                    <!-- Duty Input -->
                    <div class="mb-4">
                        <label class="block text-gray-700">Duty</label>
                        <input type="text" name="duty" class="mt-1 block w-full border-gray-300 rounded-md" value="{{ old('duty', $employee->duty) }}" />
                        <span class="text-sm text-gray-500">Duty of employee</span>
                    </div>

                    <!-- Note Input -->
                    <div class="mb-4">
                        <label class="block text-gray-700">Note</label>
                        <textarea class="mt-1 block w-full border-gray-300 rounded-md" name="note" rows="5">{{ old('note', $employee->note) }}</textarea>
                        <span class="text-sm text-gray-500">Note about employee</span>
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-4">
                        <label class="block text-gray-700">Image</label>
                        <input type="file" class="mt-1 block w-full border-gray-300 rounded-md" name="profile_image" id="profile_image" title="Browse file" />
                        <span class="text-sm text-gray-500">Image of employee</span>
                    </div>
                </div>

                <div>
                    <!-- Email Input -->
                    <div class="mb-4">
                        <label class="block text-gray-700">Email</label>
                        <input type="email" class="mt-1 block w-full border-gray-300 rounded-md" name="email" value="{{ old('email', $employee->email) }}" />
                        <span class="text-sm text-gray-500">Employee email</span>
                    </div>

                    <!-- Username Input -->
                    <div class="mb-4">
                        <label class="block text-gray-700">Username</label>
                        <input type="text" class="mt-1 block w-full border-gray-300 rounded-md" name="username" value="{{ old('username', $employee->username) }}" />
                        <span class="text-sm text-gray-500">Username for employee login</span>
                    </div>

                    <!-- Password Input -->
                    <div class="mb-4">
                        <label class="block text-gray-700">Password</label>
                        <input type="password" class="mt-1 block w-full border-gray-300 rounded-md" name="password" />
                        <span class="text-sm text-gray-500">Password for employee login (leave blank if not changing)</span>
                    </div>

                    <!-- Hidden Inputs -->
                    <input type="hidden" name="id" value="{{ $employee->id }}">
                </div>
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-default">Cancel</a>
                <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">Update Employee</button>
            </div>
        </form>
    </div>
</x-app-layout>
