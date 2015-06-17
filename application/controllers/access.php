<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class access extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html 
	 */

	public function __construct()
	{
		parent::__construct();
		
	}

	public function index() {
		$this->login();
	}

	public function login() {
		if($this->session->userdata('user_data')) {
			redirect(base_url() . 'dashboard', 'location', 301);
		} else {
			if ($this->input->post('email') != "") {
				$this->load->model('users_model');
				$this->load->model('activities_model');
				$this->load->model('dealerships_model');
				$access = $this->users_model->login($this->input->post('email'),$this->input->post('password'));				

				if($access) {
					$periods = $this->activities_model->get_periods();

					$years = array();
					$current_year = date("Y");

					if ($years) {
						for($i = $years[0]['first_period']; $i<=$current_year + 2; $i++) {
							$years[] = $i;
						}	
					} else {
						for($i = $current_year; $i<=$current_year + 2; $i++) {
							$years[] = $i;
						}
					} 

					$dealers = array();
					if ($access[0]->user_type_id == 1) {
						$dealers = $this->dealerships_model->get_all();
						$dealer_all['id'] = 0;
						$dealer_all['name'] = 'All Dealerships';
						$dealer_all['description'] = 'All Dealerships';
						$dealers[] = $dealer_all;
					}
					$user_data = array(
						'id' 				=> $access[0]->id,
						'name'				=> $access[0]->name,
						'email'				=> $access[0]->email,
						'user_type_id'		=> $access[0]->user_type_id,
						'dealership_id'		=> $access[0]->dealership_id,
						'dealership_name'	=> $access[0]->dealership_name,
						'dealers'			=> $dealers,
						'period'			=> date("Y"),
						'periods'			=> $years
					);
					$this->session->set_userdata('user_data', $user_data);
					redirect(base_url() . 'dashboard', 'location', 301);
				}
				else{
					$data['error']="User or Password incorrect, please try again";
					$this->load->view('login', $data);
				}
			} else {
				$this->load->view('login');
			}
		}
	}

	public function forgot() {
		$this->load->model('users_model');
		$date = date("Y-m-d H:i:s");

		$user = $this->users_model->get_by_email($this->input->post('email'));

		if (count($user)>0) {
			$newpassword = $this->RandomPassword(12);

			$this->users_model->change_password($user[0]['id'], $newpassword, $date);

			$message = '
				<html>
				<head>
				  <titleYour password for pp-sms.com</title>
				</head>
				<body>
				  <p><h2>pp-sms</h2></p>
				  <p><pre>Your new password is: '.$newpassword.'</pre></p>
				  <p>Go to <a href="http://pp-sms.com/login">pp-sms.com</a></p>
				</body>
				</html>
				';

			// Para enviar un correo HTML, debe establecerse la cabecera Content-type
			$heders  = 'MIME-Version: 1.0' . "\r\n";
			$heders .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			// Enviarlo
			mail($user[0]['email'], 'New password for pp-sms.com', $message, $heders);

			redirect(base_url() . 'access/resetpassword', 'location', 301);
		} else {
			redirect(base_url() . 'access/failresetpassword', 'location', 301);
		}
	} 

	public function resetpassword()	 {
		$vars['title'] = 'Reset Password'; 
	  	$vars['content_view'] = '/login_resetpassword';
	  	$this->load->view('template_public', $vars);
	}

	public function failresetpassword()	 {
		$vars['title'] = 'Reset Password'; 
	  	$vars['content_view'] = '/login_noreset';
	  	$this->load->view('template_public', $vars);
	}

	private function RandomPassword($length){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!#$%,.;:{}+-¿?\|';
		$randstring = "";
		for ($i = 0; $i < $length; $i++) {
			$randstring = $randstring . $characters[rand(0, strlen($characters))];
		}
		return $randstring;
	}

	public function logout() {
		$this->session->unset_userdata('user_data');
		$this->session->sess_destroy();
		redirect(base_url() . 'login/', 'location', 301);
	}
	
}
