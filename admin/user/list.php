<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<style>
    .user-avatar{
        width:3rem;
        height:3rem;
        object-fit:scale-down;
  		});
	}
</script>t-position:center center;
    }
	
	/* Age validation modal styling */
	#ageValidationModal .modal-header {
		border-bottom: 2px solid #ffc107;
	}
	
	#ageValidationModal .table th {
		background-color: #f8f9fa;
		font-weight: bold;
	}
	
	#ageValidationModal .alert-warning {
		border-left: 4px solid #ffc107;
	}
</style>
<div class="card card-outline rounded-0 card-navy">
	<div class="card-header">
		<h3 class="card-title">List of Sangguniang Kabataan</h3>
		<div class="card-tools">
			<a href="./?page=user/manage_user" id="create_new" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
		</div>
	</div>
	<div class="card-body">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="12%">
					<col width="12%">
					<col width="20%">
					<col width="15%">
					<col width="12%">
					<col width="12%">
					<col width="12%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Date Updated</th>
						<th>Avatar</th>
						<th>Name</th>
						<th>Zone/Purok</th>
						<th>Username</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					$qry = $conn->query("SELECT *, concat(firstname,' ', coalesce(concat(middlename,' '), '') , lastname) as `name` from `users` where id != '{$_settings->userdata('id')}' order by concat(firstname,' ', lastname) asc ");
					while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date("Y-m-d H:i",strtotime($row['date_updated'])) ?></td>
							<td class="text-center">
                                <img src="<?= validate_image($row['avatar']) ?>" alt="" class="img-thumbnail rounded-circle user-avatar">
                            </td>
							<td><?php echo $row['name'] ?></td>
							<td><?php echo isset($row['zone']) ? $row['zone'] : 'N/A'; ?></td>
							<td><?php echo $row['username'] ?></td>
							<td class="text-center">
                                <?php if(isset($row['status']) && $row['status'] == 1): ?>
                                    <span class="badge badge-success">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Deactivated</span>
                                <?php endif; ?>
                            </td>
							<td align="center">
								 <button type="button" class="btn btn-flat p-1 btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item" href="./?page=user/manage_user&id=<?= $row['id'] ?>"><span class="fa fa-edit text-dark"></span> Edit</a>
				                    <div class="dropdown-divider"></div>
				                    <?php if(isset($row['status']) && $row['status'] == 1): ?>
				                    	<a class="dropdown-item toggle_status" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-status="0"><span class="fa fa-toggle-off text-danger"></span> Deactivate</a>
				                    <?php else: ?>
				                    	<a class="dropdown-item toggle_status" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-status="1"><span class="fa fa-toggle-on text-success"></span> Activate</a>
				                    <?php endif; ?>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Age Validation Modal -->
<div class="modal fade" id="ageValidationModal" tabindex="-1" role="dialog" aria-labelledby="ageValidationModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-warning">
				<h4 class="modal-title" id="ageValidationModalLabel">
					<i class="fas fa-exclamation-triangle"></i> Age Validation Alert
				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="alert alert-warning">
					<h5><i class="fas fa-info-circle"></i> Notice:</h5>
					The following Sangguniang Kabataan members are 31 years old or older and need to be deactivated according to age requirements:
				</div>
				<div id="usersOver31List">
					<!-- Users list will be populated here -->
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">
					<i class="fas fa-times"></i> Cancel
				</button>
				<button type="button" class="btn btn-info" id="skipValidationBtn" data-dismiss="modal">
					<i class="fas fa-clock"></i> Skip for Now
				</button>
				<button type="button" class="btn btn-danger" id="deactivateUsersBtn">
					<i class="fas fa-user-times"></i> Deactivate These Users
				</button>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		// Check for users over 31 when page loads
		checkUsersOver31();
		
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this User permanently?","delete_user",[$(this).attr('data-id')])
		})
		$('.toggle_status').click(function(){
			var status = $(this).attr('data-status');
			var message = status == 1 ? "Are you sure to activate this User?" : "Are you sure to deactivate this User?";
			_conf(message,"toggle_user_status",[$(this).attr('data-id'), status])
		})
		$('.table').dataTable({
			columnDefs: [
				{ orderable: false, targets: [7] } // Action column is now index 7
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
		
		// Handle deactivate users button click
		$('#deactivateUsersBtn').click(function(){
			deactivateUsersOver31();
		});
		
		// Handle skip validation button click
		$('#skipValidationBtn').click(function(){
			sessionStorage.setItem('ageValidationSkipped', 'true');
		});
	})
	
	function checkUsersOver31(){
		// Check if admin has skipped this validation in current session
		if(sessionStorage.getItem('ageValidationSkipped') === 'true') {
			return;
		}
		
		$.ajax({
			url: _base_url_ + "classes/Users.php?f=get_users_over_31",
			method: "GET",
			dataType: "json",
			success: function(resp){
				if(resp && resp.length > 0){
					var usersList = '<div class="table-responsive"><table class="table table-striped table-bordered"><thead><tr><th>Name</th><th>Age</th></tr></thead><tbody>';
					resp.forEach(function(user){
						usersList += '<tr><td>' + user.firstname + ' ' + user.lastname + '</td><td>' + user.age + ' years old</td></tr>';
					});
					usersList += '</tbody></table></div>';
					$('#usersOver31List').html(usersList);
					$('#ageValidationModal').modal('show');
				}
			},
			error: function(err){
				console.log('Error checking users over 31:', err);
			}
		});
	}
	
	function deactivateUsersOver31(){
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Users.php?f=check_age",
			method: "POST",
			success: function(resp){
				if(resp > 0){
					alert_toast(resp + " user(s) have been deactivated due to age requirements.", 'success');
					$('#ageValidationModal').modal('hide');
					setTimeout(function(){
						location.reload();
					}, 1500);
				} else {
					alert_toast("No users were deactivated.", 'info');
					$('#ageValidationModal').modal('hide');
				}
				end_loader();
			},
			error: function(err){
				console.log(err);
				alert_toast("An error occurred while deactivating users.", 'error');
				end_loader();
			}
		});
	}
	function delete_user($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Users.php?f=delete",
			method:"POST",
			data:{id: $id},
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(resp == 1){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
	
	function toggle_user_status($id, $status){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Users.php?f=toggle_status",
			method:"POST",
			data:{id: $id, status: $status},
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(resp == 1){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>
