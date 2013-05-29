<?php 
/*------------------------------------------------------------------------
# smartslider - Smart Slider
# ------------------------------------------------------------------------
# author    Roland Soos 
# copyright Copyright (C) 2011 Offlajn.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.offlajn.com
-------------------------------------------------------------------------*/
?>
<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
require_once('buttons'.DS.'help.php');

if(version_compare(JVERSION,'3.0.0','l') && !class_exists('JControllerLegacy')){
  class JControllerLegacy extends JController{};
  jimport( 'joomla.application.component.view' );
  class JViewLegacy extends JView{};
  jimport( 'joomla.application.component.model' );
  class JModelLegacy extends JModel{};
}

class SliderController extends JControllerLegacy{
	function display(){
    
    if (SMARTSLIDER) JSubMenuHelper::addEntry(JText::_('Dashboard'), 'index.php?option=com_smartslider', !isset($_REQUEST['controller']) || $_REQUEST['controller'] == '');
    JSubMenuHelper::addEntry(JText::_(SMARTS?'Sliders and Tabbers':(SMARTSLIDER?'Sliders':'Tabbers')), 'index.php?option=com_smartslider&controller=slider', isset($_REQUEST['controller']) && $_REQUEST['controller'] == 'slider');
    JSubMenuHelper::addEntry(JText::_(SMARTS?'Slides and Tabs':(SMARTSLIDER?'Slides':'Tabs')), 'index.php?option=com_smartslider&controller=slide', isset($_REQUEST['controller']) && $_REQUEST['controller'] == 'slide');
    //if (SMARTSLIDER) JSubMenuHelper::addEntry(JText::_('Slide generator'), 'index.php?option=com_smartslider&controller=slidegenerator', isset($_REQUEST['controller']) && $_REQUEST['controller'] == 'slidegenerator');
    
    if(!defined('WP_ADMIN') ){
      //ACL
        if(version_compare(JVERSION,'1.6.0','>=')) {
          JToolBarHelper::preferences( 'com_smartslider');
        }
      //ACL end
          
      /* SmartInsert plugin checker
      * If plugin not allowed, the slidegenerator and smartinsert feature could not be used
      * If not allowed, controller.php send a notice to the back-end user.
      */                     
      $db = & JFactory::GetDBO();
      $link = "";
      if (version_compare(JVERSION,'3.0.0','>=')) {
        $query = "SELECT ".$db->qn('enabled').", ".$db->qn('extension_id')
                  ." FROM ".$db->qn('#__extensions')
                  ." WHERE ".$db->qn('element')." = ".$db->quote('smartsliderinsert');
        $link = JRoute::_( 'index.php?option=com_plugins&view=plugin&layout=edit&task=plugin.edit&extension_id=' );
      }elseif (version_compare(JVERSION,'1.6.0','>=')) {
        $query = "SELECT ".$db->nameQuote('enabled').", ".$db->nameQuote('extension_id')
                  ." FROM ".$db->nameQuote('#__extensions')
                  ." WHERE ".$db->nameQuote('element')." = ".$db->quote('smartsliderinsert');
        $link = JRoute::_( 'index.php?option=com_plugins&view=plugin&layout=edit&task=plugin.edit&extension_id=' );
      } else {
        $query = "SELECT ".$db->nameQuote('published').", ".$db->nameQuote('id')
                  ." FROM ".$db->nameQuote('#__plugins')
                  ." WHERE ".$db->nameQuote('element')." = ".$db->quote('smartsliderinsert');
        $link = JRoute::_( 'index.php?option=com_plugins&view=plugin&client=site&task=edit&cid[]=' );
      }
      $db->setQuery($query);
      $result = $db->LoadRow();
      if ((int)$result[0] == 0) {
        JError::raiseNotice( 100, JText::_('Smartinsert plugin not enabled!') .'<a href=\''.$link.$result[1].'\'>'.JText::_( ' Click here' ).'</a>'. JText::_(' to enable plugin. ') );
      }
    }
        
    if(!isset($_REQUEST['controller']) || $_REQUEST['controller'] == ''){
      JToolBarHelper::title(   JText::_( SMARTS?'Smart Slider Dashboard':(SMARTSLIDER?'Smart Slider Dashboard':'Smart Content Tabs Dashboard') ), 'generic.png' );
      
      $url = 'http://demo.nextendweb.com/smartslider/dashboard.html?tmpl=component';

      if(defined('WP_ADMIN')) $url = 'http://demo.nextendweb.com/smartslider/dashboard.html?tmpl=component';
      
      echo '
<iframe frameBorder="0" src="'.$url.'" width="696" height="595">
  <p>Your browser does not support iframes.</p>
</iframe>';
    }else{
		  parent::display();
		}
    $bar = & JToolBar::getInstance('toolbar');
		$bar->appendButton( 'HelpSlider');
	}
}
//echo JText::_('Error: You must specify the slider first. Use the "Add new Slide" button.');