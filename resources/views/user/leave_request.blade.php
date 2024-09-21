<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg">
            <form method="post" action="{{ route('user.leave.request') }}" enctype="multipart/form-data">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold"><strong>Apply</strong> for Leave</h3>
                </div>

                @if(session('success'))
                    <div class="alert alert-success mt-4" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger mt-4" role="alert">
                        <strong>Oh snap!</strong>
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                    <div>
                        @php $leaveTypes = \App\Models\LeaveType::all(); @endphp

                        <div class="mb-4">
                            <label class="block text-gray-700">Leave Type</label>
                            <select name="leave_type" class="form-select mt-1 block w-full" required>
                                @foreach($leaveTypes as $leaveType)
                                    <option value="{{ $leaveType->id }}">{{ $leaveType->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-gray-500 text-sm">Select Leave Type</span>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700">Start Date</label>
                            <input name="start_date" type="date" class="form-input mt-1 block w-full" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700">Name</label>
                            <input type="text" name="name" class="form-input mt-1 block w-full" value="{{ Auth::user()->name }}" required/>
                            <span class="text-gray-500 text-sm">Name of employee</span>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700">Username</label>
                            <input type="text" name="username" class="form-input mt-1 block w-full" value="{{ Auth::user()->username }}" required/>
                            <span class="text-gray-500 text-sm">Username of employee</span>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700">Leave Reason</label>
                            <textarea class="form-textarea mt-1 block w-full" name="reason" rows="5" required></textarea>
                            <span class="text-gray-500 text-sm">Reason and additional notes on Leave</span>
                        </div>
                    </div>

                    <div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Contact Number</label>
                            <input type="text" class="form-input mt-1 block w-full" name="contact_number" placeholder="Mobile number" required/>
                            <span class="text-gray-500 text-sm">Employee contact number</span>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700">End Date</label>
                            <input name="end_date" type="date" class="form-input mt-1 block w-full" required>
                        </div>

                        @csrf
                    </div>
                </div>

                <div class="px-6 py-4 border-t flex justify-between">
                    <button type="reset" class="bg-gray-500 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">Clear Form</button>
                    <button type="submit" class="bg-gray-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Apply Leave</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
