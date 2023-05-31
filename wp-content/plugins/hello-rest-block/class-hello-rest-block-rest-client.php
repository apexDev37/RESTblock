<?php

class Hello_REST_Block_REST_Client {
	private $base_url;
	private $endpoint;

	public function __construct() {
		$this->base_url = $_ENV['BASE_URL'];
		$this->endpoint = $_ENV['WP_REST_ENDPOINT'];
	}

	public function send_custom_greeting() {
		$url = $this->build_custom_greeting_url();
		$response = wp_remote_request($url, $this->get_request_args());
		return is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200? 
			$this->handle_rest_response($response) : $this->render_custom_greeting($response);
	}

	private function build_custom_greeting_url() {
		$url = $this->base_url . $this->endpoint;
		$params = array('greeting' => 'initial-greeting-from-wp-client');
		$url = add_query_arg($params, $url);
		return $url; 
	}

	private function get_request_args() {
		// Define your request args here
		return [
			'timeout' => 10,
			'method' => 'GET',
			'sslverify' => false
		];
	}

	private function handle_rest_response($response) {
		$custom_error_message = 'Oops, couldn\'t send our friend a greeting :(';
		$error_message = is_wp_error($response)? 
			$response->get_error_message() : $custom_error_message;
		return '<span>' . $error_message .  '</span>';
	}

	private function render_custom_greeting($response) {
		$custom_greeting = wp_remote_retrieve_body($response);
		return '<span>' . $custom_greeting .  '</span>';
	}
}
