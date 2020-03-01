<?php

class Model {

	protected $conn;

	public function __construct() {
		
		// Config database
		require_once __DIR__ . '/../../config/database.php';

		// Create connection
		$this->conn = new mysqli($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_DATABASE);

		// Check connection
		if ($this->conn->connect_error) {
			die("Connection failed: " . $this->conn->connect_error);
		}

		// Create table t_users
		$this->conn->query('CREATE TABLE IF NOT EXISTS t_users(
			id INT AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(255),
			email VARCHAR(255),
			territory VARCHAR(255)
		)');

		// $this->conn->query('DROP TABLE t_users');

		// if ($this->conn->error) {
		// 	die("Create table failed: " . $this->conn->error);
		// }
	}

	protected function result($result) {
		
		$data = [];
		while ($array = $result->fetch_array(MYSQLI_ASSOC)) {
			$data[] = $array;
		}
		$result->close();
		return $data;
	}

}