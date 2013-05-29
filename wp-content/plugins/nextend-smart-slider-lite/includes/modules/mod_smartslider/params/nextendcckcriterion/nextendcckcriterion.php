<?php 
defined('_JEXEC') or die('Restricted access');

require_once(dirname(__FILE__).'/../offlajnlist/offlajnlist.php');

class JElementnextendcckcriterion extends JElementOfflajnList
{
  var $_moduleName = '';
  
	var	$_name = 'Nextendcckfilter';

	function universalfetchElement($name, $value, &$node){
  	$this->loadFiles();
		static $filterFields = array();
    
    if(count($filterFields) == 0){
      $filterFields['user_id'] = 'User id';
      $filterFields['published'] = 'Published';
      $filterFields['title'] = 'Title';
      $filterFields['featured'] = 'Featured';
      $filterFields['hist'] = 'Hits';
      $filterFields['votes'] = 'Votes';
      $filterFields['favorite_num'] = 'Favorited';
      $filterFields['comments'] = 'Comments';
      $filterFields['tags'] = 'Tags';
      $filterFields['langs'] = 'Lang';
      
      
      $db = JFactory::getDBO();
 
      $query = "SELECT a.id, a.label, a.field_type, b.name AS typename FROM #__js_res_fields AS a LEFT JOIN #__js_res_types AS b ON b.id = a.type_id ORDER BY b.name ASC";
      $db->setQuery($query);
      foreach($db->loadRowList() AS $f){
        $filterFields['field.'.$f[0]] = $f[1].' ['.$f[2].'] ['.$f[3].']';
      }
    }
    
    foreach($filterFields AS $k => $v){
      $node->addChild('option',array('value' => $k))->setData($v);
    }
    
		return parent::universalfetchElement($name, $value, $node);
	}
	
}

if(version_compare(JVERSION,'1.6.0','ge')) {
  class JFormFieldnextendcckcriterion extends JElementnextendcckcriterion {}
}