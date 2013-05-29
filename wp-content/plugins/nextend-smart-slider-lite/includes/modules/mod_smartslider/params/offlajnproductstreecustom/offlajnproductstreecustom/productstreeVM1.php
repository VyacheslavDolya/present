<?php
  require_once(JPATH_ROOT.DS."administrator".DS."components".DS."com_virtuemart".DS."classes".DS."ps_database.php");
  
  class JElementOfflajnProductsTreeCustom extends OfflajnProductsTreeCustom{

    function initDB(){$this->db = new ps_DB();}

    function initCategories() {
      $q = 'SELECT DISTINCT c.category_name AS name, c.category_id AS cid, cx.category_parent_id AS pid ';
  	  $q.= 'FROM #__{vm}_category AS c INNER JOIN #__{vm}_category_xref AS cx ON c.category_id = cx.category_child_id ';
  	  $q.= 'WHERE c.category_publish = \'Y\' ORDER BY cx.category_parent_id';
    	$this->db->setQuery($q);
    	$this->cats = $this->db->loadAssocList();
    }

    function initProducts(){
      $q = 'SELECT DISTINCT p.product_name AS name, p.product_id AS id, pc.category_id AS cid ';
      $q.= 'FROM #__{vm}_product AS p INNER JOIN #__{vm}_product_category_xref AS pc ON p.product_id = pc.product_id ';
      $q.= 'WHERE p.product_publish = \'Y\' ORDER BY pc.category_id';
  		$this->db->setQuery($q);
  		$this->prods = $this->db->loadAssocList();
    }
  }

  if(version_compare(JVERSION,'1.6.0','ge')) {
    class JFormFieldOfflajnProductsTreeCustom extends JElementOfflajnProductsTreeCustom {}
  }
?>