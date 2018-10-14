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

// Set version number.
$capital_block_info = get_file_data( __FILE__, [ 'version' => 'Version' ] );
define( 'CAPITAL_BLOCK_VERSION', $capital_block_info['version'] );

// Set asset URL.
define( 'CAPITAL_BLOCK_ASSET_URL', plugin_dir_url( __FILE__ ) );

// Load all files in includes dir.
foreach ( scandir( __DIR__ . '/includes' ) as $file ) {
	if ( preg_match( '#^[^._].*\.php$#u', $file ) ) {
		require __DIR__ . '/includes/' . $file;
	}
}
