<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class categories extends CI_Controller {

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
		$this->load->model('categories_model');
		$this->load->library('functions');
	}

	public function index() {
		$vars['title'] = 'Activity Types';
		$vars['content_view'] = '/categories_list';
		$vars['option']  = "categories";
		//$vars['data'] = $this->categories_model->get_all();

		$parents = $this->categories_model->get_parents();
		$childs = $this->categories_model->get_childs();
		$categories = array();

		foreach ($parents as $key => $parent) {
			$category = $parent;
			$category_childs = $this->functions->search($childs, 'parent_id', $parent['id']);

			$category['childs'] = $category_childs;

			$categories[] = $category;
		}

		$vars['data'] = $categories;
		
		$this->load->view('template', $vars);
		
	}

	public function add() {
		$vars['title'] = 'Activity Types';
		$vars['content_view'] = '/categories_new';
		$vars['option']  = "categories";
		
		$vars['categories'] = $this->categories_model->get_parents();

		$this->load->view('template', $vars);
		
		
	}

	public function edit($id) {
		$vars['title'] = 'Activity Types';
		$vars['content_view'] = '/categories_edit';
		$vars['option']  = "categories";
		$vars['categories'] = $this->categories_model->get_parents();
		$vars['data'] = $this->categories_model->get_by_id($id);

		
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
		
		$this->categories_model->insert($this->input->post('parent_id'), $this->input->post('description'), $this->input->post('color'), $user['id'], $date);

		redirect(base_url() . 'categories', 'location', 301);
	}

	public function update($id) {	
		$date = date("Y-m-d H:i:s");
		$user = $this->session->userdata("user_data");
		
		$this->categories_model->update($id, $this->input->post('parent_id'), $this->input->post('description'), $this->input->post('color'), $user['id'], $date);

		redirect(base_url() . 'categories', 'location', 301);
	}
	

	public function delete($id) {	
		$date = date("Y-m-d H:i:s");
		$user = $this->session->userdata("user_data");

		$this->categories_model->delete($id, $user['id'], $date);
		redirect(base_url() . 'categories', 'location', 301);
	}

	
}


