<?php 
/*------------------------------------------------------------------------
# smartslider - Smart Slider
# ------------------------------------------------------------------------
# author    Roland Soos 
# copyright Copyright (C) 2011 Offlajn.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.offlajn.com
-------------------------------------------------------------------------*/
?>
<?php
defined('_JEXEC') or die('Restricted access');

require_once(dirname(__FILE__).DS.'classes'.DS.'cache.class.php');
require_once(dirname(__FILE__).DS.'classes'.DS.'helper.class.php');

$tthis = new stdClass();
if(isset($this)){
  $tthis = &$this;
}

$db =& JFactory::getDBO();

$tthis->slider = $row;
$tthis->slider->params = $row->sliderparams;

if($tthis->slider == NULL){
  echo JText::_('Please select a slider on the backend!');
  return;
}

$type = dirname(__FILE__) . DS . 'types' . DS . $tthis->slider->type . DS;
if(!is_dir($type)){
  echo JText::_('Please select the type for the slider!');
  return;
}

$theme = dirname(__FILE__) . DS . 'types' . DS . $tthis->slider->type . DS . $tthis->slider->theme . DS;
if(!is_dir($theme)){
  echo JText::_('Please select the theme for the slider!');
  return;
}

if(version_compare(JVERSION,'3.0.0','ge')){
  $get_date=JFactory::getDate();
  $now = $get_date->toSql();
}else{
  $jnow =& JFactory::getDate();
  $now = $jnow->toMySQL();
}
$nullDate	= $db->getNullDate();

$query = 'SELECT *'
. ' FROM #__offlajn_slide'
. ' WHERE published = 1 AND slider = '.((int)$row->slider)
. ' AND ( publish_up = '.$db->Quote($nullDate).' OR publish_up <= '.$db->Quote($now).' )'
. ' AND ( publish_down = '.$db->Quote($nullDate).' OR publish_down >= '.$db->Quote($now).' )'
. ' ORDER BY ordering';
$db->setQuery($query);
$slides = $db->loadObjectList();

$tthis->slides = array();
$count = count($slides);
if($count != 0){
  for($i = 0, $j = 0; $i < $count; ++$i, ++$j){
    $p = new OfflajnJParameter('');
    parseParams($p, $slides[$i]->params);
    $slides[$i]->params = $p;
    $slides[$i]->childs = array();
    if($slides[$i]->groupprev == 1 && isset($tthis->slides[$j-1])){
      --$j;
    }else{
      $tthis->slides[$j] = &$slides[$i];
    }
    $tthis->slides[$j]->childs[] = &$slides[$i];
  }
}

if(JRequest::getVar('task') == 'add'){
  $tthis->slides[] = new stdClass();
}


$module = new stdClass();
$module->module = 'mod_smartslider';
$module->id = "1";

$id = $module->module.'_'.$module->id;
DojoLoader::addScriptFile(DS . 'modules' . DS . 'mod_smartslider' . DS . 'js' . DS . 'responsive.js');

$themecache = new OfflajnSliderThemeCache($tthis, $module, $params, $theme.'style.css.php');
if(defined('ABSPATH')) $themecache->themeCacheUrl = smartslider_translate_url($themecache->themeCacheUrl);
$context = array();
$context['helper'] = new OfflajnSliderHelper($themecache->themeCacheDir, $themecache->themeCacheUrl);
$context['bghelper'] = new OfflajnBgHelper($themecache->themeCacheDir, $themecache->themeCacheUrl);
$context['fonturl'] = JURI::root().'modules/'.$module->module.'/fonts/';
if(defined('ABSPATH')) $context['fonturl'] = smartslider_translate_url('modules/'.$module->module.'/fonts/');
$context['url'] = JURI::root().'modules/'.$module->module.'/types/'.$tthis->slider->type.'/'.$tthis->slider->theme.'/';
if(defined('ABSPATH')) $context['url'] = smartslider_translate_url('modules/'.$module->module.'/types/'.$tthis->slider->type.'/'.$tthis->slider->theme.'/');
$context['clearcss'] = dirname(__FILE__). DS .'clear.css.php';
$context['captioncss'] = dirname(__FILE__). DS .'captions'. DS .'style.css.php';
$context['contentcss'] = dirname(__FILE__). DS .'contents'. DS .'style.css.php';
$context['id'] = '#'.$id;
$document->addStyleSheet($themecache->generateCss($context).'?t='.time());

$count = count($tthis->slides);

$tthis->slides = array();
$tthis->slides[0] = new stdClass();
$slide = &$tthis->slides[0];
$slide->id = '1';
$slide->title = '{title}';
$slide->icon = -1;
$slide->childs = array();
$slide->childs[0] = &$slide;
$slide->content = '{content}';
$slide->caption = '{caption}';
      
for($x = 1; $x < $count; $x++){
  $tthis->slides[$x] = new stdClass();
  $slide = &$tthis->slides[$x];
  $slide->id = '2';
  $slide->title = 'PREVIEW';
  $slide->icon = -1;
  $slide->childs = array();
  $slide->childs[0] = &$slide;
  $slide->content = '';
  $slide->caption = '';
}

include($theme.'theme.php');

?>