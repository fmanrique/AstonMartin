<?php
class currencies_model extends CI_Model {

	function __construct(){
		$this->load->database();
	}
   
	public function get_all(){
		//Get only actives
		$query = $this->db->get_where('currencies', array('status_id' => 1));
		return $query->result_array();
	}

	public function get_by_id($id){
		//Get only actives
		$query = $this->db->get_where('currencies', array('id' => $id, 'status_id' => 1));
		return $query->result_array();
		
	}

	public function insert($name, $description, $user_id, $date){
		$data = array(
			'name' => $name,
			'description' => $description,
			'status_id' => 1,
			'date_create' => $date,
			'date_change' => $date,
			'user_create_id' => $user_id,
			'user_change_id' => $user_id
		);

		$this->db->insert('currencies', $data);

		return $this->db->insert_id();
	}

	public function update($id, $name, $description, $user_id, $date){
		$data = array(
			'name' => $name,
			'description' => $description,
			'date_change' => $date,
			'user_change_id' => $user_id
		);

		$this->db->where('id', $id);
		$this->db->update('currencies', $data);
	}

    public function delete($id, $user_id, $date){
   		
		$data = array(
			'status_id' => 2,
			'date_change' => $date,
			'user_change_id' => $user_id
		);

		$this->db->where('id', $id);
		$this->db->update('currencies', $data);
	}

	
}
?>