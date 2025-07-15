<?php 
if(isset($_GET['id'])){
    $user = $conn->query("SELECT * FROM users where id ='{$_GET['id']}' ");
    foreach($user->fetch_array() as $k =>$v){
        $meta[$k] = $v;
    }
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
			<form action="" id="manage-user" enctype="multipart/form-data">	
				<input type="hidden" name="id" value="<?= isset($meta['id']) ? $meta['id'] : '' ?>">

				<!-- First Name -->
				<div class="form-group">
					<label for="firstname">First Name</label>
					<input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname']: '' ?>" required>
				</div>

				<!-- Middle Name -->
				<div class="form-group">
					<label for="middlename">Middle Name</label>
					<input type="text" name="middlename" id="middlename" class="form-control" value="<?php echo isset($meta['middlename']) ? $meta['middlename']: '' ?>">
				</div>

				<!-- Last Name -->
				<div class="form-group">
					<label for="lastname">Last Name</label>
					<input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname']: '' ?>" required>
				</div>

				<!-- Sex -->
				<div class="form-group">
					<label for="sex">Sex</label>
					<select name="sex" id="sex" class="form-control" required>
						<option value="" disabled selected>Select Sex</option>
						<option value="Male" <?php echo isset($meta['sex']) && $meta['sex'] == 'Male' ? 'selected' : '' ?>>Male</option>
						<option value="Female" <?php echo isset($meta['sex']) && $meta['sex'] == 'Female' ? 'selected' : '' ?>>Female</option>
					</select>
				</div>

				<!-- Birthdate -->
				<div class="form-group">
					<label for="birthdate">Birthdate</label>
					<input type="date" name="birthdate" id="birthdate" class="form-control" value="<?php echo isset($meta['birthdate']) ? $meta['birthdate'] : '' ?>" required>
				</div>

				<!-- Age -->
				<div class="form-group">
					<label for="age">Age</label>
					<input type="number" name="age" id="age" class="form-control" value="<?php echo isset($meta['age']) ? $meta['age'] : '' ?>" readonly required>
					<div class="invalid-feedback">Age must be between 15 and 30 years old.</div>
				</div>

				<!-- Username -->
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required  autocomplete="off">
				</div>

				<!-- Password -->
<div class="form-group">
	<label for="password"><?= isset($meta['id']) ? "New" : "" ?> Password</label>
	<div class="input-group">
		<input type="password" name="password" id="password" class="form-control" autocomplete="off"
			pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,20}$"
			title="Password must be 8-20 characters, include uppercase, lowercase, and a number">
		<span class="input-group-text">
			<i class="bi bi-eye-slash toggle-password" data-target="password" style="cursor:pointer;"></i>
		</span>
	</div>
	<?php if(isset($meta['id'])): ?>
		<small><i>Leave this blank if you don't want to change the password.</i></small>
	<?php endif; ?>
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


				<!-- Security Question -->
				<div class="form-group">
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

				<!-- Security Answer -->
				<div class="form-group">
					<label for="security_answer">Answer</label>
					<input type="text" name="security_answer" id="security_answer" class="form-control" value="<?php echo isset($meta['security_answer']) ? $meta['security_answer'] : '' ?>" required>
				</div>

				<!-- Zone/Purok Dropdown -->
				<div class="form-group">
					<label for="zone">Zone/Purok</label>
					<select name="zone" id="zone" class="form-control" required>
						<option value="" disabled selected>Select Zone/Purok</option>
						<option value="1" <?php echo isset($meta['zone']) && $meta['zone'] == '1' ? 'selected' : '' ?>>Zone 1</option>
						<option value="2" <?php echo isset($meta['zone']) && $meta['zone'] == '2' ? 'selected' : '' ?>>Zone 2</option>
						<option value="3" <?php echo isset($meta['zone']) && $meta['zone'] == '3' ? 'selected' : '' ?>>Zone 3</option>
						<option value="4" <?php echo isset($meta['zone']) && $meta['zone'] == '4' ? 'selected' : '' ?>>Zone 4</option>
						<option value="5" <?php echo isset($meta['zone']) && $meta['zone'] == '5' ? 'selected' : '' ?>>Zone 5</option>
						<option value="6" <?php echo isset($meta['zone']) && $meta['zone'] == '6' ? 'selected' : '' ?>>Zone 6</option>
						<option value="7" <?php echo isset($meta['zone']) && $meta['zone'] == '7' ? 'selected' : '' ?>>Zone 7</option>
					</select>
				</div>

				<!-- Avatar Upload -->
				<div class="form-group">
					<label for="" class="control-label">Avatar</label>
					<div class="custom-file">
						<input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))" accept="image/png, image/jpeg">
						<label class="custom-file-label" for="customFile">Choose file</label>
					</div>
				</div>

				<!-- Avatar Display -->
				<div class="form-group d-flex justify-content-center">
					<img src="<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] :'') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
				</div>
			</form>
		</div>
	</div>

	<div class="card-footer">
		<div class="col-md-12">
			<div class="row">
				<button class="btn btn-sm btn-primary rounded-0 mr-3" form="manage-user">Save User Details</button>
				<a href="./?page=user/list" class="btn btn-sm btn-default border rounded-0"><i class="fa fa-angle-left"></i> Cancel</a>
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

	// Calculate age based on birthdate and validate it
	$('#birthdate').change(function() {
	    var birthdate = new Date($(this).val());
	    var today = new Date();
	    var age = today.getFullYear() - birthdate.getFullYear();
	    var month = today.getMonth() - birthdate.getMonth();
	    
	    if (month < 0 || (month === 0 && today.getDate() < birthdate.getDate())) {
	        age--;
	    }
	    
	    $('#age').val(age);

	    if (age < 15 || age > 30) {
	        $('#age').addClass('is-invalid');
	        if ($('#age').next('.invalid-feedback').length === 0) {
	            $('#age').after('<div class="invalid-feedback">Age must be between 15 and 30 years old.</div>');
	        }
	    } else {
	        $('#age').removeClass('is-invalid');
	        $('#age').next('.invalid-feedback').remove();
	    }
	});

	$('#manage-user').submit(function(e){
	    e.preventDefault();  
	    start_loader();

	    var age = $('#age').val();
	    if (age < 15 || age > 30) {
	        alert('Age must be between 15 and 30 years old.');
	        end_loader();
	        return;
	    }

	    var password = $('#password').val();
	    var cpassword = $('#cpassword').val();

	    // Only validate confirm password if password field is not empty (for edit)
	    if(password.length > 0 && password !== cpassword){
	        $('#cpassword').addClass('is-invalid');
	        end_loader();
	        return;
	    } else {
	        $('#cpassword').removeClass('is-invalid');
	    }

	    $.ajax({
	        url: _base_url_ + 'classes/Users.php?f=save',
	        data: new FormData($(this)[0]),
	        cache: false,
	        contentType: false,
	        processData: false,
	        method: 'POST',
	        success: function(resp) {
	            if (resp == 1) {
	                location.href = './?page=user/list';
	            } else if (resp == 3) {
	                $('#msg').html('<div class="alert alert-danger">Username already exists</div>');
	                end_loader();
	            } else {
	                $('#msg').html('<div class="alert alert-danger">An unexpected error occurred: ' + resp + '</div>');
	                end_loader();
	            }
	        },
	        error: function(xhr, status, error) {
	            $('#msg').html('<div class="alert alert-danger">AJAX error: ' + error + '</div>');
	            end_loader();
	        }
	    });
	});
</script>
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
</script>
