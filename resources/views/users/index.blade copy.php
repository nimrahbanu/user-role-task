<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="btn btn-outline-success" href="{{ url('/') }}">Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <h3>User Form</h3>
    <form id="userForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="userId">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" id="userName" oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" id="userEmail">
        </div>
        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" id="userPhone" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" >>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" id="userDescription"></textarea>
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role_id" class="form-control" id="userRole">
            </select>
        </div>
        <div class="mb-3">
            <label>Profile Image</label>
            <input type="file" name="profile_image" class="form-control" id="userImage">
            <img id="imagePreview" src="#" alt="Image Preview" style="display: none; margin-top: 10px; width: 100px; height: auto;">
        </div>

        <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
    </form>


    <h4 class="mt-5">Users</h4>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="userTable">
            <!-- Users data will be populated here -->
        </tbody>
    </table>
</div>
@include('layouts.script')
</body>
</html>
