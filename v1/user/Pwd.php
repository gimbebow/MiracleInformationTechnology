<?php
class Pwd extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model("User_Model");
	}
	
	function Change(){
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
		if(count($user) == 0){
			$response['Result'] = array('IsOK'=>'false');
			echo json_encode($response);
			exit;
		}
		
		$this->User_Model->update_Record(array(
										"password"=>$_POST['Password']
									  ), array('username'=>$_POST['Account']));
		
		echo json_encode($response);
	}
}
?>