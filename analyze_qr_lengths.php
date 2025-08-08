<?php
require_once('config.php');

// Check for QR codes with long usernames
$query = $conn->query("SELECT qr_code, LENGTH(qr_code) as qr_length FROM users WHERE qr_code IS NOT NULL");

if ($query) {
    echo "Analyzing QR code lengths:\n";
    echo "=========================\n";
    
    while ($row = $query->fetch_assoc()) {
        $qrCode = $row['qr_code'];
        
        // Extract the username part manually
        if (preg_match('/^PMS-USER-\d{5}-(.+)-[a-f0-9]{8}$/', $qrCode, $matches)) {
            $usernamePart = $matches[1];
            echo "QR: " . $qrCode . "\n";
            echo "Username part: '" . $usernamePart . "' (length: " . strlen($usernamePart) . ")\n";
            echo "---\n";
        }
    }
}
?>
