<?php 
/*------------------------------------------------------------------------
# smartslider - Smart Slider
# ------------------------------------------------------------------------
# author    Roland Soos
# copyright Copyright (C) 2012 Offlajn.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.nextendweb.com
-------------------------------------------------------------------------*/
?>
<?php
defined('_JEXEC') or die('Restricted access');

if(version_compare(JVERSION,'2.5.6','lt')) {
  jimport ( 'joomla.application.component.model' );
}else{
  jimport ( 'joomla.application.component.modellegacy' );
}
JLoader::import( 'categories', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_cobalt' . DS . 'models' );



class JElementCobaltsections extends JElement {
  
	var	$_name = 'cobaltsections';

	function fetchElement($name, $value, &$node, $control_name){
	
	  $option = array();
	  $class = "class=inputbox";
    
    if(version_compare(JVERSION,'2.5.6','lt')) {
      $model = JModel::getInstance( 'categories', 'CobaltModel' );
    }else{
      $model = JModelLegacy::getInstance( 'categories', 'CobaltModel' );
    }
    
    $result = $model->getCategoriesWithSections();
    $options[] = JHTML::_('select.option', '0', 'Disabled');
    foreach($result[0] as $res) {
      //$options[] = JHTML::_('select.option', $res->id, $res->name);
      $this->recursiveList($res, $options, '',$res->id);
    }
     return JHTML::_('select.genericlist', $options, 'params['.$name.']', $class , 'value', 'text',  $value, $control_name.$name);
	}
  
  function recursiveList(&$cat, &$options, $sep, $sec_id){
    $options[] = JHTML::_('select.option', ($sep == '' ? '' : $sec_id.'-').$cat->id, ($sep == '' ? $cat->text : $sep.$cat->title));
    if(@$cat->children){
      foreach($cat->children AS $cat){
        $this->recursiveList($cat, $options, $sep.'-', $sec_id);
      }
    }
  }
}