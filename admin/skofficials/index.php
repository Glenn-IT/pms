<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<style>
    .official-avatar{
        width:80px;
        height:80px;
        object-fit:cover;
        border-radius:50%;
    }
    .official-card {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        background-color: #fff;
    }
    .chairman-card {
        border-color: #007bff;
        background-color: #f8f9ff;
    }
    .councilor-card {
        border-color: #28a745;
        background-color: #f8fff9;
    }
</style>

<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">
			SK Officials 
			<?php if($_settings->userdata('type') == 1): ?>
				Management
			<?php else: ?>
				<small class="text-muted">(View Only)</small>
			<?php endif; ?>
		</h3>
		<?php if($_settings->userdata('type') == 1): ?>
		<div class="card-tools">
			<button class="btn btn-primary btn-sm" type="button" id="create_new">
				<i class="fa fa-plus"></i> Add Official
			</button>
		</div>
		<?php endif; ?>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<?php 
			$qry = $conn->query("SELECT * FROM `sk_officials` WHERE status = 1 ORDER BY CASE WHEN position = 'chairman' THEN 1 ELSE 2 END, firstname, lastname");
			if($qry->num_rows > 0):
			?>
			<div class="row">
				<?php while($row = $qry->fetch_assoc()): 
					$full_name = trim($row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname']);
					$position_display = ucfirst($row['position']);
				?>
				<div class="col-lg-4 col-md-6">
					<div class="official-card <?php echo $row['position'] == 'chairman' ? 'chairman-card' : 'councilor-card' ?>">
						<div class="row">
							<div class="col-4">
								<?php if(!empty($row['image_path']) && file_exists('../uploads/sk_officials/'.$row['image_path'])): ?>
									<img src="../uploads/sk_officials/<?php echo $row['image_path'] ?>" alt="Official Image" class="official-avatar">
								<?php else: ?>
									<div class="official-avatar bg-secondary d-flex align-items-center justify-content-center">
										<i class="fa fa-user text-white fa-2x"></i>
									</div>
								<?php endif; ?>
							</div>
							<div class="col-8">
								<h5 class="mb-1"><?php echo htmlspecialchars($full_name) ?></h5>
								<p class="mb-1"><strong>SK <?php echo $position_display ?></strong></p>
								<p class="mb-1"><small>Zone: <?php echo htmlspecialchars($row['zone']) ?></small></p>
								<?php if(!empty($row['date_of_birth'])): 
									$age = date_diff(date_create($row['date_of_birth']), date_create('today'))->y;
								?>
								<p class="mb-1"><small>Age: <?php echo $age ?></small></p>
								<?php endif; ?>
								<p class="mb-1"><small>Contact: <?php echo htmlspecialchars($row['contact']) ?></small></p>
								<?php if($_settings->userdata('type') == 1): ?>
								<div class="mt-2">
									<button class="btn btn-sm btn-outline-primary edit_data" data-id="<?php echo $row['id'] ?>">
										<i class="fa fa-edit"></i> Edit
									</button>
									<button class="btn btn-sm btn-outline-danger delete_data" data-id="<?php echo $row['id'] ?>">
										<i class="fa fa-trash"></i> Delete
									</button>
								</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<?php endwhile; ?>
			</div>
			<?php else: ?>
			<div class="text-center">
				<p>No SK Officials found.</p>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	<?php if($_settings->userdata('type') == 1): ?>
	$('#create_new').click(function(){
		uni_modal("Add New SK Official","skofficials/manage_official.php")
	})
	$('.edit_data').click(function(){
		uni_modal("Edit SK Official","skofficials/manage_official.php?id="+$(this).attr('data-id'))
	})
	$('.delete_data').click(function(){
		_conf("Are you sure to delete this SK Official permanently?","delete_official",[$(this).attr('data-id')])
	})
	<?php endif; ?>
})
<?php if($_settings->userdata('type') == 1): ?>
function delete_official($id){
	start_loader();
	$.ajax({
		url:_base_url_+"classes/Master.php?f=delete_official",
		method:"POST",
		data:{id: $id},
		dataType:"json",
		error:err=>{
			console.log(err)
			alert_toast("An error occured.",'error');
			end_loader();
		},
		success:function(resp){
			if(typeof resp== 'object' && resp.status == 'success'){
				location.reload();
			}else{
				alert_toast("An error occured.",'error');
				end_loader();
			}
		}
	})
}
<?php endif; ?>
</script>
