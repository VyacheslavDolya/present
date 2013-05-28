<?php
// Custom menus
if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
		  'primary-menu' => 'Primary Menu',
		  'footer-menu' => 'Footer Menu'
		)
	);
}

// Enable language files
load_theme_textdomain( 'weddingbells', TEMPLATEPATH . '/languages' );

$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if ( is_readable($locale_file) )
	require_once($locale_file);

// Custom backgrounds functionality
add_custom_background();

// Enable post thumbnails for slider and photoblog
add_theme_support( 'post-thumbnails', array( 'slides', 'photoblog' ) );

// Add feed links
add_theme_support('automatic-feed-links');

// Load jquery hosted by Google, dropdown menu script and flexslider
function my_init_method() {
	if( !is_admin()) {
		wp_deregister_script('jquery');
		wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
		wp_enqueue_script('jquery');
		
		wp_enqueue_script('dropdownmenu', get_template_directory_uri() . '/js/dropdownmenu.js');
		if (get_option('wb_enable_slider')) { // Check if slider is enabled in the theme settings
			wp_enqueue_script('flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js');
			wp_enqueue_script('slider', get_template_directory_uri() . '/js/slider.js');
		}
	}
}
add_action('init', 'my_init_method');
?>