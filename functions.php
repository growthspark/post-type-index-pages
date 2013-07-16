<?php

function get_post_type_index($post_type) {
	if (!get_option('ptip-'.$post_type.'_settings')) return false;
	$option = get_option('ptip-'.$post_type.'_settings');
	if (empty($option['ptip-'.$post_type.'_index_page'])) return false;
	$index_id = (int) $option['ptip-'.$post_type.'_index_page'];
	if (!get_post($index_id)) return false;
	return get_post($index_id);
}

function get_post_type_index_id( $post_type = false ) {
	$page = get_post_type_index($post_type);
	if (!$page || empty($page->ID)) return false;
	return $page->ID;
}

add_filter('nav_menu_css_class' , 'add_nav_classes' , 10 , 2);
function add_nav_classes($classes, $item) {
	global $post;

	$post_id = get_the_ID();
	$post_type = $post->post_type;
	$item_id = $item->object_id;
	$index = get_post_type_index($post_type);
	if ($index && $index->ID == $item_id ) {
		$classes[] = 'current-post-type-index';
	}
    return $classes;
}
