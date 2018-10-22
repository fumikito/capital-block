<?php
/**
 * Register meta block.
 *
 * @package capitalblock
 */

/**
 * Register event and block assets.
 */
add_action( 'init', function() {
	// Register JS.
	wp_register_script( 'capital-block-meta', CAPITAL_BLOCK_ASSET_URL . 'assets/js/meta.js', [ 'wp-element', 'wp-blocks' ], CAPITAL_BLOCK_VERSION, true );
	if ( defined( 'GUTENBERG_VERSION' ) ) {
		// Register block.
		register_block_type( 'capital-block/meta', [
			'editor_script'   => 'capital-block-meta',
			'render_callback' => function( $attributes, $content = '' ) {
				// Get post meta.
				$pref = get_post_meta( get_the_ID(), 'prefecture', true );
				$src  = add_query_arg( [
					'key'  => GOOGLE_MAP_EMBED_KEY,
					'q'    => rawurlencode( $pref ),
					'zoom' => 16,
				], 'https://www.google.com/maps/embed/v1/place' );
				return <<<HTML
<iframe class="event-map-iframe" src="{$src}" frameborder="0" style="width: 100%" height="300"></iframe>
HTML;
			},
		] );
		// Register meta
		register_meta( 'post', 'prefecture', array(
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'string',
		) );
	}
} );
