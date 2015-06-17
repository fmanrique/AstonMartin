<?php
class activity_metrics_model extends CI_Model {

	function __construct(){
		$this->load->database();
	}
   
	public function get_all(){
		$this->db->select('a.id, a.category_id, c.description as category, a.metric_id, m.description as metric, a.quantity');
		$this->db->from('activity_metrics a');
		$this->db->join('categories c', 'a.category_id = c.id', 'inner');
		$this->db->join('metrics m', 'a.metric_id = m.id', 'inner');


		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_by_activity_id($activity_id){
		$this->db->select('a.id, a.category_id, c.description as category, a.metric_id, m.description as metric, a.quantity');
		$this->db->from('activity_metrics a');
		$this->db->join('categories c', 'a.category_id = c.id', 'inner');
		$this->db->join('metrics m', 'a.metric_id = m.id', 'inner');
		$this->db->where('a.activity_id', $activity_id);

		$query = $this->db->get();
		return $query->result_array();
	}

	public function insert($activity_id, $category_id,  $metric_id, $quantity){
		$data = array(
			'activity_id' => $activity_id,
			'category_id' => $category_id,
			'metric_id' => $metric_id,
			'quantity' => $quantity
		);

		$this->db->insert('activity_metrics', $data);

		return $this->db->insert_id();
	}

	public function delete_by_activity_id($activity_id){
		$this->db->where('activity_id', $activity_id);
		$this->db->delete('activity_metrics');
	}
	
}
?>