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

<div class="card card-outline rounded-0 card-navy">
	<div class="card-body">
		<div class="container-fluid">
			<div id="msg"></div>
			<form action="" id="manage-user">	
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

<div class="form-group">
    <label for="age">Age</label>
    <input type="number" name="age" id="age" class="form-control" value="<?php echo isset($meta['age']) ? $meta['age'] : '' ?>" readonly required>
    <div class="invalid-feedback">Age must be between 15 and 21 years old.</div>
</div>









				<!-- Username -->
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required  autocomplete="off">
				</div>

				<!-- Password -->
				<div class="form-group">
					<label for="password"><?= isset($meta['id']) ? "New" : "" ?> Password</label>
					<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
                    <?php if(isset($meta['id'])): ?>
					<small><i>Leave this blank if you don't want to change the password.</i></small>
                    <?php endif; ?>
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

				<!-- Zone/Purok Dropdown (Updated to Dropdown 1-7) -->
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
				<a href="./?page=user/list" class="btn btn-sm btn-default border rounded-0" form="manage-user"><i class="fa fa-angle-left"></i> Cancel</a>
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

	
	$('#manage-user').submit(function(e){
    e.preventDefault();  // Prevent the form from submitting immediately
    start_loader();  // Start the loading animation (as you've implemented)

    // Validate the age (change the range to 15-30)
    var age = $('#age').val();
    if (age < 15 || age > 30) {
        alert('Age must be between 15 and 30 years old.');
        end_loader();  // Stop loader if validation fails
        return;  // Stop the form submission
    }

    // Continue with the form submission if age is valid
    $.ajax({
        url: _base_url_ + 'classes/Users.php?f=save',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
			if (resp == 1) {
    location.href = './?page=user/list';
} else if (resp == 3) {
    $('#msg').html('<div class="alert alert-danger">Username already exists</div>');
    end_loader();
} else {
    $('#msg').html('<div class="alert alert-danger">An unexpected error occurred.</div>');
    end_loader();
}

        }
    });
});

// Calculate age based on birthdate and validate it
$('#birthdate').change(function() {
    var birthdate = new Date($(this).val());
    var today = new Date();
    var age = today.getFullYear() - birthdate.getFullYear();
    var month = today.getMonth() - birthdate.getMonth();
    
    // If the current month is before the birth month, subtract 1 from the age
    if (month < 0 || (month === 0 && today.getDate() < birthdate.getDate())) {
        age--;
    }
    
    // Set the age field
    $('#age').val(age);

    // Validate if age is between 15 and 30
    if (age < 15 || age > 30) {
        $('#age').addClass('is-invalid');
        $('#age').next('.invalid-feedback').remove(); // Remove existing message if any
        $('#age').after('<div class="invalid-feedback">Age must be between 15 and 30 years old.</div>');
    } else {
        $('#age').removeClass('is-invalid');
        $('#age').next('.invalid-feedback').remove(); // Remove any error message
    }
});

</script>
