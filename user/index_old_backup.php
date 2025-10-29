<?php
require_once('../config.php');
if($_settings->userdata('id') <= 0 || $_settings->userdata('type') != 2){
    redirect('user/login.php');
}
?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_settings->info('name') ?> - User Portal</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url ?>dist/css/adminlte.min.css">
</head>
<body class="hold-transition">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body{
        background-image: url("<?php echo validate_image($_settings->info('cover')) ?>");
        background-size:cover;
        background-repeat:no-repeat;
        backdrop-filter: contrast(1);
    }
    .welcome-container{
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .welcome-card{
        background: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        padding: 40px;
        max-width: 600px;
        width: 100%;
    }
    .welcome-title{
        color: #001f54;
        font-size: 2.5em;
        font-weight: bold;
        margin-bottom: 20px;
        text-align: center;
    }
    .welcome-subtitle{
        color: #555;
        font-size: 1.2em;
        text-align: center;
        margin-bottom: 30px;
    }
    .user-info{
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .user-info h4{
        color: #001f54;
        margin-bottom: 15px;
    }
    .user-info p{
        margin: 5px 0;
        color: #333;
    }
    .btn-logout{
        width: 100%;
        padding: 12px;
        font-size: 1.1em;
        background: #dc3545;
        border: none;
        color: white;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s;
    }
    .btn-logout:hover{
        background: #c82333;
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

<div class="welcome-container">
    <div class="welcome-card">
        <h1 class="welcome-title">Welcome to User Portal</h1>
        <p class="welcome-subtitle">You have successfully logged in!</p>
        
        <div class="user-info">
            <h4><i class="fas fa-user"></i> User Information</h4>
            <p><strong>Name:</strong> <?php echo $_settings->userdata('firstname') . ' ' . $_settings->userdata('lastname') ?></p>
            <p><strong>Username:</strong> <?php echo $_settings->userdata('username') ?></p>
            <p><strong>Zone/Purok:</strong> Zone <?php echo $_settings->userdata('zone') ?></p>
            <p><strong>Account Type:</strong> User</p>
        </div>

        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> This is a placeholder page. More features will be added soon!
        </div>

        <button class="btn-logout" onclick="logout()">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </div>
</div>

<!-- jQuery -->
<script src="<?= base_url ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
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

    function logout(){
        start_loader();
        $.ajax({
            url: '<?= base_url ?>classes/Login.php?f=user_logout',
            method: 'POST',
            success: function(resp){
                location.href = '<?= base_url ?>user/login.php';
            }
        });
    }
</script>

</body>
</html>
