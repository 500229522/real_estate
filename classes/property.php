<?php
require_once('../config.php');
Class Property extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function save(){
		$_POST['description'] = htmlentities($_POST['description']);
		$_POST['agent_id'] = $this->settings->userdata('id');
        
		extract($_POST);
		$prop_tbl_allowed_fields = ["agent_id","name","type_id","purpose","status","price","address_line","city","country","postal_code","area","description","coordinates"];
		$data = "";
		foreach($_POST as $k =>$v){
			if(in_array($k,$prop_tbl_allowed_fields)){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `properties` set {$data} ";
		}

		$save = $this->conn->query($sql);
		if($save){
			$property_id = $this->conn->insert_id;
			$resp['property_id'] = $property_id;
			$upload_path = "uploads/estate_".$property_id;
			$resp['msg'] = " Data successfully saved.";
			$resp['status'] = 'success';
			if(!is_dir(base_app.$upload_path))
				mkdir(base_app.$upload_path);
			if(isset($_FILES['imgs']) && count($_FILES['imgs']['tmp_name']) > 0){
				$err = "";
				foreach($_FILES['imgs']['tmp_name'] as $k => $v){
					if(!empty($_FILES['imgs']['tmp_name'][$k])){
						$accept = array('image/jpeg','image/png');
						if(!in_array($_FILES['imgs']['type'][$k],$accept)){
							$err = "Image file type is invalid";
							break;
						}
						if($_FILES['imgs']['type'][$k] == 'image/jpeg')
							$uploadfile = imagecreatefromjpeg($_FILES['imgs']['tmp_name'][$k]);
						elseif($_FILES['imgs']['type'][$k] == 'image/png')
							$uploadfile = imagecreatefrompng($_FILES['imgs']['tmp_name'][$k]);
						if(!$uploadfile){
							$err = "Image is invalid";
							break;
						}
						list($width,$height) = getimagesize($_FILES['imgs']['tmp_name'][$k]);
						$temp = imagescale($uploadfile,$width,$height);
						$spath = base_app.$upload_path.'/'.$_FILES['imgs']['name'][$k];
						$i = 0;
						while(true){
							if(is_file($spath)){
								$spath = base_app.$upload_path.'/'.$i."_".$_FILES['imgs']['name'][$k];
							}else{
								break;
							}
							$i++;
						}
						if($_FILES['imgs']['type'][$k] == 'image/jpeg')
						imagejpeg($temp, $spath);
						elseif($_FILES['imgs']['type'][$k] == 'image/png')
						imagepng($temp, $spath);

						imagedestroy($temp);
					}
				}
				if(!empty($err)){
					$resp['msg'] .= " But ".$err;
				}
			}
			if(!empty($_FILES['img']['tmp_name'])){
				$err = "";
				if(!is_dir(base_app."uploads/thumbnails")){
					mkdir(base_app."uploads/thumbnails");
				}
				$accept = array('image/jpeg','image/png');
				if(!in_array($_FILES['img']['type'],$accept)){
					$err = "Image file type is invalid";
				}
				$ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
				$fname = "uploads/thumbnails/$property_id.$ext";
				if($_FILES['img']['type'] == 'image/jpeg')
					$uploadfile = imagecreatefromjpeg($_FILES['img']['tmp_name']);
				elseif($_FILES['img']['type'] == 'image/png')
					$uploadfile = imagecreatefrompng($_FILES['img']['tmp_name']);
				if(!$uploadfile){
					$err = "Image is invalid";
				}
				list($width,$height) = getimagesize($_FILES['img']['tmp_name']);
				$temp = imagescale($uploadfile,$width,$height);
				if(is_file(base_app.$fname))	
					unlink(base_app.$fname);			
				if($_FILES['img']['type'] == 'image/jpeg')
					$uploaded = imagejpeg($temp, base_app.$fname);
				elseif($_FILES['img']['type'] == 'image/png')
					$uploaded = imagepng($temp, base_app.$fname);
				else
					$uploaded = false;
				if($uploaded){
					$_POST['thumbnail_path'] = $fname."?v=".(time());
				}

				imagedestroy($temp);
				if(!empty($err)){
					$resp['msg'] .= " But ".$err;
				}
			}
			$data="";
			foreach($_POST as $k =>$v){
				if(!in_array($k,array_merge($prop_tbl_allowed_fields,['id','amenity_ids']))){
					if(!empty($data)) $data .=", ";
					$k = $this->conn->real_escape_string($k);
					$v = $this->conn->real_escape_string($v);
					$data .= "('{$property_id}', '{$k}', '{$v}')";
				}
			}
			if(!empty($data)){
				$data="";
                foreach($amenity_ids as $k =>$v){
                        if(!empty($data)) $data .=", ";
                        $data .= "('{$property_id}', '{$v}')";
                }
                if(!empty($data)){
                    $sql3 = "INSERT INTO `property_amenities` (`property_id`, `amenity_id`) VALUES {$data}";
                    $save3 = $this->conn->query($sql3);
                    if(!$save3){
                        $resp['status'] = 'failed';
                        $resp['msg'] = " Saving Real Estate Data failed.";
                        $resp['err'] = $this->conn->error;
                        $resp['sql'] = $sql3;
                    }
                }
			}
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
}

$property = new Property();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save':
		echo $property->save();
	break;
	default:
		break;
}