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

	public function __construct() {
		$this->client_id = 'client-id';
    $this->client_secret = 'client-secret';
    $this->grant_type = 'grant-type';
    $this->redirect_uri = 'redirect-uri';
	}

	public function get_access_token() {
		// Logic to get access token from auth server
	}
}
