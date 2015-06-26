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
		$vars['user_type_id'] = $user['user_type_id'];

		
		$sales = array();
		$q = 1;
		$data = array();
		$quarters = array();
		$targeted = 0;
		$sumamry['targeted'] = 0;
		$sumamry['gross'] = 0;
		$sumamry['marketing'] = 0;

	
		if ($user['dealership_id'] == 0) {
			$sales = $this->sales_model->get_by_period($user['period']);
			$dealerships = $user['dealers'];
			$sumamry['spend'] = $this->activities_model->get_sales_by_date($user["period"]);
			$vars['dealership_revenue'] = 1;
		} else {
			$sales = $this->sales_model->get_by_dealership_period($user['dealership_id'], $user['period']);
			$dealerships = $this->dealerships_model->get_by_id($user['dealership_id']);
			$sumamry['spend'] = $this->activities_model->get_sales_by_dealer_date($user["dealership_id"], $user["period"]);
			$vars['dealership_revenue'] = $dealerships[0]['revenue'];
		}


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

		foreach ($dealerships as $key => $dealership) {
			$totals = $this->sales_model->get_totals_by_dealership_period($dealership['id'], $user['period']);

			$sumamry['targeted'] += $totals['sales'];
			$sumamry['gross'] += $totals['sales'] * $totals['revenue'];
			$sumamry['marketing'] += ($totals['sales'] * $totals['revenue'])*0.015;
		}

		$vars['data'] = $data;
		$vars['dealership_id'] = $user['dealership_id'];
		
		$vars['totals'] = $sumamry;

				
		$this->load->view('template', $vars);
		
	}

	
}


