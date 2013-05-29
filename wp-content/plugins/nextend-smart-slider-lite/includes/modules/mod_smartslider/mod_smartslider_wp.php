<?php
// $slider_id
// $wpdb->base_prefix
global $wpdb;

$wpdb->offlajn_slide = $wpdb->base_prefix.'offlajn_slide';
$wpdb->offlajn_slider = $wpdb->base_prefix.'offlajn_slider';

require_once(JPATH_SITE.DS.'modules'.DS.'mod_smartslider'.DS.'helpers'.DS.'functions.php');

$lang =& JFactory::getLanguage();
$extension = 'mod_smartslider';
$lang->load($extension);

$query = 'SELECT *'
  . ' FROM '.$wpdb->offlajn_slider
  . ' WHERE published = 1 AND id = '.((int)$slider_id);
$slider = $wpdb->get_row($query, OBJECT);

jimport( 'joomla.html.parameter' );

if(!function_exists('parseParams')){
  function parseParams(&$p, $vals){
    if(version_compare(JVERSION,'1.6.0','>=')) {
      $p->loadJSON($vals);
    }else{
      $p->loadIni($vals);
    }
  }
}

$typeParams = new JParameter('');
parseParams($typeParams, $slider->params);
$slider->params = &$typeParams;

if(!function_exists('getSmartSlider')) {
  function getSmartSlider($s) {
    ob_start();
    $db =& JFactory::getDBO();
    
    $params = new JParameter();
    $params->set('plugin', 0);
    
    $tthis = new stdClass();
    $tthis->slider = &$s;
    
    $module = new stdClass();
    $module->module = 'mod_smartslider';
    $module->id = $s->id+$s->instance*10000;
    
    $type = dirname(__FILE__) . DS . 'types' . DS . $s->type . DS;
    if(!is_dir($type)){
      echo JText::_('Please select the type for the slider!');
      return;
    }
    
    $theme = $type . $s->theme . DS;
    if(!is_dir($theme)){
      echo JText::_('Please select the theme for the slider!');
      return;
    }
    
    $jnow =& JFactory::getDate();
    $now = $jnow->toMySQL();
    $nullDate	= $db->getNullDate();
    
    $query = 'SELECT id, title, content, caption, groupprev, icon'
    . ' FROM #__offlajn_slide'
    . ' WHERE published = 1 AND slider = '.((int)$s->id)
    . ' AND ( publish_up = '.$db->Quote($nullDate).' OR publish_up <= '.$db->Quote($now).' )'
    . ' AND ( publish_down = '.$db->Quote($nullDate).' OR publish_down >= '.$db->Quote($now).' )';
    if($s->params->get('random', 0) == 0 ){
      $query.= ' ORDER BY ordering';
    }else{
      $query.= ' ORDER BY RAND()';
    }
    $db->setQuery($query);
    $slides = $db->loadObjectList();
    
    $count = count($slides);
    $pslides = array();
    
    if(($count != 0)){
      for($i = 0, $j = 0; $i < $count; ++$i, ++$j){
        $slides[$i]->title = str_replace('$', '&#36;', $slides[$i]->title);
        $slides[$i]->content = str_replace('$', '&#36;', $slides[$i]->content);
        $slides[$i]->caption = str_replace('$', '&#36;', $slides[$i]->caption);
        $p = new JParameter('');
        $slides[$i]->childs = array();
        if($slides[$i]->groupprev == 1 && isset($pslides[$j-1])){
          --$j;
        }else{
          $pslides[$j] = &$slides[$i];
        }
        $pslides[$j]->childs[] = &$slides[$i];
      }
    }else{
      echo JText::_('Please add some slide to the slider!');
      return;
    }
    $tthis->slides = &$pslides;
    
    $id = $module->module.'_'.$module->id;
    
    DojoLoader::r('dojo.fx.easing');
    DojoLoader::r('dojo.uacss');
    DojoLoader::addScriptFile(DS . 'modules' . DS . 'mod_smartslider' . DS . 'js' . DS . 'responsive.js');
    DojoLoader::addScriptFile(DS.'modules'.DS.'mod_smartslider'.DS.'ie6'.DS.'ie6.js');
    DojoLoader::addScriptFile(DS.'modules'.DS.'mod_smartslider'.DS.'captions'.DS.'captions.js');
    DojoLoader::addScriptFile(DS.'modules'.DS.'mod_smartslider'.DS.'types'.DS.$tthis->slider->type.DS.'script.js');
    
    require_once(dirname(__FILE__).DS.'classes'.DS.'cache.class.php');
    require_once(dirname(__FILE__).DS.'classes'.DS.'helper.class.php');
    
    $themecache = new OfflajnSliderThemeCache($tthis, $module, $params, $theme.'style.css.php');
    $themecache->themeCacheUrl = smartslider_translate_url($themecache->themeCacheUrl);
    
    $context = array();
    $context['helper'] = new OfflajnSliderHelper($themecache->themeCacheDir, $themecache->themeCacheUrl);
    $context['bghelper'] = new OfflajnBgHelper($themecache->themeCacheDir, $themecache->themeCacheUrl);
    $context['fonturl'] = smartslider_translate_url('modules/'.$module->module.'/fonts/');
    $context['url'] = smartslider_translate_url('modules/'.$module->module.'/types/'.$s->type.'/'.$s->theme.'/');
    $context['clearcss'] = dirname(__FILE__). DS .'clear.css.php';
    $context['captioncss'] = dirname(__FILE__). DS .'captions'. DS .'style.css.php';
    $context['contentcss'] = dirname(__FILE__). DS .'contents'. DS .'style.css.php';
    $context['id'] = '#'.$id;
    
    include($theme.'theme.php');
    
    $ss = ob_get_contents();
    ob_clean();
    
    $js_url = '';
    $css_url = $themecache->generateCss($context);

    return array($ss, $js_url, $css_url);
  }
}

$slider->instance = $instance;

$s = getSmartSlider($slider);

echo $s[0];

wp_register_style( 'smartslider-style'.md5($s[2]), $s[2]);
wp_enqueue_style( 'smartslider-style'.md5($s[2]));
?>