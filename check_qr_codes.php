<?php
require_once('config.php');

// Check what QR codes look like in the database
$query = $conn->query('SELECT id, username, qr_code FROM users WHERE qr_code IS NOT NULL LIMIT 5');

if ($query) {
    echo "QR Codes in database:\n";
    echo "=====================\n";
    while ($row = $query->fetch_assoc()) {
        echo "User ID: " . $row['id'] . "\n";
        echo "Username: " . $row['username'] . "\n"; 
        echo "QR Code: " . $row['qr_code'] . "\n";
        echo "Length: " . strlen($row['qr_code']) . "\n";
        echo "---\n";
    }
} else {
    echo "Error: " . $conn->error . "\n";
}

// Also test the validation function
require_once('classes/QRCodeGenerator.php');

echo "\nTesting validation function:\n";
echo "============================\n";

// Get a sample QR code
$sampleQuery = $conn->query('SELECT qr_code FROM users WHERE qr_code IS NOT NULL LIMIT 1');
if ($sampleQuery && $sampleQuery->num_rows > 0) {
    $sample = $sampleQuery->fetch_assoc();
    $sampleQR = $sample['qr_code'];
    
    echo "Sample QR: " . $sampleQR . "\n";
    
    $validation = QRCodeGenerator::validateQRCode($sampleQR);
    
    if ($validation) {
        echo "Validation: SUCCESS\n";
        echo "User ID: " . $validation['user_id'] . "\n";
        echo "Username prefix: " . $validation['username_prefix'] . "\n";
        echo "Hash prefix: " . $validation['hash_prefix'] . "\n";
    } else {
        echo "Validation: FAILED\n";
        echo "The QR code does not match the expected pattern.\n";
        
        // Show the expected pattern
        echo "Expected pattern: PMS-USER-{5-digit-id}-{1-8-chars-username}-{8-char-hash}\n";
        echo "Example: PMS-USER-00001-JOHN-a1b2c3d4\n";
    }
}
?>
