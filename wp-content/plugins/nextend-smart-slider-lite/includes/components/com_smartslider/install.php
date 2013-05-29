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

jimport('joomla.installer.helper');
/*
function com_install(){
	$installer = new Installer();	
	echo "<H3>Installing Offlajn Smart Slider component and module Success</h3>"; 
	if(version_compare(JVERSION,'1.7.0','ge')) {
    $installer->vers = 16;
	} elseif(version_compare(JVERSION,'1.6.0','ge')) {
    $installer->vers = 16;
	} else {
    $installer->vers = 15;
	}
	$installer->install();
	return true;

}
function com_uninstall(){
	$installer = new Installer();	
	$installer->uninstall();
	return true;
}*/

class com_smartslider extends JObject {

	function install() {
		if (!$this->executeSQL('install')) {
			return;
		}
	}

	function uninstall() {
  }

	function executeSQL($_sqlf){

		jimport('joomla.installer.helper');
		$_db = JFactory::getDBO();

		$_sqlf2 = (JPATH_ADMINISTRATOR. DS .'components'.DS.'com_smartslider'.DS.$_sqlf.'.sql');

    if(!$this->installSQL($_sqlf2)){
      return false;
    }

		if(version_compare(JVERSION,'1.6.0','ge')) {
			$_sqlf .= '16';
      if(!JFolder::exists(JPATH_SITE. DS .'modules'.DS.'mod_smartslider'.DS.'types'.DS.'accordionHorizontal') ){
        if(!$this->installSQL("
            DELETE FROM #__menu 
            WHERE parent_id = '1001001' AND title LIKE 'COM_SMARTSLIDER_MENU';
            
            UPDATE #__menu 
            SET parent_id='1001001'
            WHERE title LIKE 'COM_SMARTSLIDER_MENU';")){
          return false;
        }
      }else{
        if(!$this->installSQL("
            DELETE FROM #__menu 
            WHERE parent_id = '1001001' AND title LIKE 'COM_SMARTSLIDER_MENU';")){
          return false;
        }
      }

		} else {
			$_sqlf .= '15';
      if(!JFolder::exists(JPATH_SITE. DS .'modules'.DS.'mod_smartslider'.DS.'types'.DS.'accordionHorizontal') ){
        if(!$this->installSQL("
            UPDATE #__components 
            SET parent='1001001'
            WHERE link LIKE 'option=com_smartslider';")){
          return false;
        }
      }else{
        if(!$this->installSQL("
            UPDATE #__components 
            SET parent='0'
            WHERE link LIKE 'option=com_smartslider';")){
          return false;
        }
      }
		}

		$_sqlf = (JPATH_ADMINISTRATOR. DS .'components'.DS.'com_smartslider'.DS.$_sqlf.'.sql');

    if(!$this->installSQL($_sqlf)){
      return false;
    }
    
		return true;
	}
	
	function installSQL($_sqlf){
    if (is_file($_sqlf) && file_exists($_sqlf) ) {
      $_sqlf = file_get_contents($_sqlf);
    }
    $_db = JFactory::getDBO();
		$_qr = JInstallerHelper::splitSql($_sqlf);

		foreach ($_qr as $_q) {
			$_q = trim($_q);
			if ($_q != '' && $_q{0} != '#') {
				$_db->setQuery($_q);
				if (!$_db->query()) {
					JError::raiseWarning(500, 'JInstaller::install: '.JText::_('SQL Error')." ".$_db->stderr(true));
					return false;
				}
			}
		}
		return true;
  }
}