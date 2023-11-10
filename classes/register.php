<?php
require_once('../config.php');
Class Register extends DBConnection {
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
		extract($_POST);
		$data = '';
		foreach($_POST as $k => $v){
			if(!in_array($k,array('id','password'))){
				if(!empty($data)) $data .=" , ";
				$data .= " {$k} = '{$v}' ";

                if ($k == 'role') {
                    $role = $v;
                }
			}
		}
		if(!empty($password)){
			$password = md5($password);
			if(!empty($data)) $data .=" , ";
			$data .= " `password` = '{$password}' ";
		}
        date_default_timezone_set("EST5EDT");
        $created_date = date('Y-m-d');
        // $data .= " `created_date` = '{$created_date}' ";
        // $data .= " `updated_date` = '{$created_date}' ";
        $check = $this->conn->query("SELECT * FROM `users` where `email` = '{$email}' and deleted_date is null ")->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = " Email already exists in the system.";
			return json_encode($resp);
			exit;
		}

        $qry = $this->conn->query("INSERT INTO users set {$data}");
        if($qry){
            $id=$this->conn->insert_id;
            $agent_data .= " `user_id` = '{$id}' ";
            if ($role == 'Agent') {
                $agent_qry = $this->conn->query("INSERT INTO agents set {$agent_data}");

                if ($agent_qry) {
                    $this->settings->set_flashdata('success','Agent Details successfully saved.');
                } else {
                    return 2;
                }
            } else {
                $this->settings->set_flashdata('success','User Details successfully saved.');
            }
            return 1;
        } else{
            return 2;
        }
	}
}


$users = new Register();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
	case 'save':
		echo $users->save_users();
	break;
	default:
		break;
}