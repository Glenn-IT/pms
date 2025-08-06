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

        // Handle image upload
        if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
            $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
            $dir = "uploads/announcements/";
            if(!is_dir(base_app . $dir)) mkdir(base_app . $dir);
            $fname = $dir . $aid . '.' . $ext;

            move_uploaded_file($_FILES['img']['tmp_name'], base_app . $fname);
            $this->conn->query("UPDATE announcement_list SET image_path = '{$fname}' WHERE id = '{$aid}'");
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
			if(is_file(base_app . $ann['image_path'])){
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
				$announcements[] = $row;
			}
			return json_encode(['status' => 'success', 'data' => $announcements]);
		} else {
			return json_encode(['status' => 'failed', 'msg' => $this->conn->error]);
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

    if(!empty($title))
        $data .= " `title`='{$title}' ";
    if(!empty($description))
        $data .= ", `description`='{$description}' ";
    if(!empty($date_created))
        $data .= ", `date_created`='{$date_created}' ";

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

        if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
            $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
            $dir = "uploads/events/";
            if(!is_dir(base_app . $dir)) mkdir(base_app . $dir);
            $fname = $dir . $eid . '.' . $ext;

            move_uploaded_file($_FILES['img']['tmp_name'], base_app . $fname);
            $this->conn->query("UPDATE event_list SET image_path = '{$fname}' WHERE id = '{$eid}'");
        }

        $resp['msg'] = "Event successfully saved.";
    } else {
        $resp['status'] = 'failed';
        $resp['msg'] = $this->conn->error . " [{$sql}]";
    }

    return json_encode($resp);
}

function delete_event() {
    extract($_POST);

    $get = $this->conn->query("SELECT * FROM event_list WHERE id = '{$id}'");
    if($get->num_rows > 0){
        $ev = $get->fetch_assoc();
        if(is_file(base_app . $ev['image_path'])){
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
function get_all_events(){
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
}
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

	
		
	default:
		// echo $sysset->index();
		break;
}