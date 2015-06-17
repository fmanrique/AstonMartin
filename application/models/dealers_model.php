<?php
class dealers_model extends CI_Model {

	function __construct(){
		$this->load->database();
	}
   
	public function get_all(){
		$query = $this->db->get('dealers');
		return $query->result_array();
	}

	
}
?>