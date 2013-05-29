<?php
  if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php');
  $config = VmConfig::loadConfig();
  
  class JElementOfflajnProductsTreeCustom extends OfflajnProductsTreeCustom{

    function initDB(){$this->db =& JFactory::getDBO();}

    function initCategories() {
      $q = 'SELECT DISTINCT c.category_name AS name, c.virtuemart_category_id AS cid, cc.category_parent_id AS pid ';
      $q.= 'FROM #__virtuemart_categories_'.VMLANG.' AS c ' ;
      $q.= 'INNER JOIN #__virtuemart_category_categories AS cc ON c.virtuemart_category_id = cc.category_child_id ';
      $q.= 'INNER JOIN #__virtuemart_categories AS cs ON c.virtuemart_category_id = cs.virtuemart_category_id ';
      $q.= 'WHERE cs.published = 1 ORDER BY cc.category_parent_id';
    	$this->db->setQuery($q);
    	$this->cats = $this->db->loadAssocList();
    }

    function initProducts(){
      $q = 'SELECT DISTINCT p.product_name AS name, p.virtuemart_product_id AS id, pc.virtuemart_category_id AS cid ';
      $q.= 'FROM #__virtuemart_products_'.VMLANG.' AS p ';
      $q.= 'INNER JOIN #__virtuemart_product_categories AS pc ON p.virtuemart_product_id = pc.virtuemart_product_id ';
      $q.= 'INNER JOIN #__virtuemart_products AS ps ON p.virtuemart_product_id = ps.virtuemart_product_id AND ps.published = 1 ';
      $q.= 'ORDER BY pc.virtuemart_category_id';
  		$this->db->setQuery($q);
  		$this->prods = $this->db->loadAssocList();
    }
  }

  if(version_compare(JVERSION,'1.6.0','ge')) {
    class JFormFieldOfflajnProductsTreeCustom extends JElementOfflajnProductsTreeCustom {}
  }
?>