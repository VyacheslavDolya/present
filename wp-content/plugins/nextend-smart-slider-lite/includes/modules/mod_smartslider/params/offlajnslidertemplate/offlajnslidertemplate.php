<?php
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.filesystem.folder' );
jimport( 'joomla.filesystem.file' );
Nextendjimport( 'joomla.utilities.simplexml' );
		
class JElementOfflajnSliderTemplate extends JElementOfflajnList{

  var $_moduleName = '';
  
  var $_name = 'offlajnslidertemplate';
  
  var $_data = '';
  
  var $html = '';
 
  function universalfetchElement($name, $value, &$node){
    $this->loadFiles();
    $this->loadFiles('offlajnlist');
    
    $this->canvas	= $node->attributes('canvas') == 'fixed' ? 1 : 0;
    $this->ext	= $node->attributes('imgext');
    
    $this->_data = new stdClass();
    $this->row = $this->_parent->row;

    $this->folder	= $node->attributes('folder');
    
    $this->name	= $node->attributes('name');
    $this->row->params->def($this->name, $value);
    
    $this->editor	= $node->attributes('editor');
    
    $typeSelector = $this->generateTemplateSelector($name, $value, $node);
    
    if(defined('WP_ADMIN')){
      $url = smartslider_url('includes');
    }else{
      $url = rtrim(JURI::root(),"/");
    }
    DojoLoader::addScript('
      new SliderTemplate({
        container: dojo.byId("'.$this->id.'-container"),
        node: dojo.byId("'.$this->name.'"),
        editor: dojo.byId("'.$this->editor.'"),
        data: '.json_encode($this->_data).',
        v16: "'.(version_compare(JVERSION,'1.6.0','ge') ? 1 : 0).'",
        ext: "'.$this->ext.'",
        imageurl: "'.$url.'"
      });
    ');

    return $typeSelector;
  }
  
  function generateTemplateSelector($name, $value, &$node){
    $dir = JPATH_SITE . DS . 'modules' . DS . 'mod_smartslider' . DS . 'types' . DS . $this->row->type . DS . $this->row->theme . DS . $this->folder;
    $files = JFolder::files($dir, '.phtml');
    $imgurl = JURI::base().'../modules/mod_smartslider/types/'.$this->row->type.'/'.$this->row->theme.'/'.$this->folder.'/';
    if(defined('WP_ADMIN')){
      $imgurl = smartslider_translate_url('modules/mod_smartslider/types/'.$this->row->type.'/'.$this->row->theme.'/'.$this->folder.'/');
    }
    $html='';

    if($this->canvas){
      $theme = JPATH_SITE . DS . 'modules' . DS . 'mod_smartslider' . DS . 'types' . DS . $this->row->type . DS . $this->row->theme . DS . 'style.css.php';
      ob_start();
      $calc = true;
      $this->env = new stdClass();
      $this->env->slider = new stdClass();
      $this->env->slider->params = &$this->row->sliderparams;
      
      $db =& JFactory::getDBO();
      $query = 'SELECT *'
      . ' FROM #__offlajn_slide'
      . ' WHERE published = 1 AND slider = '.((int)$this->row->slider)
      . ' ORDER BY ordering';
      $db->setQuery($query);
      $slides = $db->loadObjectList();
      $this->slides = array();
      $count = count($slides);
      if($count != 0){
        for($i = 0, $j = 0; $i < $count; ++$i, ++$j){
          $p = new OfflajnJParameter('');
          $p->loadIni($slides[$i]->params);
          $slides[$i]->params = $p;
          $slides[$i]->childs = array();
          if($slides[$i]->groupprev == 1 && isset($this->slides[$j-1])){
            --$j;
          }else{
            $this->slides[$j] = &$slides[$i];
          }
          $this->slides[$j]->childs[] = &$slides[$i];
        }
      }
      if(JRequest::getVar('task') == 'add'){
        $this->slides[] = new stdClass();
      }
      $this->env->slides = &$this->slides;
      $this->calc = true;
      $c['clearcss'] = JPATH_SITE . DS . 'modules' . DS . 'mod_smartslider'. DS .'clear.css.php';
      include($theme);
      ob_end_clean();
      $html.= '<script type="text/javascript">document.canvaswidth='.$canvasWidth.';document.canvasheight='.$canvasHeight.';</script>';
    }
    $imghtml = '';
    $x = 0;
    if(is_array($files)){
      foreach($files as $file){
        $content = file_get_contents($dir.DS.$file);
        
        $file = JFile::stripExt( $file );
        $lfile = strtolower($file);
        $this->_data->$lfile = new stdClass();
        $isBlank = false;
        if($lfile == 'blank') $isBlank = true;
        $this->_data->$lfile->html = $this->parseTemplate($content,$isBlank);
        
        $pattern = '/(.*?[a-z]{1})([A-Z]{1}.*?)/';
        $replace = '${1} ${2}';
        
        $node->addChild('option',array('value' => $lfile))->setData(ucfirst(preg_replace($pattern, $replace, $file)));
        $imghtml.='<img class="miniimage" src="'.$imgurl.$file.'.png" />';
        $x++;
      }
    }
    if(defined('WP_LITE')){
      $imghtml.='<a href="http://wpcubes.com" target="_blank"><img style="cursor: pointer;float: left;height: 60px;margin: 5px;width: 100px;" src="'.$imgurl.'../images/pro.png" /></a>';
    }
    $html.= '<div id="'.$this->id.'-container" '.(version_compare(JVERSION,'1.6.0','ge') ? 'style="margin-left:177px;' : '').'">';
    $html.= parent::universalfetchElement('param['.$this->name.']', $this->row->params->get($this->name,'blank'), $node);
    $html.= '<div style="clear:both;"></div>';
    $html.= $imghtml;
    $html.= '</div>';
    return $html;
  }
  
  function parseTemplate($c, $isBlank = false){
    preg_match_all ('/{param ([a-z]*) "(.*?)"( "(.*?)")?( "(.*?)")?}(([^{]*){\/param})?/',$c , $out, PREG_SET_ORDER  );

    $filtered = array();

    foreach($out AS $o){
      if(!isset($filtered[$o[2]]))
        $filtered[$o[2]] = $o;
    }
      
      
    $xml = new JSimpleXML();
    $xml->loadString('<params></params>');
    $root = &$xml->document;
    
    $fields = array();
    $values = $this->row->params->toArray();

    foreach($filtered AS $o){
      $name = preg_replace('/[^a-z]/', '', strtolower($o[2]) );
      
      $newname = $this->name.$name;
      $fields[] = $newname;
      if(isset($values[$newname])) $o[4] = $values[$newname];
      $a = array('name' => $newname, 'type' => $o[1], 'default' => isset($o[4]) ? $o[4] : '', 'label' => $o[2], 'description' => isset($o[6]) ? $o[6] : '' );
      if($o[1] == 'textarea'){
        $a['type'] = 'offlajntextarea';
        $a['rows'] = 7;
        $a['cols'] = 100;
      }elseif($o[1] == 'text'){
        $a['type'] = 'offlajntext';
        $a['size'] = 20;
      }elseif($o[1] == 'url'){
        $a['type'] = 'nextendurl';
        $a['size'] = 20;
      }elseif($o[1] == 'list'){
        $a['type'] = 'offlajnlist';
      }elseif($o[1] == 'image'){
        $a['type'] = 'offlajnimagemanager';
        $a['folder'] = $this->row->sliderparams->get('uploaddir','/images/');
        $a['urlfield'] = 'text';
      }elseif($o[1] == 'easing'){
        $a['type'] = 'offlajneasing';
      }
      $el = $root->addChild('param', $a);
      if($o[1] == 'list'){
        $options = explode(',', $o[8]);
        for($x = 0; $x < count($options); $x++ ){
          $el->addChild('option', array('value' => $options[$x]))->setData($options[++$x]);
        }
      }
      $c = preg_replace('/{param ([a-z]*) "'.$o[2].'"( "(.*?)")?( "(.*?)")?}(([^{]*){\/param})?/', '<%=param'.$newname.'%>', $c);
    }

    $params = new OfflajnJParameter('');
    $params->setXML($root);
    $params->addElementPath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_smartslider'.DS.'oldparams');
    $params->bind($values);/*
    print_r($params);
    exit;*/
    $stack = & JsStack::getInstance();
    
    $render = '';
    if (!isset($this->control_name)) $this->control_name = "";
    if(!$isBlank){
      $render.= '<a class="editashtml" id="'.$this->control_name.$this->name.'ashtml"></a>';
    }
    $stack->startStack();
    $render.= $params->render('param');
    
    $htmlfield = $this->control_name.$this->name.'html';
    $render.= '<textarea name="param['.$htmlfield.']" style="display:none;" id="param'.$htmlfield.'"></textarea>';

    
    return array($c, $render, $params->getNumParams(), $stack->endStack(true), $fields, 'param'.$htmlfield, $this->control_name.$this->name.'ashtml');
  }
}
?>