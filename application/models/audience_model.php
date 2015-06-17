<?php
class audience_model extends CI_Model {

	function __construct(){
		$this->load->database();
	}
   
	public function get_all(){
		$query = $this->db->get('audience');
		return $query->result_array();
	}

	
}
?>