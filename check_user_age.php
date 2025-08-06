<?php
/**
 * Age Check Script
 * This script checks all active users and deactivates those who are 31 years old or older
 * Can be run manually or scheduled as a cron job
 */

require_once('config.php');
require_once('classes/Users.php');

// Create a new Users instance
$users = new Users();

// Check and deactivate users over 31
$deactivated_count = $users->check_and_deactivate_users_over_31();

// Log the result
$log_message = date('Y-m-d H:i:s') . " - Age check completed. {$deactivated_count} users deactivated.\n";

// Write to log file
$log_file = 'logs/age_check.log';
if (!is_dir('logs')) {
    mkdir('logs', 0755, true);
}
file_put_contents($log_file, $log_message, FILE_APPEND | LOCK_EX);

// Output result (useful when running manually)
echo "Age check completed. {$deactivated_count} users were deactivated for being 31 years old or older.\n";
echo "Check logged to: {$log_file}\n";
?>
