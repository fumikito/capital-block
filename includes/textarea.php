<?php
/**
 * Register input block.
 *
 * @package capitalblock
 */

defined( 'ABSPATH' ) || die();

// Register block.
add_action( 'init', function() {
	// Register JS
	wp_register_script( 'capital-block-textarea', CAPITAL_BLOCK_ASSET_URL . 'assets/js/textarea.js', [ 'wp-element', 'wp-blocks' ], CAPITAL_BLOCK_VERSION, true );
	// Register block.
	register_block_type( 'capital-block/textarea', [
		'editor_script' => 'capital-block-textarea',
	] );
} );
