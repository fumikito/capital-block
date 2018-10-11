<?php
/**
 * Plugin Name: Capital Block
 * Plugin URI: https://github.com/fumikito/capital-block
 * Description: Add original block for Gutenberg.
 * Version: 1.0.0
 * Author: Capital P
 * Author URI: https://capitalp.jp
 *
 * @package capital-block
 */

// Do not load directly.
defined( 'ABSPATH' ) || die();

// Register block.
add_action( 'init', function() {
	$info     = get_file_data( __FILE__, [ 'version' => 'Version' ] );
	$version  = $info['version'];
	$base_url = plugin_dir_url( __FILE__ );
	// Register CSS
	wp_register_style( 'capital-block-alert', $base_url . 'assets/css/alert.css', [], $version );
	// Register JS
	wp_register_script( 'capital-block-alert', $base_url . 'assets/js/alert.js', [ 'wp-element', 'wp-blocks' ], $version, true );
	// Register block.
	if ( defined( 'GUTENBERG_VERSION' ) ) {
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
