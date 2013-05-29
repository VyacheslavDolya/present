<?php
defined('_JEXEC') or die('Restricted access');

include_once(dirname(__FILE__).DS.'..'.DS.'offlajndashboard'.DS.'offlajndashboard.php');

class JElementNextendconfigurator extends JOfflajnFakeElementBase
{
	var	$_name = 'nextendconfigurator';
  
	function universalfetchElement($name, $value, &$node){
    global $offlajnParams, $offlajnDashboard;
  	$this->loadFiles();
  	$this->loadFiles('offlajnimagemanager','offlajnimagemanager');
    $html = '';
    $html.= '<div id="nextend-configurator-lightbox" class="gk_hack">';
    $html.= '<div class="gk_hack nextend-configurator-container">';
    $html.= '<div class="gk_hack nextend-configurator-container-inner">';
    $params = new OfflajnJParameter('');
    $params->setXML($node->params[0]);
    
    if(!version_compare(JVERSION,'1.6.0','ge')){ // Joomla 1.5 < 
      preg_match('/(.*)\[([a-zA-Z0-9]*)\]$/', $name, $out);
      $control = $out[1];
      $name = $out[2];
      $params->_raw = & $this->_parent->_raw;
      $params->bind($this->_parent->_raw);
    }else{ // Joomla 1.7 > 
      $control = $name;
      if($value != ''){
        $params->bind($value);
      }else if(isset($_REQUEST['id']) && $_REQUEST['id'] != ''){
        $module_id = intval($_REQUEST['id']);
        if($module_id > 0){
          $db =& JFactory::getDBO();
          $db->setQuery('SELECT params FROM #__modules WHERE id='.$module_id);
          $value = json_decode($db->loadResult());
          $params->bind($value);
        }
      }
    }
    
    //$html.= '<div class="pane-slider panel">';
    $html.= '<fieldset id="nextend-configurator-panels" class="gk_hack panelform">';
    $html.= '<div id="menu-pane" class="gk_hack pane-sliders">';
    $params->render($control);
    $html.= isset($offlajnDashboard) ? $offlajnDashboard : '';
    $html.= isset($offlajnParams['first']) && is_array($offlajnParams['first']) ? implode("\n",$offlajnParams['first']) : '';
    $html.= isset($offlajnParams['last']) && is_array($offlajnParams['last']) ? implode("\n",$offlajnParams['last']) : '';
    
    $html.= '</div>';
    $html.= '</fieldset>';
    $html.= '</div>';
    
    $html.= '</div>';
    $html.= '<div id="nextend-configurator-save"><div class="OfflajnWindowSaveContainer"><div class="OfflajnWindowSave">OK</div></div></div>';
    $html.= '</div>';
    //$html.= '</div>';

    DojoLoader::addScript('
      new NextendConfigurator({
        button: dojo.byId("nextend-configurator-button"),
        node: dojo.byId("nextend-configurator-lightbox"),
        save: dojo.byId("nextend-configurator-save"),
        message: dojo.byId("nextend-configurator-message")
      });
    ');
    
    return $html.'<a id="nextend-configurator-button" href="#">Configure</a><span id="nextend-configurator-message">&nbsp;</span>';
	} 
}

if(version_compare(JVERSION,'1.6.0','ge')) {
        class JFormFieldNextendConfigurator extends JElementNextendConfigurator {}
}