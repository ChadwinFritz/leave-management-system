<x-app-layout>
    <div class="user-profile pull-right">
        <!-- Displaying avatar -->
        <img class="avatar user-thumb" src="{{ asset('assets/images/avatar.jpg') }}" alt="avatar">
        
        <!-- User name and dropdown -->
        <h4 class="user-name dropdown-toggle" data-toggle="dropdown">
            @include('includes.logged') <!-- This includes the logged-in user's name -->
            <i class="fa fa-angle-down"></i>
        </h4>

        <!-- Dropdown menu -->
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ route('employee.profile') }}">View Profile</a>
            <a class="dropdown-item" href="{{ route('employee.change-password') }}">Password</a>
            <a class="dropdown-item" href="{{ route('logout') }}">Log Out</a>
        </div>
    </div>
</x-app-layout>
