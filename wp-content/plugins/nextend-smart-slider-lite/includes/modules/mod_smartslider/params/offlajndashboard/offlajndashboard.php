<?php
defined('_JEXEC') or die('Restricted access');

if (!extension_loaded('gd') || !function_exists('gd_info')) {
    JError::raiseWarning( 100, "This extension needs the <a href='http://php.net/manual/en/book.image.php'>GD module</a> enabled in your PHP runtime environment. Please consult with your System Administrator and he will enable it!");
}

if(version_compare(JVERSION,'3.0.0','l') && !function_exists('Nextendjimport')){
  function Nextendjimport($key, $base = null){
    return jimport($key);
  }
}
  
jimport( 'joomla.form.helper' );
jimport( 'joomla.form.formfield' );
jimport( 'joomla.filesystem.folder' );
Nextendjimport( 'joomla.utilities.simplexml' );

@ini_set('memory_limit','260M');
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();
define("OFFLAJNADMINPARAMPATH", dirname(__FILE__).DS.'..');
$_SESSION['OFFLAJNADMINPARAMPATH'] = str_replace('\\','/',OFFLAJNADMINPARAMPATH);

if(version_compare(JVERSION,'1.6.0','ge')) JFormHelper::addFieldPath(JFolder::folders(OFFLAJNADMINPARAMPATH, '.', false, true));
//else if(isset($this)) $this->addElementPath(JFolder::folders(OFFLAJNADMINPARAMPATH, '.', false, true));

include_once(dirname(__FILE__).DS.'library'.DS.'fakeElementBase.php');
include_once(dirname(__FILE__).DS.'library'.DS.'parameter.php');
include_once(dirname(__FILE__).DS.'library'.DS.'flatArray.php');
include_once(dirname(__FILE__).DS.'library'.DS.'JsStack.php');

class JElementOfflajnDashboard extends JOfflajnFakeElementBase
{
	var	$_name = 'OfflajnDashboard';
  var $attr;
	
	function loadDashboard(){
    $logoUrl = JURI::base(true).'/../modules/'.$this->_moduleName.'/params/offlajndashboard/images/dashboard-nextend.png';
    $supportTicketUrl = JURI::base(true).'/../modules/'.$this->_moduleName.'/params/offlajndashboard/images/support-ticket-button.png';
    $supportUsUrl = JURI::base(true).'/../modules/'.$this->_moduleName.'/params/offlajndashboard/images/support-us-button.png';
    global $offlajnDashboard;
    ob_start();
    include('offlajndashboard.tmpl.php');
    $offlajnDashboard = ob_get_contents();
    ob_end_clean();	
  }
  
	function universalfetchElement($name, $value, &$node){
    define("OFFLAJNADMIN", "1");
  	$this->loadFiles();
  	$this->loadFiles('legacy', 'offlajndashboard');
    $j17 = 0;
    if(version_compare(JVERSION,'1.6.0','ge')) $j17 = 1;
    $style = "";
	  $opened_ids = json_decode(stripslashes(@$_COOKIE[$this->_moduleName."lastState"]));
	  if ($opened_ids){
      foreach ( $opened_ids as $id) {
      $style.= '#content-box #'.$id.' div.content{'
      	. 'opacity: 1;'
      	. 'height: 100%;'
      	. '}'; 
      }
    }
	  $document =& JFactory::getDocument();

    $document->addStyleDeclaration( $style );	  
    DojoLoader::r('dojo.uacss');

    DojoLoader::addScript('
      var offlajnParams = new OfflajnParams({
        joomla17 : '.$j17.',
        moduleName : "'.$this->_moduleName.'"
      });
    ');

    $lang =& JFactory::getLanguage();
    $lang->load($this->_moduleName, dirname(__FILE__).DS.'..'.DS.'..');
  	$xml = dirname(__FILE__).DS.'../../'.$this->_moduleName.'.xml';
  	if(!file_exists($xml)){
      $xml = dirname(__FILE__).DS.'../../install.xml';
      if(!file_exists($xml)){
        return;
      }
    }
    if(version_compare(JVERSION,'3.0','ge')){
      $xmlo = JFactory::getXML($xml);
      $xmld = $xmlo;
    }else{
      jimport( 'joomla.utilities.simplexml' );
      $xmlo = JFactory::getXMLParser('Simple');
      $xmlo->loadFile($xml);
      $xmld = $xmlo->document;
    }
    
    if(isset($xmld->hash) && $xmld->hash[0]){
      if(version_compare(JVERSION,'3.0','ge')){
        $hash = (string)$xmld->hash[0];
      }else
        $hash = (string)$xmld->hash[0]->data();
    }
      
    $this->attr = $node->attributes();
    
    
    $this->generalInfo = '<iframe src="http://www.nextendweb.com/update_checker.php?m='.$this->_moduleName.'&v='.(version_compare(JVERSION,'3.0','ge') ?  (string)$xmld->version : $xmld->version[0]->data()).'" frameborder="no" style="border: 0;" width="100%" height="200px" ></iframe>';
    $this->relatedNews = '<iframe id="related-news-iframe" src="http://www.nextendweb.com/news_checker.php?m='.$this->_moduleName.'" frameborder="no" style="border: 0;" width="100%" ></iframe>';    

    $this->loadDashboard();
    if(!version_compare(JVERSION,'1.6.0','ge')){
      preg_match('/(.*)\[([a-zA-Z0-9]*)\]$/', $name, $out);
      @$control = $out[1];
      
      $x = file_get_contents($xml);
      preg_match('/<fieldset.*?>(.*?)<\/fieldset>/ms', $x, $out);
      
      //$params = str_replace(array('<field', '</field'),array('<param','</param'),$out[0]);
      $params = $out[0];
      $n = new JSimpleXML();
      $n->loadString($params);
      $attrs = $n->document->attributes();
      if(($_REQUEST['option'] == 'com_modules') || ($_REQUEST['option'] == 'com_advancedmodules')){
        $n->document->field[0]->params[0]->removeChild($n->document->field[0]->params[0]->param[0]);
        $params = new OfflajnJParameter('');
        $params->setXML($n->document->field[0]->params[0]);
        $params->_raw = & $this->_parent->_raw;
        $params->bind($this->_parent->_raw);
        $params->render($control);
      }
    }
    if(!isset($hash) || $hash == '') return;
	  return "";
	} 
}


function base64_url_encode($input) {
 return strtr(base64_encode($input), '+/=', '-_,');
}

if(version_compare(JVERSION,'1.6.0','ge')) {
        class JFormFieldOfflajnDashboard extends JElementOfflajnDashboard {}
}