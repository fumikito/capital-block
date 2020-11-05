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
	// Register CSS & JS.
	wp_register_style( 'capital-block-event', CAPITAL_BLOCK_ASSET_URL . 'assets/css/event.css', [], CAPITAL_BLOCK_VERSION );
	wp_register_script( 'capital-block-event', CAPITAL_BLOCK_ASSET_URL . 'assets/js/event.js', [ 'wp-element', 'wp-blocks' ], CAPITAL_BLOCK_VERSION, true );
	// Register block.
	register_block_type( 'capital-block/event', [
		'editor_style'    => 'capital-block-event',
		'editor_script'   => 'capital-block-event',
		'attributes'      => [
			'year'  => [
				'type' => 'integer',
			],
			'month' => [
				'type' => 'integer',
			],
		],
		'render_callback' => function( $attributes, $content = '' ) {
			$attributes = wp_parse_args( $attributes, [
				'year'  => 0,
				'month' => 0,
			] );
			return capital_block_render_event( $attributes['year'], $attributes['month'] );
		},
	] );
} );

/**
 * Render event loop.
 *
 * @param int $year
 * @param int $month
 * @return string
 */
function capital_block_render_event( $year, $month ) {
	$date  = sprintf( '%04d年%02d月', $year, $month );
	$query = new WP_Query( [
		'post_type'      => 'event',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby' => [ 'date' => 'DESC' ],
		'meta_query' => [
			[
				'key'     => '_event_date',
				'value'   => sprintf( '%04d-%02d', $year, $month ),
				'compare' => 'LIKE'
			],
		],
	] );
	if ( ! $query->have_posts() ) {
		return <<<HTML
		<div class="event-not-found alert alert-danger">
			{$date}にイベントはありません。
		</div>
HTML;
	}
	ob_start();
	printf( '<h2>%sのイベント</h2>', $date );
	while ( $query->have_posts() ) {
		$query->the_post();
		$lat = get_post_meta( get_the_ID(), '_lat', true );
		$lng = get_post_meta( get_the_ID(), '_lng', true );
		$src = add_query_arg( [
			'key'    => GOOGLE_MAP_EMBED_KEY,
			'center' => $lat . ',' . $lng,
			'zoom'   => 16,
		], 'https://www.google.com/maps/embed/v1/view' );
		?>
		<div class="event">
			<div class="event-content event-col">
				<span class="event-title"><?php the_title(); ?></span>
				<p class="event-meta">
					<strogn>@</strogn> <?php echo mysql2date( get_option( 'date_format' ), get_post_meta( get_the_ID(), '_event_date', true ) ) ?>
				</p>
				<div class="event-description">
					<?php the_content(); ?>
				</div>
				<a class="event-link" href="<?php the_permalink() ?>">
					参加する
				</a>
			</div>
			<div class="event-map event-col">
				<iframe class="event-map-iframe" src="<?php echo esc_url( $src ) ?>" frameborder="0"></iframe>
			</div>
		</div>
		<?php
	}
	wp_reset_postdata();
	$html = ob_get_contents();
	ob_end_clean();
	return $html;
}

// Register assets.
add_action( 'wp_enqueue_scripts', function() {
	wp_enqueue_style( 'capital-block-event' );
} );
