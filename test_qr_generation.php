<?php
require_once('libs/phpqrcode/phpqrcode.php');

// Test QR code generation
$testData = "TEST_QR_CODE_" . time();

$filename = __DIR__ . '/uploads/qrcodes/test_qr_' . time() . '.png';

try {
    QRcode::png($testData, $filename, QR_ECLEVEL_M, 6, 2);
    echo "✅ Test QR code generated successfully: " . $filename . "\n";
    echo "📄 QR Data: " . $testData . "\n";
    echo "📁 File exists: " . (file_exists($filename) ? 'Yes' : 'No') . "\n";
} catch (Exception $e) {
    echo "❌ Failed to generate test QR code: " . $e->getMessage() . "\n";
}
?>
