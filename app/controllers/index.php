<?php

class Controller_Index extends Controller {


	// Default Controller
	public function index() {

		// Page Data
		$data['title'] = 'Authorization';
		$data['regions'] = $this->model->get_regions();

		// Load Page Template
		$this->view->generate('auth', $data);

	}


	// Get Cities
	public function getCities() {
		
		if ($_SERVER['REQUEST_METHOD'] != 'POST') Route::redirect();

		$ter_id = $_POST['region'];

		// Get cities
		$data = $this->model->get_cities($ter_id);

		// If no data is found, return the selected field
		if (!$data) {
			$data = $this->model->get_ter($ter_id);
		}

		echo json_encode($data);
	}


	// Get Districts
	public function getDistricts() {

		if ($_SERVER['REQUEST_METHOD'] != 'POST') Route::redirect();

		$ter_id = $_POST['city'];

		// Get districts
		$data = $this->model->get_districts($ter_id);

		// If no data is found, return the selected field
		if (!$data) {
			$data = $this->model->get_ter($ter_id);
		}

		echo json_encode($data);
	}


	// User registration/authorization
	public function registration() {
		
		if ($_SERVER['REQUEST_METHOD'] != 'POST') Route::redirect();

		$email = $_POST['email'];

		// Get user
		$data = $this->model->get_user($email);

		// If the user is not found, create a new user
		if (!$data) {

			$ter_id = $_POST['district'];
			
			// Get select field
			$data = $this->model->get_ter($ter_id);

			// Add a new user to the database
			$this->model->set_user($_POST['username'], $_POST['email'], $data[0]['ter_address']);
			
			// Get user
			$data = $this->model->get_user($_POST['email']);
		}

		// Load Page Template
		$this->view->generate('parts/user', $data);

	}

}