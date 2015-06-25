<?php
class sales_model extends CI_Model {

	function __construct(){
		$this->load->database();
	}
   
	public function get_all(){
		$query = $this->db->get_where('targeted_sales');
		return $query->result_array();
	}

	public function get_by_dealership_period($dealership_id, $period){
		//Get only actives
		$query = $this->db->get_where('targeted_sales', array('dealership_id' => $dealership_id, 'period' => $period));
		return $query->result_array();
	}

	public function get_by_period($period){
		//Get only actives
		//$query = $this->db->get_where('targeted_sales', array('dealership_id' => $dealership_id, 'period' => $period));
		//return $query->result_array();

		$this->db->select('period, month, sum(sales) as sales');
		$this->db->from('targeted_sales');
		$this->db->group_by('period, month');
		$this->db->where('period', $period);
		$this->db->order_by('period, month');
		
		$query = $this->db->get();
		return $query->result_array();
		
		/*if ($data[0]['spend'] != "") 
			$expense = $data[0]['spend'];
		else 
			$expense = 0;

		return $expense;*/
	}

	public function get_totals_by_dealership_period($dealership_id, $period){
		//Get only actives
		//$query = $this->db->get_where('targeted_sales', array('dealership_id' => $dealership_id, 'period' => $period));
		//return $query->result_array();

		$this->db->select('sum(sales) as sales, s.dealership_id, d.revenue');
		$this->db->from('targeted_sales s');
		$this->db->join('dealerships d', 's.dealership_id = d.id', 'inner');
		$this->db->group_by('s.dealership_id, d.revenue');
		$this->db->where('s.period', $period);
		$this->db->where('s.dealership_id', $dealership_id);
		
		$query = $this->db->get();
		$data = $query->result_array();

		if ($data) return $data[0];
		
		/*if ($data[0]['spend'] != "") 
			$expense = $data[0]['spend'];
		else 
			$expense = 0;

		return $expense;*/
	}

	

	public function get_by_dealership_period_quarter($dealership_id, $period){
		//Get only actives
		$query = $this->db->get_where('targeted_sales', array('dealership_id' => $dealership_id, 'period' => $period));
		return $query->result_array();
	}

	/*public function get_by_period($period){
		//Get only actives
		$query = $this->db->get_where('targeted_sales', array('period' => $period));
		return $query->result_array();
		
	}*/


	public function get_by_id($id){
		//Get only actives
		$query = $this->db->get_where('targeted_sales', array('id' => $id));
		return $query->result_array();
		
	}

	public function exists($period, $month, $dealership_id){
		$this->db->select('id');
		$this->db->from('targeted_sales');
		$this->db->where('period', $period);
		$this->db->where('month', $month);
		$this->db->where('dealership_id', $dealership_id);
		$this->db->limit(1);

		$query = $this->db->get();
		$data = $query->result_array();
		if ($data) 
			return true;
		else 
			return false;
	}

	public function insert($period, $month, $sales, $dealership_id){
		$data = array(
			'period' => $period,
			'month' => $month,
			'sales' => $sales,
			'dealership_id' => $dealership_id
		);

		$this->db->insert('targeted_sales', $data);

		return $this->db->insert_id();
	}

	public function update($period, $month, $sales, $dealership_id){
		$data = array(
			'sales' => $sales
		);

		$this->db->where('dealership_id', $dealership_id);
		$this->db->where('period', $period);
		$this->db->where('month', $month);
		$this->db->update('targeted_sales', $data);
	}

    public function delete($id){
   		
		$data = array(
			'sales' => 0,
		);

		$this->db->where('id', $id);
		$this->db->update('targeted_sales', $data);
	}

	public function delete_by_dealership_period_quarter($dealership_id, $period){
   		
		$data = array(
			'sales' => 0,
		);

		$this->db->where('dealership_id', $dealership_id);
		$this->db->where('period', $period);
		$this->db->update('targeted_sales', $data);
	}
	
}
?>