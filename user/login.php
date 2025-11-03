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
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    html {
        overflow-x: hidden;
        max-width: 100%;
    }
    
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f4f6f9;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        overflow-x: hidden !important;
        max-width: 100vw !important;
        position: relative;
    }
    
    /* Login Container */
    .login-container {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        max-width: 100%;
    }
    
    .login-box {
        width: 100%;
        max-width: 500px;
    }
    
    /* System Title Header */
    .system-header {
        background: linear-gradient(to right, #001f3f, #003d7a);
        color: white;
        padding: 2rem;
        text-align: center;
        border-bottom: 3px solid rgba(255,255,255,0.3);
    }
    
    .system-header h1 {
        color: white !important;
        font-size: clamp(1.5rem, 3.5vw, 2rem);
        margin: 0;
        font-weight: 700;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    
    .system-header i {
        margin-right: 0.5rem;
    }
    
    /* Card matching user/index.php style */
    .card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        overflow: hidden;
        border: none;
    }
    
    .card-header {
        background: linear-gradient(to right, #001f3f, #003d7a);
        color: white;
        padding: 1.5rem;
        border-bottom: 3px solid rgba(255,255,255,0.3);
    }
    
    .card-header h4 {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }
    
    .card-body {
        padding: 2rem;
    }
    
    /* Card Footer */
    .card-footer {
        background: #f8f9fa;
        padding: 1.5rem;
        text-align: center;
        border-top: 2px solid #e0e0e0;
    }
    
    .card-footer p {
        color: #666;
        margin: 0.25rem 0;
        font-size: 0.85rem;
    }
    
    .card-footer strong {
        color: #001f3f;
    }
    
    .login-box-msg {
        text-align: center;
        margin-bottom: 1.5rem;
        color: #666;
        font-size: 1rem;
    }
    
    /* Form Controls */
    .input-group {
        margin-bottom: 1.5rem;
    }
    
    .form-control {
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        border-color: #001f3f;
        box-shadow: 0 0 0 3px rgba(0, 31, 63, 0.1);
        outline: none;
    }
    
    .input-group-text {
        background: #f8f9fa;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        color: #001f3f;
    }
    
    /* Button */
    .btn-primary {
        background: linear-gradient(to right, #001f3f, #003d7a);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s;
        width: 100%;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 31, 63, 0.3);
        background: linear-gradient(to right, #003d7a, #001f3f);
    }
    
    .btn-primary:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }
    
    /* Links */
    .card-body a {
        color: #001f3f;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s;
    }
    
    .card-body a:hover {
        color: #003d7a;
        text-decoration: underline;
    }
    
    /* Message Display */
    #login-message {
        padding: 0.75rem;
        border-radius: 8px;
        font-weight: 500;
        min-height: 20px;
    }
    
    #login-message:not(:empty) {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
    }
    
    /* Toggle Password */
    .toggle-password {
        transition: color 0.3s;
    }
    
    .toggle-password:hover {
        color: #001f3f;
    }
    
    /* Loader matching user/index.php */
    #preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background-color: rgba(0,0,0,0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        max-width: 100vw;
    }
    
    .loader-holder {
        display: flex;
        gap: 12px;
    }
    
    .loader-holder div {
        width: 18px;
        height: 18px;
        background: linear-gradient(to right, #001f3f, #003d7a);
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
    
    /* Responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem;
        }
        
        #page-title {
            font-size: 1.5rem;
        }
    }
    
    @media (max-width: 480px) {
        .login-container {
            padding: 1rem;
        }
        
        .card-body {
            padding: 1.25rem;
        }
    }
</style>

<!-- Login Container -->
<div class="login-container">
    <div class="login-box">
        <div class="card">
            <!-- System Header -->
            <div class="system-header">
                <h1>
                    <i class="fas fa-users"></i>
                    <b><?php echo $_settings->info('name') ?></b>
                </h1>
            </div>
            
            <!-- Login Form Header -->
            <div class="card-header">
                <h4>
                    <i class="fas fa-sign-in-alt"></i>
                    User Login
                </h4>
            </div>
            
            <!-- Login Form Body -->
            <div class="card-body">
                <p class="login-box-msg">Please enter your credentials to access your account</p>
                
                <!-- Message display -->
                <div id="login-message" class="text-center mb-3"></div>
                
                <form id="login-frm" action="" method="post">
                    <div class="input-group">
                        <input type="text" class="form-control" name="username" autofocus placeholder="Username" id="username-input">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group">
                        <input type="password" class="form-control" name="password" placeholder="Password" id="password-input">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="bi bi-eye-slash toggle-password" data-target="password-input" style="cursor:pointer;"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" id="login-button">
                            <i class="fas fa-sign-in-alt"></i> Sign In
                        </button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <p class="mb-2">
                        <a href="forgot_password/">
                            <i class="fas fa-key"></i> I forgot my password
                        </a>
                    </p>
                    
                    <p class="mb-0">
                        <a href="register.php">
                            <i class="fas fa-user-plus"></i> Register a new account
                        </a>
                    </p>
                </div>
            </div>
            
            <!-- Card Footer -->
            <div class="card-footer">
                <p><strong>Youth Information System</strong> - Maguilling, Piat, Cagayan</p>
                <p>&copy; <?php echo date('Y') ?> Sangguniang Kabataan. All Rights Reserved.</p>
            </div>
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
