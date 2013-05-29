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
//ACL
if(!defined('WP_ADMIN') && version_compare(JVERSION,'1.6.0','>=')) {
  if (!JFactory::getUser()->authorise('core.manage', 'com_smartslider')) {
   return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
  }
}
jimport( 'joomla.filesystem.folder' );

if(JFolder::exists(JPATH_SITE. DS .'modules'.DS.'mod_smartslider'.DS.'types'.DS.'accordionHorizontal') ){
 define ('SMARTSLIDER',1);
}else{
 define ('SMARTSLIDER',0);
}
if(JFolder::exists(JPATH_SITE. DS .'modules'.DS.'mod_smartslider'.DS.'types'.DS.'contentTabsHorizontal') ){
 define ('SMARTCONTENTTABS',1);
}else{
 define ('SMARTCONTENTTABS',0);
}
if(SMARTSLIDER && SMARTCONTENTTABS){
 define ('SMARTS',1);
}else{
 define ('SMARTS',0);
}

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_smartslider'.DS.'tables');

require_once(JPATH_SITE.DS.'modules'.DS.'mod_smartslider'.DS.'params'.DS.'offlajndashboard'.DS.'offlajndashboard.php');

require_once(JPATH_SITE.DS.'modules'.DS.'mod_smartslider'.DS.'helpers'.DS.'functions.php');

$lang = JFactory::getLanguage();
$lang->load('mod_smartslider', JPATH_SITE); 

$document =& JFactory::getDocument();
$document->addStyleSheet('components/com_smartslider/style.css');

// Require the base controller

require_once( dirname(__FILE__).DS.'controller.php' );

if(!function_exists('parseParams')){
  function parseParams(&$p, $vals){
    if(version_compare(JVERSION,'1.6.0','>=')) {
      $p->loadJSON($vals);
    }else{
      $p->loadIni($vals);
    }
  }
}

// Require specific controller if requested
if(($controller = JRequest::getWord('controller')) || $controller = 'slider') {
	$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
	if (file_exists($path)) {
		require_once $path;
	} else {
		$controller = '';
	}
}

// Create the controller
$classname	= 'SliderController'.$controller;

$controller	= new $classname( );

if(version_compare(JVERSION,'3.0.0','ge') && @$_REQUEST['format'] != 'raw') {
?>
<div id="content-box">
<?php
}
// Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) );

// Redirect if set by the controller
$controller->redirect();
if(version_compare(JVERSION,'3.0.0','ge') && @$_REQUEST['format'] != 'raw') {
?>
</div>
<?php
}