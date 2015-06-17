	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class zones extends CI_Controller {

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
		$this->load->model('zones_model');
	}

	public function index() {
		$vars['title'] = 'Zones';
		$vars['content_view'] = '/zones_list';
		$vars['option']  = "zones";
		$vars['data'] = $this->zones_model->get_all();

		
		
		$this->load->view('template', $vars);
		
	}

	public function add() {
		$vars['title'] = 'Zones';
		$vars['content_view'] = '/zones_new';
		$vars['option']  = "zones";

		$this->load->view('template', $vars);
	}

	public function edit($id) {
		$vars['title'] = 'Zones';
		$vars['content_view'] = '/zones_edit';
		$vars['option']  = "zones";
		$vars['data'] = $this->zones_model->get_by_id($id);

		
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
		
		$this->zones_model->insert($this->input->post('description'), $user['id'], $date);

		redirect(base_url() . 'zones', 'location', 301);
	}

	public function update($id) {	
		$date = date("Y-m-d H:i:s");
		$user = $this->session->userdata("user_data");
		
		$this->zones_model->update($id, $this->input->post('description'), $user['id'], $date);

		redirect(base_url() . 'zones', 'location', 301);
	}
	

	public function delete($id) {	
		$date = date("Y-m-d H:i:s");
		$user = $this->session->userdata("user_data");

		$this->zones_model->delete($id, $user['id'], $date);
		redirect(base_url() . 'zones', 'location', 301);
	}

	
}


