<x-app-layout>
    @section('content')

    <!-- Begin Page Content -->
    <div class="page-container">
        <!-- Sidebar Area Start -->
        @include('includes.admin-sidebar')
        <!-- Sidebar Area End -->

        <!-- Main Content Area Start -->
        <div class="main-content">
            <!-- Header Area Start -->
            @include('includes.admin-header')
            <!-- Header Area End -->

            <!-- Page Title Area Start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Add Admin Section</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="{{ route('admin.manage') }}">Manage Admin</a></li>
                                <li><span>Add</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page Title Area End -->

            <div class="main-content-inner">
                <div class="row">
                    <div class="col-lg-6 col-ml-12">
                        <div class="row">
                            <!-- Form Start -->
                            <div class="col-12 mt-5">
                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <strong>Info:</strong> {{ session('error') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @elseif(session('msg'))
                                    <div class="alert alert-success alert-dismissible fade show">
                                        <strong>Info:</strong> {{ session('msg') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <div class="card">
                                    <form method="POST" action="{{ route('admin.add') }}" onsubmit="return validatePasswords();">
                                        @csrf

                                        <div class="card-body">
                                            <p class="text-muted font-14 mb-4">Please fill out the form to add a new system administrator</p>

                                            <!-- Full Name -->
                                            <div class="form-group">
                                                <label for="fullname" class="col-form-label">Full Name</label>
                                                <input class="form-control" name="fullname" type="text" required>
                                            </div>

                                            <!-- Email -->
                                            <div class="form-group">
                                                <label for="email" class="col-form-label">Email ID</label>
                                                <input class="form-control" name="email" type="email" required>
                                            </div>

                                            <!-- Username -->
                                            <div class="form-group">
                                                <label for="username" class="col-form-label">Username</label>
                                                <input class="form-control" name="username" type="text" required>
                                            </div>

                                            <!-- Password -->
                                            <h4>Setting Passwords</h4>
                                            <div class="form-group">
                                                <label for="password" class="col-form-label">Password</label>
                                                <input class="form-control" name="password" type="password" required>
                                            </div>

                                            <!-- Confirm Password -->
                                            <div class="form-group">
                                                <label for="confirmpassword" class="col-form-label">Confirm Password</label>
                                                <input class="form-control" name="confirmpassword" type="password" required>
                                            </div>

                                            <!-- Submit Button -->
                                            <button class="btn btn-primary" type="submit">PROCEED</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Form End -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Area Start -->
            @include('includes.footer')
            <!-- Footer Area End -->
        </div>
        <!-- Main Content Area End -->

    </div>

    <!-- jQuery & Plugins -->
    <script src="{{ asset('assets/js/vendor/jquery-2.2.4.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>

    <!-- Custom Validation Script -->
    <script type="text/javascript">
        function validatePasswords() {
            var password = document.querySelector('input[name="password"]').value;
            var confirmPassword = document.querySelector('input[name="confirmpassword"]').value;
            
            if (password !== confirmPassword) {
                alert("Passwords do not match!");
                return false;
            }
            return true;
        }
    </script>
    
    @endsection
</x-app-layout>
