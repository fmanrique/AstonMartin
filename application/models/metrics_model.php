<?php
class metrics_model extends CI_Model {

	function __construct(){
		$this->load->database();
	}
   
	public function get_all(){
		$query = $this->db->get_where('metrics', array('status_id' => 1));
		return $query->result_array();
	}

	public function get_by_id($id){
		//Get only actives
		$query = $this->db->get_where('metrics', array('id' => $id, 'status_id' => 1));
		return $query->result_array();
		
	}

	public function insert($description, $user_id, $date){
		$data = array(
			'description' => $description,
			'status_id' => 1,
			'date_create' => $date,
			'date_change' => $date,
			'user_create_id' => $user_id,
			'user_change_id' => $user_id
		);

		$this->db->insert('metrics', $data);

		return $this->db->insert_id();
	}

	public function update($id, $description, $user_id, $date){
		$data = array(
			'description' => $description,
			'date_change' => $date,
			'user_change_id' => $user_id
		);

		$this->db->where('id', $id);
		$this->db->update('metrics', $data);
	}

    public function delete($id, $user_id, $date){
   		
		$data = array(
			'status_id' => 2,
			'date_change' => $date,
			'user_change_id' => $user_id
		);

		$this->db->where('id', $id);
		$this->db->update('metrics', $data);
	}
	
}
?>