<?php

function smartslider_url( $str="" ) {
    $path = WP_PLUGIN_URL . "/" . basename( dirname( __FILE__ ) );
    
    if ( isset( $str ) && !empty( $str ) ) {
        $sep = "/" == substr( $str, 0, 1 ) ? "" : "/";
        return $path . $sep . $str;
    } else {
        return $path;
    }
}

function smartslider_translate_url($url){
  if(substr($url, 0, 4) == 'http'){
    if(strstr($url,JUri::root()) === false) return $url;
    $url = str_replace(JUri::root(), '', $url);
    $url = smartslider_url('includes/'.$url);
  }else{
    $u = str_replace('//','/',str_replace(JUri::root(true).'/','/',$url));
    
    $url = smartslider_url('includes/'.$u);
  }
  return $url;
}

function smartslider_translate_json_url($text){
  $url = str_replace('/','\\/',JUri::root());
  $newurl = str_replace('/','\\/',smartslider_url('includes/'));
  $text = str_replace($url, $newurl, $text);
  return $text;
}

function smartslider_translate_js_url($text){
  $url = JUri::root();
  $newurl = smartslider_url('includes/');
  $text = str_replace($url.'../', $newurl, $text);
  $text = str_replace($url, $newurl, $text);
  return $text;
}

function smartslider_fix_images($html){
  require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'simple_html_dom.php');
  $dom = str_get_html($html);
  foreach($dom->find('img') as $e){
    if(strstr($e->src, 'wp-content') === false ){
      $e->src = smartslider_translate_url($e->src);
    }
  }
  return $dom;
}

function smartslider_is_plugin() {
    return (boolean) ( ( "admin.php" == basename( $_SERVER['PHP_SELF'] ) ) && ( strpos( $_GET['page'], basename( __FILE__ ) ) !== false ) );
}

function smartslider_dir( $str="" ) {
    $path =  WP_PLUGIN_DIR . "/" . basename( dirname( __FILE__ ) );
    
    if ( isset( $str ) && !empty( $str ) ) {
        $sep = "/" == substr( $str, 0, 1 ) ? "" : "/";
        return $path . $sep . $str;
    } else {
        return $path;
    }
}


?>