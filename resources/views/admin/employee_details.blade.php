<x-app-layout>
    @php
        if (isset($userId)) {
            $user = \App\Models\User::find($userId);
            $leaveInfo = \App\Models\Leave::where('empid', $user->id)->first();
            $totalLeave = $leaveInfo ? $leaveInfo->totalleave : 0;

            // Calculate leave counts by leave type
            $leaveCounts = \App\Models\Leave::where('empid', $userId)
                ->select('leave_type_id', \DB::raw('count(*) as total'))
                ->groupBy('leave_type_id')
                ->pluck('total', 'leave_type_id');
        }
    @endphp

    <div class="max-w-7xl mx-auto py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Employee Profile Panel -->
            <div class="bg-white shadow-md rounded-lg">
                <div class="p-6">
                    <div class="flex items-center space-x-6">
                        <div>
                            <img class="w-36 h-36 rounded-full" src="{{ asset('profileimg/' . $user->image) }}" alt="{{ $user->username }}" />
                        </div>
                        <div>
                            <div class="text-xl font-semibold text-gray-800">{{ $user->name }}</div>
                            <div class="text-gray-600">{{ $user->designation }}</div>
                        </div>
                    </div>
                </div>

                <div class="p-6 grid grid-cols-2 gap-4">
                    <a href="{{ route('admin.employees.edit', ['id' => $user->id]) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('admin.employees.delete', ['id' => $user->id]) }}" method="POST" onsubmit="return confirm('Do you really want to delete this user?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
                            <i class="fa fa-window-close"></i> Delete
                        </button>
                    </form>
                </div>

                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">General Info</h3>
                    <ul class="space-y-2">
                        <li><span class="font-semibold">Username:</span> {{ $user->username }}</li>
                        <li><span class="font-semibold">Email:</span> {{ $user->email }}</li>
                        <li><span class="font-semibold">Total Leave this Year:</span> {{ $totalLeave }}</li>
                        <li><span class="font-semibold">Duty:</span> {{ $user->duty }}</li>
                    </ul>
                </div>

                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Leave Details</h3>
                    @php
                        $leaveTypes = \App\Models\LeaveType::all();
                    @endphp
                    <ul class="space-y-2">
                        @foreach ($leaveTypes as $leaveType)
                            <li class="flex justify-between">
                                <span>{{ $leaveType->name }}</span>
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full">{{ $leaveCounts[$leaveType->id] ?? 0 }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Employee Leave Dates Panel -->
            <div>
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Employee Leave Dates</h3>

                    @if (isset($userId) && isset($totalDays) && isset($leaveDates))
                        <div class="mt-6">
                            <div id="calendar"></div>
                            <div class="mt-4">
                                <h4 class="text-xl">Total Days: {{ $totalDays }}</h4>
                            </div>
                        </div>
                    @else
                        <p class="text-gray-600">No leave dates available for this employee.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- START PLUGINS -->
    <script type="text/javascript" src="{{ asset('js/plugins/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/jquery/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/bootstrap/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
    <!-- END PLUGINS -->

    @if (isset($userId) && isset($totalDays) && isset($leaveDates))
        <script>
            var dates = @json($leaveDates);

            var events = dates.map(date => ({
                title: 'Leave',
                start: date
            }));

            $(document).ready(function() {
                $('#calendar').fullCalendar({
                    defaultDate: events.length ? events[0].start : new Date(),
                    events: events
                });
            });
        </script>
    @endif
</x-app-layout>
