<?php
require_once('../config.php');
require_once('QRCodeGenerator.php');
Class Users extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function save_users(){
    // Check password confirmation first
    if (isset($_POST['password']) && isset($_POST['cpassword'])) {
        if ($_POST['password'] !== $_POST['cpassword']) {
            // Passwords don't match
            return 4; // Custom code for password mismatch
        }
    }

    // Remove confirm password so it won't try to save it to DB
    if (isset($_POST['cpassword'])) {
        unset($_POST['cpassword']);
    }

    if(empty($_POST['password']))
        unset($_POST['password']);
    else
        $_POST['password'] = md5($_POST['password']);

    extract($_POST);
    $data = '';

    // ✅ Check age validation - Don't allow users above 30
    if (isset($birthdate)) {
        $birth_date = new DateTime($birthdate);
        $current_date = new DateTime();
        $age = $current_date->diff($birth_date)->y;
        
        if ($age > 30) {
            return 6; // Age above 30 not allowed
        }
    }

    // ✅ Check for duplicate username
    $check = $this->conn->query("SELECT * FROM users WHERE username = '{$username}' " . (!empty($id) ? "AND id != '{$id}'" : ""));
    if ($check && $check->num_rows > 0) {
        return 3; // Username already exists
    }

    // ✅ Check for duplicate user details (firstname, middlename, lastname, birthdate)
    $duplicate_check = $this->conn->query("SELECT * FROM users WHERE firstname = '{$firstname}' AND middlename = '{$middlename}' AND lastname = '{$lastname}' AND birthdate = '{$birthdate}' " . (!empty($id) ? "AND id != '{$id}'" : ""));
    if ($duplicate_check && $duplicate_check->num_rows > 0) {
        return 5; // User with same details already exists
    }

    foreach($_POST as $k => $v){
        if(!in_array($k,array('id'))){
            if(!empty($data)) $data .=" , ";
            $data .= " {$k} = '{$v}' ";
        }
    }
    if(empty($id)){
        $qry = $this->conn->query("INSERT INTO users set {$data}");
        if($qry){
            $id=$this->conn->insert_id;
            $this->settings->set_flashdata('success','User Details successfully saved.');
            foreach($_POST as $k => $v){
                if($k != 'id'){
                    if(!empty($data)) $data .=" , ";
                    if($this->settings->userdata('id') == $id)
                    $this->settings->set_userdata($k,$v);
                }
            }
            if(!empty($_FILES['img']['tmp_name'])){
                if(!is_dir(base_app."uploads/avatars"))
                    mkdir(base_app."uploads/avatars");
                $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
                $fname = "uploads/avatars/$id.png";
                $accept = array('image/jpeg','image/png');
                if(!in_array($_FILES['img']['type'],$accept)){
                    $err = "Image file type is invalid";
                }
                if($_FILES['img']['type'] == 'image/jpeg')
                    $uploadfile = imagecreatefromjpeg($_FILES['img']['tmp_name']);
                elseif($_FILES['img']['type'] == 'image/png')
                    $uploadfile = imagecreatefrompng($_FILES['img']['tmp_name']);
                if(!$uploadfile){
                    $err = "Image is invalid";
                }
                $temp = imagescale($uploadfile,200,200);
                if(is_file(base_app.$fname))
                unlink(base_app.$fname);
                $upload =imagepng($temp,base_app.$fname);
                if($upload){
                    $this->conn->query("UPDATE `users` set `avatar` = CONCAT('{$fname}', '?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$id}'");
                    if($this->settings->userdata('id') == $id)
                    $this->settings->set_userdata('avatar',$fname."?v=".time());
                }
                imagedestroy($temp);
            }
            
            // Generate QR Code for new user
            try {
                $userData = $_POST;
                $userData['id'] = $id;
                $qrPath = QRCodeGenerator::generateUserQR($id, $userData);
                if ($qrPath) {
                    $this->conn->query("UPDATE `users` set `qr_code` = '{$qrPath}' where id = '{$id}'");
                }
            } catch (Exception $e) {
                // QR generation failed, but user was saved - log error but don't fail
                error_log("QR Code generation failed for user {$id}: " . $e->getMessage());
            }
            
            return 1;
        }else{
            return 2;
        }

    }else{
        $qry = $this->conn->query("UPDATE users set $data where id = {$id}");
        if($qry){
            $this->settings->set_flashdata('success','User Details successfully updated.');
            foreach($_POST as $k => $v){
                if($k != 'id'){
                    if(!empty($data)) $data .=" , ";
                    if($this->settings->userdata('id') == $id)
                        $this->settings->set_userdata($k,$v);
                }
            }
            if(!empty($_FILES['img']['tmp_name'])){
                // Check if GD extension is loaded
                if (!extension_loaded('gd')) {
                    $this->settings->set_flashdata('error','GD extension is not enabled. Please enable GD extension in php.ini to upload images.');
                    return 2;
                }
                
                if(!is_dir(base_app."uploads/avatars"))
                    mkdir(base_app."uploads/avatars");
                $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
                $fname = "uploads/avatars/$id.png";
                $accept = array('image/jpeg','image/png');
                if(!in_array($_FILES['img']['type'],$accept)){
                    $err = "Image file type is invalid";
                }
                if($_FILES['img']['type'] == 'image/jpeg')
                    $uploadfile = imagecreatefromjpeg($_FILES['img']['tmp_name']);
                elseif($_FILES['img']['type'] == 'image/png')
                    $uploadfile = imagecreatefrompng($_FILES['img']['tmp_name']);
                if(!$uploadfile){
                    $err = "Image is invalid";
                }
                $temp = imagescale($uploadfile,200,200);
                if(is_file(base_app.$fname))
                unlink(base_app.$fname);
                $upload =imagepng($temp,base_app.$fname);
                if($upload){
                    $this->conn->query("UPDATE `users` set `avatar` = CONCAT('{$fname}', '?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$id}'");
                    if($this->settings->userdata('id') == $id)
                    $this->settings->set_userdata('avatar',$fname."?v=".time());
                }
                imagedestroy($temp);
            }
            
            // Generate new QR Code for updated user (only if it's a significant update)
            try {
                // Check if this is a significant update that warrants new QR code
                $significantFields = ['firstname', 'lastname', 'username', 'zone'];
                $needsNewQR = false;
                
                foreach($significantFields as $field) {
                    if(isset($_POST[$field])) {
                        $needsNewQR = true;
                        break;
                    }
                }
                
                if($needsNewQR) {
                    // Get current user data
                    $currentUser = $this->conn->query("SELECT * FROM users WHERE id = '{$id}'")->fetch_assoc();
                    
                    // Delete old QR code if exists
                    if(!empty($currentUser['qr_code'])) {
                        QRCodeGenerator::deleteQRCode($currentUser['qr_code']);
                    }
                    
                    // Generate new QR code
                    $userData = array_merge($currentUser, $_POST);
                    $qrPath = QRCodeGenerator::generateUserQR($id, $userData);
                    if ($qrPath) {
                        $this->conn->query("UPDATE `users` set `qr_code` = '{$qrPath}' where id = '{$id}'");
                    }
                }
            } catch (Exception $e) {
                // QR generation failed, but user was updated - log error but don't fail
                error_log("QR Code generation failed for user {$id}: " . $e->getMessage());
            }
            
            return 1;
        }else{
            return "UPDATE users set $data where id = {$id}";
        }
    }
}

	
	public function delete_users(){
		extract($_POST);
		
		// Get user data before deletion to clean up files
		$user = $this->conn->query("SELECT * FROM users WHERE id = $id")->fetch_assoc();
		
		$qry = $this->conn->query("DELETE FROM users where id = $id");
		if($qry){
			$this->settings->set_flashdata('success','User Details successfully deleted.');
			
			// Delete avatar file
			if(is_file(base_app."uploads/avatars/$id.png"))
				unlink(base_app."uploads/avatars/$id.png");
			
			// Delete QR code file
			if(!empty($user['qr_code'])) {
				QRCodeGenerator::deleteQRCode($user['qr_code']);
			}
			
			return 1;
		}else{
			return false;
		}
	}
	
	public function toggle_status(){
		extract($_POST);
		$qry = $this->conn->query("UPDATE users SET status = '$status' WHERE id = '$id'");
		if($qry){
			$status_text = $status == 1 ? 'activated' : 'deactivated';
			$this->settings->set_flashdata('success',"User has been $status_text successfully.");
			return 1;
		}else{
			return false;
		}
	}
	function registration(){
		if(!empty($_POST['password']))
			$_POST['password'] = md5($_POST['password']);
		else
		unset($_POST['password']);
		extract($_POST);
		$main_field = ['firstname', 'middlename', 'lastname', 'gender', 'contact', 'email', 'status', 'password'];
		$data = "";
		$check = $this->conn->query("SELECT * FROM `customer_list` where email = '{$email}' ".($id > 0 ? " and id!='{$id}'" : "")." ")->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = 'Email already exists.';
			return json_encode($resp);
		}
		foreach($_POST as $k => $v){
			$v = $this->conn->real_escape_string($v);
			if(in_array($k, $main_field)){
				if(!empty($data)) $data .= ", ";
				$data .= " `{$k}` = '{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `customer_list` set {$data} ";
		}else{
			$sql = "UPDATE `customer_list` set {$data} where id = '{$id}' ";
		}
		$save = $this->conn->query($sql);
		if($save){
			$uid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			$resp['uid'] = $uid;
			if(!empty($id))
				$resp['msg'] = 'User Details has been updated successfully';
			else
				$resp['msg'] = 'Your Account has been created successfully';

			if(!empty($_FILES['img']['tmp_name'])){
				if(!is_dir(base_app."uploads/customers"))
					mkdir(base_app."uploads/customers");
				$ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
				$fname = "uploads/customers/$uid.png";
				$accept = array('image/jpeg','image/png');
				if(!in_array($_FILES['img']['type'],$accept)){
					$resp['msg'] = "Image file type is invalid";
				}
				if($_FILES['img']['type'] == 'image/jpeg')
					$uploadfile = imagecreatefromjpeg($_FILES['img']['tmp_name']);
				elseif($_FILES['img']['type'] == 'image/png')
					$uploadfile = imagecreatefrompng($_FILES['img']['tmp_name']);
				if(!$uploadfile){
					$resp['msg'] = "Image is invalid";
				}
				$temp = imagescale($uploadfile,200,200);
				if(is_file(base_app.$fname))
				unlink(base_app.$fname);
				$upload =imagepng($temp,base_app.$fname);
				if($upload){
					$this->conn->query("UPDATE `customer_list` set `avatar` = CONCAT('{$fname}', '?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$uid}'");
				}
				imagedestroy($temp);
			}
			if(!empty($uid) && $this->settings->userdata('login_type') != 1){
				$user = $this->conn->query("SELECT * FROM `customer_list` where id = '{$uid}' ");
				if($user->num_rows > 0){
					$res = $user->fetch_array();
					foreach($res as $k => $v){
						if(!is_numeric($k) && $k != 'password'){
							$this->settings->set_userdata($k, $v);
						}
					}
					$this->settings->set_userdata('login_type', '2');
				}
			}
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = $this->conn->error;
			$resp['sql'] = $sql;
		}
		if($resp['status'] == 'success' && isset($resp['msg']))
		$this->settings->set_flashdata('success', $resp['msg']);
		return json_encode($resp);
	}
	public function delete_customer(){
		extract($_POST);
		$avatar = $this->conn->query("SELECT avatar FROM customer_list where id = $id");
		$qry = $this->conn->query("DELETE FROM customer_list where id = $id");
		if($qry){
			$this->settings->set_flashdata('success','Customer Details has been deleted successfully.');
			$resp['status'] = 'success';
			if($avatar->num_rows > 0){
				$avatar = explode("?", $avatar->fetch_array()[0])[0];
				if(is_file(base_app.$avatar)){
					unlink(base_app.$avatar);
				}
			}
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = $this->conn->error;
		}

		return json_encode($resp);
	}
	
	public function get_users_over_31(){
		// Get all active users who are 31 or older
		$users_over_31 = array();
		$users_query = $this->conn->query("SELECT id, firstname, lastname, birthdate, status FROM users WHERE status = 1 AND birthdate IS NOT NULL");
		
		if($users_query && $users_query->num_rows > 0) {
			while($user = $users_query->fetch_assoc()) {
				if(!empty($user['birthdate'])) {
					$birth_date = new DateTime($user['birthdate']);
					$current_date = new DateTime();
					$age = $current_date->diff($birth_date)->y;
					
					// If user is 31 or older, add to array
					if($age >= 31) {
						$user['age'] = $age;
						$users_over_31[] = $user;
					}
				}
			}
		}
		
		return $users_over_31;
	}

	public function check_and_deactivate_users_over_31(){
		// Get all active users
		$users_query = $this->conn->query("SELECT id, firstname, lastname, birthdate, status FROM users WHERE status = 1 AND birthdate IS NOT NULL");
		$deactivated_count = 0;
		
		if($users_query && $users_query->num_rows > 0) {
			while($user = $users_query->fetch_assoc()) {
				if(!empty($user['birthdate'])) {
					$birth_date = new DateTime($user['birthdate']);
					$current_date = new DateTime();
					$age = $current_date->diff($birth_date)->y;
					
					// If user is 31 or older, deactivate them
					if($age >= 31) {
						$update_query = $this->conn->query("UPDATE users SET status = 0 WHERE id = {$user['id']}");
						if($update_query) {
							$deactivated_count++;
						}
					}
				}
			}
		}
		
		return $deactivated_count;
	}
	
}

$users = new users();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
	case 'save':
		echo $users->save_users();
	break;
	case 'delete':
		echo $users->delete_users();
	break;
	case 'toggle_status':
		echo $users->toggle_status();
	break;
	case 'get_users_over_31':
		echo json_encode($users->get_users_over_31());
	break;
	case 'check_age':
		echo $users->check_and_deactivate_users_over_31();
	break;
	break;
	case 'registration':
		echo $users->registration();
	break;
	case 'delete_customer':
		echo $users->delete_customer();
	break;
	default:
		// echo $sysset->index();
		break;
}