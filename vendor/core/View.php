<?php

class View {
	public function generate($template, array $data = null) {
		include __DIR__ . '/../../app/views/' . $template . '.php';
	}
}