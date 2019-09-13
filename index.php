<?php include "layouts/head.php"; ?>
<div class="row">
	<div class="col-12 mt-5">
		<button class="btn btn-success mb-2" data-toggle="modal" data-target="#global-modal" data-source="add-customer">Add Customer</button>
		<div id="successMessage">
			
		</div>
		<table class="table table-bordered table-stripped" id="data-table">
			<thead>
				<tr>
					<th>No</th>
					<th>Name</th>
					<th>Email</th>
					<th>Gender</th>
					<th>Is Married</th>
					<th>Address</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody/></tbody>
		</table>
	</div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="global-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div id="err">
      		
      	</div>
      	<form autocomplete="off" id="form">
      	  <div class="form-group">
      	    <input type="hidden" class="form-control" id="id" name="id" placeholder="Enter name">
      	    <label for="name">Name</label>
      	    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" readonly="true">
      	  </div>
      	  <div class="form-group">
      	    <label for="email">Email</label>
      	    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" readonly="true">
      	  </div>
      	  <div class="form-group">
      	    <label for="password">Password</label>
      	    <input type="password" class="form-control" id="password" name="password" placeholder="Password" readonly="true">
      	  </div>
      	  
      	  <div class="form-group">
      	    <label for="gender">Gender : </label>
      	    <div class="form-check form-check-inline">
      	      <input class="form-check-input gender" type="radio" name="gender" value="M" disabled="true" checked >
      	      <label class="form-check-label gender" for="male">
      	        Male
      	      </label>
      	    </div>
      	    <div class="form-check form-check-inline">
      	      <input class="form-check-input" type="radio" name="gender" value="F" disabled="true">
      	      <label class="form-check-label" for="female">
      	        Female
      	      </label>
      	    </div>
      	  </div>
      	  <div class="form-group">
      	    <label for="marital">Is Married : </label>
      	    <div class="form-check form-check-inline">
      	      <input class="form-check-input is_married" type="radio" name="is_married" value="N" disabled="true">
      	      <label class="form-check-label" for="male">
      	        No
      	      </label>
      	   	</div>
      	   	<div class="form-check form-check-inline">
      	      <input class="form-check-input is_married" type="radio" name="is_married" value="Y" disabled ="true">
      	      <label class="form-check-label" for="female">
      	        Yes
      	      </label>
      	    </div>
      	  </div>
      	  <div class="form-group">
      	    <label for="address">Address</label>
      	    <textarea class="form-control" id="address" name="address" placeholder="address" readonly="true"></textarea>
      	  </div>
      	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary switchbtn" id="btnEdit">Edit</button>
        <button type="button" class="btn btn-success switchbtn" id="btnSave">Save</button>
        <button type="button" class="btn btn-success switchbtn" id="btnUpdate">Update</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php include "layouts/footer.php"; ?>
      
    
