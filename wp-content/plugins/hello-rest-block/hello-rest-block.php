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

// Include required class dependencies
require_once __DIR__ . '/class-hello-rest-block-oauth2-manager.php';
require_once __DIR__ . '/class-hello-rest-block-rest-client.php';

/**
 * Activation hook to execute the REST API request on installation.
 * 
 */
function hello_rest_block_activate() {
	$rest_client = new Hello_REST_Block_REST_Client();
	$rest_client->send_custom_greeting();
}

register_activation_hook(__FILE__, 'hello_rest_block_activate'); 
