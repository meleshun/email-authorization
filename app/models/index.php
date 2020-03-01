<?php

class Model_Index extends Model {

	// Get all regions
	public function get_regions() {
		$result = $this->conn->query("SELECT ter_id, ter_name FROM t_koatuu_tree WHERE ter_type_id = 0");
		return $this->result($result);
	}

	// Get cities in the regions
	public function get_cities($ter_id) {
		$result = $this->conn->query("SELECT ter_id, ter_name FROM t_koatuu_tree WHERE ter_pid = $ter_id AND ter_type_id = 1");
		return $this->result($result);
	}

	// Get districts in the cities
	public function get_districts($ter_id) {
		$result = $this->conn->query("SELECT ter_id, ter_name FROM t_koatuu_tree WHERE ter_pid = $ter_id AND ter_type_id = 3");
		return $this->result($result);
	}

	// Get row by ID
	public function get_ter($ter_id) {
		$result = $this->conn->query("SELECT * FROM t_koatuu_tree WHERE ter_id = $ter_id");
		return $this->result($result);
	}

	// Set user
	public function set_user($name, $email, $territory) {
		$result = $this->conn->query("INSERT INTO t_users(name, email, territory) VALUES ('$name', '$email', '$territory')");
	}

	// Get user
	public function get_user($email) {
		$result = $this->conn->query("SELECT * FROM t_users WHERE email = '$email'");
		return $this->result($result);
	}

}