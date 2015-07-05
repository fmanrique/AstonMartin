<?php
class regions_model extends CI_Model {

	function __construct(){
		$this->load->database();
	}
   
	public function get_all(){
		//Get only actives
		$query = $this->db->get_where('regions', array('status_id' => 1));
		return $query->result_array();
	}

	public function get_all_simple(){
		//Get only actives
		$this->db->select('r.id, r.description');
		$this->db->from('regions r');
		$this->db->where('r.status_id', 1);
		$this->db->order_by('r.description');

		$query = $this->db->get();

		return $query->result_array();
	}

	public function get_by_id($id){
		//Get only actives
		$query = $this->db->get_where('regions', array('id' => $id, 'status_id' => 1));
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

		$this->db->insert('regions', $data);

		return $this->db->insert_id();
	}

	public function update($id, $description, $user_id, $date){
		$data = array(
			'description' => $description,
			'date_change' => $date,
			'user_change_id' => $user_id
		);

		$this->db->where('id', $id);
		$this->db->update('regions', $data);
	}

    public function delete($id, $user_id, $date){
   		
		$data = array(
			'status_id' => 2,
			'date_change' => $date,
			'user_change_id' => $user_id
		);

		$this->db->where('id', $id);
		$this->db->update('regions', $data);
	}

	
}
?>