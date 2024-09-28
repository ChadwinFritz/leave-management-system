<x-app-layout>
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

    @php
        use Illuminate\Support\Facades\DB;

        // Fetch unread notifications count
        $unreadCount = DB::table('tblleaves')->where('IsRead', 0)->count();

        // Fetch leave applications that are unread
        $unreadNotifications = DB::table('tblleaves')
            ->join('tblemployees', 'tblleaves.empid', '=', 'tblemployees.id')
            ->select('tblleaves.id as lid', 'tblemployees.FirstName', 'tblemployees.LastName', 'tblemployees.EmpId', 'tblleaves.PostingDate')
            ->where('tblleaves.IsRead', 0)
            ->get();
    @endphp
    
    <li class="dropdown">
        <i class="ti-bell dropdown-toggle" data-toggle="dropdown">
            <span>{{ $unreadCount }}</span>
        </i>
        <div class="dropdown-menu bell-notify-box notify-box">
            <span class="notify-title">
                You have {{ $unreadCount }} <b>unread</b> notifications!
            </span>
            <div class="notify-list">
                @if($unreadNotifications->count() > 0)
                    @foreach($unreadNotifications as $notification)
                        <a href="{{ url('employeeLeave-details', ['leaveid' => $notification->lid]) }}" class="notify-item">
                            <div class="notify-thumb">
                                <i class="ti-comments-smiley btn-info"></i>
                            </div>
                            <div class="notify-text">
                                <p>
                                    <b>{{ $notification->FirstName }} {{ $notification->LastName }}
                                    <br /> ({{ $notification->EmpId }})</b> has recently applied for a leave.
                                </p>
                                <span>at {{ $notification->PostingDate }}</span>
                            </div>
                        </a>
                    @endforeach
                @else
                    <p>No new notifications.</p>
                @endif
            </div>
        </div>
    </li>
</x-app-layout>
