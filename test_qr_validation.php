<?php
require_once('config.php');
require_once('classes/QRCodeGenerator.php');

// Test different QR codes
$testCodes = [
    'PMS-USER-00001-ADMIN-6ab0e8d0',      // This should work
    'PMS-USER-00028-SAMPLE A-887fcc39',   // This has a space - should fail with current regex
    'PMS-USER-00029-SAMPLE B-365e407a',   // This has a space - should fail with current regex
];

echo "Testing QR code validation:\n";
echo "===========================\n";

foreach ($testCodes as $qrCode) {
    echo "Testing: " . $qrCode . "\n";
    
    $validation = QRCodeGenerator::validateQRCode($qrCode);
    
    if ($validation) {
        echo "  ✅ VALID\n";
        echo "  User ID: " . $validation['user_id'] . "\n";
        echo "  Username: " . $validation['username_prefix'] . "\n";
        echo "  Hash: " . $validation['hash_prefix'] . "\n";
    } else {
        echo "  ❌ INVALID - Does not match regex pattern\n";
    }
    echo "\n";
}

echo "Current regex pattern: /^PMS-USER-(\\d{5})-([A-Z0-9_]{1,8})-([a-f0-9]{8})$/\n";
echo "The pattern [A-Z0-9_]{1,8} does not allow spaces!\n";
echo "But some QR codes in database have spaces in username part.\n";
?>
