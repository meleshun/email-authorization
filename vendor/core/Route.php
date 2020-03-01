<?php

class Route {

	static function start() {
		
		// Default values
		$method = 'index';
		$action = 'index';

		$routes = explode('/', $_SERVER['REQUEST_URI']);

		// Get controller name
		if (!empty($routes[1])) $method = $routes[1];

		// Get action name
		if (!empty($routes[2])) $action = $routes[2];

		// Load the file with the model class
		$model = __DIR__ . '/../../app/models/' . $method . '.php';
		if (file_exists($model)) include $model;

		// Load the file with the controller class
		$controller = __DIR__ . '/../../app/controllers/' . $method . '.php';
		if (file_exists($controller)) { include $controller; }
		else { Route::redirect(); }
		
		// Create controller
		$controller_name = 'controller_' . $method;
		$controller = new $controller_name;

		if (method_exists($controller, $action)) {
			$controller->$action();
		} else {
			Route::redirect();
		}

	}

	// 
	static function redirect() {
		header('Location: /');
	}

}