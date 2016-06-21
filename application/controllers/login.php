<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	public function show(){
		$this->load->library('session');
		if($this->session->userdata("logged_in")){
			$this->load->view('login/logged');
			return;
		}
		$data['error'] = 0;
		$this->load->view('login/login_show', $data);
	}
	public function check(){
		session_start();
		if($_SESSION['code'] != $_POST['checkcode']){
			$data['error'] = 1;
			$this->load->view('login/login_show', $data);
			return;
		}
		else{
			$username = $_POST['username'];
			$password = $_POST['password'];
			if($username == '' || $password == ''){
				$data['error'] = 2;
				$this->load->view('login/login_show', $data);
				return;
			}
			$this->load->model('login_model');
			$password = md5($password);
			$account = $this->login_model->get_account($username, $password);
			if(count($account) != 0){
				$this->load->library('session');
				if ($account[0]->is_valid != 1) {
					$data['error'] = 3;
					$this->load->view('login/login_show', $data);		
				} else {
					$userdata = array(
					'username' => $username,
					'logged_in' => true,
					'gm_level' => $account[0]->gmlevel
					);
					$this->session->set_userdata($userdata);
					$this->load->view('login/login_success');	
				}
			}
			else{
				$data['error'] = 2;
				$this->load->view('login/login_show', $data);
			}
		}
	}
	public function checkcode(){
		$num1 = rand(1, 99);
		$num2 = rand(1, 99);
		session_start();
		$_SESSION['code'] = $num1 + $num2;
	
		$cimg = imagecreate(100, 30);
		
		imagecolorallocate($cimg, 14, 114, 180); // background color
		$red = imagecolorallocate($cimg, 255, 0, 0);
		
		imagestring($cimg, 5, 5, 5, $num1, $red);
		imagestring($cimg, 5, 30, 5, "+", $red);
		imagestring($cimg, 5, 45, 5, $num2, $red);
		imagestring($cimg, 5, 70, 5, "=?", $red);

		header("Content-type: image/png");
		imagepng($cimg);
		imagedestroy($cimg);
	}
	public function logout(){
		$this->load->library('session');
		$this->session->sess_destroy();
		$this->load->view('login/logout');
	}
}
?>