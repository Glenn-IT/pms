<?php 
require_once('../config.php');
// Don't require sess_auth for login page
?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_settings->info('name') ?> - User Login</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url ?>dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

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

<h1 class="text-center text-white px-4 py-5" id="page-title"><b><?php echo $_settings->info('name') ?></b></h1>

<div class="login-box">
    <div class="card card-navy my-2">
        <div class="card-body">
            <p class="login-box-msg">Please enter your credentials</p>
            
            <!-- Message display -->
            <div id="login-message" class="text-center mb-3 text-danger"></div>
            
            <form id="login-frm" action="" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="username" autofocus placeholder="Username" id="username-input">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password" id="password-input">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="bi bi-eye-slash toggle-password" data-target="password-input" style="cursor:pointer;"></i>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <!-- Empty space -->
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block" id="login-button">Sign In</button>
                    </div>
                </div>
            </form>

            <p class="mb-1 mt-3">
                <a href="forgot_password/">I forgot my password</a>
            </p>
            
            <p class="mb-0">
                <a href="register.php" class="text-center">Register a new account</a>
            </p>
        </div>
    </div>
</div>

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

    // Initialize login attempts count
    if(!sessionStorage.getItem('loginAttempts')) {
        sessionStorage.setItem('loginAttempts', 0);
    }

    // Initialize lock timeout timestamp
    if(!sessionStorage.getItem('lockTimeout')) {
        sessionStorage.setItem('lockTimeout', 0);
    }

    function unlockInputs(){
        $('#username-input, #password-input, #login-button').prop('disabled', false);
        $('#login-message').text('');
        sessionStorage.setItem('loginAttempts', 0);
        sessionStorage.setItem('lockTimeout', 0);
    }

    function lockInputsWithCountdown(seconds){
        let countdown = seconds;
        $('#username-input, #password-input, #login-button').prop('disabled', true);
        $('#login-message').text(`Too many failed attempts. Please wait ${countdown} seconds.`);

        // Save lock timeout timestamp
        const unlockTime = Date.now() + countdown * 1000;
        sessionStorage.setItem('lockTimeout', unlockTime);

        const interval = setInterval(() => {
            countdown--;
            if(countdown > 0){
                $('#login-message').text(`Too many failed attempts. Please wait ${countdown} seconds.`);
            } else {
                clearInterval(interval);
                unlockInputs();
            }
        }, 1000);
    }

    function checkLockStatus(){
        const lockTimeout = parseInt(sessionStorage.getItem('lockTimeout'));
        if(lockTimeout && lockTimeout > Date.now()){
            // Calculate remaining time in seconds
            let remaining = Math.ceil((lockTimeout - Date.now()) / 1000);
            lockInputsWithCountdown(remaining);
            return true;
        } else if(lockTimeout && lockTimeout <= Date.now()){
            unlockInputs();
            return false;
        }
        return false;
    }

    // Check on page load
    if(!checkLockStatus()){
        // If not locked, check attempts
        let attempts = parseInt(sessionStorage.getItem('loginAttempts'));
        if(attempts >= 3){
            lockInputsWithCountdown(30); // lock for 30 seconds
        }
    }

    $('#login-frm').submit(function(e){
        e.preventDefault();
        $('#login-message').text(''); // clear previous messages

        // Prevent submit if disabled
        if($('#login-button').prop('disabled')) return;

        $.ajax({
            url: '<?= base_url ?>classes/Login.php?f=user_login',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(resp){
                if(resp.status === 'success'){
                    // Reset attempts on successful login
                    sessionStorage.setItem('loginAttempts', 0);
                    sessionStorage.setItem('lockTimeout', 0);
                    window.location.href = '<?= base_url ?>user/index.php';
                }
                else if(resp.status === 'inactive'){
                    $('#login-message').text(resp.msg || 'Your account has been deactivated. Please contact support.');
                }
                else if(resp.status === 'incorrect'){
                    // Increment failed attempts
                    let attempts = parseInt(sessionStorage.getItem('loginAttempts')) + 1;
                    sessionStorage.setItem('loginAttempts', attempts);

                    if(attempts >= 3){
                        lockInputsWithCountdown(30); // lock for 30 seconds
                    } else {
                        $('#login-message').text('Incorrect username or password. Attempts left: ' + (3 - attempts));
                    }
                }
                else{
                    $('#login-message').text('Login failed. Please try again.');
                }
            },
            error: function(){
                $('#login-message').text('An error occurred. Please try again.');
            }
        });
    });
});
</script>

<script>
document.querySelectorAll('.toggle-password').forEach(icon => {
    icon.addEventListener('click', () => {
        const targetId = icon.getAttribute('data-target');
        const input = document.getElementById(targetId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    });
});
</script>

</body>
</html>
