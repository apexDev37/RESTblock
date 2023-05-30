<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
?>
<p <?php echo get_block_wrapper_attributes(); ?>>
	<?php
		// $oauth_manager = new Hello_REST_Block_OAuth2_Manager();
		$rest_client = new Hello_REST_Block_REST_Client();
		echo $rest_client->send_custom_greeting();
	?>
</p>
