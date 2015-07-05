<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class focus extends CI_Controller {

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

	public function __construct() {
		parent::__construct();
		if (!$this->session->userdata('user_data'))  redirect(base_url() . 'login/'); 
		$this->load->model('focus_model');
	}

	public function index() {
		$vars['title'] = 'Focus';
		$vars['content_view'] = '/focus_list';
		$vars['option']  = "focus";
		$vars['data'] = $this->focus_model->get_all();

		
		
		$this->load->view('template', $vars);
		
	}

	public function add() {
		$vars['title'] = 'Focus';
		$vars['content_view'] = '/focus_new';
		$vars['option']  = "focus";

		$this->load->view('template', $vars);
	}

	public function edit($id) {
		$vars['title'] = 'Focus';
		$vars['content_view'] = '/focus_edit';
		$vars['option']  = "focus";
		$vars['data'] = $this->focus_model->get_by_id($id);

		
		if (count($vars['data']) > 0) {
			$vars['data'] = $vars['data'][0];
			$this->load->view('template', $vars);
		}  else {
			show_404();
		}


	}

	public function save() {
		$date = date("Y-m-d H:i:s");
		$user = $this->session->userdata("user_data");
		
		$this->focus_model->insert($this->input->post('description'), $user['id'], $date);

		redirect(base_url() . 'focus');
	}

	public function update($id) {	
		$date = date("Y-m-d H:i:s");
		$user = $this->session->userdata("user_data");
		
		$this->focus_model->update($id, $this->input->post('description'), $user['id'], $date);

		redirect(base_url() . 'focus');
	}
	

	public function delete($id) {	
		$date = date("Y-m-d H:i:s");
		$user = $this->session->userdata("user_data");

		$this->focus_model->delete($id, $user['id'], $date);
		redirect(base_url() . 'focus');
	}

	
}


