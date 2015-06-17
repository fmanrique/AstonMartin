<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class sales extends CI_Controller {

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
		$this->load->model('sales_model');
	}


	public function save($id) {
		$date = date("Y-m-d H:i:s");
		$user = $this->session->userdata("user_data");


		if ($id == 0) 
			$this->sales_model->insert($user['period'], $this->input->post('month'), $this->input->post('quarter'), $this->input->post('sales'), $user['dealership_id']);
		else
			$this->sales_model->update($id, $user['period'], $this->input->post('month'), $this->input->post('quarter'), $this->input->post('sales'), $user['dealership_id']);


		die;
	}
	
}


