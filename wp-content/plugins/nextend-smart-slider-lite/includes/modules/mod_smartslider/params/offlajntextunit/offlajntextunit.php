<?php
defined('_JEXEC') or die('Restricted access');

  class JElementOfflajnTextUnit extends JOfflajnFakeElementBase{
    var $_moduleName = '';
  	var	$_name = 'OfflajnTextUnit';
  	function universalfetchElement($name, $value, &$node){
      return 'Do NOT use!';
      $document =& JFactory::getDocument();
      $this->loadFiles();

      $setting = "";
      $attributes = $node->attributes();
      if (!isset($attributes['size'])) $attributes['size'] = 3;
      if (isset($attributes['units']) && $attributes['units'] != ""){
        $units = explode(" ", $attributes['units']);
        $default_unit = $units[0];
      }else{
        $attributes['units'] = "";
        $units = array();
        $setting .= " no_unit";
        $default_unit = "";
      }
      if (isset($attributes['attach_unit']) && $attributes['attach_unit'] == 1 && count($units) > 1) $setting .= " variable_unit";

      $label = array();
      if ($children_count = count($node->children())){
        foreach ($node->children() as $child) $label[] = $child->data();
      }else{
        $label[0] = "";
        $children_count = 1;
        $setting .= " single";
      }

      $html = "";
      $values = explode(' ',htmlspecialchars(html_entity_decode($value, ENT_QUOTES), ENT_QUOTES));

      for($i = 0;$i < $children_count;$i++){
        if (isset($values[$i])) preg_match("((\d*.?\d+)?(\D+)?)",$values[$i],$textunit);
        else $textunit = array("","0","px");
        if (!isset($textunit[2])) $textunit[2] = $default_unit;
        $is_last = ($i+1 == $children_count) ? "last" : "";
        $html.='
          <div class="part">
            <div class="label"><span>'.$label[$i].'</span></div>
            <input type="text" value="'.$textunit[1].'" style="width:'.($attributes['size']*8).'px;"/>
            <div class="unit">
              <span>'.$textunit[2].'</span>
            </div>
            <div class="separator '.$is_last.'">
              <div class="line"></div>
              <div class="line"></div>
              <div class="line"></div>
              <div class="line last"></div>
            </div>
          </div>
        ';
      }
      DojoLoader::addScript('
        new OfflajnTextUnit({
          id: '.json_encode($this->id).',
          attachUnit: '.json_encode($attributes['attach_unit']).',
          units: '.json_encode($attributes['units']).'
        });
    ');    
      return '
        <div class="textunit_container'.$setting.'" id="'.$this->id.'_container">
          <input type="hidden" name="'.$name.'" id="'.$this->id.'" value="'.$value.'"/>
          '.$html.'
        </div>';
  	}  	
  }

  if(version_compare(JVERSION,'1.6.0','ge')) {
    class JFormFieldOfflajnTextUnit extends JElementOfflajnTextUnit {}
  }

?>