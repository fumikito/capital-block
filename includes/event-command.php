<?php
/**
 * Event command
 *
 * @package capitalblock
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	return;
}

/**
 * Command utility for Capital Block event.
 */
class CapitalBlockEventCommand extends WP_CLI_Command {
	
	/**
	 * Register events
	 *
	 * @synopsis <count> [--range=<range>]
	 * @param array $args
	 * @param array $assoc
	 */
	public function register( $args, $assoc ) {
		$count = (int) $args[0];
		$range = intval( isset( $assoc['range'] ) ? $assoc['range'] : 24 );
		if ( ! $count ) {
			WP_CLI::error( '<count> must be more than 0!' );
		}
		// Register event.
		$done = 0;
		
		for ( $i = 0; $i < $count; $i++ ) {
			$month = rand( $range / -2, $range / 2 );
			$date  = new DateTime( 'now', new DateTimeZone( 'UTC' ) );
			if ( $month > 0 ) {
				$date->add( new DateInterval( sprintf( 'P%dM', $month ) ) );
			} elseif( $month < 0 ) {
				$date->sub( new DateInterval( sprintf( 'P%dM', abs( $month ) ) ) );
			}
			$args = [
				'post_type'    => 'event',
				'post_title'   => sprintf( '#%d Capital Party @ %s', $i + 1, $date->format( 'M Y' ) ),
				'post_content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. ',
				'post_status'  => 'publish',
			];
			if ( $post_id = wp_insert_post( $args ) ) {
				add_post_meta( $post_id, '_event_date', $date->format( 'Y-m-' . rand( 1, 28 ) ) );
				$lat = (float) sprintf( '35.%d', rand( 586224, 789296 ) );
				$lng = (float) sprintf( '139.%d', rand( 579161, 867391 ) );
				add_post_meta( $post_id, '_lat', $lat );
				add_post_meta( $post_id, '_lng', $lng );
				$done++;
				echo '.';
			} else {
				echo 'x';
			}
		}
		WP_CLI::line( '' );
		WP_CLI::success( sprintf( '%d events have been registered.', $done ) );
	}
	
	/**
	 * Remove all event.
	 */
	public function erase() {
		$done = 0;
		foreach ( get_posts( [
			'post_type'      => 'event',
			'post_status'    => 'any',
			'posts_per_page' => -1,
		] ) as $post ) {
			wp_delete_post( $post->ID, true );
			echo '.';
			$done++;
		}
		WP_CLI::line( '' );
		WP_CLI::success( sprintf( '%d events have been deleted.', $done ) );
	}
}
