<?php
class QRCodeGenerator {
    
    /**
     * Generate a unique identifier for a user (text-based since QR generation has dependencies)
     * @param int $userId - The user ID
     * @param array $userData - Array containing user data
     * @return string - A unique identifier for the user
     */
    public static function generateUserQR($userId, $userData) {
        // Generate unique identifier containing user information
        $uniqueData = [
            'user_id' => $userId,
            'username' => $userData['username'],
            'fullname' => trim($userData['firstname'] . ' ' . ($userData['middlename'] ?? '') . ' ' . $userData['lastname']),
            'zone' => $userData['zone'],
            'generated_at' => date('Y-m-d H:i:s'),
            'unique_hash' => self::generateUniqueHash($userId, $userData)
        ];
        
        // Create a compact, scannable format
        $qrString = sprintf(
            "PMS-USER-%05d-%s-%s", 
            $userId, 
            strtoupper(str_replace(' ', '_', substr($userData['username'], 0, 8))), 
            substr($uniqueData['unique_hash'], 0, 8)
        );
        
        // Return the unique identifier (can be displayed as text or converted to QR later)
        return $qrString;
    }
    
    /**
     * Generate a unique hash for the user
     * @param int $userId
     * @param array $userData
     * @return string
     */
    private static function generateUniqueHash($userId, $userData) {
        $hashData = $userId . 
                   $userData['username'] . 
                   $userData['firstname'] . 
                   $userData['lastname'] . 
                   ($userData['birthdate'] ?? '') .
                   time() . 
                   uniqid();
        
        return substr(hash('sha256', $hashData), 0, 16);
    }
    
    /**
     * Delete old QR code file (not needed for text-based system)
     * @param string $qrPath - Path to the QR code file
     */
    public static function deleteQRCode($qrPath) {
        // No file to delete in text-based system
        return true;
    }
    
    /**
     * Validate a QR code string
     * @param string $qrCode - The QR code to validate
     * @return array|false - User data if valid, false if invalid
     */
    public static function validateQRCode($qrCode) {
        // Updated regex to allow spaces in username part and longer usernames
        if (preg_match('/^PMS-USER-(\d{5})-([A-Z0-9_ ]{1,15})-([a-f0-9]{8})$/', $qrCode, $matches)) {
            return [
                'user_id' => intval($matches[1]),
                'username_prefix' => $matches[2],
                'hash_prefix' => $matches[3]
            ];
        }
        return false;
    }
}
?>
