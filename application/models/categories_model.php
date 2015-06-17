<?php
class categories_model extends CI_Model {

	function __construct(){
		$this->load->database();
	}
   
	public function get_all(){
		//Get Only active categories
		$this->db->select("id, description, parent_id");
		$this->db->from("categories");
		$this->db->where('status_id', 1);
		$this->db->order_by("parent_id", "asc");

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_by_id($id){
		//Get Only active categories
		$this->db->select("id, description, color, parent_id");
		$this->db->from("categories");
		$this->db->where('status_id', 1);
		$this->db->where('id', $id);

		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_parents(){
		$query = $this->db->get_where('categories', array('parent_id' => 0, 'status_id' => 1));
		return $query->result_array();
	}

	public function get_childs(){
		$query = $this->db->get_where('categories', array('parent_id !=' => 0, 'status_id' => 1));
		return $query->result_array();
	}

	public function insert($parent_id, $description, $color, $user_id, $date){
		$data = array(
			'parent_id' => $parent_id,
			'description' => $description,
			'color' => $color,
			'status_id' => 1,
			'date_create' => $date,
			'date_change' => $date,
			'user_create_id' => $user_id,
			'user_change_id' => $user_id
		);

		$this->db->insert('categories', $data);

		return $this->db->insert_id();
	}

	public function update($id, $parent_id, $description, $color, $user_id, $date){
		$data = array(
			'parent_id' => $parent_id,
			'description' => $description,
			'color' => $color,
			'status_id' => 1,
			'date_change' => $date,
			'user_change_id' => $user_id
		);

		$this->db->where('id', $id);
		$this->db->update('categories', $data);
	}

    public function delete($id, $user_id, $date){
   		
		$data = array(
			'status_id' => 2,
			'date_change' => $date,
			'user_change_id' => $user_id
		);

		$this->db->where('id', $id);
		$this->db->update('categories', $data);
	}
	
}
?>