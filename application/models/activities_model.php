<?php
class activities_model extends CI_Model {

	function __construct(){
		$this->load->database();
	}
   
	public function get_all(){
		$this->db->select('a.id, a.start_date, a.end_date, a.repeated, a.frequency_id, a.name as title');
		$this->db->from('activities a');
		$this->db->join('categories c', 'a.category_id = c.id', 'inner');
		$this->db->where('a.status_id', 1);

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_periods(){
		$this->db->select('min(start_date) as first_period ,max(start_date) as last_period');
		$this->db->from('activities');
		$this->db->where('status_id', 1);

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_by_dealership_dates($dealership_id, $start_date, $end_date){
		$this->db->select('a.id, a.start_date, a.name as title, a.happened, c.color');
		$this->db->from('activities a');
		$this->db->join('categories c', 'a.category_id = c.id', 'inner');
		$this->db->where('a.status_id', 1);
		if ($dealership_id != 0) {
			$this->db->where('a.dealership_id', $dealership_id);
		}
		$this->db->where('a.start_date >=', $start_date);
		$this->db->where('a.start_date <=', $end_date);

		$query = $this->db->get();
		return $query->result_array();
	}




	/************************************/

	public function get_by_filters($start_date, $end_date, $category_id, $happened, $audience, $focus, $model, $dealership_id){
		$filters = " ";
		$filter_audience = " ";
		$filter_focus = " ";
		$filter_model = " ";

		if($start_date!=""){
			$filters.= " AND a.start_date >= str_to_date('" . $start_date . "','%m/%d/%Y') ";
		}

		if($end_date!=""){
			$filters.= " AND a.start_date < str_to_date('" . $end_date . "','%m/%d/%Y') ";
		}

		if($category_id!=0){
			$filters.= " AND a.category_id = ".  $category_id . " " ;
		}

		if($happened!=""){
			$filters.= " AND a.happened in ($happened) ";
		}

		if($audience!=""){
			$filter_audience = " INNER JOIN activity_audiences X ON a.id = X.activity_id AND X.audience_id in ($audience) ";
		}

		if($focus!=""){
			$filter_focus = " INNER JOIN activity_focus Y ON a.id = Y.activity_id AND Y.focus_id in ($focus) ";
		}

		if($model!=""){
			$filter_model = " INNER JOIN activity_models Z ON a.id = Z.activity_id AND Z.model_id in ($model) ";
		}

		$query = $this->db->query("
			SELECT DISTINCT a.id, a.start_date, a.name as title, a.happened, c.color
			FROM activities a
			INNER JOIN categories c ON a.category_id = c.id
			$filter_audience 
			$filter_focus 
			$filter_model 
			WHERE a.status_id = 1 
				AND (a.dealership_id = ".$dealership_id . " OR 0=".$dealership_id.")". $filters);

		/*echo "
			SELECT a.id, a.start_date, a.name as title, a.happened, c.color
			FROM activities a
			INNER JOIN categories c ON a.category_id = c.id
			$filter_audience 
			$filter_focus 
			$filter_model 
			WHERE a.status_id = 1 
				AND (a.dealership_id = ".$dealership_id . " OR 0=".$dealership_id.")". $filters;*/

		/*$this->db->select('a.id, a.start_date, a.name as title, a.happened, c.color');
		$this->db->from('activities a');
		$this->db->join('categories c', 'a.category_id = c.id', 'inner');
		$this->db->where('a.status_id', 1);
		if ($dealership_id != 0) {
			$this->db->where('a.dealership_id', $dealership_id);
		}
		$this->db->where('a.start_date >=', $start_date);
		$this->db->where('a.start_date <=', $end_date);

		$query = $this->db->get();*/
		return $query->result_array();
	}

	/************************************/






	public function get_by_dates($start_date, $end_date){
		$this->db->select('id, start_date, name as title');
		$this->db->from('activities');
		$this->db->where('status_id', 1);
		$this->db->where('start_date >=', $start_date);
		$this->db->where('start_date <=', $end_date);

		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_by_id($id){
		$query = $this->db->get_where('activities', array('id' => $id, "status_id" => 1));
		$data = $query->result_array();

		if (count($data) > 0) return $data[0];
	}

	public function get_sales_by_dealer_date($dealership_id, $year){
		$this->db->select('sum(expense) as spend');
		$this->db->from('activities');
		$this->db->where('status_id', 1);
		$this->db->where('dealership_id', $dealership_id);
		$this->db->where('YEAR(start_date)', $year);

		$query = $this->db->get();
		$data = $query->result_array();
		
		if ($data[0]['spend'] != "") 
			$expense = $data[0]['spend'];
		else 
			$expense = 0;

		return $expense;
	}

	public function get_sales_by_date($year){
		$this->db->select('sum(expense) as spend');
		$this->db->from('activities');
		$this->db->where('status_id', 1);
		$this->db->where('YEAR(start_date)', $year);

		$query = $this->db->get();
		$data = $query->result_array();

		
		if ($data[0]['spend'] != "") 
			$expense = $data[0]['spend'];
		else 
			$expense = 0;

		return $expense;
	}

	public function insert($name, $category_id, $start_date, $expense, $description, $dealership_id, $user_id, $date){
		$data = array(
			'name' => $name,
			'category_id' => $category_id,
			'start_date' => $start_date,
			'expense' => $expense,
			'description' => $description,
			'dealership_id' => $dealership_id,
			'status_id' => 1,
			'user_create_id' => $user_id,
			'user_change_id' => $user_id,
			'date_create' => $date,
			'date_change' => $date
		);

		$this->db->insert('activities', $data);

		return $this->db->insert_id();
	}

	public function update($id, $name, $category_id, $start_date, $expense, $description, $dealership_id, $happened, $user_id, $date){
		$data = array(
			'name' => $name,
			'category_id' => $category_id,
			'start_date' => $start_date,
			'expense' => $expense,
			'description' => $description,
			'dealership_id' => $dealership_id,
			'happened' => $happened,
			'user_change_id' => $user_id,
			'date_change' => $date
		);

		$this->db->where('id', $id);
		$this->db->update('activities', $data);
	}

	public function happened($id, $status, $user_id, $date) {
		$data = array(
			'happened' => $status,
			'user_change_id' => $user_id,
			'date_change' => $date
		);

		$this->db->where('id', $id);
		$this->db->update('activities', $data);
	}

    public function delete($id, $user_id, $date){
   		
		$data = array(
			'status_id' => 2,
			'user_change_id' => $user_id,
			'date_change' => $date
		);

		$this->db->where('id', $id);
		$this->db->update('activities', $data);
	}
}
?>