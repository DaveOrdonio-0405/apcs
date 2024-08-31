$(document).ready(function() {
    // Fetch users and populate the table
    $.ajax({
        url: "../adminapi/get-users",
        type: "GET",
        dataType: "json",
        success: (data) => {
            console.log("Users data:", data);
            $("#tbody-users").empty();

            $.each(data.users, (i, e) => {

                let button = `
                            <button class="btn btn-outline-success approve-user" data-id="${e.id}" data-bs-toggle="tooltip" title="Approve User">
                                <i class="fas fa-check m-1"></i>
                            </button>
                `;


                $("#tbody-users").append(`
                    <tr>
                        <td>${e.username}</td>
                        <td>${e.email}</td>
                        <td>${e.user_type}</td>
                        <td>${e.verified == 1 ? 'Yes' : 'No'}</td>
                        <td>${new Date(e.registered * 1000).toLocaleDateString()}</td>
                        <td>
                            ${e.verified == 1 ? '' : button}
                            <button class="btn btn-outline-primary edit-user" data-id="${e.id}" data-bs-toggle="tooltip" title="Edit User">
                                <i class="fas fa-edit m-1"></i>
                            </button>
                        </td>
                    </tr>
                `);
            });

            // Initialize DataTables on the table with print button
            $('#myTable').DataTable({
                dom: 'Bfrtip', // Define where the buttons should appear
                buttons: [
                    'print' // Include the print button
                ]
            });

            // Add click event listener for edit-user button
            $(".edit-user").on("click", function() {
                const userId = $(this).data('id');
                console.log("Edit User button clicked, User ID:", userId);

                // Trigger a modal with the user's data preloaded for editing
                $.ajax({
                    url: `../adminapi/get-user/${userId}`,
                    type: "GET",
                    dataType: "json",
                    success: (user) => {
                        console.log("User data retrieved:", user);

                        // Populate modal fields with user data
                        $('#editUserModal #username').val(user.username);
                        $('#editUserModal #verified').val(user.verified);
                        $('#editUserModal #userId').val(user.id);

                        // Show the modal
                        $('#editUserModal').modal('show');
                    },
                    error: (error) => {
                        console.error("Failed to retrieve user data:", error);
                        alert("Failed to retrieve user data.");
                    }
                });
            });
        },
        error: (error) => {
            console.error("Failed to retrieve users:", error);
            alert("Failed to retrieve users. Please check the console for more details.");
        }
    });

    // Save user changes when the Save button is clicked
    $("#saveUserBtn").on("click", function() {
        const userId = $('#editUserModal #userId').val();
        const username = $('#editUserModal #username').val();
        const verified = $('#editUserModal #verified').val();

        $.ajax({
            url: `../adminapi/update-user/${userId}`,
            type: "POST",
            data: {
                username: username,
                verified: verified
            },
            success: (response) => {
                alert("User updated successfully!");
                $('#editUserModal').modal('hide');
                location.reload();  // Reload the page to reflect changes
            },
            error: (error) => {
                console.error("Failed to update user:", error);
                alert("Failed to update user. Please check the console for more details.");
            }
        });
    });

});


    $(document).on("click", ".approve-user", (e)=>{

        Swal.fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, approve it!"
        }).then((result) => {
          if (result.isConfirmed) {

            $.ajax({
                url: `../adminapi/approve-user/${e.target.dataset.id}`,
                type: "POST",
                data: {
                    data: 1
                },
                beforeSend: (e) => {
                  Swal.fire({
                    html: 'Loading...',
                    didOpen: () => {
                      Swal.showLoading()
                    }
                  })
                },
                success: (response) => {
                    Swal.close();

                    Swal.fire({
                        icon: 'success',
                        title: 'User approved!',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        if (result.isConfirmed) {
                         location.reload(); 
                        }   
                    });
                },
                error: (error) => {
                    console.error("Failed to update user:", error);
                    alert("Failed to update user. Please check the console for more details.");
                }
            });

          }
        });

    })