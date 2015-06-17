<?php
class activity_focus_model extends CI_Model {

	function __construct(){
		$this->load->database();
	}
   
	public function get_all(){
		
	}

	public function get_by_activity_id($activity_id){
		$query = $this->db->get_where('activity_focus', array('activity_id' => $activity_id));

		return $query->result_array();
	}
	
	public function insert($activity_id, $focus_id){
		$data = array(
			'activity_id' => $activity_id,
			'focus_id' => $focus_id
		);

		$this->db->insert('activity_focus', $data);

		return $this->db->insert_id();
	}

	public function delete_by_activity_id($activity_id){
		$this->db->where('activity_id', $activity_id);
		$this->db->delete('activity_focus');
	}
	
}
?>