<?php
class dealerships_model extends CI_Model {

	function __construct(){
		$this->load->database();
	}
   
	public function get_all(){
		//Get only actives
		$query = $this->db->get_where('dealerships', array('status_id' => 1));

		$this->db->select('d.*,z.description as "zone_description"');
		$this->db->from('dealerships d');
		$this->db->join('zones z', 'z.id = d.zone_id', 'inner');
		$this->db->where('d.status_id', 1);
		$this->db->order_by('d.name');

		$query = $this->db->get();

		return $query->result_array();
	}

	public function get_by_id($id){
		//Get only actives
		$query = $this->db->get_where('dealerships', array('id' => $id, 'status_id' => 1));
		return $query->result_array();
		
	}

	public function insert($name, $description, $zone_id, $user_id, $date){
		$data = array(
			'name' => $name,
			'description' => $description,
			'zone_id' => $zone_id,
			'status_id' => 1,
			'date_create' => $date,
			'date_change' => $date,
			'user_create_id' => $user_id,
			'user_change_id' => $user_id
		);

		$this->db->insert('dealerships', $data);

		return $this->db->insert_id();
	}

	public function update($id, $name, $description, $zone_id, $user_id, $date){
		$data = array(
			'name' => $name,
			'description' => $description,
			'zone_id' => $zone_id,
			'date_change' => $date,
			'user_change_id' => $user_id
		);

		$this->db->where('id', $id);
		$this->db->update('dealerships', $data);
	}

    public function delete($id, $user_id, $date){
   		
		$data = array(
			'status_id' => 2,
			'date_change' => $date,
			'user_change_id' => $user_id
		);

		$this->db->where('id', $id);
		$this->db->update('dealerships', $data);
	}

	
}
?>