<?php 
/*------------------------------------------------------------------------
# smartslider - Smart Slider
# ------------------------------------------------------------------------
# author    Jeno Kovacs
# copyright Copyright (C) 2011 Offlajn.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.offlajn.com
-------------------------------------------------------------------------*/
?>
<?php
defined('_JEXEC') or die('Restricted access');

if(version_compare(JVERSION,'2.5.6','lt')) {
  jimport ( 'joomla.application.component.model' );
}else{
  jimport ( 'joomla.application.component.modellegacy' );
}
JLoader::import( 'fields', JPATH_SITE . DS . 'components' . DS . 'com_cobalt' . DS . 'models' );

require_once('helper.php'); //to parse templates and load template files

class CobaltCckParser {
  
  function CobaltCckParser($p) {
   $this->params = $p;
  }

  function makeSlides() {
    $db = & JFactory::getDBO();
    $content = TemplateParser::getFile("contents", $this->params->get('generatorcontents'));
    $caption = TemplateParser::getFile("captions", $this->params->get('generatorcaptions'));
    
    $type_id = $this->params->get("generatortypes");
    $slides = array();
    
    
    $where = '';
    
    $section = $this->params->get("generatorsection", '0');
    if($section != 0){
      $e = explode('-', $section);
      if($e[0] > 0){
        $where.= ' AND section_id = '.Nextendescape($db, $e[0]);
      }
      
      if(isset($e[1]) && $e[1] > 0){
        $where.= " AND  categories LIKE '%\"".Nextendescape($db, $e[1])."\"%'";
      }
    }
    
    for($x = 1; $x <= 5; $x++ ){
      $filter = explode('|*|',$this->params->get("generatorfilter".$x));
      if($filter[0] == '' || $filter[0] === '0') continue;
      if(strpos($filter[0], 'field.') !== false){
        $field = substr($filter[0], 6);
        $where.= 'AND (SELECT f.field_value FROM #__js_res_record_values AS f 
          WHERE f.field_id = \''.Nextendescape($db, $field).'\' 
          AND f.record_id = #__js_res_record.id) '; 
      }else{
        $where.= ' AND '.NextendnameQuote($db,$filter[0]).' ';
      }
      $where.= $this->isAcceptedCriterion($filter[1]).' \''.Nextendescape($db, $this->parseCriterionValue($filter[2])).'\'';
    }
    
    $order = $this->params->get("generatorordering", 'ctime');
    
    if($order == 'random') $order = 'rand()';
    else $order.= ','.$this->params->get("generatororder", 'desc');
    
    $this->result = TemplateParser::getIds("js_res_record", $type_id, "type_id", $order, "`published` = '1'".$where);
    
    if(version_compare(JVERSION,'2.5.6','lt')) {
      $fieldsmodel = JModel::getInstance( 'fields', 'CobaltModel' );
    }else{
      $fieldsmodel = JModelLegacy::getInstance( 'fields', 'CobaltModel' );
    }
    
    $fieldsmodel->setState('fields.type_id', $type_id);
    $fields = $fieldsmodel->getItems();
    $fxml = '<contentvalues>';
    $fxml.= '<title type="cobaltcck" insert="1">Title</title>';
    $fxml.= '<recordurl type="cobaltcckrecordurl" insert="1">Record url</recordurl>';
    
    foreach($fields AS $k => $v){
      $fxml.= '<field'.$v->id.' type="cobaltcck" insert="1">'.$v->label.'</field'.$v->id.'>';
    }
    
    $fxml.= '</contentvalues>';
    
    if(version_compare(JVERSION,'3.0.0','>=')){
      $xml = JFactory::getXML($fxml, false);
      $this->xml = $xml->children();
    }else{
      $xml = &JFactory::getXMLParser('Simple');
      $xml->loadString($fxml);
      $this->xml = $xml->document->children();
    }
    

    $count = count($this->result);
    if ($this->params->get("generatorslidenumber") != "") {
      if($count > $this->params->get("generatorslidenumber")) 
        $count = $this->params->get("generatorslidenumber");
    }
    for($i=0;$i<$count;$i++) {
      $d = TemplateParser::getDatas($i, $this->xml, $this->result, $this->params);
      
      $slides[$i]->content = TemplateParser::parse($content, $d, "content");
      $slides[$i]->caption = TemplateParser::parse($caption, $d, "caption");
      $slides[$i]->groupprev = 0;      
      $slides[$i]->title = $d["generatorslidetitle"];
    }
    return $slides;
  }
  
  function isAcceptedCriterion($c){
    $accepted = array('<', '<=','>', '>=', '=', '!=', '<>', 'LIKE', 'NOT LIKE');
    if(in_array($c, $accepted)) return $c;
    return '=';
  }
  
  function parseCriterionValue($v){
    switch($v){
      case '*user_id*':
        return intval(isset($_GET['user_id']) ? $_GET['user_id'] : 0);
        break;
      default:
    }
    return $v;
  }
  
  function makeParams($i) {
    $arr = TemplateParser::getDatas($i, $this->xml, $this->result, $this->params);
    $params = new JParameter('');
		$params->loadArray($arr);
    if(version_compare(JVERSION,'1.6.0','>=')) {
      $paramstr = stripslashes(json_encode($arr));
      $paramstr = preg_replace('/contents\"/', "content\"", $paramstr);
      $paramstr = preg_replace('/captions\"/', "caption\"", $paramstr);
    } else {
      $paramstr = $params->toString();
      $paramstr = preg_replace('/contents=/', "content=", $paramstr);
      $paramstr = preg_replace('/captions=/', "caption=", $paramstr);
    }
    $paramstr = str_replace("generator", "", $paramstr);    
   return $paramstr;
  
  }
}