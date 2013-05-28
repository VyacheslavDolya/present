<?php
if ( ! isset( $content_width ) ) {
	$content_width = 580;
}

$includes_path = TEMPLATEPATH . '/includes/';

require_once ($includes_path . 'theme-widgets.php'); // Widgetized sidebar and footer
require_once ($includes_path . 'theme-functions.php'); // Custom navigation & jquery
require_once ($includes_path . 'theme-header.php'); // Header image upload
require_once ($includes_path . 'custom-widgets.php'); // 125x125 Ads Widget & Social Media Badges Widget
require_once ($includes_path . 'theme-photoblog.php'); // Photoblog functionality
require_once ($includes_path . 'theme-options.php'); // Theme Options
require_once ($includes_path . 'theme-slider.php'); // Slider custom post type
?>