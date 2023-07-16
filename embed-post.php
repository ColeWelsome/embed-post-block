<?php
/**
 * Plugin Name:       Embed Post
 * Description:       Embed a post, showing its post title, category, featured images, and meta description.
 * Requires at least: 6.2
 * Requires PHP:      7.0
 * Version:           1.0.0
 * Author:            Cole Welsome
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       embed-post
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */

class embed_post {

    public function __construct()
    {
		// Create our Dynamic Block
		add_action('init', array($this, 'create_block_embed_post_block_init'));
	}

	public function create_block_embed_post_block_init() {
		register_block_type(__DIR__ . '/build');
	}

	// Find our post's values
	private function fetch_post($attributes)
	{
		$post = get_post($attributes);

		// Get the list of categories our post belongs to
		$cat_list = wp_get_object_terms($post->ID, 'category', array('fields' => 'names'));

		// Implode the array of categories into a nice string
		if (! empty($cat_list)) {
			$categories = implode(' | ' , $cat_list);
		} else {
			$categories = '';
		}

		// Grab our post data
		// TODO Maybe switch over to WP_Query() as it might be faster to do this in one go
		$details = array(
			'title' => $post->post_title,
			'categories' => $categories,
			'featured_image' => get_the_post_thumbnail_url($attributes),
			'excerpt' => get_the_excerpt($post->ID),
			'permalink' => get_post_permalink($post->ID)
		);

		return $details;
	}

	// Build an array of post values to display on render.php
	public function get_embeded_post($attributes)
	{
		if (! empty($attributes) &&  0 !== $attributes['selectedPost']) {
			$post = $this->fetch_post($attributes['selectedPost']);
		} else{
			$post = array(
				'title' => 'Lorem Ipsum',
				'categories' => 'Llabore | Dolore | Aliqua',
				'featured_image' => plugins_url( '/public/images/', __FILE__ ) . 'stock-image.png',
				'excerpt' => 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui.',
				'permalink' => ''
			);
		}

		return $post;
	}
}

$embed_post = new embed_post();


/*

function create_block_embed_post_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'create_block_embed_post_block_init' );

// Find our post's values
function fetch_post($attributes)
{
	$post = get_post($attributes);

	// Get the list of categories our post belongs to
	$cat_list = wp_get_object_terms($post->ID, 'category', array('fields' => 'names'));

	// Implode the array of categories into a nice string
	if (! empty($cat_list)) {
		$categories = implode(' | ' , $cat_list);
	} else {
		$categories = '';
	}

	// Grab our post data
	// TODO Maybe switch over to WP_Query() as it might be faster to do this in one go
	$details = array(
		'title' => $post->post_title,
		'categories' => $categories,
		'featured_image' => get_the_post_thumbnail_url($attributes),
		'excerpt' => get_the_excerpt($post->ID),
		'permalink' => get_post_permalink($post->ID)
	);

	return $details;
}

// Build an array of post values to display on render.php
function get_embeded_post($attributes)
{
	if (! empty($attributes) &&  0 !== $attributes['selectedPost']) {
		$post = fetch_post($attributes['selectedPost']);
	} else{
		$post = array(
			'title' => 'Lorem Ipsum',
			'categories' => 'Llabore | Dolore | Aliqua',
			'featured_image' => plugins_url( '/images/', __FILE__ ) . 'stock-image.png',
			'excerpt' => 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui.',
			'permalink' => ''
		);
	}

	return $post;
}

*/