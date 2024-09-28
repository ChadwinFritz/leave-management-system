<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Department') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        Update Department Information
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success mt-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger mt-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.department.update', $department->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mt-4">
                            <x-label for="departmentname" :value="__('Department Name')" />
                            <x-input id="departmentname" class="block mt-1 w-full" type="text" name="departmentname" value="{{ old('departmentname', $department->DepartmentName) }}" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-label for="departmentshortname" :value="__('Shortform')" />
                            <x-input id="departmentshortname" class="block mt-1 w-full" type="text" name="departmentshortname" value="{{ old('departmentshortname', $department->DepartmentShortName) }}" required />
                        </div>

                        <div class="mt-4">
                            <x-label for="deptcode" :value="__('Code')" />
                            <x-input id="deptcode" class="block mt-1 w-full" type="text" name="deptcode" value="{{ old('deptcode', $department->DepartmentCode) }}" required />
                        </div>

                        <div class="mt-6">
                            <x-button class="ml-4">
                                {{ __('Make Changes') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
