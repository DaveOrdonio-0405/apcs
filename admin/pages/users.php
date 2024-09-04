<div class="row">
	
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
			<h2><i class='fas fa-book m-1' style='color:#664400'></i> Users</h2>
			</div>
			<div class="card-body">
				<div class="table-responsive">
				<table id="myTable" class="table table-striped">
    <thead>
        <tr class="table-primary">
            <th>Username</th>    
            <th>Email</th>    
            <th>User type</th>
            <th>Verified</th>
            <th>Date Created</th>
            <th>Tools</th>
        </tr>
    </thead>
    <tbody id="tbody-users">
        <!-- User data will be appended here -->
    </tbody>    
</table>
				</div>
			</div>
		</div>
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
                    <!-- Hidden field for vaccination ID -->
                    <input type="hidden" id="editVaccinationId">

                    <!-- Display Patient Name in a readonly field -->
                    <div class="mb-3">
                        <label for="editPatientName" class="form-label">Patient Name</label>
                        <input type="text" class="form-control" id="editPatientName" readonly>
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

