<x-app-layout>
    <div class="max-w-7xl mx-auto py-8">
        <div class="bg-white shadow-md rounded-lg">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-semibold">Employees Leave Request</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">ID</th>
                            <th class="border px-4 py-2">Name</th>
                            <th class="border px-4 py-2">Number</th>
                            <th class="border px-4 py-2">Leave Type</th>
                            <th class="border px-4 py-2">Reason</th>
                            <th class="border px-4 py-2">Start Date</th>
                            <th class="border px-4 py-2">End Date</th>
                            <th class="border px-4 py-2">Total Days</th>
                            <th class="border px-4 py-2">Total Leave This Year</th>
                            <th class="border px-4 py-2">Created At</th>
                            <th class="border px-4 py-2">Status</th>
                            <th class="border px-4 py-2">Action Reason</th>
                            <th class="border px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaveRequests as $leaveRequest)
                        <tr id="trow_{{ $leaveRequest->id }}">
                            <td class="border text-center">{{ $leaveRequest->id }}</td>
                            <td class="border">
                                <strong>
                                    <a href="{{ route('employee.details', ['id' => $leaveRequest->empid]) }}" class="text-blue-500 hover:underline">{{ $leaveRequest->name }}</a>
                                </strong>
                            </td>
                            <td class="border">{{ $leaveRequest->number }}</td>
                            <td class="border">{{ \App\Models\LeaveType::find($leaveRequest->leave_type)->name ?? 'N/A' }}</td>
                            <td class="border">{{ $leaveRequest->reason }}</td>
                            <td class="border">{{ $leaveRequest->start_date }}</td>
                            <td class="border">{{ $leaveRequest->end_date }}</td>
                            <td class="border">{{ $leaveRequest->total_days }}</td>
                            <td class="border">{{ \App\Http\Controllers\AdminController::calculateTotalLeave($leaveRequest->empid) }}</td>
                            <td class="border">{{ $leaveRequest->created_at->format('Y-m-d H:i:s') }}</td>
                            <td class="border">
                                @if($leaveRequest->status == 0)
                                    <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded">Pending</span>
                                @elseif($leaveRequest->status == 1)
                                    <span class="bg-green-200 text-green-800 px-2 py-1 rounded">Approved</span>
                                @elseif($leaveRequest->status == 2)
                                    <span class="bg-red-200 text-red-800 px-2 py-1 rounded">Rejected</span>
                                @endif
                            </td>
                            <td class="border">{{ $leaveRequest->rejection_reason }}</td>
                            <td class="border">
                                @if($leaveRequest->status != 1)
                                    <a href="{{ route('leave.update', ['id' => $leaveRequest->id, 'action' => 'approve']) }}" class="bg-green-500 text-white px-4 py-1 rounded hover:bg-green-600">Approve</a>
                                @endif
                                <a href="#" class="mb-control btn btn-danger" data-box="#mb-reject" onclick="setRejectFormAction({{ $leaveRequest->id }})" class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600">Reject</a>
                                <a href="{{ route('leave.delete', ['id' => $leaveRequest->id]) }}" onclick="return confirm('Do you really want to delete this leave application?');" class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MESSAGE BOX -->
    <div class="fixed inset-0 z-50 flex items-center justify-center hidden" id="mb-reject">
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="" method="POST" id="reject-form">
                @csrf
                <div class="mb-title"><span class="fa fa-sign-out"></span> Reject <strong>Leave Request</strong>?</div>
                <div class="mb-content">
                    <p>Please specify a reason for the rejection.</p>
                    <div class="form-group">
                        <textarea class="form-control border rounded w-full" name="rejection_reason" rows="5" required></textarea>
                        <input type="hidden" name="action" value="reject"/>
                        <input type="hidden" name="additional_info" value="2"/>
                    </div>
                </div>
                <div class="mb-footer flex justify-end">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Yes</button>
                    <button type="button" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400 mb-control-close">No</button>
                </div>
            </form>
        </div>
    </div>
    <!-- END MESSAGE BOX -->

    <script>
        function setRejectFormAction(id) {
            document.getElementById('reject-form').action = "{{ route('leave.update', ['id' => ':id', 'action' => 'reject']) }}".replace(':id', id);
            document.getElementById('mb-reject').classList.remove('hidden');
        }
    </script>
</x-app-layout>
