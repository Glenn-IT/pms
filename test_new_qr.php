<?php
require_once('config.php');
require_once('classes/QRCodeGenerator.php');

// Test the new QR code generation
$testUserData = [
    'username' => 'test_user',
    'firstname' => 'Test',
    'middlename' => 'Middle',
    'lastname' => 'User',
    'zone' => '1',
    'birthdate' => '1995-01-01'
];

echo "Testing QR Code generation...\n";

$qrPath = QRCodeGenerator::generateUserQR(999, $testUserData);

if ($qrPath) {
    echo "✅ QR Code generated successfully: " . $qrPath . "\n";
    echo "📁 File exists: " . (file_exists($qrPath) ? 'Yes' : 'No') . "\n";
    if (file_exists($qrPath)) {
        echo "📏 File size: " . filesize($qrPath) . " bytes\n";
    }
} else {
    echo "❌ QR Code generation failed\n";
}
?>
