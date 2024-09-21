<x-app-layout>
    @php  
        $userId = \Illuminate\Support\Facades\Auth::user()->id;
        $user = DB::table('users')->where('id', $userId)->first();
    @endphp

    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white shadow-md rounded-lg">
                <div class="flex items-center justify-center py-8">
                    <div class="profile-image">
                        <img class="w-48 h-48 rounded-full" src="{{ asset('profileimg/' . $user->image) }}" alt="{{ $user->username }}" />
                    </div>
                </div>
                <div class="text-center pb-6">
                    <h2 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h2>
                    <p class="text-gray-600">{{ $user->designation }}</p>
                </div>

                <div class="border-t border-gray-200">
                    <div class="px-6 py-4">
                        <h3 class="font-semibold text-gray-700">Activity</h3>
                        <ul class="list-disc list-inside">
                            <li>Username: <span class="font-bold text-red-500">{{ $user->username }}</span></li>
                            <li>Email: <span class="font-bold text-red-500">{{ $user->email }}</span></li>
                            <li>Total Leave in this Year: <span class="font-bold text-red-500">{{ \App\Http\Controllers\AdminController::calculateTotalLeave($userId) }}</span></li>
                            <li>Duty: <span class="font-bold text-red-500">{{ $user->duty }}</span></li>
                        </ul>
                    </div>

                    <div class="px-6 py-4">
                        <h3 class="font-semibold text-gray-700">Leave Details</h3>
                        @php $leaveTypes = DB::table('leave_types')->get(); @endphp
                        <ul class="list-disc list-inside">
                            @foreach($leaveTypes as $leaveType)
                                <li>{{ $leaveType->name }}: <span class="font-bold text-red-500">{{ \App\Http\Controllers\UserController::getEachLeaveCount($userId, $leaveType->id) }}</span></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold">Employee Leave Dates</h3>
                </div>
                <form class="p-6" method="post" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700">Start Date</label>
                            <input name="start_date" type="text" class="form-input mt-1 block w-full" placeholder="DD-MM-YYYY" required>
                        </div>
                        <div>
                            <label class="block text-gray-700">End Date</label>
                            <input name="end_date" type="text" class="form-input mt-1 block w-full" placeholder="DD-MM-YYYY" required>
                        </div>
                    </div>
                    <button type="submit" class="mt-6 bg-gray-500 text-white py-2 px-4 rounded">Apply</button>
                </form>

                <!-- Display Calendar if available -->
                @if(isset($totalDays) && isset($leaveDates))
                    <div class="p-6">
                        <div class="calendar">
                            <div id="calendar"></div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>