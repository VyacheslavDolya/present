<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
Nextendjimport('joomla.utilities.simplexml');

class JElementOfflajnSlideGenerator extends JOfflajnFakeElementBase {
  
  var $_moduleName = '';
  
  var $_name = 'OfflajnSlideGenerator';
  
  var $_types = array();
  
  var $p = null;
  
  var $params = null;
  
  function fetchElement($name, $value, &$node, $control_name) {

    $this->loadFiles();
    $this->p = & $this->_parent;
    $document = & JFactory::getDocument();
    if (version_compare(JVERSION, '1.6.0', '>=')) {
      $style = '#paramsgeneratorslidegenerate0, #paramsgeneratorslidegenerate1 {' . 'float: left;' . '}' . '#paramsgeneratorcontents {' . 'clear: both;' . '}' . '.selectdiv .limiterlbl {' . 'position: absolute;' . 'margin-left: 390px; }';
      $document->addStyleDeclaration($style);
    }
    $this->control_name = $control_name;
    $this->name = $name;
    $this->row = $this->_parent->row;
    $generator = $this->generateSelector();
    DojoLoader::addScript('
        new SlideGenerator({
        data: ' . json_encode($this->_types) . ',
        lang_choose: "' . JTEXT::_('Choose') . '",
        lang_addposition: "' . JTEXT::_('Add position') . '",
        lang_addcustom: "' . JTEXT::_('Add custom content') . '",
        lang_limit: "' . JTEXT::_('Limit') . '",
        lang_addtitle: "' . JTEXT::_('Add title for slides') . '",
        lang_default: "' . JTEXT::_('Default') . '",
        ext: "png"
      });
    ');
    return $generator;
  }
  
  function generateSelector() {

    $this->dir = JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_smartslider' . DS . 'oldparams' . DS . 'slidegenerator';
    $this->xmlfiles = JFolder::files($this->dir, '.xml$');
    $stack = & JsStack::getInstance();
    $options = array();

    
    $options[] = JHTML::_('select.option', '', '-' . JTEXT::_('Choose') . '-');
    $this->xmlsettings = array();
    $this->deniedfields = array();
    $this->editablefields = array();
    $this->contentpositions = array();
    $this->captionpositions = array();
    $this->_types["contents"] = new stdClass();
    $this->_types["contents"]->types = array();
    foreach($this->xmlfiles as $file) {
      $this->currenttype = JFile::stripExt($file);
      $this->_types[$this->currenttype] = new stdClass();
      $GLOBALS['scripts'] = array();
      $xmlfile = $this->dir . DS . $file;
      $params = new OfflajnJParameter('', $xmlfile);
      $params->addElementPath(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_smartslider' . DS . 'oldparams');
      $xml = new JSimpleXML();
      $xml->loadFile($this->dir . DS . $file);

      //check if component parameter added in the xml file
      
      //if yes, we check whether the required component installed to Joomla!

      if (file_exists(JPATH_ADMINISTRATOR . DS . 'components' . DS . $xml->document->settings[0]->component[0]->data())) {
        if ($xml->document->settings[0]->component[0]->data() == "com_virtuemart") {
          $version = "";
          if (file_exists(JPATH_SITE . DS . 'components' . DS . 'com_virtuemart' . DS . 'virtuemart_parser.php') && version_compare(JVERSION, '1.6.0', 'l')) {
            $version = "1";
          } else {
            $version = "2";
          }
          if ((int)$version == (int)$xml->document->settings[0]->version[0]->data()) {
            $options[] = JHTML::_('select.option', JFile::stripExt($file) , implode(' ', preg_split('/(?=[A-Z])/', ucfirst(JFile::stripExt($file)))));
          }
        } else {
          $options[] = JHTML::_('select.option', JFile::stripExt($file) , implode(' ', preg_split('/(?=[A-Z])/', ucfirst(JFile::stripExt($file)))));
        }

        //Allowed content templates
        if (isset($xml->document->settings[0]->allowedtemplates[0]->allowedtemplate)) foreach($xml->document->settings[0]->allowedtemplates[0]->allowedtemplate as $allowedtype) {
          $this->_types[JFile::stripExt($file) ]->allowedtype[] = $allowedtype->data();
        }

        //Fields which always shown when select the content template
        if (isset($xml->document->settings[0]->editablefields[0]->editablefield)) foreach($xml->document->settings[0]->editablefields[0]->editablefield as $editablefield) {
          $this->_types[JFile::stripExt($file) ]->editablefield[] = $editablefield->data();
          $this->editablefields[] = $editablefield->data();
        }

        //Fields which never shown, and not be selectable
        if (isset($xml->document->settings[0]->deniedfields[0]->deniedfield)) foreach($xml->document->settings[0]->deniedfields[0]->deniedfield as $deniedfield) {
          $this->_types[JFile::stripExt($file) ]->deniedfield[] = $deniedfield->data();
          $this->deniedfields[] = $deniedfield->data();
        }

        //Fields of the templates where user can define values
        if (isset($xml->document->settings[0]->contentpositions[0]->contentposition)) foreach($xml->document->settings[0]->contentpositions[0]->contentposition as $contentposition) {

          //$this->_types[JFile::stripExt( $file )]->contentposition[] = strtolower(preg_replace('/\s/', '', $contentposition->data()));
          $this->_types[JFile::stripExt($file) ]->contentposition[] = $contentposition->data();

          //$this->_types[JFile::stripExt( $file )]->contentposition[]->default = $contentposition->attributes('default');
          $this->contentpositions[] = strtolower(preg_replace('/\s/', '', $contentposition->data()));
        }

        //Captions
        if (isset($xml->document->settings[0]->captionpositions[0]->captionposition)) foreach($xml->document->settings[0]->captionpositions[0]->captionposition as $captionposition) {
          $this->_types[JFile::stripExt($file) ]->captionposition[] = $captionposition->data();
          $this->captionpositions[] = strtolower(preg_replace('/\s/', '', $captionposition->data()));
        }

        //Values which user can set to different positions
        if (isset($xml->document->settings[0]->contentvalues[0])) foreach($xml->document->settings[0]->contentvalues[0]->children() as $contentvalue) {
          $this->_types[JFile::stripExt($file) ]->contentvalue->data[] = $contentvalue->data();
          $this->_types[JFile::stripExt($file) ]->contentvalue->name[] = $contentvalue->name();
        }

        //Can make captions for slides or not
        if (isset($xml->document->settings[0]->showcaptions)) {
          $this->_types[JFile::stripExt($file) ]->showcaptions = $xml->document->settings[0]->showcaptions[0]->data();
        }

        //set the slides title, and store default value
        if (isset($xml->document->settings[0]->showtitle)) {
          $this->_types[JFile::stripExt($file) ]->showtitle[] = $xml->document->settings[0]->showtitle[0]->data();
          $this->_types[JFile::stripExt($file) ]->showtitle[] = $xml->document->settings[0]->showtitle[0]->attributes('default');
        }

        //default content elements
        if (isset($xml->document->settings[0]->defaultcontents[0])) foreach($xml->document->settings[0]->defaultcontents[0]->children() as $defaultcontent) {
          $this->_types[JFile::stripExt($file) ]->defaultcontent->data[] = $defaultcontent->data();
          $this->_types[JFile::stripExt($file) ]->defaultcontent->position[] = $defaultcontent->name();
        }

        //default caption elements
        if (isset($xml->document->settings[0]->defaultcaptions[0])) foreach($xml->document->settings[0]->defaultcaptions[0]->children() as $defaultcaption) {
          $this->_types[JFile::stripExt($file) ]->defaultcaption->data[] = $defaultcaption->data();
          $this->_types[JFile::stripExt($file) ]->defaultcaption->position[] = $defaultcaption->name();
        }
        $params->bind($this->_parent->toArray());

        $stack->startStack();
        $this->_types[JFile::stripExt($file) ]->html = $params->render('params') . '<div style="clear:both;"></div>';
        $this->_types[JFile::stripExt($file) ]->script = implode('', $GLOBALS['scripts']) . $stack->endStack(true);
        $this->generateTypeFilteredTemplates("contents", true);
        $this->generateTypeFilteredTemplates("captions", true);
      }
    }
    $this->_types["contents"]->html = $this->generateTemplateSelector("contents");
    $this->_types["captions"]->html = $this->generateTemplateSelector("captions");
    $this->_types["selectedcontent"] = $this->_parent->get('generatorcontents');
    $this->_types["sliderdatas"] = $this->_parent->toArray();
    return JHTML::_('select.genericlist', $options, 'params' . $this->control_name . '[generator]', 'class="inputbox"', 'value', 'text', $this->_parent->get('generator'));
  }

  //generate the template selectors(content, caption)
  
  function generateTemplateSelector($templatetype) {

    $a = $this->generateTypeFilteredTemplates($templatetype);
    $options = $a[0];
    $html = $a[1];
    if ($templatetype == "captions") {
      $val = "";
      if ($this->_parent->get('generatorcaptions')) {
        $val = $this->_parent->get('generatorcaptions');
      } else {
        $val = "blank";
      }
      return JHTML::_('select.genericlist', $options, 'params[generator' . $templatetype . ']', 'class="inputbox"', 'value', 'text', $val) . $html;
    } else {
      return JHTML::_('select.genericlist', $options, 'params[generator' . $templatetype . ']', 'class="inputbox"', 'value', 'text');
    }
  }
  
  function generateTypeFilteredTemplates($templatetype, $typewide = false) {

    $document = & JFactory::getDocument();
    $this->templatedir = JPATH_SITE . DS . 'modules' . DS . 'mod_smartslider' . DS . $templatetype;
    $files = JFolder::files($this->templatedir, '.phtml');
    $imgurl = JURI::base() . '../modules/mod_smartslider/' . $templatetype . '/';
    $options = array();
    $html = '<div style="clear:both"></div>';
    $x = 0;
    if (is_array($files)) {
      foreach($files as $file) {
        $content = file_get_contents($this->templatedir . DS . $file);
        $file = JFile::stripExt($file);
        $this->_types[$templatetype]->types[] = $file;
        $lfile = strtolower($file);
        $this->_types[$lfile] = new stdClass();
        $isBlank = false;
        if ($lfile == 'blank') $isBlank = true;

        //store parsed items to js
        $parsed = $this->parseTemplate($content, $isBlank, $lfile, $templatetype);
        if ($typewide) {
          $this->_types[$this->currenttype]->{$lfile} = new stdClass();
          $this->_types[$this->currenttype]->{$lfile}->html = $parsed;
        } else {
          $this->_types[$lfile]->html = $parsed;
        }
        $pattern = '/(.*?[a-z]{1})([A-Z]{1}.*?)/';
        $replace = '${1} ${2}';
        $name = preg_replace($pattern, $replace, $file);
        $this->_types[$lfile]->name = $name;
        $this->_types[$lfile]->lname = $lfile;
        $this->_types[$lfile]->img = '<img id="param' . $templatetype . $x . '" onclick="var el=odojo.byId(\'paramsgenerator' . $templatetype . '\'); el.callChange(' . $x . ');" class="miniimage" src="' . $imgurl . $file . '.png" />';
        if ($templatetype == "captions") {
          $html.= '<img id="param' . $templatetype . $x . '" onclick="var el=odojo.byId(\'paramsgenerator' . $templatetype . '\'); el.selectedIndex = ' . $x . ';el.callChange();" class="miniimage" src="' . $imgurl . $file . '.png" />';
          $options[] = JHTML::_('select.option', $lfile, ucfirst($name));
        }
        $x++;
      }
    }
    return array(
      $options,
      $html
    );
  }

  //Parse .phtml files of the template
  
  function parseTemplate($c, $isBlank = false, $lfile, $template) {

    preg_match_all('/{param ([a-z]*) "(.*?)"( "(.*?)")?( "(.*?)")?}(([^{]*){\/param})?/', $c, $out, PREG_SET_ORDER);
    $filtered = array();
    $this->_types[$lfile]->fields = array();
    foreach($out AS $o) {
      if (!isset($filtered[$o[2]])) $filtered[$o[2]] = $o;
    }
    $xml = new JSimpleXML();
    $xml->loadString('<params addPath="/administrator/components/com_smartslider/oldparams"></params>');
    $root = & $xml->document;
    $fields = array();
    $values = $this->row->params->toArray();
    if ($template == "contents") $this->_types[$lfile]->fields[] = "slidetitle"; //store slidetitle for content templates fields to work properly when select contentpositions

    foreach($filtered AS $o) {
      $name = preg_replace('/[^a-z]/', '', strtolower($o[2]));
      $newname = $this->name . substr($template, 0, -1) . $name;
      $name2 = substr($template, 0, -1) . $name;
      $fields[] = $newname;
      if (in_array($name2, $this->contentpositions)) {
        $this->_types[$lfile]->fields[] = $name2; //store name of the current template's fields

        
      }
      if (in_array($name2, $this->captionpositions)) {
        $this->_types[$lfile]->fields[] = $name2; //store name of the current template's fields

        
      }

      if (((!in_array($name2, $this->deniedfields)) && (in_array($name2, $this->editablefields)))) {
        if (isset($values[$newname])) $o[4] = $values[$newname];
        $a = array(
          'name' => $newname,
          'type' => $o[1],
          'default' => isset($o[4]) ? $o[4] : '',
          'label' => $o[2],
          'description' => isset($o[6]) ? $o[6] : ''
        );
        if ($o[1] == 'textarea') {
          $a['rows'] = 7;
          $a['cols'] = 60;
        } elseif ($o[1] == 'text') {
          $a['size'] = 60;
        }
        $el = $root->addChild('param', $a);
        if ($o[1] == 'list') {
          $options = explode(',', $o[8]);
          for ($x = 0;$x < count($options);$x++) {
            $el->addChild('option', array(
              'value' => $options[$x]
            ))->setData($options[++$x]);
          }
        }
        $c = preg_replace('/{param ([a-z]*) "' . $o[2] . '"( "(.*?)")?( "(.*?)")?}(([^{]*){\/param})?/', '<%=param' . $newname . '%>', $c);
      }
    }
    $params = new OfflajnJParameter('');
    $params->setXML($root);
    $params->bind($values);
    $GLOBALS['scripts'] = array();
    $render = '';
    $render.= $params->render('params');
    $htmlfield = $this->control_name . $this->name . 'html';
    $render.= '<textarea name="params[' . $htmlfield . ']" style="display:none;" id="params' . $htmlfield . '"></textarea>';
    return array(
      $c,
      $render,
      $params->getNumParams() ,
      implode('', $GLOBALS['scripts']) ,
      $fields,
      'param' . $htmlfield,
      $this->control_name . $this->name . 'ashtml'
    );
  }
}
if (version_compare(JVERSION, '1.6.0', 'ge')) {
  
  class JFormFieldOfflajnSlideGenerator extends JElementOfflajnSlideGenerator {
  }
}
?>