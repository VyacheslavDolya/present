<?php
/*-------------------------------------------------------------------------
# com_smartslider - Smart Slider
# -------------------------------------------------------------------------
# @ author    Roland Soos
# @ copyright Copyright (C) 2013 Offlajn.com  All Rights Reserved.
# @ license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# @ website   http://www.offlajn.com
-------------------------------------------------------------------------*/
?><?php
  if(file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart')) {
    //$virtuemart_xml = &JFactory::getXMLParser('Simple');
    //$virtuemart_xml->loadFile(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS."virtuemart.xml");
    if(!file_exists(JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'virtuemart_parser.php')) {
      if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'config.php');
        $config= VmConfig::loadConfig();    
    }
  }
  if(!defined('VMLANG'))
      define("VMLANG", "");
$sqlTables = array( 
  "content" => array("com_content", "Articles", "id", "title", "introtext", "alias"),  
  "users" => array("com_users", "Users details", "id", "email", "username"),
  "k2_items" => array("com_k2", "K2 Articles", "id", "introtext", "title"),
  "k2_categories" => array("com_k2", "K2 categories", "id", "name"),
  "vm_product" => array("com_virtuemart", "Virtuemart Product details" ,"product_id", "product_sku", "product_s_desc", "product_desc", "product_name"),
  "phocagallery_categories" => array("com_phocagallery", "Phocagallery categories", "id", "title", "description"),
  "phocagallery" => array("com_phocagallery", "Phocagallery images", "id", "title", "description", "filename"),
  "easyblog_post" => array("com_easyblog", "Easy Blog", "id", "title", "intro", "content"),
  "igallery_img" => array("com_igallery", "Igallery images", "id", "filename", "description"),
  "community_events" => array("com_community", "JomSocial events", "id", "title", "location", "summary", "description"),
  "virtuemart_products_".VMLANG => array("com_virtuemart", "Virtuemart2 Product details" ,"virtuemart_product_id", "product_s_desc", "product_desc", "product_name")
);  

?>