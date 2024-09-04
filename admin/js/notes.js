$(document).ready(function () {
    let patientsData = [];

    // Fetch all patients data on page load
    function loadPatientData() {
        $.ajax({
            url: "../adminapi/get-patients",  // Adjust the URL based on your setup
            type: "GET",
            dataType: 'json',
            success: function (data) {
                patientsData = data.patients;  // Store fetched data globally
                console.log("Patients loaded:", patientsData);  // Debugging output
                initializePatientSelect();  // Initialize Select2 after loading patients data
            },
            error: function (xhr, status, error) {
                console.error("Error occurred while fetching patients:", xhr.responseText);
            }
        });
    }

    // Initialize Select2 for Patient Name in Add Note Modal
    function initializePatientSelect() {
        $("#addPatientName").select2({
            placeholder: "Search for a patient",
            width: '100%',  // Ensure the Select2 dropdown has proper width
            dropdownParent: $('#addNoteModal'),  // Ensure dropdown works inside the modal
            data: patientsData.map(function (patient) {  // Load patient data into Select2
                return {
                    id: patient.id,  // This should be the patient's ID
                    text: patient.first_name + ' ' + patient.last_name // Display full name
                };
            })
        });
    }

    // Fetch notes records and display them in the table
    function fetchNotes() {
        $.ajax({
            url: "../adminapi/get-notes",
            type: "GET",
            dataType: "json",
            success: function (response) {
                $("#tbody-notes").empty();  // Clear the existing table rows
                $.each(response.notes, function (index, note) {
                    $("#tbody-notes").append(`
                        <tr>
                            <td>${note.id}</td>
                            <td>${note.patient_name}</td>
                            <td>${note.note}</td>
                            <td>
                                <button class="btn btn-outline-primary edit-note" data-id="${note.id}" title="Edit Note">
                                    <i class="fas fa-edit m-1"></i>
                                </button>
                                <button class="btn btn-outline-danger delete-note" data-id="${note.id}" title="Delete Note">
                                    <i class="fas fa-trash m-1"></i>
                                </button>
                            </td>
                        </tr>
                    `);
                });

                attachEventHandlers();  // Attach event handlers for edit and delete buttons
            },
            error: function (xhr, status, error) {
                console.error("Error occurred while fetching notes:", xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while fetching the notes. Please try again.',
                    confirmButtonText: 'Ok'
                });
            }
        });
    }

    // Attach event handlers for edit, delete, and save buttons
    function attachEventHandlers() {
        // Edit note button click
        $(".edit-note").on("click", function () {
            const noteId = $(this).data('id');

            // Fetch note data and populate the form
            $.ajax({
                url: `../adminapi/get-note/${noteId}`,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('#editNoteId').val(data.id);
                    $('#editPatientName').val(data.patient_name);  // Display patient name as readonly
                    $('#editPatientNote').val(data.note);

                    // Show the modal
                    $('#editPatientNotesModal').modal('show');
                },
                error: function (xhr, status, error) {
                    console.error("Error occurred while fetching note data:", xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while fetching the note data. Please try again.',
                        confirmButtonText: 'Ok'
                    });
                }
            });
        });

        // Save changes button click in the Edit Notes Modal
        $("#saveEditPatientNotesBtn").on("click", function () {
            const noteId = $('#editNoteId').val();  // Get note ID
            const noteText = $('#editPatientNote').val();  // Get note text

            // Ensure all fields are filled
            if (!noteText) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'The note field is required.',
                    confirmButtonText: 'Ok'
                });
                return;
            }

            const noteData = {
                note: noteText
            };

            // Send AJAX request to update the note
            $.ajax({
                url: `../adminapi/update-note/${noteId}`,
                type: "PUT",  // Ensure this is PUT
                contentType: "application/json",
                data: JSON.stringify(noteData),
                dataType: "json",
                success: function (response) {
                    if (response.status === 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Note updated successfully!',
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#editPatientNotesModal').modal('hide');
                                fetchNotes();  // Reload notes after updating
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed to update note',
                            text: response.message,
                            confirmButtonText: 'Ok'
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error occurred while updating note:", xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while updating the note. Please try again.',
                        confirmButtonText: 'Ok'
                    });
                }
            });
        });

        // Delete note button click
        $(".delete-note").on("click", function () {
            const noteId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `../adminapi/delete-note/${noteId}`,
                        type: "DELETE",
                        success: function (response) {
                            if (response.status === 1) {
                                Swal.fire(
                                    'Deleted!',
                                    'The note has been deleted.',
                                    'success'
                                ).then(() => {
                                    fetchNotes();  // Reload notes after deletion
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed to delete',
                                    text: response.message,
                                    confirmButtonText: 'Ok'
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error("Error occurred while deleting note:", xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while deleting the note. Please try again.',
                                confirmButtonText: 'Ok'
                            });
                        }
                    });
                }
            });
        });
    }

    // Add Note button click
    $("#addNoteBtn").on("click", function () {
        $('#addNoteModal').modal('show');  // Show the modal
    });

    // Save Note button click in Add Note Modal
    $("#saveAddNoteBtn").on("click", function () {
        const noteData = {
            patient_id: $('#addPatientName').val(),  // Get patient ID from Select2
            note: $('#addNoteText').val()
        };

        // Validate required fields
        if (!noteData.patient_id || !noteData.note) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'All fields are required.',
                confirmButtonText: 'Ok'
            });
            return;
        }

        // Send AJAX request to add note
        $.ajax({
            url: "../adminapi/add-note",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(noteData),
            dataType: "json",
            success: function (response) {
                if (response.status === 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Note added successfully!',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#addNoteModal').modal('hide');
                            fetchNotes();  // Reload notes after adding
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to add note',
                        text: response.message,
                        confirmButtonText: 'Ok'
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error("Error occurred while adding note:", xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while adding the note. Please try again.',
                    confirmButtonText: 'Ok'
                });
            }
        });
    });

    // Load patients data and fetch notes on page load
    loadPatientData();  // Load patients data on page load
    fetchNotes();  // Fetch notes data on page load
});
