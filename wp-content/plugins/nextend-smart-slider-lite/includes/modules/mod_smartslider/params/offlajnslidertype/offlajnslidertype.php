<?php
defined('_JEXEC') or die('Restricted access');
Nextendjimport('joomla.utilities.simplexml');

class JElementOfflajnSliderType extends JElementOfflajnList {
  
  var $_moduleName = '';
  
  var $_name = 'OfflajnSliderType';
  
  var $_types = array();
  
  function universalfetchElement($name, $value, &$node) {

    $this->loadFiles();
    $this->loadFiles('Offlajnlist');
    $this->typesDir = JPATH_SITE . DS . 'modules' . DS . 'mod_smartslider' . DS . 'types';
    $typeSelector = $this->generateTypeSelector($name, $value, $node);
    if(defined('WP_ADMIN')){
        $url = admin_url('admin.php?page=smartslider.php/slider');
    }else{
        $url = JUri::root(true) . '/administrator/index.php';
    }
    DojoLoader::addScript('
      var theme = new ThemeConfigurator({
        data: ' . json_encode($this->_types) . ',
        cType: "' . $this->sliderType . '",
        cTheme: "' . $this->sliderTheme . '",
        url: "' . $url . '"
      });
    ');
    return $typeSelector;
  }
  
  function generateTypeSelector($name, $value, &$lnode) {

    $types = JFolder::folders($this->typesDir);
    $stack = & JsStack::getInstance();
    $options = array();
    preg_match('/(.*)\[([a-zA-Z0-9]*)\]$/', $name, $out);
    $out[1] = str_replace(array(
      "[",
      "]"
    ) , '', $out[1]);
    @$control = $out[1];
    @$orig_name = $out[2];
    $data = $this->_parent->toArray();
    $_SESSION['slidertype'] = array(
      'typesdir' => $this->typesDir,
      'formdata' => $data,
      'c' => 'params',
      'module' => $this->_moduleName
      );
      $this->sliderType = isset($data['type']) ? $data['type'] : '';
      $this->sliderTheme = isset($data['theme']) ? $data['theme'] : '';
      if (is_array($types)) {
        foreach($types as $type) {
          $stack->startStack();
          $lnode->addChild('option', array(
            'value' => $type
          ))->setData(implode(' ', preg_split('/(?=[A-Z])/', ucfirst($type))));
          $this->_types[$type] = new stdClass();
          $key = md5($_SERVER['QUERY_STRING'] . $type);
          $_SESSION['slidertype']['forms'][$key] = $type;
          $this->_types[$type]->html = $key;

          /* Themes start */
          $this->_types[$type]->themes = '';
          $themesDir = $this->typesDir . DS . $type;
          $themes = JFolder::folders($themesDir);
          $themexml = new JSimpleXML();
          $txml = <<<EOD
<params>
  <param type="offlajnlist" default="elegant" label="Theme" />
</params
EOD;
          $themexml->loadString($txml);
          $themefieldxml = $themexml->document->param[0];
          $themefieldxml->addAttribute('name', 'theme');
          if (is_array($themes)) {
            foreach($themes as $theme) {
              $themefieldxml->addChild('option', array(
                'value' => $theme
              ))->setData(ucfirst($theme));
            }
          }
          $this->_types[$type]->chooser = new stdClass();
          $params = new OfflajnJParameter('');
          $params->setXML($themexml->document);
          if ($type == $data['type']) {
            $params->bind($data);
          } else {
            $params->bind(array(
              'theme' => $themes[0]
            ));
          }
          $this->_types[$type]->chooser->html = $params->render('params');
          $this->_types[$type]->script = $stack->endStack(true);
          $this->_types[$type]->themes = new stdClass();
          if (is_array($themes)) {
            foreach($themes as $theme) {
              $this->_types[$type]->themes->$theme = new stdClass();
              $key = md5($_SERVER['QUERY_STRING'] . $theme);
              $_SESSION['slidertype'][$type]['theme'][$key] = $theme;
              $this->_types[$type]->themes->$theme->html = $key;

              /*
              $stack->startStack();
              
              $themeparams = new OfflajnJParameter( '', $this->typesDir . DS . $type . DS . $theme . DS . 'theme.xml');
              
              $themeparams->bind($this->_parent->toArray());
              
              $this->_types[$type]->themes->$theme->html = $themeparams->render('params');
              $this->_types[$type]->themes->$theme->script = $stack->endStack(true);*/
            }
          }

          /* Themes end */
        }
      }
      return parent::universalfetchElement($name, is_array($value) ? $value["type"] : $value, $lnode);
    }
  }
?>