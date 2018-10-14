<?php
/**
 * Register alert block.
 *
 * @package capitalblock
 */

defined( 'ABSPATH' ) || die();

// Register block.
add_action( 'init', function() {
	// Register CSS
	wp_register_style( 'capital-block-alert', CAPITAL_BLOCK_ASSET_URL . 'assets/css/alert.css', [], CAPITAL_BLOCK_VERSION );
	// Register JS
	wp_register_script( 'capital-block-alert', CAPITAL_BLOCK_ASSET_URL . 'assets/js/alert.js', [ 'wp-element', 'wp-blocks' ], CAPITAL_BLOCK_VERSION, true );
	// Register block.
	if ( defined( 'GUTENBERG_VERSION' ) ) {
		// Alert Block.
		register_block_type( 'capital-block/alert', [
			'editor_style'  => 'capital-block-alert',
			'editor_script' => 'capital-block-alert',
		] );
	}
} );

// Enqueue css for theme.
add_action( 'wp_enqueue_scripts', function() {
	wp_enqueue_style( 'capital-block-alert' );
} );

