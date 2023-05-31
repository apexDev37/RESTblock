<?php

class Hello_REST_Block_OAuth2_Manager {
	// OAuth properties
	private $client_id;
	private $client_secret;
	private $grant_type;
	private $redirect_uri;

	// OAuth endpoints
	private $base_url;
	private $auth_code_endpoint;

	public function __construct() {
		$this->client_id = $_ENV['CLIENT_ID'];
    $this->client_secret = $_ENV['CLIENT_SECRET'];
    $this->grant_type = $_ENV['GRANT_TYPE'];
    $this->redirect_uri = $_ENV['REDIRECT_URI'];

		$this->base_url = $_ENV['BASE_URL'];
		$this->auth_code_endpoint = $_ENV['AUTHORIZATION_CODE_ENDPOINT'];
	}

	public function get_access_token() {
		// GET authorization code to request access token
		$auth_code_url = add_query_arg(
			array(
					'response_type' => $this->grant_type,
					'client_id' => $this->client_id,
					'redirect_uri' => $this->redirect_uri,
			),
			$this->base_url . $this->auth_code_endpoint
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $auth_code_url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		// curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
    // curl_setopt($ch, CURLOPT_PROXY, $this->auth_code_endpoint); 
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36'); // Set the user agent from the HTTP request headers

		$response = curl_exec($ch);
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$headers = curl_getinfo($ch);

		return '<pre>' . print_r($headers, true) .  '</pre>';
	}
}
