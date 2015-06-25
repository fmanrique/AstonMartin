<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  dealerships extends CI_Controller {

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
		if (!$this->session->userdata('user_data'))  redirect(base_url() . 'login/', 'location', 301); 
		$this->load->model('dealerships_model');
		$this->load->model('regions_model');
		$this->load->model('currencies_model');
	}

	public function index() {
		$vars['title'] = 'Dealerships';
		$vars['content_view'] = '/dealerships_list';
		$vars['option']  = "dealerships";
		$vars['data'] = $this->dealerships_model->get_all();
		
		$this->load->view('template', $vars);
		
	}

	public function add() {
		$vars['title'] = 'dealerships';
		$vars['content_view'] = '/dealerships_new';
		$vars['option']  = "dealerships";
		$vars['regions'] = $this->regions_model->get_all();
		$vars['currencies'] = $this->currencies_model->get_all();

		$this->load->view('template', $vars);
	}

	public function edit($id) {
		$vars['title'] = 'dealerships';
		$vars['content_view'] = '/dealerships_edit';
		$vars['option']  = "dealerships";
		$vars['data'] = $this->dealerships_model->get_by_id($id);
		$vars['regions'] = $this->regions_model->get_all();
		$vars['currencies'] = $this->currencies_model->get_all();
			
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
		
		$this->dealerships_model->insert($this->input->post('name'),$this->input->post('description'),$this->input->post('revenue'),$this->input->post('currency_id'),$this->input->post('region_id'), $user['id'], $date);

		redirect(base_url() . 'dealerships', 'location', 301);
	}

	public function update($id) {	
		$date = date("Y-m-d H:i:s");
		$user = $this->session->userdata("user_data");
		
		$this->dealerships_model->update($id, $this->input->post('name'), $this->input->post('description'),$this->input->post('revenue'),$this->input->post('currency_id'),$this->input->post('region_id'), $user['id'], $date);

		redirect(base_url() . 'dealerships', 'location', 301);
	}
	

	public function delete($id) {	
		$date = date("Y-m-d H:i:s");
		$user = $this->session->userdata("user_data");

		$this->dealerships_model->delete($id, $user['id'], $date);
		redirect(base_url() . 'dealerships', 'location', 301);
	}

	
}


