<?php
require_once('config.php');
require_once('classes/QRCodeGenerator.php');

echo "Testing QR code validation fix:\n";
echo "===============================\n";

// Test with all QR codes from database
$query = $conn->query('SELECT id, username, qr_code FROM users WHERE qr_code IS NOT NULL');

if ($query) {
    $total = 0;
    $valid = 0;
    
    while ($row = $query->fetch_assoc()) {
        $total++;
        $qrCode = $row['qr_code'];
        
        echo "Testing User ID " . $row['id'] . " (" . $row['username'] . "):\n";
        echo "QR Code: " . $qrCode . "\n";
        
        $validation = QRCodeGenerator::validateQRCode($qrCode);
        
        if ($validation) {
            $valid++;
            echo "  ✅ VALID\n";
            echo "  Extracted User ID: " . $validation['user_id'] . "\n";
            echo "  Username prefix: '" . $validation['username_prefix'] . "'\n";
            echo "  Hash prefix: " . $validation['hash_prefix'] . "\n";
            
            // Verify extracted user ID matches actual user ID
            if ($validation['user_id'] == $row['id']) {
                echo "  ✅ User ID matches\n";
            } else {
                echo "  ❌ User ID mismatch!\n";
            }
        } else {
            echo "  ❌ INVALID\n";
        }
        echo "\n";
    }
    
    echo "Results:\n";
    echo "========\n";
    echo "Total QR codes tested: " . $total . "\n";
    echo "Valid QR codes: " . $valid . "\n";
    echo "Invalid QR codes: " . ($total - $valid) . "\n";
    
    if ($valid == $total) {
        echo "🎉 All QR codes are now valid!\n";
    } else {
        echo "⚠️  Some QR codes are still invalid.\n";
    }
}
?>
