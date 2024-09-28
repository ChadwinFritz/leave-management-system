<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Leave Type') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @elseif(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.addLeaveType') }}">
                        @csrf

                        <div class="form-group">
                            <label for="leavetype" class="col-form-label">Leave Type</label>
                            <input class="form-control" name="leavetype" type="text" required id="leavetype">
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-form-label">Short Description</label>
                            <input class="form-control" name="description" type="text" required id="description">
                        </div>

                        <button class="btn btn-primary" name="add" id="add" type="submit">Add Leave Type</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
