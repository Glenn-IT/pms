<?php
// Test file to check if get_most_attended_events works
require_once('config.php');
require_once('classes/Master.php');

$master = new Master();

// Test the function
$result = $master->get_most_attended_events();
echo "Result: " . $result;
?>
