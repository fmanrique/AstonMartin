<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

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
		if (!$this->session->userdata('user_data'))  redirect(base_url()  . 'login/', 'location', 301); 

		$user = $this->session->userdata("user_data");
		if ($user['user_type_id'] != 1)  redirect(base_url()  . 'login/', 'location', 301); 
		
		$this->load->model('users_model');
		$this->load->model('dealerships_model');
	}

	public function index()
	{
		$vars['title'] = 'Dealers';
		$vars['content_view'] = '/users_list';
		$vars['data'] = $this->users_model->get_all();
		$vars['option']  = "users";
		

		$this->load->view('template', $vars);
		
	}

	public function add() {
		$vars['title'] = 'Add new Dealer User';
		$vars['content_view'] = '/users_new';
		$vars['user_types'] = $this->users_model->get_user_types();
		$vars['dealerships'] = $this->dealerships_model->get_all();
		$vars['option']  = "users";

		$this->load->view('template', $vars);
		
	}

	public function edit($id) {
		$vars['title'] = 'Edit Dealer';
		$vars['content_view'] = '/users_edit';
		$vars['data'] = $this->users_model->get_by_id($id);
		$vars['user_types'] = $this->users_model->get_user_types();
		$vars['dealerships'] = $this->dealerships_model->get_all();
		$vars['option']  = "users";

		if (count($vars['data']) > 0) {
			$vars['data'] = $vars['data'][0];
			$this->load->view('template', $vars);
		}  else {
			show_404();
		}
	}

	public function validate($id) {
		if ($id == 0) {
			//New user
			$exists = $this->users_model->get_by_email($this->input->post('email'));
		} else {
			$exists = $this->users_model->get_by_email_id($id, $this->input->post('email'));
		}
		

		if ($exists)
			echo '"This email already taken, please choose another one"';
		else {
			echo "true";
		}
	}

	public function changeperiod($period, $controller) {
		$user_data = $this->session->userdata('user_data');

		$user_data['period'] = $period;

		$this->session->set_userdata('user_data', $user_data);

		redirect(base_url() . $controller, 'location', 301);	
	}

	public function changedealer($dealership_id, $controller) {
		$user_data = $this->session->userdata('user_data');
		$dealership = $this->dealerships_model->get_by_id($dealership_id);

		if ($dealership_id == 0) {
			$user_data['dealership_id'] = $dealership_id;
			$user_data['dealership_name'] = 'All Dealerships';
		} else {
			$user_data['dealership_id'] = $dealership_id;
			$user_data['dealership_name'] = $dealership[0]['name'];	
		}

		$this->session->set_userdata('user_data', $user_data);

		redirect(base_url() . $controller, 'location', 301);	
	}

	public function save() {
		$date = date("Y-m-d H:i:s");
		$user = $this->session->userdata("user_data");

		$exists = $this->users_model->get_by_email($this->input->post('email'));

		if (!$exists) {
			$this->users_model->insert($this->input->post('name'), $this->input->post('email'), $this->input->post('user_type_id'),$this->input->post('dealership_id'), $this->input->post('password'), $user['id'], $date);
			redirect(base_url() . 'users', 'location', 301);	
		} 
		
	}

	public function update($id) {	
		$date = date("Y-m-d H:i:s");
		$user = $this->session->userdata("user_data");

		$this->users_model->update($id, $this->input->post('name'), $this->input->post('email'), $this->input->post('user_type_id'),$this->input->post('dealership_id'), $user['id'], $date);
		redirect(base_url() . 'users', 'location', 301);
	}
	

	public function change_password($id) {
		$date = date("Y-m-d H:i:s");
		$user = $this->session->userdata("user_data");

		$this->users_model->change_password($id, $this->input->post('password'), $user['id'], $date);
		redirect(base_url() . 'users', 'location', 301);
	}

	public function delete($id) {	
		$date = date("Y-m-d H:i:s");
		$user = $this->session->userdata("user_data");

		$this->users_model->delete($id, $user['id'], $date);
		redirect(base_url() . 'users', 'location', 301);
	}

	public function myprofile() {
		$user = $this->session->userdata("user_data");
		$vars['title'] = 'My Profile';
		$vars['content_view'] = '/users_myprofile';
		$vars['data'] = $this->users_model->get_by_id($user['id']);
		$vars['option']  = "";

		if (count($vars['data']) > 0) {
			$vars['data'] = $vars['data'][0];
			$this->load->view('template', $vars);
		}  else {
			show_404();
		}

	}

	public function update_myprofile($id) {	
		$date = date("Y-m-d H:i:s");
		$user = $this->session->userdata("user_data");

		$this->users_model->update_profile($id, $this->input->post('name'), $user['id'], $date);
		$user['name'] = $this->input->post('name');

		$this->session->set_userdata('user_data', $user);

		if ($this->input->post('password') != "") {
			$this->users_model->change_password($id, $this->input->post('password'), $date);
		}

		redirect(base_url() . 'users/myprofile', 'location', 301);
	}
}

