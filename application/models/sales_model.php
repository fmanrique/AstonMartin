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

		$this->db->select('period, month, quarter, sum(sales) as sales');
		$this->db->from('targeted_sales');
		$this->db->group_by('period, month, quarter');
		$this->db->where('period', $period);
		$this->db->order_by('period, quarter, month');
		
		$query = $this->db->get();
		return $query->result_array();
		
		/*if ($data[0]['spend'] != "") 
			$expense = $data[0]['spend'];
		else 
			$expense = 0;

		return $expense;*/
	}

	

	public function get_by_dealership_period_quarter($dealership_id, $period, $quarter){
		//Get only actives
		$query = $this->db->get_where('targeted_sales', array('dealership_id' => $dealership_id, 'period' => $period, 'quarter' => $quarter));
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

	public function exists($period, $month, $quarter, $dealership_id){
		$this->db->select('id');
		$this->db->from('targeted_sales');
		$this->db->where('period', $period);
		$this->db->where('month', $month);
		$this->db->where('quarter', $quarter);
		$this->db->whete('dealership_id', $dealership_id);
		$this->db->limit(1);

		$query = $this->db->get();
		return $query->result_array();
	}

	public function insert($period, $month, $quarter, $sales, $dealership_id){
		$data = array(
			'period' => $period,
			'month' => $month,
			'quarter' => $quarter,
			'sales' => $sales,
			'dealership_id' => $dealership_id
		);

		$this->db->insert('targeted_sales', $data);

		return $this->db->insert_id();
	}

	public function update($id, $period, $month, $quarter, $sales, $dealership_id){
		$data = array(
			'period' => $period,
			'month' => $month,
			'quarter' => $quarter,
			'sales' => $sales,
			'dealership_id' => $dealership_id
		);

		$this->db->where('id', $id);
		$this->db->update('targeted_sales', $data);
	}

    public function delete($id){
   		
		$data = array(
			'sales' => 0,
		);

		$this->db->where('id', $id);
		$this->db->update('targeted_sales', $data);
	}
	
}
?>