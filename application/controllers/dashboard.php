<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dashboard extends CI_Controller {

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
		$this->load->model('sales_model');
		$this->load->model('activities_model');
		$this->load->library('functions');
	}

	public function index() {
		$user = $this->session->userdata("user_data");

		$vars['title'] = 'Dashboard';
		$vars['content_view'] = '/targeted_sales';
		$vars['option']  = "dashboard";
		$vars['dealerships'] = $this->dealerships_model->get_all();
		$vars['user_type_id'] = $user['user_type_id'];

		if ($user['dealership_id'] == 0) {
			$sales = $this->sales_model->get_by_period($user['period']);
		} else {
			$sales = $this->sales_model->get_by_dealership_period($user['dealership_id'], $user['period']);
		}
		
		$q = 1;
		$data = array();
		$quarters = array();
		$targeted = 0;

		for ($i = 1; $i<=12; $i++) {
			$quarter['period'] = $user['period'];
			$quarter['month'] = $this->functions->get_month_name($i);
			$quarter['month_id'] = $i;

			$amounts = $this->functions->search($sales, 'month', $i);
			if ($amounts) {
				if ($user['dealership_id'] == 0)
					$quarter['sales_id'] = 0;
				else 
					$quarter['sales_id'] = $amounts[0]['id'];
				$quarter['sales'] = $amounts[0]['sales'];
				$targeted += $amounts[0]['sales'];
			} else {
				$quarter['sales'] = 0;
				$quarter['sales_id'] = 0;
			}
			
			$quarter['quarter'] = $q;
			$quarters[] = $quarter;

			if (($i > 1) && ($i % 3 == 0)) {
				$data['q'.$q] = $quarters;
				$quarters = array();
				$q = ($i/3) + 1;
			}
		}

		$totals['targeted'] = $targeted;
		$totals['gross'] = $targeted * 200000;
		$totals['marketing'] = ($targeted * 200000)*0.015;
		if ($user['dealership_id'] == 0)
			$totals['spend'] = $this->activities_model->get_sales_by_date($user["period"]);
		else 
			$totals['spend'] = $this->activities_model->get_sales_by_dealer_date($user["dealership_id"], $user["period"]);

		$vars['data'] = $data;
		$vars['dealership_id'] = $user['dealership_id'];
		$vars['totals'] = $totals;



		
		/*echo "<pre>";
		print_r($totals);
		echo "</pre>";
		die;*/
				
		$this->load->view('template', $vars);
		
	}

	
}


