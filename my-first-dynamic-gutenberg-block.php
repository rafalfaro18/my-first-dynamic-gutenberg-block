<?php
/**
 * Created by PhpStorm.
 * User: rafalfaro
 * Date: 07/11/18
 * Time: 08:48
 *
 * @package WordPress
 *
 * Plugin Name: My First Dynamic Gutenberg Block
 */

/**
 * Registers block and required scripts
 */
function register_dynamic_block_action() {

	wp_register_script(
		'my-first-dynamic-gutenberg-block-script',
		plugins_url( 'myblock.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element' )
	);

	register_block_type(
		'my-first-dynamic-gutenberg-block/latest-post',
		array(
			'editor_script'   => 'my-first-dynamic-gutenberg-block-script',
			'render_callback' => 'my_plugin_render_block_latest_post',
		)
	);

}

add_action( 'init', 'register_dynamic_block_action' );

/**
 * Renders the block content
 *
 * @param array $attributes block attributes.
 * @param array $content block content.
 *
 * @return string Rendered block markup
 */
function my_plugin_render_block_latest_post() {
	$recent_posts = wp_get_recent_posts(
		array(
			'numberposts' => 1,
			'post_status' => 'publish',
		)
	);
	if ( count( $recent_posts ) === 0 ) {
		return 'No posts';
	}
	$post    = $recent_posts[0];
	$post_id = $post['ID'];
	return sprintf(
		'<a class="wp-block-my-plugin-latest-post" href="%1$s">%2$s</a>',
		esc_url( get_permalink( $post_id ) ),
		esc_html( get_the_title( $post_id ) )
	);
}

add_action( 'init', 'my_plugin_render_block_latest_post' );
