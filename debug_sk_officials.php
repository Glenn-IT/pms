<?php
require_once('initialize.php');
require_once('classes/DBConnection.php');

$db = new DBConnection;
$conn = $db->conn;

echo "=== SK Officials Debug ===\n";
$result = $conn->query('SELECT id, firstname, lastname, position, image_path, user_id FROM sk_officials WHERE status = 1');

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row['id'] . " | Name: " . $row['firstname'] . " " . $row['lastname'] . 
             " | Position: " . $row['position'] . " | Image: " . $row['image_path'] . 
             " | User ID: " . $row['user_id'] . "\n";
        
        // Check if image file exists
        if (!empty($row['image_path'])) {
            $image_file = 'uploads/sk_officials/' . $row['image_path'];
            echo "  -> Image file exists: " . (file_exists($image_file) ? "YES" : "NO") . " ($image_file)\n";
        }
        
        // Check user avatar if user_id exists
        if (!empty($row['user_id'])) {
            $user_result = $conn->query("SELECT avatar FROM users WHERE id = " . $row['user_id']);
            if ($user_result && $user_row = $user_result->fetch_assoc()) {
                echo "  -> User avatar: " . $user_row['avatar'] . "\n";
                if (!empty($user_row['avatar'])) {
                    $avatar_file = 'uploads/avatars/' . $user_row['avatar'];
                    echo "  -> Avatar file exists: " . (file_exists($avatar_file) ? "YES" : "NO") . " ($avatar_file)\n";
                }
            }
        }
        echo "\n";
    }
} else {
    echo "No SK officials found.\n";
}
?>
