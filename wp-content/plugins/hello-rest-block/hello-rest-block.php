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
	private $auth_code_endpoint;

	public function __construct() {
		$this->client_id = $_ENV['CLIENT_ID'];
    $this->client_secret = $_ENV['CLIENT_SECRET'];
    $this->grant_type = $_ENV['GRANT_TYPE'];
    $this->redirect_uri = $_ENV['REDIRECT_URI'];

		$this->auth_code_endpoint = $_ENV['AUTHORIZATION_CODE_ENDPOINT'];
	}

	public function get_access_token() {
		// GET authorization code to request access token
		$auth_code_url = add_query_arg(
			array (
				'response_type' => $this->grant_type,
				'client_id' => $this->client_id,
				'redirect_uri' => $this->redirect_uri,
			),
			$this->auth_code_endpoint
		);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $auth_code_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_PROXY, $_ENV['AUTHORIZATION_CODE_ENDPOINT']);
		
		$response = curl_exec($ch);
    if (curl_errno($ch)) {
			$error_message = curl_error($ch);
			curl_close($ch);
			return '<span>' . $error_message . '</span>';
		}

		curl_close($ch);

		$redirect_uri = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
		return '<span>' . 'Redirect uri: ' . $redirect_uri . '</span>';
	}	
}
