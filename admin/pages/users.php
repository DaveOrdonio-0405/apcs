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


<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editUserForm">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username">
          </div>
          <div class="mb-3">
            <label for="verified" class="form-label">Verified</label>
            <select class="form-control" id="verified" name="verified">
              <option value="1">Yes</option>
              <option value="0">No</option>
            </select>
          </div>
          <input type="hidden" id="userId" name="userId">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveUserBtn">Save changes</button>
      </div>
    </div>
  </div>
</div>
