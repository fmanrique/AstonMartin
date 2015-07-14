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
			redirect(base_url() . 'dashboard');
		} else {
			if ($this->input->post('email') != "") {
				$this->load->model('users_model');
				$this->load->model('activities_model');
				$this->load->model('dealerships_model');
				$this->load->model('regions_model');
				$access = $this->users_model->login($this->input->post('email'),$this->input->post('password'));				

				if($access) {
					$periods = $this->activities_model->get_periods();
					$dealers = array();
					$regions = array();

					switch ($access[0]->user_type_id) {
						case 1:
							$dealers = $this->dealerships_model->get_all_simple();
							$dealer_all['id'] = 0;
							$dealer_all['name'] = 'All';
							$dealer_all['description'] = 'All';
							$dealers[] = $dealer_all;

							$dealer_default = $dealer_all;

							$regions = $this->regions_model->get_all_simple();

							$region_all['id'] = 0;
							$region_all['description'] = 'All';
							$regions[] = $region_all;

							$region_default = $region_all;
							break;
						case 2:
							$dealers = $this->dealerships_model->get_by_region($access[0]->region_id);
							$dealer_all['id'] = 0;
							$dealer_all['name'] = 'All';
							$dealer_all['description'] = 'All';
							$dealers[] = $dealer_all;

							$dealer_default = $dealer_all;

							$regions = $this->regions_model->get_by_id($access[0]->region_id);
							$region_default = $regions[0];
							break;
						default:
							$dealers = $this->dealerships_model->get_by_user($access[0]->id);

							$dealer_default = $dealers[0];

							$region_default['id'] = 0;
							$region_default['description'] = 'All';
							# code...
							break;
					}
					

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
					
					$user_data = array(
						'id' 					=> $access[0]->id,
						'name'					=> $access[0]->name,
						'email'					=> $access[0]->email,
						'user_type_id'			=> $access[0]->user_type_id,
						'region_id'				=> $region_default['id'],
						'region_name'			=> $region_default['description'],
						'dealership_id'			=> $dealer_default['id'],
						'dealership_name'		=> $dealer_default['name'], 
						//'dealers'				=> $dealers,
						//'regions'				=> $regions,
						'period'				=> date("Y"),
						//'periods'				=> $years
					);

					$security_data = array(
						'dealers'				=> $dealers,
						'regions'				=> $regions,
						'periods'				=> $years
					);

					$this->session->set_userdata('user_data', $user_data);
					$this->session->set_userdata('security_data', $security_data);
					redirect(base_url() . 'dashboard');
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

			redirect(base_url() . 'access/resetpassword');
		} else {
			redirect(base_url() . 'access/failresetpassword');
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
		redirect(base_url() . 'login/');
	}
	
}
