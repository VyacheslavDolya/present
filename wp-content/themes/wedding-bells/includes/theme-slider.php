<?php
add_action('init', 'slides_register');

function slides_register() {
	if (get_option('wb_enable_slider')) { // Check if slider is enabled in the theme settings
	
	$labels = array(
		'name' => __('Slides', 'weddingbells'),
		'singular_name' => __('Slides post', 'weddingbells'),
		'add_new' => __('Add New', 'weddingbells'),
		'add_new_item' => __('Add New Slide', 'weddingbells'),
		'edit_item' => __('Edit Slide', 'weddingbells'),
		'new_item' => __('New Slide', 'weddingbells'),
		'view_item' => __('View Slide', 'weddingbells'),
		'search_items' => __('Search Slides', 'weddingbells'),
		'not_found' =>  __('Nothing found', 'weddingbells'),
		'not_found_in_trash' => __('Nothing found in Trash', 'weddingbells'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array(
			'title',
			'thumbnail'
		)
	  ); 
 
		register_post_type( 'slides' , $args );
	}
}

// Move post thumbnail from side to center
add_action('do_meta_boxes', 'slider_image_box');
function slider_image_box() {

	remove_meta_box( 'postimagediv', 'slides', 'side' );
	add_meta_box('postimagediv', __('Upload a photo to this slide', 'weddingbells'), 'post_thumbnail_meta_box', 'slides', 'normal', 'high');

}
?>