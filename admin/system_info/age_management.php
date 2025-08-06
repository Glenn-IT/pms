<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<div class="card card-outline rounded-0 card-navy">
	<div class="card-header">
		<h3 class="card-title">Age Management</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<div id="msg"></div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="info-box">
						<span class="info-box-icon bg-info"><i class="fas fa-calendar-check"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Automatic Age Verification</span>
							<span class="info-box-number">Users above 30 are automatically rejected</span>
							<p class="text-muted">The system prevents registration of users over 30 years old.</p>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="info-box">
						<span class="info-box-icon bg-warning"><i class="fas fa-user-times"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Automatic Deactivation</span>
							<span class="info-box-number">Users turning 31 are deactivated</span>
							<p class="text-muted">Run the age check to deactivate users who have turned 31.</p>
							<button class="btn btn-warning btn-sm" id="run-age-check">
								<i class="fas fa-play"></i> Run Age Check Now
							</button>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">Scheduling Instructions</h4>
						</div>
						<div class="card-body">
							<p>To automatically check and deactivate users daily, you can schedule the age check script:</p>
							<h5>Option 1: Windows Task Scheduler</h5>
							<ol>
								<li>Open Windows Task Scheduler</li>
								<li>Create a new task</li>
								<li>Set trigger to run daily at a specific time</li>
								<li>Set action to run: <code>C:\xampp\htdocs\pms\run_age_check.bat</code></li>
							</ol>
							
							<h5>Option 2: Manual Run</h5>
							<p>You can manually run the script by executing:</p>
							<code>C:\xampp\htdocs\pms\run_age_check.bat</code>
							
							<h5>Option 3: PHP CLI</h5>
							<p>Run directly with PHP:</p>
							<code>php C:\xampp\htdocs\pms\check_user_age.php</code>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
$('#run-age-check').click(function(){
	if(confirm("Are you sure you want to run the age check now? This will deactivate all users who are 31 years old or older.")){
		start_loader();
		
		$.ajax({
			url: _base_url_ + 'classes/Users.php?f=check_age',
			method: 'POST',
			success: function(resp) {
				end_loader();
				if(resp >= 0) {
					$('#msg').html('<div class="alert alert-success">Age check completed successfully. ' + resp + ' user(s) were deactivated.</div>');
				} else {
					$('#msg').html('<div class="alert alert-danger">An error occurred while running the age check.</div>');
				}
			},
			error: function(xhr, status, error) {
				end_loader();
				$('#msg').html('<div class="alert alert-danger">AJAX error: ' + error + '</div>');
			}
		});
	}
});
</script>
