<?php
session_start();
require_once('config.php');

// Initialize classes manually to avoid path issues
require_once('classes/DBConnection.php');
require_once('classes/SystemSettings.php');

echo "Testing SK Officials Assignment...\n";

// Test data
$_POST = array(
    'firstname' => 'Test',
    'middlename' => 'User',
    'lastname' => 'Official',
    'contact' => '09123456789',
    'email' => 'test@email.com',
    'zone' => 'Zone 1',
    'date_of_birth' => '2000-01-01',
    'sex' => 'Male',
    'position' => 'kagawad'
);

// Simulate admin user
$_SESSION['userdata'] = array('type' => 1);

$Master = new Master();
$result = $Master->assign_sk_official();

echo "Result: " . $result . "\n";

// Check database
$check = $conn->query("SELECT * FROM sk_officials WHERE firstname = 'Test'");
if($check->num_rows > 0) {
    echo "✓ Record found in database\n";
    $row = $check->fetch_assoc();
    print_r($row);
} else {
    echo "✗ No record found in database\n";
}
?>
