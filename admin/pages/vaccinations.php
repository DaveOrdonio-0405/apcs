<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-syringe"></i> Manage Vaccination Records</h2>
    <button class="btn btn-primary mb-3" id="addVaccinationBtn">Add Vaccination Record</button>

    <div class="table-responsive">
        <table id="vaccinationsTable" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient</th>
                    <th>Vaccine Type</th>
                    <th>Date of Vaccination</th>
                    <th>Next Due Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tbody-vaccinations">
                <!-- Vaccination data will be populated here via AJAX -->
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Vaccination Modal -->
<div class="modal fade" id="editVaccinationModal" tabindex="-1" aria-labelledby="editVaccinationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editVaccinationModalLabel">Edit Vaccination Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editVaccinationForm">
                    <!-- Hidden fields for vaccination and patient ID -->
                    <input type="hidden" id="editVaccinationId">
                    <input type="hidden" id="editPatientId">

                    <!-- Display Patient Name Instead of Dropdown -->
                    <div class="mb-3">
                        <label for="editPatientName" class="form-label">Patient Name</label>
                        <input type="text" class="form-control" id="editPatientName" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="editVaccineType" class="form-label">Vaccine Type</label>
                        <select class="form-control" id="editVaccineType" required></select>
                    </div>
                    <div class="mb-3">
                        <label for="editDateOfVaccination" class="form-label">Date of Vaccination</label>
                        <input type="date" class="form-control" id="editDateOfVaccination" required>
                    </div>
                    <div class="mb-3">
                        <label for="editNextDueDate" class="form-label">Next Due Date</label>
                        <input type="date" class="form-control" id="editNextDueDate">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveEditVaccinationBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Vaccination Modal -->
<div class="modal fade" id="addVaccinationModal" tabindex="-1" aria-labelledby="addVaccinationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addVaccinationModalLabel">Add Vaccination Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addVaccinationForm">
                    <!-- Patient Name Select2 Dropdown -->
                    <div class="mb-3">
                        <label for="addPatientName" class="form-label">Patient Name</label>
                        <select class="form-control" id="addPatientName" required></select>
                    </div>
                    <div class="mb-3">
                        <label for="addVaccineType" class="form-label">Vaccine Type</label>
                        <select class="form-control" id="addVaccineType" required></select>
                    </div>
                    <div class="mb-3">
                        <label for="addDateOfVaccination" class="form-label">Date of Vaccination</label>
                        <input type="date" class="form-control" id="addDateOfVaccination" required>
                    </div>
                    <div class="mb-3">
                        <label for="addNextDueDate" class="form-label">Next Due Date</label>
                        <input type="date" class="form-control" id="addNextDueDate">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveAddVaccinationBtn">Add Record</button>
            </div>
        </div>
    </div>
</div>
