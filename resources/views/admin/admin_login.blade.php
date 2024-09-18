<x-app-layout>
    <div class="login-container">
        <div class="login-box animated fadeInDown">
            <!-- Display Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <strong>Oh snap!</strong>
                    @foreach ($errors->all() as $error)
                        <p class="alert-material-red">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Login Form -->
            <div class="login-body">
                <div class="login-title"><strong>Leave System Admin Portal</strong>, Please login</div>
                <form action="{{ route('admin.login') }}" class="form-horizontal" method="post">
                    @csrf
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" name="username" class="form-control" placeholder="Username" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password" name="password" class="form-control" placeholder="Password" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <a href="{{ route('admin.login') }}" class="btn btn-link btn-block">Login as an Admin</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-info btn-block">Log In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
