<?php
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.html.parameter' );

@JOfflajnParams::load('offlajnlist');

class JElementOfflajnTheme extends JElementOfflajnList{

  var $_moduleName = '';
  
  var $_name = 'offlajntheme';
  
  var $firstRun = 0;
 
  function universalFetchElement($name, $value, &$node){
    $this->jf = false;
    if($_REQUEST['option'] == 'com_joomfish'){
      $this->jf = true;
    }
    $this->loadFiles();
    $this->loadFiles('offlajnlist');
    $this->themesdir = dirname(__FILE__).'/../../themes/';
    $themesdir = dirname(__FILE__).'/../../themes/';
    $document =& JFactory::getDocument();
    if($value == 1) {
      $value = "default";
      $this->firstRun = 1;
    }
    return $this->generateThemeSelector($name, $value, $node);
  }
  
  function generateThemeSelector($name, $value, &$lnode){
    $themes = JFolder::folders($this->themesdir);
    $this->themeParams = array('default' => '');
    $this->themeScripts = array('default' => '');

    //$stack = & JsStack::getInstance();
    
    $themeparams = null;
    
    $data = $this->_parent->toArray();
    
    preg_match('/(.*)\[([a-zA-Z0-9]*)\]$/', $name, $out);
    
    $out[1] = str_replace(array("[", "]"), '', $out[1]);
    
    @$control = $out[1];
    @$orig_name = $out[2];
    
    $formdata = array();
    $c = $control;
    if(version_compare(JVERSION,'1.6.0','ge')) {
      if(isset($data[$orig_name]) && is_array($data[$orig_name]) ){
        $formdata = $data[$orig_name];
      }
      $c = $name;
    }else{
      $formdata = $data;
    }
    
    $_SESSION['theme'] = array(
      'themesdir' => str_replace('\\','/',$this->themesdir),
      'formdata' => $formdata,
      'c' => $c,
      'module' => $this->_moduleName,
      'name' => $name,
      'raw' => $this->_parent->getRaw()
    );

    if ( is_array($themes) ){
    	foreach($themes as $theme){
        $lnode->addChild('option',array('value' => $theme))->setData(ucfirst($theme));
        
    		if($theme == 'default') $theme.=2;
        
        $key = md5($theme);
        $_SESSION['theme']['forms'][$key] = $theme;
          
        $this->themeParams[$theme] = $key;
    	}
    }
    if(version_compare(JVERSION,'1.6.0','ge')) {
      $name.= '['.$orig_name.']';
    }

    $themeField = parent::universalfetchElement($name, is_array($value) ? $value["theme"] : $value, $lnode);
    
    $id = $this->generateId($control).'theme';
    plgSystemOfflajnParams::addNewTab($id, 'Theme Parameters', '');

    DojoLoader::addScript('
      var theme = new ThemeConfigurator({
        id: "'.$id.'-details",
        selectTheme: "'.$this->generateId($name).'",
        themeSelector: '.json_encode(@$this->themeSelector).',
        themeParams: '.json_encode($this->themeParams).',
        themeScripts: '.json_encode($this->themeScripts).',
        joomfish: '.(int)$this->jf.',
        control: "'.$control.'",
        firstRun: "'.$this->firstRun.'",
        url: "'.JUri::root(true).'/administrator/index.php'.'"
      });
    ');
    return $themeField;
  }
  
  function setModuleName(){
    preg_match('/modules\/(.*?)\//', $this->_parent->_xml['_default']->_attributes['addpath'], $matches);
    $this->_moduleName = $matches[1];
  }
}

if(version_compare(JVERSION,'1.6.0','ge')) {
  class JFormFieldOfflajnTheme extends JElementOfflajnTheme {}
}
?>