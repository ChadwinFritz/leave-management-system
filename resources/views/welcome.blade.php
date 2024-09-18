<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Leave Management System</title>
    <!-- Add your CSS links here -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Include additional CSS if needed -->
    <link rel="stylesheet" href="{{ asset('css/custom-styles.css') }}"> <!-- Example -->
</head>
<body class="bg-light text-dark">

    <header class="text-center py-4">
        <h1 class="display-4">Welcome to the Leave Management System</h1>
    </header>

    <div class="container text-center my-5">
        <div class="btn-group">
            <!-- Links to the login pages and registration -->
            <a href="{{ route('admin.login') }}" class="btn btn-primary mx-2">Admin Login</a>
            <a href="{{ route('user.login') }}" class="btn btn-primary mx-2">User Login</a>
            <a href="{{ route('auth.register') }}" class="btn btn-secondary mx-2">Register</a>
        </div>
    </div>

    <section class="container text-center my-5">
        <h2>About the System</h2>
        <p>This system is designed to simplify the management of employee leaves for both admins and users. Admins can manage leave requests, employees, and leave types, while users can submit leave requests and view their profile information.</p>
    </section>

    <footer class="text-center py-4 bg-dark text-white">
        <p>&copy; {{ date('Y') }} Leave Management System. All rights reserved.</p>
    </footer>
    
</body>
</html>
