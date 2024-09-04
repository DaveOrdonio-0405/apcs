$(document).ready(function () {
    const vaccineTypes = [
        "Pfizer-BioNTech",
        "Moderna",
        "AstraZeneca",
        "Johnson & Johnson",
        "Sinovac",
        "Covaxin",
        "Sputnik V"
    ];

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

    // Initialize Select2 with preloaded data
    function initializePatientSelect() {
        const selectData = patientsData.map(function (patient) {
            return {
                id: patient.id,
                text: patient.first_name + ' ' + patient.last_name
            };
        });

        // Destroy previous instance if exists to avoid reinitialization conflicts
        if ($.fn.select2 && $("#addPatientName").hasClass("select2-hidden-accessible")) {
            $("#addPatientName").select2('destroy');
        }

        $("#addPatientName").select2({
            placeholder: "Search for a patient",
            width: '100%',
            data: selectData,  // Use preloaded data for Select2
            allowClear: true,
            dropdownParent: $('#addVaccinationModal')  // Specify the modal as the dropdown parent
        });
    }

    function populateVaccineTypeDropdown(selector, selectedType = "") {
        let options = '<option value="">Select Vaccine Type</option>';
        vaccineTypes.forEach(function (type) {
            const isSelected = type === selectedType ? "selected" : "";
            options += `<option value="${type}" ${isSelected}>${type}</option>`;
        });
        $(selector).html(options);
    }

    function attachEventHandlers() {
        $(".edit-vaccination").on("click", function () {
            const vaccinationId = $(this).data('id');

            $.ajax({
                url: `../adminapi/get-vaccination/${vaccinationId}`,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('#editVaccinationId').val(data.id);
                    $('#editPatientId').val(data.patient_id);
                    $('#editPatientName').val(data.patient_name);
                    populateVaccineTypeDropdown("#editVaccineType", data.vaccine_type);
                    $('#editDateOfVaccination').val(data.date_of_vaccination);
                    $('#editNextDueDate').val(data.next_due_date);

                    $('#editVaccinationModal').modal('show');
                },
                error: function (xhr, status, error) {
                    console.error("Error occurred while fetching vaccination data:", xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while fetching the vaccination data. Please try again.',
                        confirmButtonText: 'Ok'
                    });
                }
            });
        });

        $(".delete-vaccination").on("click", function () {
            const vaccinationId = $(this).data('id');

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
                        url: `../adminapi/delete-vaccination/${vaccinationId}`,
                        type: "DELETE",
                        success: function (response) {
                            if (response.status === 1) {
                                Swal.fire(
                                    'Deleted!',
                                    'The vaccination record has been deleted.',
                                    'success'
                                ).then(() => {
                                    location.reload();
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
                            console.error("Error occurred while deleting vaccination:", xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while deleting the vaccination. Please try again.',
                                confirmButtonText: 'Ok'
                            });
                        }
                    });
                }
            });
        });
    }

    // Fetch vaccination records
    $.ajax({
        url: "../adminapi/get-vaccinations",
        type: "GET",
        dataType: "json",
        success: function (response) {
            $("#tbody-vaccinations").empty();
            $.each(response.vaccinations, function (index, vaccination) {
                $("#tbody-vaccinations").append(`
                    <tr>
                        <td>${vaccination.id}</td>
                        <td>${vaccination.patient_name}</td>
                        <td>${vaccination.vaccine_type}</td>
                        <td>${vaccination.date_of_vaccination}</td>
                        <td>${vaccination.next_due_date || '-'}</td>
                        <td>
                            <button class="btn btn-outline-primary edit-vaccination" data-id="${vaccination.id}" title="Edit Vaccination">
                                <i class="fas fa-edit m-1"></i>
                            </button>
                            <button class="btn btn-outline-danger delete-vaccination" data-id="${vaccination.id}" title="Delete Vaccination">
                                <i class="fas fa-trash m-1"></i>
                            </button>
                        </td>
                    </tr>
                `);
            });

            attachEventHandlers();
        },
        error: function (xhr, status, error) {
            console.error("Error occurred while fetching vaccinations:", xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while fetching the vaccinations. Please try again.',
                confirmButtonText: 'Ok'
            });
        }
    });

    $("#addVaccinationBtn").on("click", function () {
        $('#addVaccinationModal').modal('show');
    });

    $("#saveAddVaccinationBtn").on("click", function () {
        const vaccinationData = {
            patient_id: $('#addPatientName').val(),
            vaccine_type: $('#addVaccineType').val(),
            date_of_vaccination: $('#addDateOfVaccination').val(),
            next_due_date: $('#addNextDueDate').val()
        };

        if (!vaccinationData.patient_id || !vaccinationData.vaccine_type || !vaccinationData.date_of_vaccination) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'All fields are required.',
                confirmButtonText: 'Ok'
            });
            return;
        }

        $.ajax({
            url: "../adminapi/add-vaccination",
            type: "POST",
            data: JSON.stringify(vaccinationData),
            contentType: "application/json",
            dataType: "json",
            success: function (response) {
                if (response.status === 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Vaccination added successfully!',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#addVaccinationModal').modal('hide');
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to add vaccination',
                        text: response.message,
                        confirmButtonText: 'Ok'
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error("Error occurred while adding vaccination:", xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while adding the vaccination. Please try again.',
                    confirmButtonText: 'Ok'
                });
            }
        });
    });

    // Load Patient Data on Page Load
    loadPatientData();

    // Initialize Vaccine Type Dropdowns
    populateVaccineTypeDropdown("#addVaccineType");
    populateVaccineTypeDropdown("#editVaccineType");
});
