<?php
@ini_set('memory_limit','260M');
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();


include_once(dirname(__FILE__).DS.'library'.DS.'fakeElementBase.php');

class JElementOfflajnupdatechecker extends JOfflajnFakeElementBase
{
  
	var	$_name = 'Offlajnupdatechecker';
  
	function universalfetchElement($name, $value, &$node){
    $lang =& JFactory::getLanguage();
    $lang->load($this->_moduleName, dirname(__FILE__).DS.'..');

  	$xml = dirname(__FILE__).DS.'../'.$this->_moduleName.'.xml';
  	if(!file_exists($xml)){
      $xml = dirname(__FILE__).DS.'../install.xml';
      if(!file_exists($xml)){
        return;
      }
    }
    $xml = simplexml_load_file($xml);
    $hash = (string)$xml->hash;
    if($hash == '') return;
    
	  return '<iframe src="http://offlajn.com/index2.php?option=com_offlajn_update&hash='.base64_url_encode($hash).'&v='.$xml->version.'&u='.JURI::root().'" frameborder="no" style="border: 0;" width="100%" height="30"></iframe>';
	}
}


function base64_url_encode($input) {
 return strtr(base64_encode($input), '+/=', '-_,');
}

if(version_compare(JVERSION,'1.6.0','ge')) {
        class JFormFieldOfflajnupdatechecker extends JElementOfflajnupdatechecker {}
}
