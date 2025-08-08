<?php
require_once('config.php');
require_once('classes/QRCodeGenerator.php');

// Test the new text-based QR code generation
$testUserData = [
    'username' => 'test_user',
    'firstname' => 'Test',
    'middlename' => 'Middle',
    'lastname' => 'User',
    'zone' => '1',
    'birthdate' => '1995-01-01'
];

echo "Testing text-based QR Code generation...\n";

$qrCode = QRCodeGenerator::generateUserQR(999, $testUserData);

if ($qrCode) {
    echo "✅ QR Code generated successfully: " . $qrCode . "\n";
    
    // Test validation
    $validation = QRCodeGenerator::validateQRCode($qrCode);
    if ($validation) {
        echo "✅ QR Code validation successful:\n";
        echo "   User ID: " . $validation['user_id'] . "\n";
        echo "   Username prefix: " . $validation['username_prefix'] . "\n";
        echo "   Hash prefix: " . $validation['hash_prefix'] . "\n";
    } else {
        echo "❌ QR Code validation failed\n";
    }
} else {
    echo "❌ QR Code generation failed\n";
}

// Test another user
echo "\nTesting another user...\n";
$testUserData2 = [
    'username' => 'john_doe',
    'firstname' => 'John',
    'middlename' => '',
    'lastname' => 'Doe',
    'zone' => '3',
    'birthdate' => '1990-05-15'
];

$qrCode2 = QRCodeGenerator::generateUserQR(123, $testUserData2);
echo "QR Code for user 123: " . $qrCode2 . "\n";
?>
