<x-app-layout>
    @php
        $userId = \Illuminate\Support\Facades\Auth::id();
        $leaveRequests = \App\Models\LeaveApplication::where('empid', $userId)->get()->reverse();
    @endphp

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg">
            <div class="p-6 border-b">
                <h3 class="text-xl font-semibold">Your Leave Requests</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">ID</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Name</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Number</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Leave Type</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Reason</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Start Date</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">End Date</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Total Days</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Status</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Rejection Reason</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($leaveRequests as $leaveRequest)
                            @php
                                $status = $leaveRequest->status;
                            @endphp
                            <tr id="trow_{{ $leaveRequest->id }}">
                                <td class="px-4 py-2 text-center">{{ $leaveRequest->id }}</td>
                                <td class="px-4 py-2 font-bold">{{ $leaveRequest->name }}</td>
                                <td class="px-4 py-2">{{ $leaveRequest->number }}</td>
                                <td class="px-4 py-2">{{ \App\Models\LeaveType::find($leaveRequest->leave_type)->name ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $leaveRequest->reason }}</td>
                                <td class="px-4 py-2">{{ $leaveRequest->start_date }}</td>
                                <td class="px-4 py-2">{{ $leaveRequest->end_date }}</td>
                                <td class="px-4 py-2">{{ $leaveRequest->total_days }}</td>
                                <td class="px-4 py-2">
                                    @if($status == 0)
                                        <span class="text-gray-500 font-bold">Pending</span>
                                    @elseif($status == 1)
                                        <span class="text-gray-500 font-bold">Approved</span>
                                    @elseif($status == 2)
                                        <span class="text-gray-500 font-bold">Rejected</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">{{ $leaveRequest->rejection_reason }}</td>
                                @if($status == 0)
                                    <td class="px-4 py-2">
                                        <a href="{{ route('user.leave.delete', ['id' => $leaveRequest->id]) }}"
                                           onclick="return confirm('Do you really want to delete this leave application?');"
                                           class="bg-gray-500 text-white rounded-lg px-3 py-1 hover:bg-red-600">Delete</a>
                                    </td>
                                @else
                                    <td class="px-4 py-2"></td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
