<?php
class users_regions_model extends CI_Model {

	function __construct(){
		$this->load->database();
	}

	public function get_by_user_id($user_id){
		$query = $this->db->get_where('users_regions', array('user_id' => $user_id));

		return $query->result_array();
	}

	public function insert($user_id, $region_id){
		$data = array(
			'user_id' => $user_id,
			'region_id' => $region_id
		);

		$this->db->insert('users_regions', $data);
	}

    public function delete($user_id){
		$this->db->delete('users_regions', array('user_id' => $user_id)); 
	}
	
}
?>