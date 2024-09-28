<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Employee') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <!-- Display success or error messages -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Add Employee Form -->
                <form action="{{ route('admin.employees.store') }}" method="POST" onsubmit="return valid();">
                    @csrf
                    
                    <div class="mb-4">
                        <x-jet-label for="empcode" value="{{ __('Employee ID') }}" />
                        <x-jet-input id="empcode" class="block mt-1 w-full" type="text" name="empcode" required autofocus autocomplete="off" onblur="checkAvailabilityEmpid()" />
                        <span id="empid-availability"></span>
                    </div>

                    <div class="mb-4">
                        <x-jet-label for="firstName" value="{{ __('First Name') }}" />
                        <x-jet-input id="firstName" class="block mt-1 w-full" type="text" name="firstName" required />
                    </div>

                    <div class="mb-4">
                        <x-jet-label for="lastName" value="{{ __('Last Name') }}" />
                        <x-jet-input id="lastName" class="block mt-1 w-full" type="text" name="lastName" required />
                    </div>

                    <div class="mb-4">
                        <x-jet-label for="email" value="{{ __('Email') }}" />
                        <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" required onblur="checkAvailabilityEmailid()" />
                        <span id="emailid-availability"></span>
                    </div>

                    <div class="mb-4">
                        <x-jet-label for="department" value="{{ __('Preferred Department') }}" />
                        <select id="department" name="department" class="block mt-1 w-full" required>
                            <option value="">{{ __('Choose..') }}</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->name }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <x-jet-label for="gender" value="{{ __('Gender') }}" />
                        <select id="gender" name="gender" class="block mt-1 w-full" required>
                            <option value="">{{ __('Choose..') }}</option>
                            <option value="Male">{{ __('Male') }}</option>
                            <option value="Female">{{ __('Female') }}</option>
                            <option value="Other">{{ __('Other') }}</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <x-jet-label for="dob" value="{{ __('Date of Birth') }}" />
                        <x-jet-input id="dob" class="block mt-1 w-full" type="date" name="dob" required />
                    </div>

                    <div class="mb-4">
                        <x-jet-label for="mobileno" value="{{ __('Contact Number') }}" />
                        <x-jet-input id="mobileno" class="block mt-1 w-full" type="tel" name="mobileno" required maxlength="10" />
                    </div>

                    <div class="mb-4">
                        <x-jet-label for="country" value="{{ __('Country') }}" />
                        <x-jet-input id="country" class="block mt-1 w-full" type="text" name="country" required />
                    </div>

                    <div class="mb-4">
                        <x-jet-label for="address" value="{{ __('Address') }}" />
                        <x-jet-input id="address" class="block mt-1 w-full" type="text" name="address" required />
                    </div>

                    <div class="mb-4">
                        <x-jet-label for="city" value="{{ __('City') }}" />
                        <x-jet-input id="city" class="block mt-1 w-full" type="text" name="city" required />
                    </div>

                    <h4>{{ __('Set Password for Employee Login') }}</h4>

                    <div class="mb-4">
                        <x-jet-label for="password" value="{{ __('Password') }}" />
                        <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                    </div>

                    <div class="mb-4">
                        <x-jet-label for="confirmpassword" value="{{ __('Confirm Password') }}" />
                        <x-jet-input id="confirmpassword" class="block mt-1 w-full" type="password" name="confirmpassword" required />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-jet-button class="ml-4">
                            {{ __('Add Employee') }}
                        </x-jet-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery scripts for validation and availability checks -->
    <script>
        function valid() {
            if (document.getElementById('password').value !== document.getElementById('confirmpassword').value) {
                alert("Password and Confirm Password do not match!");
                return false;
            }
            return true;
        }

        function checkAvailabilityEmpid() {
            $.ajax({
                url: "{{ route('admin.checkAvailabilityEmpid') }}",
                type: "POST",
                data: { empcode: $('#empcode').val(), _token: '{{ csrf_token() }}' },
                success: function(data) {
                    $('#empid-availability').html(data);
                }
            });
        }

        function checkAvailabilityEmailid() {
            $.ajax({
                url: "{{ route('admin.checkAvailabilityEmailid') }}",
                type: "POST",
                data: { email: $('#email').val(), _token: '{{ csrf_token() }}' },
                success: function(data) {
                    $('#emailid-availability').html(data);
                }
            });
        }
    </script>
</x-app-layout>
