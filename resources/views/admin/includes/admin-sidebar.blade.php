<x-app-layout>
    <nav>
        <ul class="metismenu" id="menu">
            <li class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="ti-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            
            <li class="{{ request()->is('admin/employees') ? 'active' : '' }}">
                <a href="{{ route('admin.employees') }}">
                    <i class="ti-id-badge"></i> <span>Employee Section</span>
                </a>
            </li>
            
            <li class="{{ request()->is('admin/department') ? 'active' : '' }}">
                <a href="{{ route('admin.department') }}">
                    <i class="fa fa-th-large"></i> <span>Department Section</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/leave-types') ? 'active' : '' }}">
                <a href="{{ route('admin.leave-types') }}">
                    <i class="fa fa-sign-out"></i> <span>Leave Types</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/manage-leave*') ? 'active' : '' }}">
                <a href="javascript:void(0)" aria-expanded="true">
                    <i class="ti-briefcase"></i><span>Manage Leave</span>
                </a>

                <ul class="collapse">
                    <li><a href="{{ route('admin.leave.pending') }}">
                        <i class="fa fa-spinner"></i> Pending</a></li>
                    <li><a href="{{ route('admin.leave.approved') }}">
                        <i class="fa fa-check"></i> Approved</a></li>
                    <li><a href="{{ route('admin.leave.declined') }}">
                        <i class="fa fa-times-circle"></i> Declined</a></li>
                    <li><a href="{{ route('admin.leave.history') }}">
                        <i class="fa fa-history"></i> Leave History</a></li>
                </ul>
            </li>

            <li class="{{ request()->is('admin/manage-admin') ? 'active' : '' }}">
                <a href="{{ route('admin.manage-admin') }}">
                    <i class="fa fa-lock"></i> <span>Manage Admin</span>
                </a>
            </li>
        </ul>
    </nav>
</x-app-layout>
