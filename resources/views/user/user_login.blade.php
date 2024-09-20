<x-app-layout>
    <div class="login-container lightmode">
        <div class="login-box animated fadeInDown">
            <div class="login-body">
                <div style="text-align: center" class="login-title"><strong>Leave Register System</strong> Employee</div>

                <div class="login-title"><strong>Log In</strong> to your account</div>

                <!-- error container -->
                @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <strong>Oh snap!</strong>
                        @foreach ($errors->all() as $error)
                            <p class="alert-material-red">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <!-- Updated form to use email instead of username -->
                <form action="{{ route('user.login') }}" class="form-horizontal" method="post">
                    @csrf
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="email" id="email" class="form-control" name="email" placeholder="Your email" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password" id="password" class="form-control" name="password" placeholder="Password" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <button class="btn btn-info btn-block">Log In</button>
                        </div>
                    </div>
                    <div class="login-subtitle">
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
