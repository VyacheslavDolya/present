<?php
/*-------------------------------------------------------------------------
# com_smartslider - Smart Slider
# -------------------------------------------------------------------------
# @ author    Roland Soós
# @ copyright Copyright (C) 2013 Nextendweb.com  All Rights Reserved.
# @ license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# @ website   http://www.nextendweb.com
-------------------------------------------------------------------------*/
?><?php
defined('_JEXEC') or die('Restricted access');
  if (!class_exists("ProductItem")) {
    class ProductItem {
    	var $id, $label, $selected, $parent, $pid;
    	
    	function ProductItem($id, $label, $selected, $parent, $pid = 0) {
    	  $this->id = $id;
    	  $this->pid = $pid;
    	  $this->label = $label;
    	  $this->selected = $selected;
    	  $this->parent = $parent;
    	}
    }
  }
  
  if (!class_exists("CategoryItem")) {
    class CategoryItem extends ProductItem {
    	var $children = null;
    
    	function CategoryItem($id, $label, $selected, $parent) {
    	  $this->ProductItem($id, $label, $selected, $parent);
    	}
    }
  }
  
  class OfflajnProductsTreeCustom extends JOfflajnFakeElementBase{
  	var $db, $cats, $prods, $selected;
  
    var $_name = 'OfflajnProductsTreeCustom';
    
    function initDB() {}
  	function initCategories() {}
  	function initProducts() {}
  	
  	function &getCategories($pid) {
  	  $cats = array();
  	  foreach($this->cats as $cat) {
  	    if ($cat['pid'] >  $pid) break;
  	    if ($cat['pid'] == $pid)
  				$cats[] = new CategoryItem($cat['cid'], stripcslashes($cat['name']), in_array($cat['cid'], $this->selected), $pid);
  		}
  		return $cats;
  	}
  	
  	function &getProducts($cid) {
  	  $prods = array();
  	  foreach($this->prods as $prod) {
  	    if ($prod['cid'] >  $cid) break;
  	    $id = $cid.'-'.$prod['id'];
  	    if ($prod['cid'] == $cid)
  				$prods[] = new ProductItem($id, stripcslashes($prod['name']), in_array($id, $this->selected), $cid, $prod['id']);
  		}
  		return $prods;
  	}
  	
  	function createTree($cid = 0, &$children = null) {
  		$cats = $this->getCategories($cid);
  	  foreach ($cats as $cat) {
  			$this->createTree($cat->id, $cat->children);
  		}
  		if ($cid) $children = array_merge($cats, $this->getProducts($cid));
  		else return $cats;
  	}
  
  	function universalfetchElement($name, $value, &$node) {

      $path = JURI::root(true)."/modules/mod_scroller/params";
  	  $this->initDB();
  		$this->initCategories();
  		$this->initProducts();
  		$this->loadFiles('_dndSelector', 'offlajnproductstreecustom');
  		$this->loadFiles();
  		if (!$value) $value = '[]';
  		$this->selected = json_decode($value);
  		$document =& JFactory::getDocument();

  	  $ret .= '<div class="productstree-container">'.
  	    '<div class="productstree-hider"></div>
        '.
        '<a id="productstree-all" href="javascript:;">Select all</a>&nbsp;&nbsp;|&nbsp;&nbsp;'.
  			'<a id="productstree-none" href="javascript:;">Select none</a>&nbsp;&nbsp;|&nbsp;&nbsp;'.
  			'<a id="productstree-expand" href="javascript:;">[+] Expand all</a>&nbsp;&nbsp;|&nbsp;&nbsp;'.
  			'<a id="productstree-collapse" href="javascript:;">[-] Collapse all</a>'.
  			'<div class="claro"><div id="productstree">Loading...</div></div>'.
        '</div>'.
  			'
        <input type="hidden"  name="'.$name.'" id="'.$this->id.'" value=\''.$value.'\' />';

  		DojoLoader::addScript('
          if (odijit.byId( "productstree"))
            odijit.byId("productstree").destroy( true );
          window.x = new ProductsTree({
            "node" : "productstree",
            "id": "'.$this->id.'",
            "json": '.json_encode($this->createTree()).'
          });         
      ');
  		return $ret;
  	}
  }

  if(version_compare(JVERSION,'1.6.0','l') && is_dir(JPATH_ROOT.DS.'components'.DS.'com_virtuemart') && file_exists(JPATH_ROOT.DS.'components'.DS.'com_virtuemart'.DS.'virtuemart_parser.php'))
    require_once("offlajnproductstreecustom".DS."productstreeVM1.php");
  if(is_dir(JPATH_ROOT.DS.'components'.DS.'com_virtuemart'.DS.'controllers')) 
    require_once("offlajnproductstreecustom".DS."productstreeVM2.php");
?>