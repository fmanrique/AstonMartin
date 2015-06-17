<?php
class activity_audiences_model extends CI_Model {

	function __construct(){
		$this->load->database();
	}
   
	public function get_all(){
		
	}

	public function get_by_activity_id($activity_id){
		$query = $this->db->get_where('activity_audiences', array('activity_id' => $activity_id));

		return $query->result_array();
	}
	
	public function insert($activity_id, $audience_id){
		$data = array(
			'activity_id' => $activity_id,
			'audience_id' => $audience_id
		);

		$this->db->insert('activity_audiences', $data);

		return $this->db->insert_id();
	}

	public function delete_by_activity_id($activity_id){
		$this->db->where('activity_id', $activity_id);
		$this->db->delete('activity_audiences');
	}

	
}
?>