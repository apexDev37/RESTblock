<?php
/**
 * Plugin Name:       Hello Rest Block
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       hello-rest-block
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_hello_rest_block_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'create_block_hello_rest_block_block_init' );

/**
 * Loads the .env file provided in the root of the hello-rest-block
 * and suppresses any warnings if a .env file is not present.
 * 
 * @package	vlucas/phpdotenv
 * @see	https://github.com/vlucas/phpdotenv
 */
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

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

class Hello_REST_Block_REST_Client {
	private $base_url;
	private $endpoint;

	public function __construct() {
		$this->base_url = $_ENV['BASE_URL'];
		$this->endpoint = $_ENV['WP_REST_ENDPOINT'];
	}

	public function send_custom_greeting() {
		$url = $this->base_url . $this->endpoint;
		$args = array(
			'timeout' => 10,
			'method' => 'GET',
			'sslverify' => false
		);	

		$params = array('greeting' => 'hello-from-wp-client');
		$final_url = add_query_arg($params, $url);
		$response = wp_remote_request($final_url, $args);

		// Handle response 
		// ...

		if (is_wp_error($response)) {
			$error_message = $response->get_error_message();
			return '<span>' . $error_message .  '</span>';
		}
		
		$response_code = wp_remote_retrieve_response_code($response);
		if ($response_code !== 200) {
			$custom_error_message = 'Oops, couldn\'t send our friend a greeting :(';
			return '<span>' . $custom_error_message .  '</span>';
		}

		$custom_greeting = wp_remote_retrieve_body($response);
		return '<span>' . $custom_greeting .  '</span>';
	}
}
