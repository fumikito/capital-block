<?php
/**
 * Register event block.
 *
 * @package capitalblock
 */

/**
 * Register event and block assets.
 */
add_action( 'init', function() {
	// Register post type.
	register_post_type( 'event', [
		'label'        => __( 'Event', 'capitalblock' ),
		'public'       => true,
		'show_in_rest' => true,
		'supports'     => [ 'title', 'editor' ],
		'menu_icon'    => 'dashicons-calendar-alt',
	] );
	// Register command.
	if ( defined( 'WP_CLI' ) && WP_CLI ) {
		WP_CLI::add_command( 'capital-party', CapitalBlockEventCommand::class );
	}
} );
