<?php
class users_model extends CI_Model {

	function __construct(){
		$this->load->database();
	}
   
	public function get_all(){
		$query = $this->db->query("
			SELECT u.id, u.email, u.name, t.type, u.dealership_id, ifnull(d.name, 'All Dealerships') as dealership_name, ifnull(r.description, 'All Regions') as region_name 
			FROM (users u) 
			INNER JOIN user_types t ON t.id = u.user_type_id 
			LEFT JOIN dealerships d ON d.id = u.dealership_id 
			LEFT JOIN regions r ON r.id = d.region_id 
			WHERE u.status_id = 1
		");

		return $query->result_array();
	}
	
	public function get_by_id($id){
		$query = $this->db->query("
			SELECT u.id, u.email, u.name, u.user_type_id, t.type, u.dealership_id, ifnull(d.name, 'All Dealerships') as dealership_name, ifnull(r.description, 'All Regions') as region_name
			FROM (users u) 
			INNER JOIN user_types t ON t.id = u.user_type_id 
			LEFT JOIN dealerships d ON d.id = u.dealership_id 
			LEFT JOIN regions r ON r.id = d.region_id 
			WHERE u.id=$id AND u.status_id = 1
			LIMIT 1
		");

		return $query->result_array();
	}

	public function get_by_email($email){
		$this->db->select('id, email, name, user_type_id,dealership_id');
		$this->db->from('users');
		$this->db->where('email', $email);
		$this->db->where('status_id', 1);
		$this->db->limit(1);

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_by_email_id($id, $email){
		$this->db->select('id, email, name, user_type_id,dealership_id');
		$this->db->from('users');
		$this->db->where('email', $email);
		$this->db->where('id !=', $id);
		$this->db->where('status_id', 1);
		$this->db->limit(1);

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_user_types(){
		$query = $this->db->get('user_types');
		return $query->result_array();
	}
	
	public function login($email, $password) {

		$query = $this->db->query("
			SELECT u.id, u.email, u.name, u.password, u.user_type_id, IFNULL(u.dealership_id, 0) AS dealership_id, IFNULL(d.name, 'All Dealerships') as dealership_name 
			FROM (users u) 
			LEFT JOIN dealerships d ON d.id = u.dealership_id 
			WHERE u.email = '$email' AND u.password = '" . sha1($password) . "' AND u.status_id = 1 
			LIMIT 1
		");

		if($query -> num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function insert($name, $email, $user_type_id, $dealership_id, $password, $user_id, $date){
		$data = array(
			'name' => $name,
			'email' => $email,
			'user_type_id' => $user_type_id,
			'dealership_id' => $dealership_id,
			'password' => sha1($password),
			'date_create' => $date,
			'date_change' => $date,
			'user_create_id' => $user_id,
			'user_change_id' => $user_id,
			'status_id' => 1
		);

		$this->db->insert('users', $data);

		return $this->db->insert_id();
	}

	public function update($id, $name, $email, $user_type_id, $dealership_id, $user_id, $date){
		$data = array(
			'name' => $name,
			'email' => $email,
			'user_type_id' => $user_type_id,
			'dealership_id' => $dealership_id,
			'date_change' => $date,
			'user_change_id' => $user_id,	
			'status_id' => 1
		);

		$this->db->where('id', $id);
		$this->db->update('users', $data);
	}

	public function update_profile($id, $name, $user_id, $date){
		$data = array(
			'name' => $name,
			'date_change' => $date,
			'user_change_id' => $user_id,	
			'status_id' => 1
		);

		$this->db->where('id', $id);
		$this->db->update('users', $data);
	}

	public function change_password($id, $password, $user_id, $date){
		$data = array(
			'password' => sha1($password),
			'user_change_id' => $user_id,
			'date_change' => $date
		);

		$this->db->where('id', $id);
		$this->db->update('users', $data);
	}

    public function delete($id, $user_id, $date){
   		
		$data = array(
			'status_id' => 2,
			'user_change_id' => $user_id,
			'date_change' => $date
		);

		$this->db->where('id', $id);
		$this->db->update('users', $data);
	}
}
?>