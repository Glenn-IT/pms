<?php 
require_once('../config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?php echo $_settings->info('name') ?> - User Registration</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/fontawesome-free/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url ?>dist/css/adminlte.min.css">
    
    <style>
        * {
            box-sizing: border-box;
        }
        
        body{
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 1rem 0;
        }
        
        .sk-header{
            text-align: center;
            color: white;
            margin-bottom: 2rem;
            padding: 1rem;
        }
        
        .sk-header h1{
            font-size: clamp(1.5rem, 5vw, 2.5rem);
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            margin: 0 0 0.5rem 0;
        }
        
        .sk-header p{
            font-size: clamp(0.9rem, 2vw, 1.1rem);
            opacity: 0.9;
            margin: 0;
        }
        
        .register-container{
            max-width: 650px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .card{
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.3);
            overflow: hidden;
            background: white;
        }
        
        .card-header{
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 1.75rem 2rem;
            text-align: center;
        }
        
        .card-header h2{
            font-size: clamp(1.25rem, 4vw, 1.75rem);
            margin: 0;
            font-weight: 600;
        }
        
        .card-body{
            padding: 2rem;
        }
        
        .welcome-text{
            text-align: center;
            color: #666;
            margin-bottom: 2rem;
            font-size: clamp(0.9rem, 2vw, 1rem);
        }
        
        .form-group{
            margin-bottom: 1.25rem;
        }
        
        .form-group label{
            font-weight: 600;
            color: #333;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .form-control, .custom-select{
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            padding: 0.75rem 1rem;
            transition: all 0.3s;
            font-size: 0.95rem;
            height: 48px;
            min-height: 48px;
        }
        
        .form-control:focus, .custom-select:focus{
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102,126,234,0.15);
        }
        
        .input-group-text{
            background: #f8f9fa;
            border: 2px solid #e0e0e0;
            border-left: none;
            border-radius: 0 10px 10px 0;
            cursor: pointer;
            transition: all 0.3s;
            min-height: 48px;
            display: flex;
            align-items: center;
        }
        
        .input-group-text:hover{
            background: #e9ecef;
        }
        
        .btn-register{
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 0.875rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            color: white;
            width: 100%;
            transition: all 0.3s;
            margin-top: 1rem;
        }
        
        .btn-register:hover{
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102,126,234,0.4);
            color: white;
        }
        
        .text-danger{
            color: #e74c3c !important;
            font-weight: 600;
        }
        
        img#cimg{
            height: 130px;
            width: 130px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #667eea;
            transition: all 0.3s;
        }
        
        img#cimg:hover{
            transform: scale(1.05);
        }
        
        #password-requirements{
            margin-top: 0.5rem;
            padding-left: 0;
            list-style: none;
        }
        
        #password-requirements li{
            font-size: 0.85rem;
            padding: 0.25rem 0;
            transition: all 0.3s;
        }
        
        .alert{
            border-radius: 10px;
            border: none;
        }
        
        .login-link{
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e0e0e0;
        }
        
        .login-link a{
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .login-link a:hover{
            color: #764ba2;
            text-decoration: underline;
        }
        
        .custom-file-label{
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            padding: 0.75rem 1rem;
            height: 48px;
            line-height: 1.5;
        }
        
        .custom-file-label::after{
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 0 8px 8px 0;
        }
        
        /* Loader */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: rgba(0,0,0,0.8);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .loader-holder {
            display: flex;
            gap: 12px;
        }
        
        .loader-holder div {
            width: 18px;
            height: 18px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            animation: bounce 1.4s infinite ease-in-out both;
        }
        
        .loader-holder div:nth-child(1) { animation-delay: -0.32s; }
        .loader-holder div:nth-child(2) { animation-delay: -0.16s; }
        .loader-holder div:nth-child(3) { animation-delay: 0s; }
        .loader-holder div:nth-child(4) { animation-delay: 0.16s; }
        
        @keyframes bounce {
            0%, 80%, 100% { transform: scale(0); opacity: 0.5; }
            40% { transform: scale(1); opacity: 1; }
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .card-body{
                padding: 1.5rem 1.25rem;
            }
            
            .form-control, .custom-select{
                font-size: 16px; /* Prevents zoom on iOS */
            }
            
            img#cimg{
                height: 110px;
                width: 110px;
            }
        }
        
        @media (max-width: 480px) {
            .register-container{
                padding: 0 0.75rem;
            }
            
            .card-header{
                padding: 1.5rem 1rem;
            }
            
            .card-body{
                padding: 1.25rem 1rem;
            }
            
            .btn-register{
                padding: 0.75rem 1.5rem;
                font-size: 0.95rem;
            }
            
            img#cimg{
                height: 100px;
                width: 100px;
            }
        }
    </style>
</head>
<body>

<div class="sk-header">
    <h1><i class="fas fa-users"></i> <?php echo $_settings->info('name') ?></h1>
    <p>Sangguniang Kabataan User Registration</p>
</div>

<div class="register-container">
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-user-plus"></i> Create Your Account</h2>
        </div>
        <div class="card-body">
            <p class="welcome-text">Join the SK community by registering below</p>

            <div id="msg"></div>

            <form action="" id="register-frm" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="firstname">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter first name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="middlename">Middle Name</label>
                            <input type="text" name="middlename" id="middlename" class="form-control" placeholder="Enter middle name">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="lastname">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Enter last name" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sex">Sex <span class="text-danger">*</span></label>
                            <select name="sex" id="sex" class="form-control custom-select" required>
                                <option value="" disabled selected hidden>Select Sex</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="zone">Zone/Purok <span class="text-danger">*</span></label>
                            <select name="zone" id="zone" class="form-control custom-select" required>
                                <option value="" disabled selected hidden>Select Zone</option>
                                <option value="1">Zone 1</option>
                                <option value="2">Zone 2</option>
                                <option value="3">Zone 3</option>
                                <option value="4">Zone 4</option>
                                <option value="5">Zone 5</option>
                                <option value="6">Zone 6</option>
                                <option value="7">Zone 7</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="birthdate">Birthdate <span class="text-danger">*</span></label>
                            <input type="date" name="birthdate" id="birthdate" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="age">Age <span class="text-danger">*</span></label>
                            <input type="number" name="age" id="age" class="form-control" placeholder="Auto-calculated" readonly required>
                            <small class="text-warning"><strong>Note:</strong> Age 15-30 only</small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="username">Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Choose a username" required autocomplete="off">
                </div>

                <div class="form-group">
                    <label for="password">Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" 
                            placeholder="Create a strong password"
                            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,20}$"
                            title="8-20 characters, include uppercase, lowercase, and number"
                            required autocomplete="off">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="bi bi-eye-slash toggle-password" data-target="password"></i>
                            </span>
                        </div>
                    </div>
                    <ul id="password-requirements" class="mt-2">
                        <li id="req-length" class="text-danger"><i class="fas fa-times-circle"></i> 8–20 characters</li>
                        <li id="req-upper" class="text-danger"><i class="fas fa-times-circle"></i> One uppercase letter</li>
                        <li id="req-lower" class="text-danger"><i class="fas fa-times-circle"></i> One lowercase letter</li>
                        <li id="req-digit" class="text-danger"><i class="fas fa-times-circle"></i> One number</li>
                    </ul>
                </div>

                <div class="form-group">
                    <label for="cpassword">Confirm Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" name="cpassword" id="cpassword" class="form-control" placeholder="Re-enter password" required autocomplete="off">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="bi bi-eye-slash toggle-password" data-target="cpassword"></i>
                            </span>
                        </div>
                    </div>
                    <div class="invalid-feedback" id="cpassword-error">Passwords do not match.</div>
                </div>

                <div class="form-group">
                    <label for="security_question">Security Question <span class="text-danger">*</span></label>
                    <select name="security_question" id="security_question" class="form-control custom-select" required>
                        <option value="" disabled selected hidden>Select a security question</option>
                        <option value="pet">What is the name of your first pet?</option>
                        <option value="school">What was the name of your elementary school?</option>
                        <option value="mother_maiden">What is your mother's maiden name?</option>
                        <option value="birth_city">In what city were you born?</option>
                        <option value="nickname">What was your childhood nickname?</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="security_answer">Security Answer <span class="text-danger">*</span></label>
                    <input type="text" name="security_answer" id="security_answer" class="form-control" placeholder="Enter your answer" required>
                </div>

                <div class="form-group">
                    <label for="customFile">Profile Picture (Optional)</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile" name="img" onchange="displayImg(this,$(this))" accept="image/png, image/jpeg">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>

                <div class="form-group text-center">
                    <img src="<?php echo validate_image('') ?>" alt="Profile Preview" id="cimg" class="img-fluid">
                </div>

                <input type="hidden" name="type" value="2">
                <input type="hidden" name="status" value="1">

                <button type="submit" class="btn btn-register">
                    <i class="fas fa-user-check"></i> Register Account
                </button>

                <div class="login-link">
                    Already have an account? <a href="login.php"><i class="fas fa-sign-in-alt"></i> Login here</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="<?= base_url ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?= base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

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

    // Calculate age
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
            alert('Age must be between 15 and 30 years old.');
            end_loader();
            return;
        }

        var password = $('#password').val();
        var cpassword = $('#cpassword').val();

        if(password !== cpassword){
            $('#cpassword').addClass('is-invalid');
            $('#msg').html('<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Passwords do not match.</div>');
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
                    $('#msg').html('<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Username already exists</div>');
                    end_loader();
                } else if (resp == 5) {
                    $('#msg').html('<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> A user with the same details already exists</div>');
                    end_loader();
                } else if (resp == 6) {
                    $('#msg').html('<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Users above 30 years old are not allowed</div>');
                    end_loader();
                } else {
                    $('#msg').html('<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> An error occurred: ' + resp + '</div>');
                    end_loader();
                }
            },
            error: function(xhr, status, error) {
                $('#msg').html('<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Error: ' + error + '</div>');
                end_loader();
            }
        });
    });

    function checkPasswordStrength(password) {
        const lengthCheck = password.length >= 8 && password.length <= 20;
        const upperCheck = /[A-Z]/.test(password);
        const lowerCheck = /[a-z]/.test(password);
        const digitCheck = /\d/.test(password);

        $('#req-length').toggleClass('text-success', lengthCheck).toggleClass('text-danger', !lengthCheck)
            .html((lengthCheck ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-times-circle"></i>') + ' 8–20 characters');
        $('#req-upper').toggleClass('text-success', upperCheck).toggleClass('text-danger', !upperCheck)
            .html((upperCheck ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-times-circle"></i>') + ' One uppercase letter');
        $('#req-lower').toggleClass('text-success', lowerCheck).toggleClass('text-danger', !lowerCheck)
            .html((lowerCheck ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-times-circle"></i>') + ' One lowercase letter');
        $('#req-digit').toggleClass('text-success', digitCheck).toggleClass('text-danger', !digitCheck)
            .html((digitCheck ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-times-circle"></i>') + ' One number');
    }

    $('#password').on('input', function() {
        checkPasswordStrength($(this).val());
    });

    // Toggle password visibility
    $('.toggle-password').on('click', function() {
        const targetId = $(this).data('target');
        const input = $('#' + targetId);
        const type = input.attr('type') === 'password' ? 'text' : 'password';
        input.attr('type', type);
        $(this).toggleClass('bi-eye').toggleClass('bi-eye-slash');
    });

    // Update custom file label
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName);
    });
</script>

</body>
</html>
