<?php

/* ------------------------------------------------------------------------
# smartslider - Smart Slider
# ------------------------------------------------------------------------
# author    Roland Soos
# copyright Copyright (C) 2011 Offlajn.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.offlajn.com
------------------------------------------------------------------------- */
?>
<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class sliderViewslide extends JViewLegacy {
  
  function display($tpl = null) {

    global $mainframe;
    $id = JRequest::getInt('id', 0);
    ($id > 0) ? $title = 'Edit ' : $title = 'Add ';
    $model = $this->getModel();
    $user = & JFactory::getUser();
    $model->setId($id);
    if ($id > 0) $model->getData()->checkout($user->get('id'));
    $row = $model->getDataWithSlider();
    $bar = & JToolBar::getInstance('toolbar');
    if ($id > 0) {
      $url = JRoute::_('index.php?option=com_smartslider&controller=slider&task=edit&id=' . $row->slider);
      $bar->appendButton('Link', 'back2slider', 'Back to Slider', $url);
    }
    $document = & JFactory::getDocument();
    DojoLoader::r('dojo.fx.easing');
    DojoLoader::addScriptFile(DS . 'modules/mod_smartslider/captions/captions.js');
    DojoLoader::addScriptFile((!defined('WP_ADMIN') ? DS . 'administrator' : '') . DS . 'components' . DS . 'com_smartslider' . DS . 'js' . DS . 'live.js');
    JToolBarHelper::title(JText::_('Slide Manager') . ' - ' . JText::_($title . 'slide') , 'generic.png');
    JToolBarHelper::save();
    if (version_compare(JVERSION, '1.7.0', 'ge')) {
      JToolBarHelper::save2new();
    } else {
      $bar = & JToolBar::getInstance('toolbar');
      $bar->appendButton('Standard', 'savenew', 'Save & New', 'save2new', false, false);
    }
    $bar = & JToolBar::getInstance('toolbar');
    $bar->appendButton('Standard', 'savenew', 'Save as New', 'saveasnew', false, false);
    JToolBarHelper::apply();
    JToolBarHelper::cancel();
    if (SMARTCONTENTTABS) {
      $xmlfile = dirname(__FILE__) . DS . '..' . DS . '..' . DS . 'forms' . DS . 'tab.xml';
    }
    if (SMARTSLIDER) {
      $xmlfile = dirname(__FILE__) . DS . '..' . DS . '..' . DS . 'forms' . DS . 'slide.xml';
    }
    $params = new OfflajnJParameter('', $xmlfile);
    $params->addElementPath(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_smartslider' . DS . 'params');
    $row->sliderparams = new OfflajnJParameter($row->sliderparams);
    if (!property_exists($row, 'params')) $row->params = '';
    $p = $row->params;
    $row->params = new OfflajnJParameter('');
    parseParams($row->params, $p);
    $params->row = & $row;
    $row->sliderproperties = $row->slidername . '|*|' . $row->type . '|*|' . $row->theme;
    if (isset($_SESSION['slideparams']) && count($_SESSION['slideparams']) > 0) {
      $params->bind($_SESSION['slideparams']);
      parseParams($params, $_SESSION['slideparams']['params']);
      parseParams($row->params, $_SESSION['slideparams']['params']);
      unset($_SESSION['slideparams']);
    } else {
      $params->bind($row);
      $params->bind($row->params);
    }
    if (JRequest::getVar('task') == 'add') {
      $row->slider = JRequest::getInt('sliderid');
    }
    $this->assignRef('defaultparams', $params->render('params'));
    $this->assignRef('contentparams', $params->render('params', 'content'));
    $this->assignRef('captionparams', $params->render('params', 'caption'));
    $this->assignRef('row', $row);
    ob_start();
    include (JPATH_SITE . DS . 'modules' . DS . 'mod_smartslider' . DS . 'live_demo.php');
    $live = ob_get_clean();
    $document = & JFactory::getDocument();
    $size = OfflajnValueParser::parse($row->sliderparams->get('size'));

    DojoLoader::addScript('
        document.live = ' . json_encode($live) . ';
        var tips = dojo.query(".hasTip", dojo.byId("defaultparams"));
        dojo.forEach(tips, function(el, i){
          new ofTip({node: el});
        } );
        new SlideLive({
          width: ' . $size[1][0] . ',
          height: ' . $size[2][0] . ',
          lang_insert: "' . JTEXT::_('insert') . '",
          lang_replace: "' . JTEXT::_('replace') . '",
          ajaxRefresh: ' . (defined('WP_ADMIN') ? 0 : 1) . '
        });
    ');
    parent::display($tpl);
  }
}
