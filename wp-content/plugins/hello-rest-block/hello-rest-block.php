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

class Hello_REST_Block_OAuth2_Manager {
	// OAuth properties
	private $client_id;
	private $client_secret;
	private $grant_type;
	private $redirect_uri;

	// OAuth endpoints
	private $auth_code_endpoint;

	public function __construct() {
		$this->client_id = 'client-id';
    $this->client_secret = 'client-secret';
    $this->grant_type = 'grant-type';
    $this->redirect_uri = 'redirect-uri';
	}

	public function get_access_token() {
		// GET authorization code to request access token
		$auth_code_url = add_query_arg(
			array (
				'response_type' => 'code',
				'client_id' => $this->client_id,
				'redirect_uri' => $this->redirect_uri,
			),
			$this->auth_code_endpoint
		);
		
		$response = wp_remote_get(
			$auth_code_url,
			array (
				'headers' => array (
					'Content-Type' => 'application/json',	
				),
			)
		);

		if (is_wp_error($response)) {
			$error_message = $response->get_error_message();
			return '<span>' . $error_message . '</span>';
		}

		// Retrieve the redirect URL from the response headers
		$redirect_uri = wp_remote_retrieve_header($response, 'location');
		if (strpos($redirect_uri, 'code=') !== false) {
			$query_params = wp_parse_url($redirect_uri, PHP_URL_QUERY);
			parse_str($query_params, $query_vars);
			$auth_code = $query_vars['code'];
			return '<span>' . $auth_code . '</span>';
		} else {
			return '<h2>Authorization code not found in the redirect URL.</h2>';
		}
	}	
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();