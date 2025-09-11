<?php
// Simple test file to check if AJAX is working
echo "Test content loaded successfully!";
echo "<br>Current time: " . date('Y-m-d H:i:s');
echo "<br>Session status: " . (session_status() == PHP_SESSION_ACTIVE ? 'Active' : 'Inactive');

// Try to include the header to see if there are any errors
try {
    require_once('../inc/sess_auth.php');
    echo "<br>Session auth loaded successfully";
    
    if (isset($_settings)) {
        echo "<br>Settings object exists";
        $user_id = $_settings->userdata('id');
        echo "<br>User ID: " . $user_id;
    } else {
        echo "<br>Settings object not found";
    }
} catch (Exception $e) {
    echo "<br>Error loading session: " . $e->getMessage();
}
?>
