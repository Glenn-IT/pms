<?php
require_once('../../config.php');

class SKOfficials {
    private $conn;
    private $settings;
    
    public function __construct(){
        global $_settings;
        $this->settings = $_settings;
        
        // Create database connection
        $this->conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        
        if($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    function save_official(){
        try {
            extract($_POST);
            
            // Validate required fields
            if(empty($name) || empty($contact) || empty($position)) {
                return json_encode(array('status' => 'error', 'msg' => 'Name, contact, and position are required.'));
            }
            
            // Validate position
            $valid_positions = ['chairman', 'secretary', 'treasurer', 'kagawad1', 'kagawad2', 'kagawad3', 'kagawad4'];
            if(!in_array($position, $valid_positions)) {
                return json_encode(array('status' => 'error', 'msg' => 'Invalid position.'));
            }
            
            // Handle image upload
            $image_path = null;
            if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image_path = $this->handleImageUpload($_FILES['image'], $position);
                if($image_path === false) {
                    return json_encode(array('status' => 'error', 'msg' => 'Failed to upload image. Please check file type and size.'));
                }
            }
            
            // Escape data to prevent SQL injection
            $name = $this->conn->real_escape_string($name);
            $contact = $this->conn->real_escape_string($contact);
            $email = !empty($email) ? $this->conn->real_escape_string($email) : '';
            $age = !empty($age) ? intval($age) : null;
            $address = !empty($address) ? $this->conn->real_escape_string($address) : '';
            $start_date = !empty($start_date) ? $this->conn->real_escape_string($start_date) : '';
            $status = !empty($status) ? $this->conn->real_escape_string($status) : 'active';
            $position = $this->conn->real_escape_string($position);
            
            // Build data string
            $data = " name = '$name' ";
            $data .= ", contact = '$contact' ";
            $data .= ", email = " . ($email ? "'$email'" : "NULL");
            $data .= ", age = " . ($age !== null ? $age : "NULL");
            $data .= ", address = " . ($address ? "'$address'" : "NULL");
            if($image_path) {
                $data .= ", image = '$image_path' ";
            }
            $data .= ", start_date = " . ($start_date ? "'$start_date'" : "NULL");
            $data .= ", status = '$status' ";
            
            // Check if official exists
            $check_query = "SELECT id FROM `sk_officials` WHERE `position` = '$position'";
            $check_result = $this->conn->query($check_query);
            
            if($check_result && $check_result->num_rows > 0) {
                // Update existing official
                $update_query = "UPDATE `sk_officials` SET $data WHERE `position` = '$position'";
                $save = $this->conn->query($update_query);
                if($save) {
                    return json_encode(array('status' => 'success', 'msg' => 'SK Official information updated successfully.'));
                } else {
                    return json_encode(array('status' => 'error', 'msg' => 'Failed to update official information: ' . $this->conn->error));
                }
            } else {
                // Insert new official
                $insert_query = "INSERT INTO `sk_officials` SET position = '$position', $data";
                $save = $this->conn->query($insert_query);
                if($save) {
                    return json_encode(array('status' => 'success', 'msg' => 'SK Official information saved successfully.'));
                } else {
                    return json_encode(array('status' => 'error', 'msg' => 'Failed to save official information: ' . $this->conn->error));
                }
            }
            
        } catch (Exception $e) {
            return json_encode(array('status' => 'error', 'msg' => 'Database error: ' . $e->getMessage()));
        }
    }

    function get_official(){
        extract($_GET);
        
        if(empty($position)) {
            return json_encode(array('status' => 'error', 'msg' => 'Position is required.'));
        }
        
        // Escape position to prevent SQL injection
        $position = $this->conn->real_escape_string($position);
        
        $qry = $this->conn->query("SELECT * FROM `sk_officials` WHERE `position` = '$position' AND `status` = 'active'");
        
        if($qry && $qry->num_rows > 0) {
            $official = $qry->fetch_assoc();
            return json_encode(array('status' => 'success', 'data' => $official));
        } else {
            return json_encode(array('status' => 'error', 'msg' => 'Official not found.'));
        }
    }

    function get_all_officials(){
        $officials = array();
        
        $qry = $this->conn->query("SELECT * FROM `sk_officials` WHERE `status` = 'active' ORDER BY 
            CASE position 
                WHEN 'chairman' THEN 1 
                WHEN 'secretary' THEN 2 
                WHEN 'treasurer' THEN 3 
                WHEN 'kagawad1' THEN 4 
                WHEN 'kagawad2' THEN 5 
                WHEN 'kagawad3' THEN 6 
                WHEN 'kagawad4' THEN 7 
            END");
            
        while($row = $qry->fetch_assoc()) {
            $officials[$row['position']] = $row;
        }
        
        return json_encode(array('status' => 'success', 'data' => $officials));
    }

    function delete_official(){
        extract($_POST);
        
        if(empty($position)) {
            return json_encode(array('status' => 'error', 'msg' => 'Position is required.'));
        }
        
        // Escape position to prevent SQL injection
        $position = $this->conn->real_escape_string($position);
        
        $delete = $this->conn->query("UPDATE `sk_officials` SET `status` = 'inactive' WHERE `position` = '$position'");
        
        if($delete) {
            return json_encode(array('status' => 'success', 'msg' => 'SK Official removed successfully.'));
        } else {
            return json_encode(array('status' => 'error', 'msg' => 'Failed to remove official: ' . $this->conn->error));
        }
    }
    
    private function handleImageUpload($file, $position) {
        $upload_dir = '../../uploads/sk_officials/';
        
        // Create directory if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        // Validate file type
        $allowed_types = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');
        if (!in_array($file['type'], $allowed_types)) {
            return false;
        }
        
        // Validate file size (max 5MB)
        if ($file['size'] > 5 * 1024 * 1024) {
            return false;
        }
        
        // Get file extension
        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        // Generate unique filename
        $filename = $position . '_' . time() . '.' . $file_extension;
        $upload_path = $upload_dir . $filename;
        
        // Delete old image if exists
        $this->deleteOldImage($position);
        
        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $upload_path)) {
            return 'uploads/sk_officials/' . $filename;
        }
        
        return false;
    }
    
    private function deleteOldImage($position) {
        $qry = $this->conn->query("SELECT image FROM `sk_officials` WHERE `position` = '$position'");
        if($qry && $qry->num_rows > 0) {
            $row = $qry->fetch_assoc();
            if($row['image'] && file_exists('../../' . $row['image'])) {
                unlink('../../' . $row['image']);
            }
        }
    }
    
    // Destructor to close database connection
    public function __destruct() {
        if($this->conn) {
            $this->conn->close();
        }
    }
}

$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SKOfficials();

switch ($action) {
    case 'save_official':
        echo $sysset->save_official();
        break;
    case 'get_official':
        echo $sysset->get_official();
        break;
    case 'get_all_officials':
        echo $sysset->get_all_officials();
        break;
    case 'delete_official':
        echo $sysset->delete_official();
        break;
    default:
        echo json_encode(array('status' => 'error', 'msg' => 'Invalid action.'));
        break;
}
?>
