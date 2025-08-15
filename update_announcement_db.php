<?php
echo "Starting database update...\n";

require_once('config.php');
echo "Config loaded\n";

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
echo "Database connection attempted\n";

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error . "\n");
}
echo "Database connected successfully\n";

// Add images column
echo "Adding images column...\n";
$sql1 = 'ALTER TABLE `announcement_list` ADD COLUMN `images` TEXT NULL AFTER `image_path`';
if ($conn->query($sql1)) {
    echo "Images column added successfully\n";
} else {
    if (strpos($conn->error, 'Duplicate column name') !== false) {
        echo "Images column already exists\n";
    } else {
        echo "Error adding images column: " . $conn->error . "\n";
    }
}

// Update existing records
echo "Updating existing records...\n";
$sql2 = 'UPDATE `announcement_list` SET `images` = CONCAT(\'["\', `image_path`, \'"]\') WHERE `image_path` IS NOT NULL AND `image_path` != \'\'';
if ($conn->query($sql2)) {
    echo "Existing records updated successfully\n";
} else {
    echo "Error updating existing records: " . $conn->error . "\n";
}

$conn->close();
echo "Database update completed\n";
?>
