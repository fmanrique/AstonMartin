<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class activities extends CI_Controller {

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
		$this->load->model('activities_model');
		$this->load->model('categories_model');
		$this->load->model('audiences_model');
		$this->load->model('models_model');
		$this->load->model('focus_model');
		$this->load->model('frequency_model');
		$this->load->model('metrics_model');
		$this->load->model('activity_audiences_model');
		$this->load->model('activity_models_model');
		$this->load->model('activity_focus_model');
		$this->load->model('activity_metrics_model');
		$this->load->library('functions');
	}

	public function index()
	{
		$vars['title'] = 'Activities';
		$vars['content_view'] = '/activities_list';
		//$vars['data'] = $this->activities_model->get_all();
		$vars['option']  = "activities";
		$vars['audiences'] = $this->audiences_model->get_all();
		$vars['models'] = $this->models_model->get_all();
		$vars['focus'] = $this->focus_model->get_all();
		$vars['frequencies'] = $this->frequency_model->get_all();
		$vars['metrics'] = $this->metrics_model->get_all();


		$parents = $this->categories_model->get_parents();
		$childs = $this->categories_model->get_childs();
		$categories = array();

		foreach ($parents as $key => $parent) {
			$category = $parent;
			$category_childs = $this->functions->search($childs, 'parent_id', $parent['id']);

			$category['childs'] = $category_childs;

			$categories[] = $category;
		}

		$vars['categories'] = $categories;
		

		$this->load->view('template', $vars);
		
	}

	public function calendar($year, $month)
	{
		$date = date("Y-m-d H:i:s");
		$user = $this->session->userdata("user_data");

		// FILTERS =============
		$happened = "";
		$audience = "";
		$focus = "";
		$model = "";

		$category_id = $this->input->post("category");
		$dealership_id = $user['dealership_id'];

		if ($_POST["from"] != "") {
			$start = $this->input->post("from");
			$end = $start;
		} else {
			$start = date(str_pad($month, 2, '0', STR_PAD_LEFT) . '/01/' . $year);
			$end = $start;
			$start = date('m/d/Y', strtotime("-7 days", strtotime($end)));
		}

		if ($_POST["to"] != "") {
			$end = $this->input->post("to");
			$end = date('m/d/Y', strtotime("+1 day", strtotime($end)));
		} else {
			$end = date('m/d/Y', strtotime("+1 months +7 days", strtotime($end)));
		}



		if(isset($_POST["happened"])) {
			foreach ($_POST["happened"] as $item) {
				$happened.=$item.",";
			}
		}

		if(isset($_POST["audience"])) {
			foreach ($this->input->post("audience") as $item) {
				$audience.=$item.",";
			}
		}
  
		if(isset($_POST["focus"])) {
			foreach ($this->input->post("focus") as $item) {    
				$focus.=$item.",";
			}
		}
 
		if(isset($_POST["model"])) {
			foreach ($this->input->post("model") as $item) {
				$model.=$item.",";
			}
		}
		// FILTERS =============

		$activities = $this->activities_model->get_by_filters($start, $end, $category_id, rtrim($happened,','), rtrim($audience,','), rtrim($focus,','), rtrim($model,','),$dealership_id);	


		$calendar = "[";

		foreach ($activities as $key => $activity) {
			$calendar .= "{";

			//$start_date = new DateTime($activity['start_date']);
			$start_date = new DateTime(date('m/d/Y', strtotime("+1 day", strtotime($activity['start_date']))));	

			//$end = date('m/d/Y', strtotime("+1 day", strtotime($end)));		

			$calendar .= "\"id\":\"" . $activity['id'] . "\",";
			$calendar .= "\"title\":\"" . $activity['title'] . "\",";
			$calendar .= "\"start\":" . date_timestamp_get($start_date) . ",";
			$calendar .= "\"allDay\":\"true\",";
			$calendar .= "\"happened\":\"" . $activity['happened'] . "\",";
			
			if ($user['user_type_id'] != 2) {
				$calendar .= "\"backgroundColor\":\"".$activity['color']."\",";
				$calendar .= "\"url\":\"" . base_url() . "activities/edit/" . $activity['id'] . "\"";
			} else {
				$calendar .= "\"backgroundColor\":\"".$activity['color']."\"";
			}

			$calendar .= "},";
			
		}

		$calendar = substr($calendar, 0, -1);

		$calendar .= "]";


		echo $calendar;
		
			
		die;
		
	}

	public function add() {
		$vars['title'] = 'Add new activity';
		$vars['content_view'] = '/activities_new';
		$vars['option']  = "activities";
		$vars['audiences'] = $this->audiences_model->get_all();
		$vars['models'] = $this->models_model->get_all();
		$vars['focus'] = $this->focus_model->get_all();
		$vars['frequencies'] = $this->frequency_model->get_all();
		$vars['metrics'] = $this->metrics_model->get_all();
		$vars['end_date'] = date('m/d/Y', strtotime('12/31'));

		$parents = $this->categories_model->get_parents();
		$childs = $this->categories_model->get_childs();
		$categories = array();

		foreach ($parents as $key => $parent) {
			$category = $parent;
			$category_childs = $this->functions->search($childs, 'parent_id', $parent['id']);

			$category['childs'] = $category_childs;

			$categories[] = $category;
		}

		$vars['categories'] = $categories;
		

		$this->load->view('template', $vars);
		
	}

	public function edit($id) {
		$min_date = new DateTime('01/01/1900');

		$vars['title'] = 'Add new activity';
		$vars['content_view'] = '/activities_edit';
		$vars['option']  = "activities";
		$vars['frequencies'] = $this->frequency_model->get_all();
		$vars['metrics'] = $this->metrics_model->get_all();
		$vars['activity_metrics'] = $this->activity_metrics_model->get_by_activity_id($id);
		$vars['data'] = $this->activities_model->get_by_id($id);
		$vars['data']['start_date'] = date('Y-m-d', strtotime($vars['data']['start_date']));

		$audiences = $this->audiences_model->get_all();
		$models = $this->models_model->get_all();
		$focus = $this->focus_model->get_all();
		
		$activity_audiences = $this->activity_audiences_model->get_by_activity_id($vars['data']['id']);
		$activity_models = $this->activity_models_model->get_by_activity_id($vars['data']['id']);
		$activity_focus = $this->activity_focus_model->get_by_activity_id($vars['data']['id']);
		$parents = $this->categories_model->get_parents();
		$childs = $this->categories_model->get_childs();

		$categories = array();

		//Categories
		foreach ($parents as $key => $parent) {
			$category = $parent;
			$category_childs = $this->functions->search($childs, 'parent_id', $parent['id']);

			$category['childs'] = $category_childs;

			$categories[] = $category;
		}

		$vars['categories'] = $categories;
		
		//Audiencies
		foreach ($audiences as $key => $audience) {
			if ($this->functions->exists_in_array($activity_audiences, 'audience_id', $audience['id'])) {
				$audiences[$key]['checked'] = 1;
			} else {
				$audiences[$key]['checked'] = 0;
			}
		}

		$vars['audiences'] = $audiences;

		//Models
		foreach ($models as $key => $model) {
			if ($this->functions->exists_in_array($activity_models, 'model_id', $model['id'])) {
				$models[$key]['checked'] = 1;
			} else {
				$models[$key]['checked'] = 0;
			}
		}

		$vars['models'] = $models;

		//Focus
		foreach ($focus as $key => $item) {
			if ($this->functions->exists_in_array($activity_focus, 'focus_id', $item['id'])) {
				$focus[$key]['checked'] = 1;
			} else {
				$focus[$key]['checked'] = 0;
			}
		}

		$vars['focus'] = $focus;

		$activity_metrics = array();
		foreach ($vars['activity_metrics'] as $key => $metric) {
			$item[0] = $key;
			$item[1] = $metric['metric_id'];
			$item[2] = $metric['quantity'];

			$activity_metrics[] = $item;
		}
		$vars['activity_metrics_json'] = json_encode($activity_metrics);	


		$this->load->view('template', $vars);
	}

	public function save() {
		$s_date = DateTime::createFromFormat('m/d/Y', $this->input->post('start_date'));
		$start_date = $s_date->format( 'm/d/Y' );
		$total_expense = $this->input->post('expense');

		$end_date = date('m/d/Y', strtotime('12/31'));
		if ($this->input->post('end_date') != "") {
			$e_date = DateTime::createFromFormat('m/d/Y', $this->input->post('end_date'));
			$end_date = $e_date->format( 'm/d/Y' );
		}

		if ($this->input->post('repeated') == "1") {
			$current_date = $start_date;
			switch ($this->input->post('frequency_id')) {
				case '3': //By Week
					$weeks = $this->functions->datediff("+1 week", $start_date, $end_date);
					$expense = $total_expense/$weeks;
					for ($i = 0; $i<$weeks; $i++) {
						$this->insert($this->input->post('name'), $this->input->post('category_id'), $current_date, $expense, $this->input->post('description'), $this->input->post('audience'), $this->input->post('model'), $this->input->post('focus'), $this->input->post('metrics'));
						$current_date = date('Y-m-d', strtotime("+1 week", strtotime($current_date)));
					}
					break;
				case '2': //By Month
					$months = $this->functions->datediff("+1 months", $start_date, $end_date);
					$expense = $total_expense/$months;
					for ($i = 0; $i<$months; $i++) {
						$this->insert($this->input->post('name'), $this->input->post('category_id'), $current_date, $expense, $this->input->post('description'), $this->input->post('audience'), $this->input->post('model'), $this->input->post('focus'), $this->input->post('metrics'));
						$current_date = date('Y-m-d', strtotime("+1 months", strtotime($current_date)));
					}
					break;
				case '1': //By Quarter
					$quarters = $this->functions->datediff("+4 months", $start_date, $end_date);
					$expense = $total_expense/$quarters;
					for ($i = 0; $i<$quarters; $i++) {
						$this->insert($this->input->post('name'), $this->input->post('category_id'), $current_date, $expense, $this->input->post('description'), $this->input->post('audience'), $this->input->post('model'), $this->input->post('focus'), $this->input->post('metrics'));
						$current_date = date('Y-m-d', strtotime("+4 months", strtotime($current_date)));
					}
					break;
			}
		} else {
			$this->insert($this->input->post('name'), $this->input->post('category_id'), $start_date, $this->input->post('expense'), $this->input->post('description'), $this->input->post('audience'), $this->input->post('model'), $this->input->post('focus'), $this->input->post('metrics'));
		}

		redirect(base_url() . 'activities', 'location', 301);
	}

	private function insert($name, $category_id, $start_date, $expense, $description, $audiences, $models, $focus, $metrics){
		$date = date("Y-m-d H:i:s");
		$user = $this->session->userdata("user_data");
		
		$activity_id = $this->activities_model->insert($name, $category_id, $start_date, $expense, $description, $user['dealership_id'], $user['id'], $date);

		if ($audiences != "") {
			foreach($audiences as $key => $audience_id) {
			 	$this->activity_audiences_model->insert($activity_id, $audience_id);
			}
		}

		if ($models != "") {
			foreach($models as $key => $model_id) {
			 	$this->activity_models_model->insert($activity_id, $model_id);
			}	
		}

		if ($focus != "") {
			foreach($focus as $key => $focus_id) {
			 	$this->activity_focus_model->insert($activity_id, $focus_id);
			}	
		}

		$metrics = json_decode($this->input->post('metrics'));

		foreach($metrics as $key => $metric) {
			$this->activity_metrics_model->insert($activity_id, $metric[1], $metric[2]);
		}
	}

	public function update($id) {	

		$date = date("Y-m-d H:i:s");
		$user = $this->session->userdata("user_data");

		$s_date = DateTime::createFromFormat('m-d-Y', $this->input->post('start_date'));
		$start_date = $s_date->format( 'Y-m-d' );
		
		$this->activities_model->update($id, $this->input->post('name'), $this->input->post('category_id'), $start_date, $this->input->post('expense'), $this->input->post('description'), $user['dealership_id'], $this->input->post('happened'), $user['id'],  $date);

		$this->activity_audiences_model->delete_by_activity_id($id);
		if ($this->input->post('audience') != "") {
			foreach($this->input->post('audience') as $key => $audience_id) {
			 	$this->activity_audiences_model->insert($id, $audience_id);
			}
		}

		$this->activity_models_model->delete_by_activity_id($id);
		if ($this->input->post('model') != "") {
			foreach($this->input->post('model') as $key => $model_id) {
			 	$this->activity_models_model->insert($id, $model_id);
			}
		}

		$this->activity_focus_model->delete_by_activity_id($id);
		if ($this->input->post('focus') != "") {
			foreach($this->input->post('focus') as $key => $focus_id) {
			 	$this->activity_focus_model->insert($id, $focus_id);
			}
		}

		$metrics = json_decode(json_encode(json_decode($this->input->post('metrics'))),true);

		$this->activity_metrics_model->delete_by_activity_id($id);
		foreach($metrics as $key => $metric) {
			$this->activity_metrics_model->insert($id, $metric[1], $metric[2]);
		}

		redirect(base_url() . 'activities', 'location', 301);
	}
	

	public function delete($id) {	
		$date = date("Y-m-d H:i:s");
		$user = $this->session->userdata("user_data");

		$this->activities_model->delete($id, $user['id'], $date);
		echo "OK";
		die;
	}

	function happened($id) {
		$date = date("Y-m-d H:i:s");
		$user = $this->session->userdata("user_data");
		$status = 0;

		$activity = $this->activities_model->get_by_id($id);

		if ($activity['happened'] == 0)
			$status = 1;
		else
			$status = 0;

		$this->activities_model->happened($id, $status, $user['id'], $date);
		echo $status;
		die;
	}

	
}


