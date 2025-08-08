<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<style>
    .official-avatar{
        width: 90px;
        height: 90px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .official-avatar:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }
    
    .official-card {
        border: none;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 25px;
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .official-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        transition: height 0.3s ease;
    }
    
    .official-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }
    
    .official-card:hover::before {
        height: 6px;
    }
    
    .chairman-card {
        background: linear-gradient(135deg, #fff 0%, #e3f2fd 100%);
        border-left: 5px solid #2196f3;
    }
    
    .chairman-card::before {
        background: linear-gradient(90deg, #2196f3 0%, #1976d2 100%);
    }
    
    .councilor-card {
        background: linear-gradient(135deg, #fff 0%, #e8f5e8 100%);
        border-left: 5px solid #4caf50;
    }
    
    .councilor-card::before {
        background: linear-gradient(90deg, #4caf50 0%, #388e3c 100%);
    }
    
    .official-name {
        font-size: 1.3rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }
    
    .official-position {
        font-size: 1rem;
        font-weight: 500;
        color: #667eea;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .official-info {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
    }
    
    .official-info i {
        margin-right: 8px;
        width: 16px;
        color: #667eea;
    }
    
    .btn-modern {
        border-radius: 25px;
        padding: 8px 20px;
        font-weight: 500;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        border: none;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .btn-edit {
        background: linear-gradient(45deg, #667eea, #764ba2);
        color: white;
        margin-right: 8px;
    }
    
    .btn-edit:hover {
        background: linear-gradient(45deg, #5a6fd8, #6a4190);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .btn-delete {
        background: linear-gradient(45deg, #ff6b6b, #ee5a24);
        color: white;
    }
    
    .btn-delete:hover {
        background: linear-gradient(45deg, #ff5252, #d63031);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
        color: white;
    }
    
    .card-header-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 16px 16px 0 0 !important;
        padding: 20px 25px;
        border: none;
    }
    
    .card-title-modern {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
        letter-spacing: -0.5px;
    }
    
    .card-modern {
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .btn-add-modern {
        background: rgba(255,255,255,0.2);
        color: white;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 25px;
        padding: 10px 25px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-add-modern:hover {
        background: rgba(255,255,255,0.3);
        border-color: rgba(255,255,255,0.5);
        transform: translateY(-2px);
        color: white;
    }
    
    .no-officials-container {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }
    
    .no-officials-icon {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 20px;
    }
    
    .fade-in {
        animation: fadeIn 0.6s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="card card-modern">
	<div class="card-header card-header-modern">
		<h3 class="card-title card-title-modern">
			<i class="fas fa-users mr-2"></i>SK Officials 
			<?php if($_settings->userdata('type') == 1): ?>
				Management
			<?php else: ?>
				<small style="opacity: 0.8;">(View Only)</small>
			<?php endif; ?>
		</h3>
		<?php if($_settings->userdata('type') == 1): ?>
		<div class="card-tools">
			<button class="btn btn-add-modern" type="button" id="create_new">
				<i class="fa fa-plus mr-2"></i> Add Official
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
				<div class="col-lg-4 col-md-6 fade-in">
					<div class="official-card <?php echo $row['position'] == 'chairman' ? 'chairman-card' : 'councilor-card' ?>">
						<div class="row align-items-center">
							<div class="col-4 text-center">
								<?php if(!empty($row['image_path']) && file_exists('../uploads/sk_officials/'.$row['image_path'])): ?>
									<img src="../uploads/sk_officials/<?php echo $row['image_path'] ?>" alt="Official Image" class="official-avatar">
								<?php else: ?>
									<div class="official-avatar bg-gradient-secondary d-flex align-items-center justify-content-center">
										<i class="fa fa-user text-white fa-2x"></i>
									</div>
								<?php endif; ?>
							</div>
							<div class="col-8">
								<h5 class="official-name"><?php echo htmlspecialchars($full_name) ?></h5>
								<p class="official-position">SK <?php echo $position_display ?></p>
								<div class="official-info">
									<i class="fas fa-map-marker-alt"></i>
									<span>Zone: <?php echo htmlspecialchars($row['zone']) ?></span>
								</div>
								<?php if(!empty($row['date_of_birth'])): 
									$age = date_diff(date_create($row['date_of_birth']), date_create('today'))->y;
								?>
								<div class="official-info">
									<i class="fas fa-birthday-cake"></i>
									<span>Age: <?php echo $age ?></span>
								</div>
								<?php endif; ?>
								<div class="official-info">
									<i class="fas fa-phone"></i>
									<span><?php echo htmlspecialchars($row['contact']) ?></span>
								</div>
								<?php if($_settings->userdata('type') == 1): ?>
								<div class="mt-3">
									<button class="btn btn-modern btn-edit edit_data" data-id="<?php echo $row['id'] ?>">
										<i class="fa fa-edit mr-1"></i> Edit
									</button>
									<button class="btn btn-modern btn-delete delete_data" data-id="<?php echo $row['id'] ?>">
										<i class="fa fa-trash mr-1"></i> Delete
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
			<div class="no-officials-container">
				<div class="no-officials-icon">
					<i class="fas fa-users"></i>
				</div>
				<h4 style="color: #6c757d; font-weight: 300;">No SK Officials Found</h4>
				<p style="color: #adb5bd;">Start by adding your first SK official to the system.</p>
				<?php if($_settings->userdata('type') == 1): ?>
				<button class="btn btn-modern btn-edit mt-3" id="create_first">
					<i class="fa fa-plus mr-2"></i> Add First Official
				</button>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	// Add fade-in animation to cards
	$('.fade-in').each(function(index) {
		$(this).css('animation-delay', (index * 0.1) + 's');
	});
	
	<?php if($_settings->userdata('type') == 1): ?>
	$('#create_new, #create_first').click(function(){
		uni_modal("Add New SK Official","skofficials/manage_official.php")
	})
	$('.edit_data').click(function(){
		uni_modal("Edit SK Official","skofficials/manage_official.php?id="+$(this).attr('data-id'))
	})
	$('.delete_data').click(function(){
		_conf("Are you sure you want to delete this SK Official permanently?","delete_official",[$(this).attr('data-id')])
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
