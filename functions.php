<?php

/**
 * Returns the post object of the index page
 * for a given post type.
 *
 * @param string $post_type
 * @return object|bool Post object if index exists, false otherwise
 * @since 1.0
 */
function get_post_type_index($post_type) {
	if (!get_option('ptip-'.$post_type.'_settings')) return false;
	$option = get_option('ptip-'.$post_type.'_settings');
	if (empty($option['ptip-'.$post_type.'_index_page'])) return false;
	$index_id = (int) $option['ptip-'.$post_type.'_index_page'];
	if (!get_post($index_id)) return false;
	return get_post($index_id);
}

/**
 * Returns the ID of the index page for a given post type.
 *
 * @param string $post_type
 * @return int|bool Post ID if index exists, false otherwise
 * @since 1.0
 */
function get_post_type_index_id( $post_type = false ) {
	$page = get_post_type_index($post_type);
	if (!$page || empty($page->ID)) return false;
	return $page->ID;
}

/**
 * Filters the native WP_Menu classesss
 *
 * This function adds an addition class, 'current-post-type-index'
 * to any menu item corresponding to the index page for a post type,
 * when the 'single' template is currently being viewed for that post type.
 *
 * @param array $classes
 * @param object $item
 * @return array
 * @since 1.0
 */
function ptip_add_nav_classes($classes, $item) {
	global $post;
	if (!$post) return $classes;
	$post_id = get_the_ID();
	$post_type = $post->post_type;
	$item_id = $item->object_id;
	$index = get_post_type_index($post_type);
	if ($index && $index->ID == $item_id ) {
		$classes[] = 'current-post-type-index';
	}
    return $classes;
}
add_filter('nav_menu_css_class' , 'ptip_add_nav_classes' , 10 , 2);