<?php 
$user = $conn->query("SELECT * FROM users where id ='".$_settings->userdata('id')."'");
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
?>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="card card-outline rounded-0 card-navy">
	<div class="card-body">
		<div class="container-fluid">
			<div id="msg"></div>
			<form action="" id="manage-user">	
				<input type="hidden" name="id" value="<?php echo $_settings->userdata('id') ?>">
				<div class="form-group">
					<label for="name">First Name</label>
					<input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname']: '' ?>" required>
				</div>
				<div class="form-group">
					<label for="name">Middle Name</label>
					<input type="text" name="middlename" id="middlename" class="form-control" value="<?php echo isset($meta['middlename']) ? $meta['middlename']: '' ?>">
				</div>
				<div class="form-group">
					<label for="name">Last Name</label>
					<input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname']: '' ?>" required>
				</div>
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required  autocomplete="off">
				</div>
				<!-- Password -->
<div class="form-group">
	<label for="password">New Password</label>
	<div class="input-group">
		<input type="password" name="password" id="password" class="form-control" autocomplete="off"
			pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,20}$"
			title="Password must be 8-20 characters, include uppercase, lowercase, and a number">
		<span class="input-group-text">
			<i class="bi bi-eye-slash toggle-password" data-target="password" style="cursor:pointer;"></i>
		</span>
	</div>
	<small><i>Leave this blank if you don't want to change the password.</i></small>
</div>

<!-- Password Strength Indicator -->
<ul id="password-requirements" class="list-unstyled small text-muted ml-2">
	<li id="req-length" class="text-danger">❌ 8–20 characters</li>
	<li id="req-upper" class="text-danger">❌ At least one uppercase letter</li>
	<li id="req-lower" class="text-danger">❌ At least one lowercase letter</li>
	<li id="req-digit" class="text-danger">❌ At least one number</li>
</ul>

<!-- Confirm Password -->
<div class="form-group">
	<label for="cpassword">Confirm Password</label>
	<div class="input-group">
		<input type="password" name="cpassword" id="cpassword" class="form-control" autocomplete="off">
		<span class="input-group-text">
			<i class="bi bi-eye-slash toggle-password" data-target="cpassword" style="cursor:pointer;"></i>
		</span>
	</div>
	<div class="invalid-feedback" id="cpassword-error">Passwords do not match.</div>
</div>




				<div class="form-group col-6">
    <label for="security_question">Security Question</label>
    <select name="security_question" id="security_question" class="form-control" required>
        <option value="" disabled selected>Select a question</option>
        <option value="pet" <?php echo isset($meta['security_question']) && $meta['security_question'] == 'pet' ? 'selected' : '' ?>>What is the name of your first pet?</option>
        <option value="school" <?php echo isset($meta['security_question']) && $meta['security_question'] == 'school' ? 'selected' : '' ?>>What was the name of your elementary school?</option>
        <option value="mother_maiden" <?php echo isset($meta['security_question']) && $meta['security_question'] == 'mother_maiden' ? 'selected' : '' ?>>What is your mother's maiden name?</option>
        <option value="birth_city" <?php echo isset($meta['security_question']) && $meta['security_question'] == 'birth_city' ? 'selected' : '' ?>>In what city were you born?</option>
        <option value="nickname" <?php echo isset($meta['security_question']) && $meta['security_question'] == 'nickname' ? 'selected' : '' ?>>What was your childhood nickname?</option>
    </select>
</div>

<div class="form-group col-6">
    <label for="security_answer">Answer</label>
    <input type="text" name="security_answer" id="security_answer" class="form-control" value="<?php echo isset($meta['security_answer']) ? $meta['security_answer'] : '' ?>" required>
</div>


				<div class="form-group">
					<label for="" class="control-label">Avatar</label>
					<div class="custom-file">
		              <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))" accept="image/png, image/jpeg">
		              <label class="custom-file-label" for="customFile">Choose file</label>
		            </div>
				</div>
				<div class="form-group d-flex justify-content-center">
					<img src="<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] :'') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
				</div>
			</form>
		</div>
	</div>
	<div class="card-footer">
			<div class="col-md-12">
				<div class="row">
					<button class="btn btn-sm btn-primary" form="manage-user">Update</button>
				</div>
			</div>
		</div>
</div>
<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<script>
function checkPasswordStrength(password) {
	const lengthCheck = password.length >= 8 && password.length <= 20;
	const upperCheck = /[A-Z]/.test(password);
	const lowerCheck = /[a-z]/.test(password);
	const digitCheck = /\d/.test(password);

	$('#req-length').toggleClass('text-success', lengthCheck).toggleClass('text-danger', !lengthCheck).html((lengthCheck ? '✅' : '❌') + ' 8–20 characters');
	$('#req-upper').toggleClass('text-success', upperCheck).toggleClass('text-danger', !upperCheck).html((upperCheck ? '✅' : '❌') + ' At least one uppercase letter');
	$('#req-lower').toggleClass('text-success', lowerCheck).toggleClass('text-danger', !lowerCheck).html((lowerCheck ? '✅' : '❌') + ' At least one lowercase letter');
	$('#req-digit').toggleClass('text-success', digitCheck).toggleClass('text-danger', !digitCheck).html((digitCheck ? '✅' : '❌') + ' At least one number');
}

$('#password').on('input', function() {
	const password = $(this).val();
	checkPasswordStrength(password);
});

// Toggle show/hide password
$('.toggle-password').on('click', function() {
	const targetId = $(this).data('target');
	const input = $('#' + targetId);
	const type = input.attr('type') === 'password' ? 'text' : 'password';
	input.attr('type', type);
	$(this).toggleClass('bi-eye').toggleClass('bi-eye-slash');
});

// Confirm Password Validation
$('#manage-user').submit(function(e){
	e.preventDefault();
	start_loader();

	var password = $('#password').val();
	var cpassword = $('#cpassword').val();

	if(password.length > 0 && password !== cpassword){
	    $('#cpassword').addClass('is-invalid');
	    end_loader();
	    return;
	} else {
	    $('#cpassword').removeClass('is-invalid');
	}

	$.ajax({
		url: _base_url_+'classes/Users.php?f=save',
		data: new FormData($(this)[0]),
		cache: false,
		contentType: false,
		processData: false,
		method: 'POST',
		success: function(resp) {
			if(resp == 1){
				location.reload();
			}else{
				$('#msg').html('<div class="alert alert-danger">Username already exists</div>');
				end_loader();
			}
		}
	});
});
</script>

<script>
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }else{
			$('#cimg').attr('src', "<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] :'') ?>");
		}
	}
	$('#manage-user').submit(function(e){
		e.preventDefault();
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Users.php?f=save',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp ==1){
					location.reload()
				}else{
					$('#msg').html('<div class="alert alert-danger">Username already exist</div>')
					end_loader()
				}
			}
		})
	})

</script>