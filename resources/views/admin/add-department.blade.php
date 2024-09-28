<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Department') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        Add a New Department
                    </div>

                    <div class="mt-6 text-gray-500">
                        Please fill up the form below to add a new department.
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @elseif (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>

                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <form method="POST" action="{{ route('admin.departments.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="departmentname" class="block font-medium text-sm text-gray-700">Department Name</label>
                                <input type="text" name="departmentname" id="departmentname" class="form-control" required autofocus>
                            </div>

                            <div class="form-group mt-4">
                                <label for="departmentshortname" class="block font-medium text-sm text-gray-700">Shortform</label>
                                <input type="text" name="departmentshortname" id="departmentshortname" class="form-control" required>
                            </div>

                            <div class="form-group mt-4">
                                <label for="deptcode" class="block font-medium text-sm text-gray-700">Department Code</label>
                                <input type="text" name="deptcode" id="deptcode" class="form-control" required>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add Department') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
