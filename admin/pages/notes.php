<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-notes-medical"></i> Manage Patient Notes</h2>
    <button class="btn btn-primary mb-3" id="addNoteBtn">Add Note</button>

    <div class="table-responsive">
        <table id="notesTable" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient</th>
                    <th>Note</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tbody-notes">
                <!-- Notes data will be populated here via AJAX -->
            </tbody>
        </table>
    </div>
</div>

<!-- Add Note Modal -->
<div class="modal fade" id="addNoteModal" tabindex="-1" aria-labelledby="addNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNoteModalLabel">Add Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addNoteForm">
                    <div class="mb-3">
                        <label for="addPatientName" class="form-label">Patient Name</label>
                        <select class="form-control" id="addPatientName" required></select>
                    </div>
                    <div class="mb-3">
                        <label for="addNoteText" class="form-label">Note</label>
                        <textarea class="form-control" id="addNoteText" rows="4" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveAddNoteBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Patient Notes Modal -->
<div class="modal fade" id="editPatientNotesModal" tabindex="-1" aria-labelledby="editPatientNotesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPatientNotesModalLabel">Edit Patient Notes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPatientNotesForm">
                    <!-- Hidden field for note ID -->
                    <input type="hidden" id="editNoteId">

                    <!-- Display Patient Name as readonly -->
                    <div class="mb-3">
                        <label for="editPatientName" class="form-label">Patient Name</label>
                        <input type="text" class="form-control" id="editPatientName" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="editPatientNote" class="form-label">Notes</label>
                        <textarea class="form-control" id="editPatientNote" rows="4" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveEditPatientNotesBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>

