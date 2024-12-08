
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {

        // Load roles into the role select dropdown
        function loadRoles() {
            $.ajax({
                url: '/api/roles',  // Assuming this endpoint fetches roles
                type: 'GET',
                success: function (response) {
                    let roleOptions = '';
                    response.data.forEach(role => {
                        roleOptions += `<option value="${role.id}">${role.role_name}</option>`;
                    });
                    $('select[name="role_id"]').html(roleOptions);
                }
            });
        }

        // Load users into the table
        function loadUsers() {
            $.ajax({
                url: '/api/users',  // Assuming this endpoint fetches users
                type: 'GET',
                success: function (response) {
                    let tableData = '';
                    response.data.forEach(user => {
                        const roleName = user.role_info && user.role_info.role_name ? user.role_info.role_name : 'Role Not Found';
                        tableData += `<tr>
                            <td>${user.name}</td>
                            <td>${user.email}</td>
                            <td>${user.phone}</td>
                            <td>${roleName}</td>
                             <td>
                                <button class="btn btn-warning btn-sm editBtn" data-id="${user.id}">Edit</button>
                                <button class="btn btn-danger btn-sm deleteBtn" data-id="${user.id}">Delete</button>
                            </td>
                        </tr>`;
                    });
                    $('#userTable').html(tableData);
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching users:', error);
                    alert('Failed to load users. Please try again later.');
                }
            });
        }

        // Initial load of roles and users
        loadRoles();
        loadUsers();

        // Submit form to create a new user
        $('#userForm').on('submit', function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            const dynamic_url = $('#userId').val() ? `/api/users/${$('#userId').val()}` : '/api/users';  // Determine URL based on whether it's create or edit
            const dynamic_method = $('#userId').val() ? 'PUT' : 'POST';
            $.ajax({
                url: dynamic_url,  // Assuming this endpoint stores the user data
                method: dynamic_method,
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    loadUsers();
                    $('#userForm')[0].reset();
                    $('#errorAlert').hide();
                    $('#formTitle').text('User Form');
                    $('#submitBtn').text('Submit');
                    $('#userId').val('');
                },
                error: function (response) {
                    if (response.status === 422) {

                        const errors = response.responseJSON.errors;
                        let errorMessages = '';
                        for (let field in errors) {
                            errorMessages += `<p><strong>${field}:</strong> ${errors[field].join(', ')}</p>`;
                        }
                        $('#errorAlert').html(errorMessages).show();

                    } else {
                        alert('Error adding user');
                    }
                }
            });
        });

        // Edit user (can be expanded based on backend logic)
        $(document).on('click', '.editBtn', function () {
            const userId = $(this).data('id');
            $.ajax({
                url: `/api/users/${userId}`,
                type: 'GET',
                success: function (response) {
                    const user = response.data;
                    $('#formTitle').text('Edit User');
                    $('#submitBtn').text('Update');
                    $('#userId').val(user.id);
                    $('#userName').val(user.name);
                    $('#userEmail').val(user.email);
                    $('#userPhone').val(user.phone);
                    $('#userDescription').val(user.description);
                    $('#userRole').val(user.role_id);
                },
                error: function () {
                    alert('Error fetching user data');
                }
            });
        });

        // Delete user
        $(document).on('click', '.deleteBtn', function () {
            const userId = $(this).data('id');
            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    url: `/api/users/${userId}`,
                    type: 'DELETE',
                    success: function (response) {
                        loadUsers();  // Reload the user list after deletion
                    },
                    error: function () {
                        alert('Error deleting user');
                    }
                });
            }
        });

    });

$('#userImage').on('change', function (e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (event) {
            $('#imagePreview').attr('src', event.target.result).show();
        };
        reader.readAsDataURL(file);
    } else {
        $('#imagePreview').hide();
    }
});

</script>
