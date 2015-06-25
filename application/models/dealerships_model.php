<?php
class dealerships_model extends CI_Model {

	function __construct(){
		$this->load->database();
	}
   
	public function get_all(){
		//Get only actives
		$query = $this->db->get_where('dealerships', array('status_id' => 1));

		$this->db->select('d.*,z.description as "region_description", c.name as "currency_name"');
		$this->db->from('dealerships d');
		$this->db->join('regions z', 'z.id = d.region_id', 'inner');
		$this->db->join('currencies c', 'c.id = d.currency_id', 'left');
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

	public function get_revenues(){
		$this->db->select('id, revenue');
		$this->db->from('dealerships d');
		$this->db->join('regions z', 'z.id = d.region_id', 'inner');
		$this->db->where('d.status_id', 1);
		$this->db->order_by('d.name');

		$query = $this->db->get();

		return $query->result_array();
		
	}

	public function insert($name, $description, $revenue, $currency_id, $region_id, $user_id, $date){
		$data = array(
			'name' => $name,
			'description' => $description,
			'currency_id' => $currency_id,
			'revenue' => $revenue,
			'region_id' => $region_id,
			'status_id' => 1,
			'date_create' => $date,
			'date_change' => $date,
			'user_create_id' => $user_id,
			'user_change_id' => $user_id
		);

		$this->db->insert('dealerships', $data);

		return $this->db->insert_id();
	}

	public function update($id, $name, $description, $revenue, $currency_id, $region_id, $user_id, $date){
		$data = array(
			'name' => $name,
			'description' => $description,
			'currency_id' => $currency_id,
			'revenue' => $revenue,
			'region_id' => $region_id,
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