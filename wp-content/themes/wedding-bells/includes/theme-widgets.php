<?php
// Sidebar widget
if(function_exists('register_sidebar'))
	register_sidebar(array(
		'name' => 'Sidebar',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
));
// Footer left column
if(function_exists('register_sidebar'))
	register_sidebar(array(
		'name' => 'Footer - Left Column',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>',
));
// Footer center column
if(function_exists('register_sidebar'))
	register_sidebar(array(
		'name' => 'Footer - Center Column',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>',
));
// Footer right column
if(function_exists('register_sidebar'))
	register_sidebar(array(
		'name' => 'Footer - Right Column',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>',
));
?>