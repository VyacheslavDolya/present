<?php

function smartslider_install() {
    global $wpdb;
    if ( $wpdb->get_var( "SHOW TABLES LIKE '" . $wpdb->offlajn_slider . "'" ) != $wpdb->offlajn_slider ) {
      require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'softinit.php');
      
      jimport('joomla.installer.helper');
      
  		$_db = JFactory::getDBO();
  
  		$_sqlf = (JPATH_ADMINISTRATOR. DS .'components'.DS.'com_smartslider'.DS.'install.sql');

  		$_qr = JInstallerHelper::splitSql(file_get_contents($_sqlf));
  
  		foreach ($_qr as $_q) {
  			$_q = trim($_q);
  			if ($_q != '' && $_q{0} != '#') {
  				$_db->setQuery($_q);
  				if (!$_db->query()) {
  				}
  			}
  		}
      
      $_sqlf = (JPATH_ADMINISTRATOR. DS .'components'.DS.'com_smartslider'.DS.'install_wp.sql');

  		$_qr = JInstallerHelper::splitSql(file_get_contents($_sqlf));
  
  		foreach ($_qr as $_q) {
  			$_q = trim($_q);
  			if ($_q != '' && $_q{0} != '#') {
  				$_db->setQuery($_q);
  				if (!$_db->query()) {
  				}
  			}
  		}
  		return true;
    }
}
function smartslider_deactivate() {

}

?>