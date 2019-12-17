<?php
class User extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model("User_Model");
	}
	
	function Login(){
		if($_SERVER['REQUEST_METHOD'] == 'GET' && empty($_GET)){
			$_GET = json_decode(file_get_contents('php://input'), true);
		}		
		
		$response = array();
		$response['Code'] = '0';
		$response['Message'] = '';
		$response['HttpCode'] = '200';
		$response['Result'] = null;
		
		if(!isset($_GET['Account']) || empty($_GET['Account'])){
			$response['Code'] = '2';
			$response['Message'] = 'Login Failed';
			$response['HttpCode'] = '400';
			echo json_encode($response);
			exit;
		}
		
		if(!isset($_GET['Password']) || empty($_GET['Password'])){
			$response['Code'] = '2';
			$response['Message'] = 'Login Failed';
			$response['HttpCode'] = '400';
			echo json_encode($response);
			exit;
		}
			
		$user = $this->User_Model->read_RecordByWhereCase(array('username'=>$_GET['Account']));
		if(count($user) == 0){
			$response['Code'] = '2';
			$response['Message'] = 'Login Failed';
			$response['HttpCode'] = '400';
			echo json_encode($response);
			exit;
		}
		$user = $user[0];
		
		if($user != $_GET['Password']){
			$response['Code'] = '2';
			$response['Message'] = 'Login Failed';
			$response['HttpCode'] = '400';
			echo json_encode($response);
			exit;
		}
		
		echo json_encode($response);
	}
	
	function Create(){
		if($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)){
			$_POST = json_decode(file_get_contents('php://input'), true);
		}
		
		$response = array();
		$response['Code'] = '0';
		$response['Message'] = '';
		$response['Result'] = array('IsOK'=>'true');
		
		if(!isset($_POST['Account']) || empty($_POST['Account'])){
			$response['Result'] = array('IsOK'=>'false');
			echo json_encode($response);
			exit;
		}
		
		if(!isset($_POST['Password']) || empty($_POST['Password'])){
			$response['Result'] = array('IsOK'=>'false');
			echo json_encode($response);
			exit;
		}
		
		$user = $this->User_Model->read_RecordByWhereCase(array('username'=>$_POST['Account']));
		if(count($user) != 0){
			$response['Result'] = array('IsOK'=>'false');
			echo json_encode($response);
			exit;
		}
		
		$this->User_Model->save_Record(array(
										"username"=>$_POST['Account'], 
										"password"=>$_POST['Password']
									  ));
		
		echo json_encode($response);
	}
	
	function Delete(){
		if($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)){
			$_POST = json_decode(file_get_contents('php://input'), true);
		}
		
		$response = array();
		$response['Code'] = '0';
		$response['Message'] = '';
		$response['Result'] = array('IsOK'=>'true');
		
		if(!isset($_POST['Account']) || empty($_POST['Account'])){
			$response['Result'] = array('IsOK'=>'false');
			echo json_encode($response);
			exit;
		}
		
		$this->User_Model->delete_Record(array('username'=>$_POST['Account']));
		echo json_encode($response);		
	}	
}
?>