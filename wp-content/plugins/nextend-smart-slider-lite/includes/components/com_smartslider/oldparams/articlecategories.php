<?php 
/*------------------------------------------------------------------------
# smartslider - Smart Slider
# ------------------------------------------------------------------------
# author    Jeno Kovacs 
# copyright Copyright (C) 2012 Offlajn.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.offlajn.com
-------------------------------------------------------------------------*/
?>
<?php
defined('_JEXEC') or die('Restricted access');

/*
  *Custom parameter to select article categories
  *In Joomla 1.5.x the category parameter works fine, and it can only shows the article's categories
  *In Joomla 1.6.x and 1.7.x the category parameter is an extended version of the basic parameter, which can select article categories, banner categories, etc.
  *The problem, that there is a bug in this parameter, and it can't load the previously selected item
  *That's why this custom parameter borned
*/


if(version_compare(JVERSION,'1.6.0','>=')) { 
  class JElementArticlecategories extends JElement {
    
  	var	$_name = 'articlecategories';
  
    function fetchElement($name, $value, &$node, $control_name){
      
      $option = array();
      $class = "class='inputbox'";
      
       $db = & JFactory::getDBO();
       $query = "SELECT ". $db->qn('id').", ".$db->qn('title').", parent_id".
                " FROM ". $db->qn('#__categories'). 
                " WHERE ".$db->qn('extension')."=".$db->quote('com_content');
       $db->setQuery($query);
        $menuItems = $db->loadObjectList();
        
        $children = array();
        if ($menuItems) {
          foreach ($menuItems as $v) {
              $pt = $v->parent_id;
              $list = isset($children[$pt]) ? $children[$pt] : array();
              array_push($list, $v);
              $children[$pt] = $list;
          }
        }
        jimport('joomla.html.html.menu');
        $_options = JHTML::_('menu.treerecurse', 1, '', array(), $children, 9999, 0, 0);

       foreach($_options as $res) {
        $options[] = JHTML::_('select.option', $res->id, $res->treename);
       }
       return JHTML::_('select.genericlist', $options, 'params['.$name.'][]', $class." multiple='1' size='10'" , 'value', 'text',  $value, $control_name.$name);
    }
  }
} else {
    jimport( 'joomla.html.parameter.element.category' );
    class JElementArticlecategories extends JElement {
  
    	var	$_name = 'articlecategories';
    	
	    function fetchElement($name, $value, &$node, $control_name) {

		    $parameter =& $this->_parent->loadElement('category');

		    return $parameter->fetchElement($name, $value, $node, $control_name);
	    }
    }
}
?>