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

require_once('helper.php'); //to parse templates and load template files

class ArticlesParser {
  
  function ArticlesParser($p) {
   $this->params = $p;
  }

  function makeSlides() {
    $content = TemplateParser::getFile("contents", $this->params->get('generatorcontents'));
    $caption = TemplateParser::getFile("captions", $this->params->get('generatorcaptions'));
    $slides = array();
    $_orderby = $this->params->get('generatororderby');
    $_order = $this->params->get('generatororder');
    $order = '';
    $where = '';
    if($this->params->get('generatorfeatured',0) == 1){
      $where.=' AND featured = 1 ';
    }
    if($this->params->get('generatorcontentimage',0) == 1){
      $where.=' AND introtext LIKE "%src=%"';
    }
    
    
    if($_order == 'random'){
      $order = 'rand()';
    }else if($_orderby != ''){
      $order = $_orderby.','.$_order;
    }
    $this->result = TemplateParser::getIds("content", $this->params->get("generatorcategory"), "catid", $order, " `state` = '1'".$where);
    
    
    if(version_compare(JVERSION,'3.0.0','>=')){
      $xml = JFactory::getXML(JPATH_ADMINISTRATOR .DS. "components" .DS. "com_smartslider" .DS. "oldparams" .DS. "slidegenerator" .DS. $this->params->get('generator') .".xml");
      $this->xml = $xml->settings[0]->contentvalues[0]->children();
    }else{
      $xml = &JFactory::getXMLParser('Simple');
      $xml->loadFile(JPATH_ADMINISTRATOR .DS. "components" .DS. "com_smartslider" .DS. "oldparams" .DS. "slidegenerator" .DS. $this->params->get('generator') .".xml");
      $this->xml = $xml->document->settings[0]->contentvalues[0]->children();
    } 

    $count = count($this->result);
    if ($this->params->get("generatorslidenumber") != "") {
      if($count > $this->params->get("generatorslidenumber")) 
        $count = $this->params->get("generatorslidenumber");
    }
    for($i=0;$i<$count;$i++) {
      //$d = $this->getDatas($i);
      $d = TemplateParser::getDatas($i, $this->xml, $this->result, $this->params);
      $slides[$i]->id = $this->result[$i];
      $slides[$i]->content = TemplateParser::parse($content, $d, "content");
      $slides[$i]->caption = TemplateParser::parse($caption, $d, "caption");
      $slides[$i]->groupprev = 0;      
      $slides[$i]->title = $d["generatorslidetitle"];
    }
    return $slides;
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