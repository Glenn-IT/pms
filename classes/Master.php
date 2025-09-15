<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function delete_img(){
		extract($_POST);
		if(is_file($path)){
			if(unlink($path)){
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete '.$path;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown '.$path.' path';
		}
		return json_encode($resp);
	}
	function save_prison(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string(htmlspecialchars($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `prison_list` where `name` = '{$this->conn->real_escape_string($name)}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Prison already exists.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `prison_list` set {$data} ";
		}else{
			$sql = "UPDATE `prison_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$cid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['cid'] = $cid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Prison successfully saved.";
			else
				$resp['msg'] = " Prison successfully updated.";
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		// if($resp['status'] == 'success')
		// 	$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_prison(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `prison_list` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Prison successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_cell(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string(htmlspecialchars($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `cell_list` where `name` = '{$this->conn->real_escape_string($name)}' and `prison_id` = '{$prison_id}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Prison Cell Block already exists.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `cell_list` set {$data} ";
		}else{
			$sql = "UPDATE `cell_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$cid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['cid'] = $cid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Cell Block successfully saved.";
			else
				$resp['msg'] = " Cell Block successfully updated.";
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		// if($resp['status'] == 'success')
		// 	$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_cell(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `cell_list` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Cell Block successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_crime(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string(htmlspecialchars($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `crime_list` where `name` = '{$this->conn->real_escape_string($name)}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Crime already exists.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `crime_list` set {$data} ";
		}else{
			$sql = "UPDATE `crime_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$cid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['cid'] = $cid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Crime successfully saved.";
			else
				$resp['msg'] = " Crime successfully updated.";
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		// if($resp['status'] == 'success')
		// 	$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_crime(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `crime_list` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Crime successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_inmate(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id')) && !is_array($_POST[$k])){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string(htmlspecialchars($v));
				if(!empty($v))
				$data .= " `{$k}`='{$v}' ";
				else
				$data .= " `{$k}`= NULL ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `inmate_list` where `code` = '{$this->conn->real_escape_string($code)}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Inmate Code already exists.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `inmate_list` set {$data} ";
		}else{
			$sql = "UPDATE `inmate_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$iid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['iid'] = $iid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Inmate successfully saved.";
			else
				$resp['msg'] = " Inmate successfully updated.";
			if(isset($crime_ids)){
				$this->conn->query("DELETE FROM `inmate_crimes` where inmate_id = '{$iid}'");
				$data = '';
				foreach($crime_ids as $k=>$v){
					if(!empty($data)) $data .=", ";
					$data .= "('{$iid}', '{$v}')";
				}
				if(!empty($data)){
					$sql2 = "INSERT INTO `inmate_crimes` (`inmate_id`, `crime_id`) VALUES {$data}";
					$save2 = $this->conn->query($sql2);
					if(!$save2){
						$resp['status'] = 'failed';
						$resp['msg'] = $this->conn->error;
						$resp['sql'] = $sql2;
					}
				}
			}
			if(!empty($_FILES['img']['tmp_name'])){
				$ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
				$dir = "uploads/inmates/";
				if(!is_dir(base_app.$dir))
					mkdir(base_app.$dir);
				$fname = $dir.$iid.'.png';
				$accept = array('image/jpeg','image/png');
				if(!in_array($_FILES['img']['type'],$accept)){
					$resp['msg'] .= "Image file type is invalid";
				}
				if($_FILES['img']['type'] == 'image/jpeg')
					$uploadfile = imagecreatefromjpeg($_FILES['img']['tmp_name']);
				elseif($_FILES['img']['type'] == 'image/png')
					$uploadfile = imagecreatefrompng($_FILES['img']['tmp_name']);
				if(!$uploadfile){
					$resp['msg'] .= "Image is invalid";
				}
				$temp = imagescale($uploadfile,200,200);
				if(is_file(base_app.$fname))
				unlink(base_app.$fname);
				$upload =imagepng($temp,base_app.$fname);
				if($upload){
					$qry = $this->conn->query("UPDATE inmate_list set image_path = CONCAT('{$fname}', '?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$iid}' ");
				}
				imagedestroy($temp);
			}
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success' && isset($resp['msg']))
			$this->settings->set_flashdata('success',$resp['msg']);
			
			return json_encode($resp);
	}
	function delete_inmate(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `inmate_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Inmate successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_action(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string(htmlspecialchars($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `action_list` where `name` = '{$this->conn->real_escape_string($name)}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Action already exists.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `action_list` set {$data} ";
		}else{
			$sql = "UPDATE `action_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$cid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['cid'] = $cid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Action successfully saved.";
			else
				$resp['msg'] = " Action successfully updated.";
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		// if($resp['status'] == 'success')
		// 	$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_action(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `action_list` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Action successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_record(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string(htmlspecialchars($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `record_list` set {$data} ";
		}else{
			$sql = "UPDATE `record_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$cid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['cid'] = $cid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Record successfully saved.";
			else
				$resp['msg'] = " Record successfully updated.";
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_record(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `record_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Record successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function update_privilege(){
		extract($_POST);
		$vp = isset($visiting_privilege) && $visiting_privilege == 'on' ? 1 : 0;
		$update = $this->conn->query("UPDATE `inmate_list` set `visiting_privilege` = $vp where id = '{$id}' ");
		if($update){
			$resp['status'] = 'success';
			$resp['msg'] = " Inmate's Privilege has been updated.";
		}else{
			$resp['status'] = 'success';
			$resp['msg'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function save_visit(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string(htmlspecialchars($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `visit_list` set {$data} ";
		}else{
			$sql = "UPDATE `visit_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$cid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['cid'] = $cid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Visitor Details successfully saved.";
			else
				$resp['msg'] = " Visitor Details successfully updated.";
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_visit(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `visit_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Visitor Details successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	//Announcement Code
	function save_announcement() {
    extract($_POST);
    $data = "";

    // Sanitize title & description
    $title = $this->conn->real_escape_string(htmlspecialchars($title));
    $description = $this->conn->real_escape_string(htmlspecialchars($description));

    // Check for duplicate title and date
    if(!empty($title) && !empty($date_created)){
        $date_only = date('Y-m-d', strtotime($date_created));
        $duplicate_check = $this->conn->query("SELECT * FROM `announcement_list` WHERE `title` = '{$title}' AND DATE(`date_created`) = '{$date_only}'" . (!empty($id) ? " AND id != {$id}" : ""));
        
        if($duplicate_check && $duplicate_check->num_rows > 0){
            $resp['status'] = 'failed';
            $resp['msg'] = "An announcement with the same title and date already exists.";
            return json_encode($resp);
        }
    }

    if(!empty($title))
        $data .= " `title`='{$title}' ";
    if(!empty($description))
        $data .= ", `description`='{$description}' ";
    if(!empty($date_created))
        $data .= ", `date_created`='{$date_created}' ";

    if(!empty($id)){
        $sql = "UPDATE `announcement_list` SET {$data} WHERE id = '{$id}'";
    } else {
        $sql = "INSERT INTO `announcement_list` SET {$data}";
    }

    $save = $this->conn->query($sql);
    if($this->capture_err())
        return $this->capture_err();

    if($save){
        $aid = !empty($id) ? $id : $this->conn->insert_id;
        $resp['aid'] = $aid;
        $resp['status'] = 'success';

        // Handle multiple images upload
        if(isset($_FILES['images']) && !empty($_FILES['images']['tmp_name'][0])){
            $dir = "uploads/announcements/";
            if(!is_dir(base_app . $dir)) mkdir(base_app . $dir);
            
            $imagePaths = [];
            
            for($i = 0; $i < count($_FILES['images']['tmp_name']); $i++){
                if($_FILES['images']['tmp_name'][$i] != ''){
                    $ext = pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION);
                    $fname = $dir . $aid . '_' . ($i + 1) . '.' . $ext;
                    
                    if(move_uploaded_file($_FILES['images']['tmp_name'][$i], base_app . $fname)){
                        $imagePaths[] = $fname;
                    }
                }
            }
            
            if(!empty($imagePaths)){
                // Store first image in image_path for backward compatibility
                $this->conn->query("UPDATE announcement_list SET image_path = '{$imagePaths[0]}' WHERE id = '{$aid}'");
                
                // Store all images as JSON in images column (add this column if it doesn't exist)
                $imagesJson = json_encode($imagePaths);
                $this->conn->query("UPDATE announcement_list SET images = '{$imagesJson}' WHERE id = '{$aid}'");
            }
        }

        $resp['msg'] = "Announcement successfully saved.";
    } else {
        $resp['status'] = 'failed';
        $resp['msg'] = $this->conn->error . " [{$sql}]";
    }

    return json_encode($resp);
}


	function delete_announcement() {
		extract($_POST);
	
		$get = $this->conn->query("SELECT * FROM announcement_list WHERE id = '{$id}'");
		if($get->num_rows > 0){
			$ann = $get->fetch_assoc();
			
			// Delete multiple images if exists
			if(!empty($ann['images'])){
				$images = json_decode($ann['images'], true);
				if($images){
					foreach($images as $imagePath){
						if(is_file(base_app . $imagePath)){
							unlink(base_app . $imagePath);
						}
					}
				}
			}
			
			// Delete single image for backward compatibility
			if(!empty($ann['image_path']) && is_file(base_app . $ann['image_path'])){
				unlink(base_app . $ann['image_path']);
			}
		}
	
		$del = $this->conn->query("DELETE FROM `announcement_list` WHERE id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Announcement successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
	
		return json_encode($resp);
	}

	function get_latest_announcement(){
		$qry = $this->conn->query("SELECT * FROM `announcement_list` ORDER BY `date_created` DESC LIMIT 1");
		if($qry && $qry->num_rows > 0){
			$row = $qry->fetch_assoc();
			return json_encode([
				'status' => 'success',
				
				'image_path' => $row['image_path'], // e.g. 'uploads/announcements/1.png'
				'date' => date("F j, Y - g:i A", strtotime($row['date_created'])),
				'description' => $row['description']
			]);
		} else {
			return json_encode([
				'status' => 'fail',
				'msg' => 'No announcement found.'
			]);
		}
	}

	function get_all_announcements(){
		$announcements = [];
		$qry = $this->conn->query("SELECT * FROM announcement_list ORDER BY date_created DESC");
		if($qry){
			while($row = $qry->fetch_assoc()){
				$row['date'] = date("F j, Y - g:i A", strtotime($row['date_created']));
				
				// Handle multiple images
				if(!empty($row['images'])){
					$row['images'] = json_decode($row['images'], true);
				} else if(!empty($row['image_path'])){
					// For backward compatibility
					$row['images'] = [$row['image_path']];
				} else {
					$row['images'] = [];
				}
				
				$announcements[] = $row;
			}
			return json_encode(['status' => 'success', 'data' => $announcements]);
		} else {
			return json_encode(['status' => 'failed', 'msg' => $this->conn->error]);
		}
	}
	
	function check_announcement_duplicate(){
		extract($_GET);
		$title = $this->conn->real_escape_string(htmlspecialchars($title));
		$date_only = date('Y-m-d', strtotime($date));
		$id = isset($id) ? $id : '';
		
		$duplicate_check = $this->conn->query("SELECT * FROM `announcement_list` WHERE `title` = '{$title}' AND DATE(`date_created`) = '{$date_only}'" . (!empty($id) ? " AND id != {$id}" : ""));
		
		if($duplicate_check && $duplicate_check->num_rows > 0){
			return json_encode(['status' => 'duplicate', 'msg' => 'Duplicate found']);
		} else {
			return json_encode(['status' => 'unique', 'msg' => 'No duplicate found']);
		}
	}
	
	function search_announcements(){
		extract($_GET); // get `keyword`
		$announcements = [];
		$keyword = $this->conn->real_escape_string($keyword);
		$qry = $this->conn->query("SELECT * FROM `announcement_list` WHERE `description` LIKE '%$keyword%' ORDER BY date_created DESC");
		if($qry){
			while($row = $qry->fetch_assoc()){
				$row['date'] = date("F j, Y - g:i A", strtotime($row['date_created']));
				$announcements[] = $row;
			}
			return json_encode(['status' => 'success', 'data' => $announcements]);
		} else {
			return json_encode(['status' => 'failed', 'msg' => $this->conn->error]);
		}
	}
	
	
	
//End of Announcement Code

//Start Event Code
function save_event() {
    extract($_POST);
    $data = "";

    $title = $this->conn->real_escape_string(htmlspecialchars($title));
    $description = $this->conn->real_escape_string(htmlspecialchars($description));

    // Check for duplicate title and time (same title and same time, regardless of date)
    if(!empty($title) && !empty($date)) {
        try {
            $inputDateTime = new DateTime($date);
            $inputTime = $inputDateTime->format('H:i:s');
            
            // Query to check for existing events with same title and time
            $duplicateQuery = "SELECT id, title, date_created FROM `event_list` 
                              WHERE `title` = '{$title}' 
                              AND TIME(`date_created`) = '{$inputTime}'";
            
            // If updating, exclude the current record from duplicate check
            if(!empty($id)) {
                $duplicateQuery .= " AND id != '{$id}'";
            }
            
            $duplicateCheck = $this->conn->query($duplicateQuery);
            
            if($this->capture_err())
                return $this->capture_err();
                
            if($duplicateCheck && $duplicateCheck->num_rows > 0) {
                $existing = $duplicateCheck->fetch_assoc();
                try {
                    $existingDateTime = new DateTime($existing['date_created']);
                    $existingDate = $existingDateTime->format('Y-m-d');
                    $existingTime = $existingDateTime->format('H:i');
                } catch (Exception $e) {
                    $existingDate = 'unknown date';
                    $existingTime = $inputTime;
                }
                
                $resp['status'] = 'failed';
                $resp['msg'] = "An event with the same title '{$title}' and time {$existingTime} already exists on {$existingDate}. Please use a different title or time.";
                return json_encode($resp);
            }
        } catch (Exception $e) {
            // If date parsing fails, continue without duplicate check
            error_log("Date parsing error in save_event: " . $e->getMessage());
        }
    }

    if(!empty($title))
        $data .= " `title`='{$title}' ";
    if(!empty($description))
        $data .= ", `description`='{$description}' ";
    if(!empty($date))
        $data .= ", `date_created`='{$date}' ";

    if(!empty($id)){
        $sql = "UPDATE `event_list` SET {$data} WHERE id = '{$id}'";
    } else {
        $sql = "INSERT INTO `event_list` SET {$data}";
    }

    $save = $this->conn->query($sql);
    if($this->capture_err())
        return $this->capture_err();

    if($save){
        $eid = !empty($id) ? $id : $this->conn->insert_id;
        $resp['eid'] = $eid;
        $resp['status'] = 'success';

        // Handle multiple image upload
        if(isset($_FILES['images']) && !empty($_FILES['images']['name'][0])){
            $dir = "uploads/events/";
            if(!is_dir(base_app . $dir)) mkdir(base_app . $dir, 0777, true);
            
            $imagePaths = [];
            $totalFiles = count($_FILES['images']['name']);
            
            for($i = 0; $i < $totalFiles; $i++){
                if($_FILES['images']['error'][$i] == UPLOAD_ERR_OK){
                    $ext = pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION);
                    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                    
                    if(in_array(strtolower($ext), $allowedTypes)){
                        $filename = $eid . '_' . time() . '_' . $i . '.' . $ext;
                        $filepath = $dir . $filename;
                        
                        if(move_uploaded_file($_FILES['images']['tmp_name'][$i], base_app . $filepath)){
                            $imagePaths[] = $filepath;
                        }
                    }
                }
            }
            
            if(!empty($imagePaths)){
                $imagePathsJson = json_encode($imagePaths);
                $imagePathsJson = $this->conn->real_escape_string($imagePathsJson);
                $this->conn->query("UPDATE event_list SET image_paths = '{$imagePathsJson}' WHERE id = '{$eid}'");
            }
        }

        $resp['msg'] = "Event successfully saved.";
    } else {
        $resp['status'] = 'failed';
        $resp['msg'] = $this->conn->error . " [{$sql}]";
    }

    return json_encode($resp);
}

function get_all_events(){
    $events = [];
    $qry = $this->conn->query("SELECT * FROM event_list ORDER BY date_created DESC");
    if($qry){
        while($row = $qry->fetch_assoc()){
            $row['date'] = date("F j, Y - g:i A", strtotime($row['date_created']));
            
            // Handle multiple images
            if(!empty($row['image_paths'])){
                $row['images'] = json_decode($row['image_paths'], true);
            } else if(!empty($row['image_path'])){
                // Fallback for single image (backward compatibility)
                $row['images'] = [$row['image_path']];
            } else {
                $row['images'] = [];
            }
            
            $events[] = $row;
        }
        return json_encode(['status' => 'success', 'data' => $events]);
    } else {
        return json_encode(['status' => 'failed', 'msg' => $this->conn->error]);
    }
}

function delete_event() {
    extract($_POST);

    $get = $this->conn->query("SELECT * FROM event_list WHERE id = '{$id}'");
    if($get->num_rows > 0){
        $ev = $get->fetch_assoc();
        
        // Delete multiple images
        if(!empty($ev['image_paths'])){
            $imagePaths = json_decode($ev['image_paths'], true);
            if(is_array($imagePaths)){
                foreach($imagePaths as $imagePath){
                    if(is_file(base_app . $imagePath)){
                        unlink(base_app . $imagePath);
                    }
                }
            }
        }
        
        // Delete single image (backward compatibility)
        if(!empty($ev['image_path']) && is_file(base_app . $ev['image_path'])){
            unlink(base_app . $ev['image_path']);
        }
    }

    $del = $this->conn->query("DELETE FROM `event_list` WHERE id = '{$id}'");
    if($del){
        $resp['status'] = 'success';
        $this->settings->set_flashdata('success', "Event successfully deleted.");
    } else {
        $resp['status'] = 'failed';
        $resp['error'] = $this->conn->error;
    }

    return json_encode($resp);
}
function get_latest_event(){
    $qry = $this->conn->query("SELECT * FROM `event_list` ORDER BY `date_created` DESC LIMIT 1");
    if($qry && $qry->num_rows > 0){
        $row = $qry->fetch_assoc();
        return json_encode([
            'status' => 'success',
            'image_path' => $row['image_path'],
            'date' => date("F j, Y - g:i A", strtotime($row['date_created'])),
            'description' => $row['description']
        ]);
    } else {
        return json_encode([
            'status' => 'fail',
            'msg' => 'No event found.'
        ]);
    }
}
/*function get_all_events(){
    $events = [];
    $qry = $this->conn->query("SELECT * FROM event_list ORDER BY date_created DESC");
    if($qry){
        while($row = $qry->fetch_assoc()){
            $row['date'] = date("F j, Y - g:i A", strtotime($row['date_created']));
            $events[] = $row;
        }
        return json_encode(['status' => 'success', 'data' => $events]);
    } else {
        return json_encode(['status' => 'failed', 'msg' => $this->conn->error]);
    }
}*/
function search_events(){
    extract($_GET); // get `keyword`
    $events = [];
    $keyword = $this->conn->real_escape_string($keyword);
    $qry = $this->conn->query("SELECT * FROM `event_list` WHERE `description` LIKE '%$keyword%' ORDER BY date_created DESC");
    if($qry){
        while($row = $qry->fetch_assoc()){
            $row['date'] = date("F j, Y - g:i A", strtotime($row['date_created']));
            $events[] = $row;
        }
        return json_encode(['status' => 'success', 'data' => $events]);
    } else {
        return json_encode(['status' => 'failed', 'msg' => $this->conn->error]);
    }
}

// Event Attendance Functions
function record_event_attendance() {
    extract($_POST);
    $resp = array();
    
    if (empty($event_id) || empty($qr_code)) {
        $resp['status'] = 'failed';
        $resp['msg'] = 'Event ID and QR code are required';
        return json_encode($resp);
    }
    
    // Validate QR code and get user
    require_once('QRCodeGenerator.php');
    $validation = QRCodeGenerator::validateQRCode($qr_code);
    
    if (!$validation) {
        $resp['status'] = 'failed';
        $resp['msg'] = 'Invalid QR code format';
        return json_encode($resp);
    }
    
    $userId = $validation['user_id'];
    
    // Check if user exists and QR code matches
    $userQuery = $this->conn->query("SELECT * FROM users WHERE id = '{$userId}' AND qr_code = '{$qr_code}' AND status = 1");
    
    if (!$userQuery || $userQuery->num_rows === 0) {
        $resp['status'] = 'failed';
        $resp['msg'] = 'No active user found matching this QR code';
        return json_encode($resp);
    }
    
    $user = $userQuery->fetch_assoc();
    
    // Check if event exists
    $eventQuery = $this->conn->query("SELECT * FROM event_list WHERE id = '{$event_id}'");
    if (!$eventQuery || $eventQuery->num_rows === 0) {
        $resp['status'] = 'failed';
        $resp['msg'] = 'Event not found';
        return json_encode($resp);
    }
    
    // Check if already attended
    $attendanceCheck = $this->conn->query("SELECT * FROM event_attendance WHERE event_id = '{$event_id}' AND user_id = '{$userId}'");
    
    if ($attendanceCheck && $attendanceCheck->num_rows > 0) {
        $existing = $attendanceCheck->fetch_assoc();
        $resp['status'] = 'failed';
        $resp['msg'] = 'User ' . $user['firstname'] . ' ' . $user['lastname'] . ' has already been marked present for this event at ' . date('M j, Y g:i A', strtotime($existing['scan_time']));
        return json_encode($resp);
    }
    
    // Get scanner user ID (current logged-in user)
    $scannerUserId = $this->settings->userdata('id');
    
    // Record attendance
    $sql = "INSERT INTO event_attendance (event_id, user_id, qr_code, scan_time, status, scanner_user_id) 
            VALUES ('{$event_id}', '{$userId}', '{$qr_code}', NOW(), 'present', '{$scannerUserId}')";
    
    $save = $this->conn->query($sql);
    
    if ($save) {
        $resp['status'] = 'success';
        $resp['msg'] = 'Attendance recorded successfully';
        $resp['user'] = array(
            'firstname' => $user['firstname'],
            'lastname' => $user['lastname'],
            'username' => $user['username']
        );
        $resp['scan_time'] = date('M j, Y g:i A');
    } else {
        $resp['status'] = 'failed';
        $resp['msg'] = 'Failed to record attendance: ' . $this->conn->error;
    }
    
    return json_encode($resp);
}

function get_event_attendance() {
    extract($_GET);
    $resp = array();
    
    if (empty($event_id)) {
        $resp['status'] = 'failed';
        $resp['msg'] = 'Event ID is required';
        return json_encode($resp);
    }
    
    $sql = "SELECT ea.*, u.firstname, u.lastname, u.username, u.type, u.zone 
            FROM event_attendance ea 
            JOIN users u ON ea.user_id = u.id 
            WHERE ea.event_id = '{$event_id}' 
            ORDER BY ea.scan_time DESC";
    
    $qry = $this->conn->query($sql);
    
    if ($qry) {
        $attendance = [];
        while ($row = $qry->fetch_assoc()) {
            $attendance[] = $row;
        }
        
        $resp['status'] = 'success';
        $resp['data'] = $attendance;
    } else {
        $resp['status'] = 'failed';
        $resp['msg'] = $this->conn->error;
    }
    
    return json_encode($resp);
}

function get_all_events_with_attendance() {
    $events = [];
    $sql = "SELECT e.*, 
                   COUNT(ea.id) as attendance_count
            FROM event_list e 
            LEFT JOIN event_attendance ea ON e.id = ea.event_id 
            GROUP BY e.id 
            ORDER BY e.date_created DESC";
    
    $qry = $this->conn->query($sql);
    if ($qry) {
        while ($row = $qry->fetch_assoc()) {
            $row['date'] = date("F j, Y - g:i A", strtotime($row['date_created']));
            $events[] = $row;
        }
        return json_encode(['status' => 'success', 'data' => $events]);
    } else {
        return json_encode(['status' => 'failed', 'msg' => $this->conn->error]);
    }
}

function get_dashboard_stats() {
    $stats = [];
    
    // Count registered youth (users with status = 1, minus 1 for admin)
    $youth_qry = $this->conn->query("SELECT COUNT(*) as count FROM `users` WHERE `status` = 1");
    if($youth_qry) {
        $youth_result = $youth_qry->fetch_assoc();
        $stats['youth'] = $youth_result['count'] - 1; // Subtract 1 to exclude admin
    } else {
        $stats['youth'] = 0;
    }
    
    // Count events
    $event_qry = $this->conn->query("SELECT COUNT(*) as count FROM `event_list`");
    if($event_qry) {
        $event_result = $event_qry->fetch_assoc();
        $stats['events'] = (int)$event_result['count'];
    } else {
        $stats['events'] = 0;
    }
    
    // Count announcements
    $announcement_qry = $this->conn->query("SELECT COUNT(*) as count FROM `announcement_list`");
    if($announcement_qry) {
        $announcement_result = $announcement_qry->fetch_assoc();
        $stats['announcements'] = (int)$announcement_result['count'];
    } else {
        $stats['announcements'] = 0;
    }
    
    return json_encode(['status' => 'success', 'data' => $stats]);
}

function get_gender_stats() {
    $gender_stats = [];
    
    // Get gender distribution (excluding admin - type = 1)
    $gender_qry = $this->conn->query("SELECT sex, COUNT(*) as count FROM `users` WHERE `status` = 1 AND `type` != 1 GROUP BY sex");
    if($gender_qry) {
        while($row = $gender_qry->fetch_assoc()) {
            $gender_stats[] = [
                'label' => $row['sex'],
                'count' => (int)$row['count']
            ];
        }
    }
    
    return json_encode(['status' => 'success', 'data' => $gender_stats]);
}

function get_zone_stats() {
    $zone_stats = [];
    
    // Get zone distribution (excluding admin - type = 1)
    $zone_qry = $this->conn->query("SELECT zone, COUNT(*) as count FROM `users` WHERE `status` = 1 AND `type` != 1 GROUP BY zone ORDER BY zone");
    if($zone_qry) {
        while($row = $zone_qry->fetch_assoc()) {
            $zone_stats[] = [
                'label' => 'Zone ' . $row['zone'],
                'count' => (int)$row['count']
            ];
        }
    }
    
    return json_encode(['status' => 'success', 'data' => $zone_stats]);
}

function get_status_stats() {
    $status_stats = [];
    
    // Get status distribution (excluding admin - type = 1)
    $status_qry = $this->conn->query("SELECT 
        CASE 
            WHEN status = 1 THEN 'Active' 
            WHEN status = 0 THEN 'Inactive' 
        END as status_label, 
        COUNT(*) as count 
        FROM `users` 
        WHERE `type` != 1 
        GROUP BY status 
        ORDER BY status DESC");
    
    if($status_qry) {
        while($row = $status_qry->fetch_assoc()) {
            $status_stats[] = [
                'label' => $row['status_label'],
                'count' => (int)$row['count']
            ];
        }
    }
    
    return json_encode(['status' => 'success', 'data' => $status_stats]);
}

function get_attendance_stats() {
    $attendance_stats = [];
    $event_id = isset($_GET['event_id']) ? $_GET['event_id'] : null;
    
    if($event_id && $event_id != 'all') {
        // Get attendance for specific event
        $event_id = $this->conn->real_escape_string($event_id);
        
        // Get total registered users (potential attendees)
        $total_users_qry = $this->conn->query("SELECT COUNT(*) as total FROM `users` WHERE `type` != 1 AND `status` = 1");
        $total_users = 0;
        if($total_users_qry) {
            $total_users_row = $total_users_qry->fetch_assoc();
            $total_users = (int)$total_users_row['total'];
        }
        
        // Get present count for this event
        $present_qry = $this->conn->query("
            SELECT COUNT(*) as present_count 
            FROM `event_attendance` 
            WHERE `event_id` = '{$event_id}' AND `status` = 'present'
        ");
        
        $present = 0;
        if($present_qry) {
            $present_row = $present_qry->fetch_assoc();
            $present = (int)$present_row['present_count'];
        }
        
        $absent = $total_users - $present;
        
        $attendance_stats[] = [
            'label' => 'Present',
            'count' => $present
        ];
        $attendance_stats[] = [
            'label' => 'Absent', 
            'count' => $absent
        ];
        
    } else {
        // Get overall attendance statistics across all events
        // First get total registered users
        $total_users_qry = $this->conn->query("SELECT COUNT(*) as total FROM `users` WHERE `type` != 1 AND `status` = 1");
        $total_users = 0;
        if($total_users_qry) {
            $total_users_row = $total_users_qry->fetch_assoc();
            $total_users = (int)$total_users_row['total'];
        }
        
        // Get unique users who have attended at least one event
        $attended_users_qry = $this->conn->query("
            SELECT COUNT(DISTINCT user_id) as attended_count 
            FROM `event_attendance` 
            WHERE `status` = 'present'
        ");
        
        $attended_users = 0;
        if($attended_users_qry) {
            $attended_row = $attended_users_qry->fetch_assoc();
            $attended_users = (int)$attended_row['attended_count'];
        }
        
        $never_attended = $total_users - $attended_users;
        
        $attendance_stats[] = [
            'label' => 'Ever Attended',
            'count' => $attended_users
        ];
        $attendance_stats[] = [
            'label' => 'Never Attended', 
            'count' => $never_attended
        ];
    }
    
    return json_encode(['status' => 'success', 'data' => $attendance_stats]);
}

function get_events_for_dropdown() {
    $events = [];
    $qry = $this->conn->query("SELECT id, title, date_created FROM `event_list` ORDER BY date_created DESC");
    if($qry) {
        while($row = $qry->fetch_assoc()) {
            $events[] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'date' => date("M j, Y", strtotime($row['date_created']))
            ];
        }
    }
    return json_encode(['status' => 'success', 'data' => $events]);
}

function get_most_attended_events() {
    $events = [];
    
    // Query to get events with their attendance statistics
    $qry = $this->conn->query("
        SELECT 
            e.id,
            e.title,
            e.date_created,
            COALESCE(attended.total_attended, 0) as total_attended,
            (
                SELECT COUNT(*) 
                FROM `users` u 
                WHERE u.status = 1 AND u.type != 1 
                AND u.id NOT IN (
                    SELECT ea.user_id 
                    FROM `event_attendance` ea 
                    WHERE ea.event_id = e.id AND ea.status = 'present'
                )
            ) as total_absent
        FROM `event_list` e
        LEFT JOIN (
            SELECT 
                event_id, 
                COUNT(*) as total_attended 
            FROM `event_attendance` 
            WHERE `status` = 'present' 
            GROUP BY event_id
        ) attended ON e.id = attended.event_id
        WHERE attended.total_attended > 0
        ORDER BY attended.total_attended DESC, e.date_created DESC
        LIMIT 8
    ");
    
    if($qry) {
        while($row = $qry->fetch_assoc()) {
            $total_attended = (int)$row['total_attended'];
            $total_absent = (int)$row['total_absent'];
            $total_records = $total_attended + $total_absent;
            
            $events[] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'schedule' => $row['date_created'] ? date("M j, Y", strtotime($row['date_created'])) : 'No date set',
                'total_attended' => $total_attended,
                'total_absent' => $total_absent,
                'total_records' => $total_records
            ];
        }
    } else {
        // Log error for debugging
        error_log("MySQL Error in get_most_attended_events: " . $this->conn->error);
    }
    
    return json_encode(['status' => 'success', 'data' => $events]);
}

	// SK Officials Functions
	function save_official(){
		// Check if user is admin
		if($this->settings->userdata('type') != 1){
			$resp['status'] = 'failed';
			$resp['msg'] = "Access Denied. Only administrators can manage SK Officials.";
			return json_encode($resp);
		}
		
		extract($_POST);
		
		// Check if user_id is provided
		if(empty($user_id)){
			$resp['status'] = 'failed';
			$resp['msg'] = "Please select a user to assign as SK Official.";
			return json_encode($resp);
		}
		
		// Check if user exists and is active
		$user_check = $this->conn->query("SELECT * FROM `users` WHERE `id` = '{$user_id}' AND `status` = 1");
		if($user_check->num_rows == 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Selected user not found or inactive.";
			return json_encode($resp);
		}
		$user_data = $user_check->fetch_assoc();
		
		// Check if user is already an SK official (unless editing the same record)
		$existing_check = $this->conn->query("SELECT * FROM `sk_officials` WHERE `user_id` = '{$user_id}' AND `status` = 1 ".(!empty($id) ? " AND id != {$id} " : "")."");
		if($existing_check->num_rows > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "This user is already assigned as an SK Official.";
			return json_encode($resp);
		}
		
		// Check position limits: 1 Chairman, max 7 Councilors
		if($position == 'chairman'){
			$check_chairman = $this->conn->query("SELECT * FROM `sk_officials` WHERE `position` = 'chairman' AND status = 1 ".(!empty($id) ? " AND id != {$id} " : "")." ")->num_rows;
			if($check_chairman > 0){
				$resp['status'] = 'failed';
				$resp['msg'] = "There can only be one SK Chairman.";
				return json_encode($resp);
			}
		} elseif($position == 'councilor'){
			$check_councilor = $this->conn->query("SELECT * FROM `sk_officials` WHERE `position` = 'councilor' AND status = 1 ".(!empty($id) ? " AND id != {$id} " : "")." ")->num_rows;
			if($check_councilor >= 7){
				$resp['status'] = 'failed';
				$resp['msg'] = "Maximum of 7 SK Councilors allowed.";
				return json_encode($resp);
			}
		}
		
		// Automatically populate user data
		$firstname = $this->conn->real_escape_string($user_data['firstname']);
		$middlename = $this->conn->real_escape_string($user_data['middlename']);
		$lastname = $this->conn->real_escape_string($user_data['lastname']);
		$full_name = trim($firstname . ' ' . $middlename . ' ' . $lastname);
		$date_of_birth = $user_data['birthdate'];
		$sex = $user_data['sex'];
		$zone = 'Zone ' . $user_data['zone'];
		
		// Validate age (SK officials must be 18-30 years old)
		$birth_date = new DateTime($date_of_birth);
		$today = new DateTime();
		$age = $today->diff($birth_date)->y;
		if($age < 18 || $age > 30){
			$resp['status'] = 'failed';
			$resp['msg'] = "SK Officials must be between 18-30 years old. Selected user is {$age} years old.";
			return json_encode($resp);
		}
		
		// Prepare data for insertion/update
		$data = "`user_id` = '{$user_id}', 
				 `name` = '{$full_name}',
				 `firstname` = '{$firstname}',
				 `middlename` = '{$middlename}',
				 `lastname` = '{$lastname}',
				 `position` = '{$position}',
				 `date_of_birth` = '{$date_of_birth}',
				 `sex` = '{$sex}',
				 `zone` = '{$zone}',
				 `status` = 1";
		
		// Add optional fields if provided
		if(!empty($contact)){
			$contact = $this->conn->real_escape_string($contact);
			$data .= ", `contact` = '{$contact}'";
		}
		if(!empty($email)){
			$email = $this->conn->real_escape_string($email);
			$data .= ", `email` = '{$email}'";
		}
		
		// Handle file upload
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.($_FILES['img']['name']);
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'../uploads/sk_officials/'. $fname);
			if($move){
				$data .= ", `image_path` = '{$fname}'";
			}
		}
		
		// Save to database
		if(empty($id)){
			$sql = "INSERT INTO `sk_officials` SET {$data}";
		}else{
			$sql = "UPDATE `sk_officials` SET {$data} WHERE id = '{$id}'";
		}
		
		$save = $this->conn->query($sql);
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New SK Official successfully assigned.");
			else
				$this->settings->set_flashdata('success',"SK Official successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	
	function delete_official(){
		// Check if user is admin
		if($this->settings->userdata('type') != 1){
			$resp['status'] = 'failed';
			$resp['msg'] = "Access Denied. Only administrators can manage SK Officials.";
			return json_encode($resp);
		}
		
		extract($_POST);
		$del = $this->conn->query("UPDATE `sk_officials` set `status` = 0 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"SK Official successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

//End Event Code
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'delete_img':
		echo $Master->delete_img();
	break;
	case 'get_dashboard_stats':
		echo $Master->get_dashboard_stats();
	break;
	case 'get_gender_stats':
		echo $Master->get_gender_stats();
	break;
	case 'get_zone_stats':
		echo $Master->get_zone_stats();
	break;
	case 'get_status_stats':
		echo $Master->get_status_stats();
	break;
	case 'get_attendance_stats':
		echo $Master->get_attendance_stats();
	break;
	case 'get_events_for_dropdown':
		echo $Master->get_events_for_dropdown();
	break;
	case 'get_most_attended_events':
		echo $Master->get_most_attended_events();
	break;
	case 'save_prison':
		echo $Master->save_prison();
	break;
	case 'delete_prison':
		echo $Master->delete_prison();
	break;
	case 'save_cell':
		echo $Master->save_cell();
	break;
	case 'delete_cell':
		echo $Master->delete_cell();
	break;
	case 'save_crime':
		echo $Master->save_crime();
	break;
	case 'delete_crime':
		echo $Master->delete_crime();
	break;
	case 'save_inmate':
		echo $Master->save_inmate();
	break;
	case 'delete_inmate':
		echo $Master->delete_inmate();
	break;
	case 'save_action':
		echo $Master->save_action();
	break;
	case 'delete_action':
		echo $Master->delete_action();
	break;
	case 'save_record':
		echo $Master->save_record();
	break;
	case 'delete_record':
		echo $Master->delete_record();
	break;
	case 'update_privilege':
		echo $Master->update_privilege();
	break;
	case 'save_visit':
		echo $Master->save_visit();
	break;
	case 'delete_visit':
		echo $Master->delete_visit();
	break;
	case 'save_announcement':
		echo $Master->save_announcement();
		break;
	case 'delete_announcement':
		echo $Master->delete_announcement();
		break;
	case 'get_latest_announcement':
		echo $Master->get_latest_announcement();
		break;
		case 'get_all_announcements':
			echo $Master->get_all_announcements();
			break;
		case 'check_announcement_duplicate':
			echo $Master->check_announcement_duplicate();
			break;
	case 'search_announcements':
	echo $Master->search_announcements();
	break;
		case 'save_event':
		echo $Master->save_event();
	break;
	case 'delete_event':
		echo $Master->delete_event();
	break;
	case 'get_latest_event':
		echo $Master->get_latest_event();
	break;
	case 'get_all_events':
		echo $Master->get_all_events();
	break;
	case 'search_events':
		echo $Master->search_events();
	break;
	case 'record_event_attendance':
		echo $Master->record_event_attendance();
	break;
	case 'get_event_attendance':
		echo $Master->get_event_attendance();
	break;
	case 'get_all_events_with_attendance':
		echo $Master->get_all_events_with_attendance();
	break;
	case 'save_official':
		echo $Master->save_official();
	break;
	case 'delete_official':
		echo $Master->delete_official();
	break;

	
		
	default:
		// echo $sysset->index();
		break;
}