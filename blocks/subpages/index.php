<?php

namespace Ejo\Custom_Block\Subpages;


add_action( 'init', __NAMESPACE__ . '\register_dynamic_block' );

/**
 * Register the dynamic block.
 *
 * @since 2.1.0
 *
 * @return void
 */
function register_dynamic_block() {

	// Only load if Gutenberg is available.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Hook server side rendering into render callback
	register_block_type( 'ejo/subpages', [
		// 'attributes'      => array(
		// 	'className'       => array(
		// 		'type' => 'string',
		// 	),
		// ),
		'render_callback' => __NAMESPACE__ . '\render_dynamic_block',
	] );

}

/**
 * Server rendering for /blocks/examples/12-dynamic
 */
function render_dynamic_block( $attributes, $class_name ) {

	$subpages = get_posts( [
		'post_type' => 'page',
		'posts_per_page' => -1,
		'post_parent' => get_the_ID(),
		'orderby' => 'menu_order',
		'order' => 'asc'
	] );

	$block = '<div class="wp-block-ejo-subpages">%s</div>';

	if ( empty( $subpages ) ) {
		return sprintf( $block, '<p>No Subpages</p>' );
	}

	$list = '<ul>%s</ul>';
	$list_items = '';

	foreach ( $subpages as $subpage ) {

		$list_items .= sprintf(
			'<li><a href="%1$s">%2$s</a></li>',
			esc_url( get_permalink( $subpage->ID ) ),
			esc_html( get_the_title( $subpage->ID ) )
		);		
	}

	$list = sprintf($list, $list_items);
	$block = sprintf( $block, $list );

	return $block;
}
