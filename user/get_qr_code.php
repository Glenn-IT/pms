<?php
require_once('../config.php');

// Check if user is logged in
if($_settings->userdata('id') <= 0 || $_settings->userdata('type') != 2){
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit;
}

$user_id = $_settings->userdata('id');

// Fetch user data including QR code
$qry = $conn->query("SELECT id, firstname, middlename, lastname, username, zone, qr_code FROM users WHERE id = '{$user_id}' AND type = 2");

if($qry && $qry->num_rows > 0){
    $user_data = $qry->fetch_assoc();
    
    // Check if QR code exists
    if(empty($user_data['qr_code'])){
        // Generate QR code if it doesn't exist
        require_once('../classes/QRCodeGenerator.php');
        
        $qrCode = QRCodeGenerator::generateUserQR($user_data['id'], $user_data);
        
        if($qrCode){
            // Update database with new QR code
            $conn->query("UPDATE users SET qr_code = '{$qrCode}' WHERE id = '{$user_data['id']}'");
            $user_data['qr_code'] = $qrCode;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to generate QR code']);
            exit;
        }
    }
    
    // Return QR code data
    echo json_encode([
        'status' => 'success',
        'data' => [
            'qr_code' => $user_data['qr_code'],
            'user_id' => $user_data['id'],
            'fullname' => trim($user_data['firstname'] . ' ' . ($user_data['middlename'] ?? '') . ' ' . $user_data['lastname']),
            'username' => $user_data['username'],
            'zone' => $user_data['zone']
        ]
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'User not found']);
}
?>
