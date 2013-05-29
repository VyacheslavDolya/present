<?php
/*
Plugin Name: Nextend Smart Slider Lite
Plugin URI: http://www.nextendweb.com/smart-slider
Description: The perfect all-in-one slider solution for WordPress. 
Author: Roland Soos
Author URI: http://www.nextendweb.com
Version: 1.0.12
License: GPL2
*/

/*------------------------------------------------------------------------
# smartslider - Smart Slider
# ------------------------------------------------------------------------
# author    Roland Soos 
# copyright Copyright (C) 2011 Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.nextendweb.com
-------------------------------------------------------------------------*/
define("SS_LITE", 1);

if ( !isset( $wpdb ) && empty( $wpdb ) ) {
    global $wpdb;
}

global $smartslider;

$wpdb->offlajn_slide = $wpdb->base_prefix.'offlajn_slide';
$wpdb->offlajn_slider = $wpdb->base_prefix.'offlajn_slider';


// Disable Update
add_filter('site_transient_update_plugins', 'dd_remove_update_nag');
function dd_remove_update_nag($value) {
  if($value->response)
    unset($value->response[ plugin_basename(__FILE__) ]);
  return $value;
}


include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'functions.php');
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'tinymce_functions.php');
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'installation.php');
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'widget.php');

if ( function_exists( 'register_activation_hook' ) ) {
    register_activation_hook( __FILE__, 'smartslider_install' );
}

if( function_exists( 'register_deactivation_hook' ) ) {
    register_deactivation_hook( __FILE__, 'smartslider_deactivate' );
}

function ss_admin_menu(){
  add_menu_page( 'smartslider', 'Smart Slider', 'publish_posts', basename( __FILE__ ), 'smartslider_render', smartslider_url( '/images/icon.png' ) );
  add_submenu_page( basename( __FILE__ ), 'Dashboard', 'Dashboard', 'publish_posts', basename( __FILE__ ), 'smartslider_render' );
  add_submenu_page( basename( __FILE__ ), 'List Sliders', 'List Sliders', 'publish_posts', basename( __FILE__ ). '/slider', 'smartslider_render' );
  add_submenu_page( basename( __FILE__ ), 'List Slides', 'List Slides', 'publish_posts', basename( __FILE__ ). '/slide', 'smartslider_render' );
}

function smartslider_dashboard(){
  $_REQUEST['controller'] = '';
  smartslider_init_joomla();
}

function smartslider_listsliders(){
  $_REQUEST['controller'] = 'slider';
  smartslider_init_joomla();
}

function smartslider_listslides(){
  $_REQUEST['controller'] = 'slide';
  smartslider_init_joomla();
}

function smartslider_init_joomla(){

  wp_register_style( 'smartslider-style', smartslider_url('css/style.css'));
  wp_enqueue_style( 'smartslider-style');

  require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'init.php');
  $document	= JFactory::getDocument();
  foreach($document->_styleSheets AS $k => $s){
    wp_register_style( 'smartslider-style'.md5($k), smartslider_translate_url($k));
    wp_enqueue_style( 'smartslider-style'.md5($k));
  }
  foreach($document->_scripts AS $k => $s){
    wp_register_script( 'smartslider-script'.md5($k), smartslider_translate_url($k));
    wp_enqueue_script( 'smartslider-script'.md5($k));
  }
  function smartslider_inline_js_css() {
  ?>
  <style>
  <?php 
    $document	= JFactory::getDocument();
    echo $document->_style['text/css'];
  ?>
  </style>
  <script type="text/javascript">
  <?php 
    $document	= JFactory::getDocument();
    echo smartslider_translate_json_url($document->_script['text/javascript']);
  ?>
  </script>
  <?php
  }
  add_action( 'admin_print_footer_scripts', 'smartslider_inline_js_css' );
}

function smartslider_render(){
  $out = (string)JFactory::getApplication('wpadministrator');
  echo smartslider_fix_images($out);
}

function smartslider_joomla_dipatcher(){

if(isset($_GET['module']) &&  isset($_GET['w'])){
  require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'init.php');
  exit;
}

  if($_REQUEST['page'] == '' && $_REQUEST['option'] == 'com_smartslider'){
    !isset($_REQUEST['controller']) ? $_REQUEST['controller']='' : '';
    if($_SERVER['REQUEST_METHOD'] != 'POST'){
      header('HTTP/1.1 307 Temporary Redirect');
      header('Location: admin.php?page=smartslider.php/'.$_REQUEST['controller'].'&'.http_build_query($_GET));
      exit;
    }else{
      if($_REQUEST['task'] != 'add'){
        smartslider_init_joomla();
        ob_start();
        smartslider_render();
        ob_end_clean();
      }
      header('Location: admin.php?page=smartslider.php/'.$_REQUEST['controller'].'&'.http_build_query($_POST));
      exit;
    }
  }
}


function generate_slider($slider_id, &$instances) {
    global $smartslider;
    if(!isset($instances[$slider_id])) $instances[$slider_id] = 1;
    else $instances[$slider_id]++;
    $instance = $instances[$slider_id];
    require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'softinit.php');
    ob_start();
    include(dirname(__FILE__).DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'mod_smartslider'.DIRECTORY_SEPARATOR.'mod_smartslider_wp.php');
    $smartslider[$slider_id][] = ob_get_contents();
    ob_clean();
}

/*
Searches for Smart Sliders in the posts and creates the required styles and scripts.
*/
function smartslider_wp_hook() {
  global $posts, $smartslider;
    $instances = array();
    
    /*
      Hozzáadjuk a postokhoz a widgetekben talált slidereket is.
    */
    $sswidget = get_option('widget_smartsliderwidget');
    if (count($sswidget)>1) {
      foreach($sswidget as $widget) {
        if (isset($widget['slider'])) {
          generate_slider($widget['slider'], $instances);
        }
      }    
    } 
    
  $_posts = $posts;
  if( isset( $_posts ) && !empty( $_posts ) ) {
    foreach( (array) $_posts as $post ) {
        $matches = array();
        preg_match_all( '/\[SmartSlider ([0-9]*)\]/', $post->post_content, $matches );

        if( !empty( $matches[1] ) ) {
            foreach( $matches[1] as $slider_id ) {
              generate_slider($slider_id, $instances);
            }
        }
    }
  }
  if(count($instances) > 0 ){
    plgSystemDojoloader::customBuild();
    $document	= &JFactory::getDocument();

    foreach($document->_scripts AS $k => $s){
      wp_register_script( 'smartslider-script'.md5($k), smartslider_translate_url($k));
      wp_enqueue_script( 'smartslider-script'.md5($k));
    }
  }
}

/*
Translates [SmartSlider] short codes into sliders.
*/
function smartslider_shortcode($code){
  global $smartslider;
  if(isset($code[0])){
    $id = $code[0];
    return array_shift($smartslider[$id]);
  }
  return '';
}

if( !is_admin() ) {
    add_action( 'wp', 'smartslider_wp_hook' );
}



add_shortcode( 'SmartSlider', 'smartslider_shortcode' );

add_action('admin_menu', 'ss_admin_menu');

add_action('load-toplevel_page_smartslider', 'smartslider_dashboard');
add_action('load-smart-slider_page_smartslider/slider', 'smartslider_listsliders');
add_action('load-smart-slider_page_smartslider/slide', 'smartslider_listslides');

add_action('plugins_loaded', 'smartslider_joomla_dipatcher');

?>