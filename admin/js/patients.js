$(document).ready(function () {
  // Fetch patients and populate the table
  fetchPatients();

  // Function to fetch patients and populate the table
  function fetchPatients() {
      $.ajax({
          url: "../adminapi/get-patients",
          type: "GET",
          dataType: "json",
          success: function (data) {
              $("#tbody-patients").empty();
              $.each(data.patients, function (i, patient) {
                  $("#tbody-patients").append(`
                      <tr>
                          <td>${patient.id}</td>
                          <td>${patient.first_name} ${patient.last_name}</td>
                          <td>${patient.email}</td>
                          <td>${patient.phone_number}</td>
                          <td>${patient.date_of_birth}</td>
                          <td>
                              <button class="btn btn-outline-primary edit-patient" data-id="${patient.id}"><i class="fas fa-edit"></i> Edit</button>
                              <button class="btn btn-outline-danger delete-patient" data-id="${patient.id}"><i class="fas fa-trash-alt"></i> Delete</button>
                          </td>
                      </tr>
                  `);
              });

              // Attach event handlers after loading data
              attachEventHandlers();
          },
          error: function (xhr, status, error) {
              console.error("Failed to retrieve patients:", xhr.responseText);
              alert("Failed to fetch patients. Please check the console for more details.");
          }
      });
  }

  // Function to attach event handlers to dynamically loaded elements
  function attachEventHandlers() {
      // Edit patient button click handler
      $(".edit-patient").on("click", function () {
          const patientId = $(this).data('id');

          // Fetch patient data and populate the form for editing
          $.ajax({
              url: `../adminapi/get-patient/${patientId}`,
              type: "GET",
              dataType: "json",
              success: function (patient) {
                  $('#patientId').val(patient.id);
                  $('#firstName').val(patient.first_name);
                  $('#lastName').val(patient.last_name);
                  $('#email').val(patient.email);
                  $('#phone').val(patient.phone_number);
                  $('#dob').val(patient.date_of_birth);
                  $('#patientModal').modal('show'); // Show the modal after data is loaded
              },
              error: function (xhr, status, error) {
                  console.error("Failed to retrieve patient data:", xhr.responseText);
                  alert("Failed to retrieve patient data.");
              }
          });
      });

      // Delete patient button click handler
      $(".delete-patient").on("click", function () {
          const patientId = $(this).data('id');

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
                      url: `../adminapi/delete-patient/${patientId}`,
                      type: "DELETE",
                      dataType: "json",
                      success: function (response) {
                          Swal.fire('Deleted!', 'The patient has been deleted.', 'success');
                          fetchPatients(); // Refresh the patient list
                      },
                      error: function (xhr, status, error) {
                          console.error("Failed to delete patient:", xhr.responseText);
                          Swal.fire('Error!', 'Failed to delete the patient. Please try again.', 'error');
                      }
                  });
              }
          });
      });
  }

  // Add Patient button click handler
  $("#addPatientBtn").on("click", function () {
      // Clear form for adding a new patient
      $('#patientForm')[0].reset();
      $('#patientId').val('');
      $('#patientModal').modal('show');
  });

  // Save changes button click handler (for both adding and editing)
  $("#savePatientBtn").on("click", function () {
      const patientId = $('#patientId').val();
      const patientData = {
          first_name: $('#firstName').val(),
          last_name: $('#lastName').val(),
          email: $('#email').val(),
          phone_number: $('#phone').val(),
          date_of_birth: $('#dob').val()
      };

      const url = patientId ? `../adminapi/update-patient/${patientId}` : "../adminapi/add-patient";
      const method = patientId ? "POST" : "POST";

      // Send AJAX request to add or update the patient
      $.ajax({
          url: url,
          type: method,
          data: patientData,
          dataType: "json",
          success: function (response) {
              if (response.status === 1) {
                  Swal.fire({
                      icon: 'success',
                      title: patientId ? 'Patient updated successfully!' : 'Patient added successfully!',
                      confirmButtonText: 'Ok'
                  }).then((result) => {
                      if (result.isConfirmed) {
                          $('#patientModal').modal('hide'); // Hide the modal
                          fetchPatients(); // Refresh the patient list without reloading the page
                      }
                  });
              } else {
                  Swal.fire({
                      icon: 'error',
                      title: 'Failed to save patient',
                      text: response.message,
                      confirmButtonText: 'Ok'
                  });
              }
          },
          error: function (xhr, status, error) {
              console.error("Error occurred while saving patient:", xhr.responseText);
              Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'An error occurred while saving the patient. Please try again.',
                  confirmButtonText: 'Ok'
              });
          }
      });
  });
});
