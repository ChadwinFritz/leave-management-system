<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Leave Management System</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Include your CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome for icons -->
    <script src="{{ asset('js/app.js') }}" defer></script> <!-- Include your JS -->
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="{{ route('welcome') }}">Leave Management System</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.register') }}">Register Admin</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-5">
        <div class="text-center">
            <h1>Welcome to the Leave Management System</h1>
            <p class="lead">Manage your leaves efficiently, whether you're an admin or an employee.</p>
            <div class="mt-4">
                <a href="{{ route('admin.login') }}" class="btn btn-primary btn-lg">Admin Area</a>
                <a href="{{ route('employee.login') }}" class="btn btn-secondary btn-lg">Employee Area</a>
            </div>
        </div>
    </main>

    <footer class="text-center mt-5 py-4 bg-light">
        <p>&copy; {{ date('Y') }} Leave Management System. All rights reserved.</p>
    </footer>
</body>
</html>
