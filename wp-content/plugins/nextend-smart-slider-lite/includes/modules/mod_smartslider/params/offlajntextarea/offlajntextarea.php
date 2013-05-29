<?php
defined('_JEXEC') or die('Restricted access');

class JElementOfflajnTextarea extends JOfflajnFakeElementBase{
  var	$_name = 'OfflajnTextarea';
  
  function universalfetchElement($name, $value, &$node){
    $document =& JFactory::getDocument();
    $this->loadFiles();
    $attr = $node->attributes();
    
    $html = '<div class="offlajntextareacontainer" id="offlajntextareacontainer'.$this->id.'">';
    $html.= '<textarea  cols="' . (isset($attr['cols'])? $attr['cols'] : 10) . '" rows="' . (isset($attr['rows'])? $attr['rows'] : 10) . '" class="offlajntextarea" type="text" name="'.$name.'" id="'.$this->id.'">'.$value.'</textarea>';
    $html.= '</div>';
    return $html;
  }
}
