<?php
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.html.parameter' );

@JOfflajnParams::load('offlajnlist');

class JElementOfflajnMenutype extends JElementOfflajnList{

  var $_name = 'offlajnmenutype';
 
  function universalFetchElement($name, $value, &$node){
    $this->loadFiles();
    $attrs = $node->attributes();
    $f = isset($attrs['folder']) ? $attrs['folder'] : 'types';
    $this->label = isset($attrs['label']) ? $attrs['label'] : 'Type';
    $this->typesdir = dirname(__FILE__).DS.'..'.DS.'..'.DS.$f.DS;
    $document =& JFactory::getDocument();
    
    return $this->generateTypeSelector($name, $value);
  }
  
  function generateTypeSelector($name, $value){
    $id = $this->generateId($this->label);
    
    $types_bak = JFolder::folders($this->typesdir);
    $type_priority = array(
      'joomla'=>1,
      'virtuemart1'=>2,
      'virtuemart2'=>3,
      'k2'=>4,
      'redshop'=>5,
      'tienda'=>6,
      'cobaltcck'=>7, 
      'jshopping'=>8,
      'hikashop'=>9 
    );
    $types = array();
    foreach($type_priority AS $k => $type){
      if(in_array($k, $types_bak)){
        $types[] = $k;
      }
    }
    
    $this->typeParams = array('default' => '');
    $this->typeScripts = array('default' => '');
    $node = new JSimpleXMLElement('list'); 
    
    $data = $this->_parent->toArray();
    
    
    
    preg_match('/(.*)\[([a-zA-Z0-9]*)\]$/', $name, $out);
    @$control = $out[1];
    @$orig_name = $out[2];
    
    $document =& JFactory::getDocument();
    $stack = & JsStack::getInstance();
    
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
    
    $_SESSION[$id] = array(
      'typesdir' => str_replace('\\','/',$this->typesdir),
      'formdata' => $formdata,
      'c' => $c,
      'module' => $this->_moduleName
    );
    
    if ( is_array($types) ){
      foreach($types as $type){
        $node->addChild('option',array('value' => $type))->setData(ucfirst($type));

        if($this->checkExtension($type)){
        
          $key = md5($type);
          $_SESSION[$id]['forms'][$key] = $type;
            
          $this->typeParams[$type] = $key;
        }else{
          $this->typeParams[$type] = '<ul class="adminformlist"><li><label>&nbsp;</label><div>'.JText::_('THIS_COMPONENT_NOT_INSTALLED').'</div></li></ul>';
          $this->typeScripts[$type] = '';
        }
    	}   	
    }
    
    if(version_compare(JVERSION,'1.6.0','ge')) {
      $name.= '['.$orig_name.']';
    }

    $typeField = parent::universalfetchElement($name, version_compare(JVERSION,'1.6.0','ge') ? @$value[$orig_name] : $value, $node);

    
    plgSystemOfflajnParams::addNewTab($id, $this->label.' Parameters', '');

    $document =& JFactory::getDocument();
    DojoLoader::addScript('
        new TypeConfigurator({
          selectorId: "'.$this->generateId($name).'",
          typeParams: '.json_encode($this->typeParams).',
          typeScripts: '.json_encode($this->typeScripts).',
          joomfish: 0,
          control: "'.$id.'",
          url: "'.JUri::root(true).'/administrator/index.php'.'"
        });
    ');
    
    return $typeField;
  }
   
  
  
  function checkExtension($name){
    if($name == 'virtuemart1'){
      if(!is_dir(JPATH_ROOT.DS.'components'.DS.'com_virtuemart') || file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php')){
        return false;
      }
    }else if($name == 'virtuemart2'){
      if(!is_dir(JPATH_ROOT.DS.'components'.DS.'com_virtuemart'.DS.'controllers')){
        return false;
      }
    } else if ($name =='k2') {
      if(!is_dir(JPATH_ROOT.DS.'components'.DS.'com_k2'.DS.'controllers')){
        return false;
      }      
    } else if ($name =='tienda') {
      if(!is_dir(JPATH_ROOT.DS.'components'.DS.'com_tienda'.DS.'controllers')){
        return false;
      }      
    } else if ($name =='redshop') {
      if(!is_dir(JPATH_ROOT.DS.'components'.DS.'com_redshop'.DS.'controllers')){
        return false;
      }      
    } else if ($name =='hikashop') {
      if(!is_dir(JPATH_ROOT.DS.'components'.DS.'com_hikashop'.DS.'controllers')){
        return false;
      }      
    } else if ($name =='jshopping') {
      if(!is_dir(JPATH_ROOT.DS.'components'.DS.'com_jshopping')){
        return false;
      }      
    } else if ($name =='cobaltcck') {
      if(!is_dir(JPATH_ROOT.DS.'components'.DS.'com_cobalt')){
        return false;
      }      
    }
    return true;
  }

}

if(version_compare(JVERSION,'1.6.0','ge')) {
  class JFormFieldOfflajnMenutype extends JElementOfflajnMenutype {}
}
?>