<?php 
require_once('../config.php');
// Don't require sess_auth for registration page
?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_settings->info('name') ?> - User Registration</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url ?>dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body{
        background-image: url("<?php echo validate_image($_settings->info('cover')) ?>");
        background-size:cover;
        background-repeat:no-repeat;
        backdrop-filter: contrast(1);
    }
    #page-title{
        text-shadow: 6px 4px 7px black;
        font-size: 3.5em;
        color: #fff4f4 !important;
        background: #8080801c;
    }
    .register-box{
        width: 500px;
        margin: 2% auto;
    }
    .register-card-body{
        background: #fff;
        padding: 20px;
        border-radius: 5px;
    }
</style>

<h1 class="text-center text-white px-4 py-3" id="page-title"><b><?php echo $_settings->info('name') ?></b></h1>

<div class="register-box">
    <div class="card card-outline card-navy">
        <div class="card-header text-center">
            <h1><b>User Registration</b></h1>
        </div>
        <div class="card-body register-card-body">
            <p class="login-box-msg">Register a new user account</p>

            <div id="msg"></div>

            <form action="" id="register-frm" enctype="multipart/form-data">
                <!-- First Name -->
                <div class="form-group">
                    <label for="firstname">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="firstname" id="firstname" class="form-control" required>
                </div>

                <!-- Middle Name -->
                <div class="form-group">
                    <label for="middlename">Middle Name</label>
                    <input type="text" name="middlename" id="middlename" class="form-control">
                </div>

                <!-- Last Name -->
                <div class="form-group">
                    <label for="lastname">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="lastname" id="lastname" class="form-control" required>
                </div>

                <!-- Sex -->
                <div class="form-group">
                    <label for="sex">Sex <span class="text-danger">*</span></label>
                    <select name="sex" id="sex" class="form-control" required>
                        <option value="" disabled selected>Select Sex</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <!-- Birthdate -->
                <div class="form-group">
                    <label for="birthdate">Birthdate <span class="text-danger">*</span></label>
                    <input type="date" name="birthdate" id="birthdate" class="form-control" required>
                </div>

                <!-- Age -->
                <div class="form-group">
                    <label for="age">Age <span class="text-danger">*</span></label>
                    <input type="number" name="age" id="age" class="form-control" readonly required>
                    <small class="text-warning"><strong>Note:</strong> Age must be between 15 and 30 years old.</small>
                </div>

                <!-- Username -->
                <div class="form-group">
                    <label for="username">Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" id="username" class="form-control" required autocomplete="off">
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" 
                            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,20}$"
                            title="Password must be 8-20 characters, include uppercase, lowercase, and a number"
                            required autocomplete="off">
                        <span class="input-group-text">
                            <i class="bi bi-eye-slash toggle-password" data-target="password" style="cursor:pointer;"></i>
                        </span>
                    </div>
                </div>

                <!-- Password Strength Indicator -->
                <ul id="password-requirements" class="list-unstyled small text-muted ml-2 mb-3">
                    <li id="req-length" class="text-danger">❌ 8–20 characters</li>
                    <li id="req-upper" class="text-danger">❌ At least one uppercase letter</li>
                    <li id="req-lower" class="text-danger">❌ At least one lowercase letter</li>
                    <li id="req-digit" class="text-danger">❌ At least one number</li>
                </ul>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="cpassword">Confirm Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" name="cpassword" id="cpassword" class="form-control" required autocomplete="off">
                        <span class="input-group-text">
                            <i class="bi bi-eye-slash toggle-password" data-target="cpassword" style="cursor:pointer;"></i>
                        </span>
                    </div>
                    <div class="invalid-feedback" id="cpassword-error">Passwords do not match.</div>
                </div>

                <!-- Security Question -->
                <div class="form-group">
                    <label for="security_question">Security Question <span class="text-danger">*</span></label>
                    <select name="security_question" id="security_question" class="form-control" required>
                        <option value="" disabled selected>Select a question</option>
                        <option value="pet">What is the name of your first pet?</option>
                        <option value="school">What was the name of your elementary school?</option>
                        <option value="mother_maiden">What is your mother's maiden name?</option>
                        <option value="birth_city">In what city were you born?</option>
                        <option value="nickname">What was your childhood nickname?</option>
                    </select>
                </div>

                <!-- Security Answer -->
                <div class="form-group">
                    <label for="security_answer">Answer <span class="text-danger">*</span></label>
                    <input type="text" name="security_answer" id="security_answer" class="form-control" required>
                </div>

                <!-- Zone/Purok Dropdown -->
                <div class="form-group">
                    <label for="zone">Zone/Purok <span class="text-danger">*</span></label>
                    <select name="zone" id="zone" class="form-control" required>
                        <option value="" disabled selected>Select Zone/Purok</option>
                        <option value="1">Zone 1</option>
                        <option value="2">Zone 2</option>
                        <option value="3">Zone 3</option>
                        <option value="4">Zone 4</option>
                        <option value="5">Zone 5</option>
                        <option value="6">Zone 6</option>
                        <option value="7">Zone 7</option>
                    </select>
                </div>

                <!-- Hidden User Type - Auto set to User (2) -->
                <input type="hidden" name="type" value="2">

                <!-- Hidden Status - Auto set to Active (1) -->
                <input type="hidden" name="status" value="1">

                <!-- Avatar Upload -->
                <div class="form-group">
                    <label for="" class="control-label">Avatar (Optional)</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))" accept="image/png, image/jpeg">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>

                <!-- Avatar Display -->
                <div class="form-group d-flex justify-content-center">
                    <img src="<?php echo validate_image('') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                </div>
            </form>

            <p class="mb-0 mt-3 text-center">
                <a href="login.php" class="text-center">Already have an account? Login here</a>
            </p>
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
    /* Loader styles */
    #preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background-color: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .loader-holder {
        display: flex;
        gap: 10px;
    }
    .loader-holder div {
        width: 15px;
        height: 15px;
        background-color: #fff;
        border-radius: 50%;
        animation: bounce 1.4s infinite ease-in-out both;
    }
    .loader-holder div:nth-child(1) { animation-delay: -0.32s; }
    .loader-holder div:nth-child(2) { animation-delay: -0.16s; }
    @keyframes bounce {
        0%, 80%, 100% { transform: scale(0); }
        40% { transform: scale(1); }
    }
</style>

<!-- jQuery -->
<script src="<?= base_url ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url ?>dist/js/adminlte.min.js"></script>

<script>
    // Define base_url
    var _base_url_ = '<?php echo base_url ?>';
    
    // Loader functions
    window.start_loader = function(){
        $('body').append('<div id="preloader"><div class="loader-holder"><div></div><div></div><div></div><div></div></div></div>');
    }
    window.end_loader = function(){
        $('#preloader').fadeOut('fast', function() {
            $(this).remove();
        });
    }
    
    $(document).ready(function(){
        end_loader();
    });

    function displayImg(input,_this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#cimg').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }else{
            $('#cimg').attr('src', "<?php echo validate_image('') ?>");
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
        } else {
            $('#age').removeClass('is-invalid');
        }
    });

    $('#register-frm').submit(function(e){
        e.preventDefault();  
        start_loader();

        var age = $('#age').val();
        if (age < 15 || age > 30) {
            alert('Age must be between 15 and 30 years old. Users above 30 are not allowed to register.');
            end_loader();
            return;
        }

        var password = $('#password').val();
        var cpassword = $('#cpassword').val();

        if(password !== cpassword){
            $('#cpassword').addClass('is-invalid');
            $('#msg').html('<div class="alert alert-danger">Passwords do not match.</div>');
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
                    alert('Registration successful! You can now login.');
                    location.href = 'login.php';
                } else if (resp == 3) {
                    $('#msg').html('<div class="alert alert-danger">Username already exists</div>');
                    end_loader();
                } else if (resp == 5) {
                    $('#msg').html('<div class="alert alert-danger">A user with the same name and birthdate already exists</div>');
                    end_loader();
                } else if (resp == 6) {
                    $('#msg').html('<div class="alert alert-danger">Users above 30 years old are not allowed to register</div>');
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

</body>
</html>
