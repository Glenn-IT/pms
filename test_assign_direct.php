<?php
// Simple test to check if the assign_sk_official function works
require_once('config.php');

// Simulate the form data
$_POST = array(
    'firstname' => 'Test',
    'middlename' => '',
    'lastname' => 'User',
    'contact' => '09123456789',
    'email' => 'test@example.com',
    'zone' => 'Zone 1',
    'date_of_birth' => '2000-01-01',
    'sex' => 'Male',
    'position' => 'kagawad'
);

// Start session and set admin user
session_start();
$_SESSION['userdata'] = array('type' => 1);

// Test the function directly
$url = 'http://localhost/pms/classes/Master.php?f=assign_sk_official';

$postdata = http_build_query($_POST);

$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);

$context  = stream_context_create($opts);
$result = file_get_contents($url, false, $context);

echo "Response from assign_sk_official:\n";
echo $result;
echo "\n\n";

// Test if it's valid JSON
$json = json_decode($result, true);
if(json_last_error() === JSON_ERROR_NONE) {
    echo "✓ Valid JSON response\n";
    print_r($json);
} else {
    echo "✗ Invalid JSON - Error: " . json_last_error_msg() . "\n";
    echo "Raw response:\n" . $result . "\n";
}
?>
