<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
        }
        .navbar {
            background-color: #007bff;
        }
        .navbar a {
            color: white;
            font-size: 18px;
        }
        .container {
            margin-top: 50px;
        }
        .btn-dashboard {
            width: 100%;
            padding: 20px;
            font-size: 20px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .btn-primary-dashboard {
            background-color: #007bff;
            border: none;
            color: white;
        }
        .btn-success-dashboard {
            background-color: #28a745;
            border: none;
            color: white;
        }
        h3 {
            margin-bottom: 40px;
        }
    </style>
</head>
<body>

    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Panel</a>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="container text-center">
        <h3>Admin Dashboard</h3>

        <div class="row">
            <div class="col-md-6">
                <a href="{{route('roles')}}" class="btn btn-outline-primary btn-dashboard">Manage Roles</a>
            </div>
            <div class="col-md-6">
                <a href="{{route('users')}}" class="btn btn-outline-success btn-dashboard">Manage Users</a>
            </div>
        </div>
    </div>

</body>
</html>
