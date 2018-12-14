<?php
/**
 * Add review
 */

add_action( 'init', function() {
	register_post_type( 'reviews', [
		'label' => 'レビュー',
		'public' => true,
		'show_in_rest' => true,
		'template' => [
			[ 'core/image', [
				'align' => 'left',
			] ],
			[ 'core/heading', [
				'placeholder' => 'プラグイン名',
			] ],
			[ 'core/paragraph', [
				'placeholder' => 'ここにレビューを入れてください',
			] ],
		],
		'template_lock' => 'all',
	] );
} );
