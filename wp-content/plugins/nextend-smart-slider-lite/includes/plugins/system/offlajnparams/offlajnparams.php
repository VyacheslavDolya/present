<?php
/*-------------------------------------------------------------------------
# com_smartslider - Smart Slider
# -------------------------------------------------------------------------
# @ author    Roland Soós
# @ copyright Copyright (C) 2012 Offlajn.com  All Rights Reserved.
# @ license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# @ website   http://www.offlajn.com
-------------------------------------------------------------------------*/
?><?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );
if(version_compare(JVERSION,'3.0.0','ge')) require_once(JPATH_PLUGINS.DIRECTORY_SEPARATOR.'system'.DIRECTORY_SEPARATOR.'nextendjoomla3compat'.DIRECTORY_SEPARATOR.'nextendjoomla3compat.php');

require_once(dirname(__FILE__).DS.'imageuploader.php');

require_once(dirname(__FILE__).DS.'compatibility.php');

require_once(dirname(__FILE__).DS.'formrenderer.php');


class  plgSystemOfflajnParams extends JPlugin
{
	function plgSystemOfflajnParams(& $subject, $config){
		parent::__construct($subject, $config);
	}

  function addNewTab($id, $title, $text, $position = 'last', $class=''){
    global $offlajnParams;
    if($position != 'first') $position = 'last';
    $offlajnParams[$position][] = self::renderNewTab($id, $title, $text, $class);
  }
  
  function renderNewTab($id, $title, $text, $class=''){
    ob_start();
    if(version_compare(JVERSION,'1.6.0','ge'))
      include(dirname(__FILE__).DS.'tab16.tpl.php');
    else
      include(dirname(__FILE__).DS.'tab15.tpl.php');
      
    return ob_get_clean();
  }
	
}
