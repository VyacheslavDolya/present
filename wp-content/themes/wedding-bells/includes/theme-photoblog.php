<?php
add_action('init', 'photoblog_register');
 
function photoblog_register() {
 
	$labels = array(
		'name' => __('Photoblogs', 'weddingbells'),
		'singular_name' => __('Photoblog post', 'weddingbells'),
		'add_new' => __('Add New', 'weddingbells'),
		'add_new_item' => __('Add New Photoblog post', 'weddingbells'),
		'edit_item' => __('Edit Photoblog post', 'weddingbells'),
		'new_item' => __('New Photoblog post', 'weddingbells'),
		'view_item' => __('View Photoblog post', 'weddingbells'),
		'search_items' => __('Search Photoblog', 'weddingbells'),
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
			'thumbnail',
			'comments',
			'revisions'
		)
	  ); 
 
	register_post_type( 'photoblog' , $args );
}

// Register photoblog categories taxonomy
add_action( 'init', 'photoblogcats_taxonomy', 0 );

function photoblogcats_taxonomy() {
	$labels = array(
		'name' => __( 'Photoblog Categories', 'weddingbells' ),
		'singular_name' => __( 'Photoblog Category', 'weddingbells' ),
		'search_items' =>  __( 'Search Photoblog Categories', 'weddingbells' ),
		'all_items' => __( 'All Photoblog Categories', 'weddingbells' ),
		'parent_item' => __( 'Parent Photoblog Category', 'weddingbells' ),
		'parent_item_colon' => __( 'Parent Photoblog Category:', 'weddingbells' ),
		'edit_item' => __( 'Edit Photoblog Category', 'weddingbells' ), 
		'update_item' => __( 'Update Photoblog Category', 'weddingbells' ),
		'add_new_item' => __( 'Add New Photoblog Category', 'weddingbells' ),
		'new_item_name' => __( 'New Photoblog Category Name', 'weddingbells' ),
		'menu_name' => __( 'Photoblog Categories', 'weddingbells' ),
	);

	register_taxonomy("photoblog-cats", array("photoblog"), 
			array(
				"hierarchical" => true, 
				"labels" => $labels, 
				"rewrite" => true)
	);
}

// Photoblog default image size
add_image_size( 'photoblog-big-size', 880, 9999 );

// Photoblog widget thumbnail
add_image_size( 'photoblog-small-size', 125, 125, true);

// Move post thumbnail from side to center
add_action('do_meta_boxes', 'customposttype_image_box');
function customposttype_image_box() {

	remove_meta_box( 'postimagediv', 'photoblog', 'side' );
	add_meta_box('postimagediv', __('Upload a photo to this post', 'weddingbells'), 'post_thumbnail_meta_box', 'photoblog', 'normal', 'high');

}
?>