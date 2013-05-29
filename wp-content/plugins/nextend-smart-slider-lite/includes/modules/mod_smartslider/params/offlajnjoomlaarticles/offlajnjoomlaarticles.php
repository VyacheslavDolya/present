<?php
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
  
  class OfflajnJoomlaArticles extends JOfflajnFakeElementBase{
  	var $db, $cats, $prods, $selected;
  
    var $_name = 'OfflajnJoomlaArticles';
    
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
  		$this->loadFiles('_dndSelector', 'offlajnjoomlaarticles');
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
          if (dijit.byId( "productstree"))
            dijit.byId("productstree").destroy( true );
          window.x = new ArticlesTree({
            "node" : "productstree",
            "id": "'.$this->id.'",
            "json": '.json_encode($this->createTree()).'
          });         
      ');
  		return $ret;
  	}
  }


  class JElementOfflajnJoomlaArticles extends OfflajnJoomlaArticles {

    function initDB(){$this->db =& JFactory::getDBO();}

    function initCategories() {
      $q = 'SELECT DISTINCT c.title AS name, c.id AS cid, c.parent_id AS pid ';
      $q.= 'FROM #__categories AS c ' ;
      if(version_compare(JVERSION,'1.6.0','ge')) {
        $q.= 'WHERE c.published = 1 ORDER BY c.id ASC';
      } else {
        $q.= 'WHERE c.published = 1 ORDER BY c.ordering ASC';
      }
    	$this->db->setQuery($q);
    	$this->cats = $this->db->loadAssocList();
    }

    function initProducts(){
      $q = 'SELECT DISTINCT p.title AS name, p.id AS id, pc.id AS cid ';
      $q.= 'FROM #__content AS p ';
      $q.= 'INNER JOIN #__categories AS pc ON p.id = pc.id ';
      $q.= 'ORDER BY p.id';
  		$this->db->setQuery($q);
  		$this->prods = $this->db->loadAssocList();
    }
  }

  if(version_compare(JVERSION,'1.6.0','ge')) {
    class JFormFieldOfflajnJoomlaArticles extends JElementOfflajnJoomlaArticles {}
  }

?>