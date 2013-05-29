<?php 
defined('_JEXEC') or die('Restricted access');

require_once(dirname(__FILE__).'/../offlajnlist/offlajnlist.php');

class JElementnextendcobaltccktype extends JElementOfflajnList
{
  var $_moduleName = '';
  
	var	$_name = 'Nextendcobaltccktype';

	function universalfetchElement($name, $value, &$node){
  	$this->loadFiles();
		$sectionlist = array();
    $db = JFactory::getDBO();
    
    $sectionlist[0] = 'Show all sections in the menu';
    
    $query = "SELECT id, name FROM #__js_res_sections ORDER BY name ASC";
    $db->setQuery($query);
    foreach($db->loadRowList() AS $f){
      $sectionlist[$f[0]] = $f[1];
    }
    
    foreach($sectionlist AS $k => $v){
      $node->addChild('option',array('value' => $k))->setData($v);
    }
    
		return parent::universalfetchElement($name, $value, $node);
	}
	
}

if(version_compare(JVERSION,'1.6.0','ge')) {
  class JFormFieldnextendcobaltccktype extends JElementnextendcobaltccktype {}
}