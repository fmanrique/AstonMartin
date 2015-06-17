<?php
class frequency_model extends CI_Model {

	function __construct(){
		$this->load->database();
	}
   
	public function get_all(){
		$query = $this->db->get('frequency');
		return $query->result_array();
	}

	
}
?>