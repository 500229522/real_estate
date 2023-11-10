<?php
require_once '../config.php';
class Login extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;

		parent::__construct();
		ini_set('display_error', 1);
	}
	public function __destruct(){
		parent::__destruct();
	}

	public function login(){
		extract($_POST);

		$stmt = $this->conn->prepare("SELECT * from users where email = ? and password = ? and deleted_date is null ");
        $password = md5($password);
		$stmt->bind_param('ss', $email, $password);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			foreach($result->fetch_array() as $k => $v){

                if ($k == 'role') {
                    $role = $v;
                }

                if ($role == 'Agent') {
                    $user_id = $this->settings->userdata('id');
                    $agent_stmt = $this->conn->prepare("SELECT * FROM users u join agents a on u.id = a.user_id where u.id = ? "); 
                    $agent_stmt->bind_param('s', $user_id);
                    $agent_stmt->execute();
                    $agent_result = $agent_stmt->get_result();
                    if($agent_result->num_rows > 0){
                        foreach($agent_result->fetch_array() as $k => $v){                        
                            if(!is_numeric($k)){
                                $this->settings->set_userdata($k,$v);
                            }
                        }
                    }
                } else {
                    if(!is_numeric($k) && $k != 'password'){
                        $this->settings->set_userdata($k,$v);
                    }
                }
			}
 
		    return json_encode(array('status'=>'success', 'role'=> $role));
		}else{
		    return json_encode(array('status'=>'failed'));
		}
	}

	public function logout(){
		if($this->settings->sess_des()){
			redirect('login.php');
		}
	}
}
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$auth = new Login();
switch ($action) {
	case 'login':
		echo $auth->login();
		break;
	case 'logout':
		echo $auth->logout();
		break;
	default:
		break;
}

