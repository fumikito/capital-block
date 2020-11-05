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
	wp_register_script( 'capital-block-richtext', CAPITAL_BLOCK_ASSET_URL . 'assets/js/richtext.js', [ 'wp-element', 'wp-blocks' ], CAPITAL_BLOCK_VERSION, true );
	// Register block.
	register_block_type( 'capital-block/richtext', [
		'editor_script' => 'capital-block-richtext',
	] );
} );
