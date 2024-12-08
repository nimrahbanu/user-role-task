<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role</title>
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
    <h3>Role Form</h3>
    <form id="roleForm" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Role Name</label>
            <input type="text" name="role_name" class="form-control" oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')" required>
            <div id="roleError" class="text-danger mt-2" style="display: none;"></div>
        </div>
        <button type="submit" class="btn btn-primary" id="submit">Submit</button>
    </form>

    <h4 class="mt-5">Roles</h4>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Role Name</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="roleTable">
        </tbody>
    </table>

    <div id="errorAlert" class="alert alert-danger" style="display: none;">
        <strong>Error:</strong> Something went wrong, please try again.
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
var i=1;
        function loadRole() {
            $.ajax({
                url: '/api/roles',
                type: 'GET',
                success: function (response) {
                    let tableData = '';
                    response.data.forEach(role => {
                        tableData += `<tr>
                            <td>${i++}</td>
                            <td class="text-capitalize">${role.role_name}</td>
                            <td>
                                <button class="btn btn-warning btn-sm editBtn" data-id="${role.id}">Edit</button>
                                <button class="btn btn-danger btn-sm deleteBtn" data-id="${role.id}">Delete</button>
                            </td>
                        </tr>`;
                    });
                    $('#roleTable').html(tableData);
                },
                error: function () {
                    $('#errorAlert').text("Failed to load roles. Please try again.").show();
                }
            });
        }

        loadRole();

        $('#roleForm').on('submit', function (e) {
            e.preventDefault();
            let formData = new FormData(this);

            $('#roleError').hide();
            $('#errorAlert').hide();

            $.ajax({
                url: '/api/roles',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function () {
                    loadRole();
                    $('#roleForm')[0].reset();
                },
                error: function (response) {
                    if (response.status === 422) {
                        const errors = response.responseJSON.errors;
                        if (errors.role_name) {
                            $('#roleError').text(errors.role_name[0]).show();
                        }
                    } else {
                        $('#errorAlert').text("Error adding role. Please try again.").show();
                    }
                }
            });
        });

        $(document).on('click', '.editBtn', function () {
            const roleId = $(this).data('id');
            alert('Edit role with ID: ' + roleId);
        });

        $(document).on('click', '.deleteBtn', function () {
            const roleId = $(this).data('id');
            if (confirm('Are you sure you want to delete this role?')) {
                $.ajax({
                    url: `/api/roles/${roleId}`,
                    type: 'DELETE',
                    success: function () {
                        loadRole();
                    },
                    error: function () {
                        $('#errorAlert').text("Error deleting role. Please try again.").show();
                    }
                });
            }
        });

    });
</script>
</body>
</html>
