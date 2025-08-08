<?php
require_once('config.php');

// Check if the qr_code column already exists
$checkColumn = $conn->query("SHOW COLUMNS FROM `users` LIKE 'qr_code'");
if($checkColumn->num_rows == 0) {
    // Add the qr_code column
    $addColumn = $conn->query("ALTER TABLE `users` ADD COLUMN `qr_code` TEXT NULL AFTER `avatar`");
    if($addColumn) {
        echo "✅ Successfully added qr_code column to users table.\n";
    } else {
        echo "❌ Failed to add qr_code column: " . $conn->error . "\n";
    }
} else {
    echo "ℹ️ qr_code column already exists in users table.\n";
}

// Create qrcodes directory if it doesn't exist
$qrDir = 'uploads/qrcodes/';
if (!is_dir($qrDir)) {
    if(mkdir($qrDir, 0755, true)) {
        echo "✅ Created uploads/qrcodes directory.\n";
    } else {
        echo "❌ Failed to create uploads/qrcodes directory.\n";
    }
} else {
    echo "ℹ️ uploads/qrcodes directory already exists.\n";
}

echo "\n🎉 QR Code feature setup complete!\n";
echo "You can now create users with unique QR codes.\n";
?>
