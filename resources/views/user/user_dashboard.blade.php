<x-app-layout>
    @php
        $userId = \Illuminate\Support\Facades\Auth::id();
        $leaveRequests = \App\Models\LeaveApplication::where('empid', $userId)->get()->reverse();
    @endphp

    <div class="page-content-wrap">
        <!-- START RESPONSIVE TABLES -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Your Leave Requests</h3>
                    </div>
                    <div class="panel-body panel-body-table">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-actions">
                                <thead>
                                    <tr>
                                        <th width="50">ID</th>
                                        <th width="100">Name</th>
                                        <th width="100">Number</th>
                                        <th width="100">Leave Type</th>
                                        <th width="100">Reason</th>
                                        <th width="100">Start Date</th>
                                        <th width="100">End Date</th>
                                        <th width="100">Total Days</th>
                                        <th width="100">Status</th>
                                        <th width="100">Rejection Reason</th>
                                        <th width="100">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leaveRequests as $leaveRequest)
                                        @php
                                            $status = $leaveRequest->status;
                                        @endphp
                                        <tr id="trow_{{ $leaveRequest->id }}">
                                            <td class="text-center">{{ $leaveRequest->id }}</td>
                                            <td><strong>{{ $leaveRequest->name }}</strong></td>
                                            <td>{{ $leaveRequest->number }}</td>
                                            <td>{{ \App\Models\LeaveType::find($leaveRequest->leave_type)->name }}</td>
                                            <td>{{ $leaveRequest->reason }}</td>
                                            <td>{{ $leaveRequest->start_date }}</td>
                                            <td>{{ $leaveRequest->end_date }}</td>
                                            <td>{{ $leaveRequest->total_days }}</td>
                                            <td>
                                                @if($status == 0)
                                                    <span class="label label-warning">Pending</span>
                                                @elseif($status == 1)
                                                    <span class="label label-success">Approved</span>
                                                @elseif($status == 2)
                                                    <span class="label label-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>{{ $leaveRequest->rejection_reason }}</td>
                                            @if($status == 0)
                                                <td>
                                                    <a href="{{ route('user.leave.delete', ['id' => $leaveRequest->id]) }}"
                                                       onclick="return confirm('Do you really want to delete this leave application?');"
                                                       class="btn btn-danger">Delete</a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END RESPONSIVE TABLES -->
    </div>
</x-app-layout>
