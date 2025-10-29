<?php
require_once('../config.php');

// Call the user_logout function
if($_settings->userdata('id') > 0 && $_settings->userdata('type') == 2){
    // Clear all session data
    $_settings->sess_des();
}

// Redirect to login page
redirect('user/login.php');
?>
