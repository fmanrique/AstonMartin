<?php
class users_dealerships_model extends CI_Model {

	function __construct(){
		$this->load->database();
	}

	public function get_by_user_id($user_id){
		$query = $this->db->get_where('users_dealerships', array('user_id' => $user_id));

		return $query->result_array();
	}

	public function insert($user_id, $dealership_id){
		$data = array(
			'user_id' => $user_id,
			'dealership_id' => $dealership_id
		);

		$this->db->insert('users_dealerships', $data);
	}

    public function delete($user_id){
		$this->db->delete('users_dealerships', array('user_id' => $user_id)); 
	}
	
}
?>