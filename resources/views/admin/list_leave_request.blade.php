<x-app-layout>
    <!-- START RESPONSIVE TABLES -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Employees Leave Request</h3>
                </div>
                <div class="panel-body panel-body-table">
                    <div class="table-responsive">
                        <table class="table datatable table-bordered table-striped table-actions">
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
                                    <th width="100">Total Leave This Year</th>
                                    <th width="100">Created At</th>
                                    <th width="100">Status</th>
                                    <th width="100">Action Reason</th>
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
                                    <td><strong><a href="{{ route('employee.details', ['id' => $leaveRequest->empid]) }}">{{ $leaveRequest->name }}</a></strong></td>
                                    <td>{{ $leaveRequest->number }}</td>
                                    <td>{{ \App\Models\LeaveType::find($leaveRequest->leave_type)->name ?? 'N/A' }}</td>
                                    <td>{{ $leaveRequest->reason }}</td>
                                    <td>{{ $leaveRequest->start_date }}</td>
                                    <td>{{ $leaveRequest->end_date }}</td>
                                    <td>{{ $leaveRequest->total_days }}</td>
                                    <td>{{ \App\Http\Controllers\AdminController::calculateTotalLeave($leaveRequest->empid) }}</td>
                                    <td>{{ $leaveRequest->created_at->format('Y-m-d H:i:s') }}</td>
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
                                    <td>
                                        @if($status != 1)
                                            <a href="{{ route('leave.update', ['id' => $leaveRequest->id, 'action' => 'approve']) }}" class="btn btn-success">Approve</a>
                                        @endif
                                        <a href="#" class="mb-control btn btn-danger" data-box="#mb-reject" onclick="setRejectFormAction({{ $leaveRequest->id }})">Reject</a>
                                        <a href="{{ route('leave.delete', ['id' => $leaveRequest->id]) }}" onclick="return confirm('Do you really want to delete this leave application?');" class="btn btn-danger">Delete</a>
                                    </td>
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

    <!-- MESSAGE BOX -->
    <div class="message-box animated fadeIn" id="mb-reject">
        <div class="mb-container">
            <div class="mb-middle">
                <form action="" method="POST" id="reject-form">
                    @csrf
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Reject <strong>Leave Request</strong>?</div>
                    <div class="mb-content">
                        <p>Please specify a reason for the rejection.</p>
                        <div class="form-group">
                            <textarea class="form-control" name="rejection_reason" rows="5"></textarea>
                            <input type="hidden" name="action" value="reject"/>
                            <input type="hidden" name="additional_info" value="2"/>
                        </div>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success btn-lg">Yes</button>
                            <button type="button" class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END MESSAGE BOX -->

    <script>
        function setRejectFormAction(id) {
            document.getElementById('reject-form').action = "{{ route('leave.update', ['id' => ':id', 'action' => 'reject']) }}".replace(':id', id);
        }
    </script>
</x-app-layout>
