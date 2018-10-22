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
	wp_register_script( 'capital-block-input', CAPITAL_BLOCK_ASSET_URL . 'assets/js/inputs.js', [ 'wp-element', 'wp-blocks' ], CAPITAL_BLOCK_VERSION, true );
	// Register block.
	if ( defined( 'GUTENBERG_VERSION' ) ) {
		// Alert Block.
		register_block_type( 'capital-block/input', [
			'editor_script' => 'capital-block-input',
		] );
	}
} );
