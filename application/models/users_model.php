<?php
class users_model extends CI_Model {

	function __construct(){
		$this->load->database();
	}
   
	public function get_all(){
		$query = $this->db->query("
			SELECT id, email, name, user_type_id, type, dealership_id, region_id, region_name, dealership_name
			FROM (
				SELECT u.id, u.email, u.name, u.user_type_id, t.type, u.dealership_id, r.id as region_id, r.description as region_name, d.name as dealership_name
				FROM (users u) 
				INNER JOIN user_types t ON t.id = u.user_type_id 
				INNER JOIN dealerships d ON d.id = u.dealership_id 
				INNER JOIN regions r ON r.id = d.region_id 
				WHERE u.status_id = 1 AND u.user_type_id <> 2
				UNION ALL
				SELECT u.id, u.email, u.name, u.user_type_id, t.type, u.dealership_id, u.region_id as region_id, r.description as region_name, de_re.dealerships_regions as dealership_name
				FROM (users u) 
				INNER JOIN user_types t ON t.id = u.user_type_id 
				INNER JOIN regions r ON r.id = u.region_id 
				LEFT JOIN (SELECT de.region_id, GROUP_CONCAT(de.name SEPARATOR ', ') as 'dealerships_regions'
									FROM dealerships de
									INNER JOIN regions re ON re.id = de.region_id
									WHERE de.status_id = 1 AND re.status_id = 1
									GROUP BY region_id) de_re ON u.region_id = de_re.region_id
				WHERE u.status_id = 1 AND u.user_type_id = 2
				) O
			ORDER BY name
		");

		return $query->result_array();
	}
	
	public function get_by_id($id){
		$query = $this->db->query("
			SELECT u.id, u.email, u.name, u.user_type_id, t.type, u.dealership_id, u.region_id, d.name as dealership_name, r.description as region_name
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
			SELECT u.id, u.email, u.name, u.password, u.user_type_id, u.region_id, u.dealership_id
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

	public function insert($name, $email, $user_type_id, $dealership_id, $region_id, $password, $user_id, $date){
		$data = array(
			'name' => $name,
			'email' => $email,
			'user_type_id' => $user_type_id,
			'dealership_id' => $dealership_id,
			'region_id' => $region_id,
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

	public function update($id, $name, $email, $user_type_id, $dealership_id, $region_id, $user_id, $date){
		$data = array(
			'name' => $name,
			'email' => $email,
			'user_type_id' => $user_type_id,
			'dealership_id' => $dealership_id,
			'region_id' => $region_id,
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