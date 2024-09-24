<x-app-layout>
    @php
        $userId = Auth::id();
        $leaveRequests = \App\Models\LeaveApplication::where('empid', $userId)->latest()->get();
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
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Contact Number</th>
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
                            <tr id="trow_{{ $leaveRequest->id }}">
                                <td class="px-4 py-2 text-center">{{ $leaveRequest->id }}</td>
                                <td class="px-4 py-2 font-bold">{{ $leaveRequest->name }}</td>
                                <td class="px-4 py-2">{{ $leaveRequest->contact_number }}</td>
                                <td class="px-4 py-2">{{ optional($leaveRequest->leaveType)->name ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $leaveRequest->reason }}</td>
                                <td class="px-4 py-2">{{ $leaveRequest->start_date }}</td>
                                <td class="px-4 py-2">{{ $leaveRequest->end_date }}</td>
                                <td class="px-4 py-2">{{ $leaveRequest->total_days }}</td>
                                <td class="px-4 py-2">
                                    @if($leaveRequest->status === 0)
                                        <span class="text-gray-500 font-bold">Pending</span>
                                    @elseif($leaveRequest->status === 1)
                                        <span class="text-green-500 font-bold">Approved</span>
                                    @elseif($leaveRequest->status === 2)
                                        <span class="text-red-500 font-bold">Rejected</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">{{ $leaveRequest->rejection_reason }}</td>
                                <td class="px-4 py-2">
                                    @if($leaveRequest->status === 0)
                                        <a href="{{ route('user.leave.delete', ['id' => $leaveRequest->id]) }}"
                                           onclick="return confirm('Do you really want to delete this leave application?');"
                                           class="bg-gray-500 text-white rounded-lg px-3 py-1 hover:bg-red-600">Delete</a>
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($leaveRequests->isEmpty())
                    <div class="p-6 text-center text-gray-600">No leave requests found.</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
