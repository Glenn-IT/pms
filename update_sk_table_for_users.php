<?php
require_once('config.php');

echo "Adding user_id field to sk_officials table...\n";

// Check if user_id column exists
$check = $conn->query("SHOW COLUMNS FROM sk_officials LIKE 'user_id'");
if($check->num_rows == 0) {
    // Add user_id column
    $sql = "ALTER TABLE `sk_officials` ADD COLUMN `user_id` INT(11) NULL AFTER `id`";
    if($conn->query($sql)) {
        echo "✓ user_id column added successfully!\n";
    } else {
        echo "❌ Error adding user_id column: " . $conn->error . "\n";
        exit;
    }
} else {
    echo "ℹ️ user_id column already exists.\n";
}

// Add foreign key constraint
$check_fk = $conn->query("SELECT * FROM information_schema.KEY_COLUMN_USAGE 
                         WHERE TABLE_NAME = 'sk_officials' 
                         AND COLUMN_NAME = 'user_id' 
                         AND REFERENCED_TABLE_NAME = 'users'");

if($check_fk->num_rows == 0) {
    $sql_fk = "ALTER TABLE `sk_officials` ADD CONSTRAINT `fk_sk_officials_user` 
               FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE";
    if($conn->query($sql_fk)) {
        echo "✓ Foreign key constraint added successfully!\n";
    } else {
        echo "❌ Error adding foreign key: " . $conn->error . "\n";
    }
} else {
    echo "ℹ️ Foreign key constraint already exists.\n";
}

echo "Database update completed!\n";
?>
