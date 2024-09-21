<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Leave Management System</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-styles.css') }}"> <!-- Example -->
</head>
<body class="bg-gray-100 text-gray-800">

    <header class="text-center py-8">
        <h1 class="text-4xl font-bold">Welcome to the Leave Management System</h1>
    </header>

    <div class="container mx-auto text-center my-8">
        <div class="btn-group flex justify-center space-x-4">
            <a href="{{ route('admin.login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Admin Login</a>
            <a href="{{ route('user.login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">User Login</a>
            <a href="{{ route('auth.register') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded">Register</a>
        </div>
    </div>

    <section class="container mx-auto text-center my-10 p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-semibold">About the System</h2>
        <p class="mt-4">This system is designed to simplify the management of employee leaves for both admins and users. Admins can manage leave requests, employees, and leave types, while users can submit leave requests and view their profile information.</p>
    </section>

    <footer class="text-center py-4 bg-gray-800 text-white">
        <p>&copy; {{ date('Y') }} Leave Management System. All rights reserved.</p>
    </footer>
    
</body>
</html>
