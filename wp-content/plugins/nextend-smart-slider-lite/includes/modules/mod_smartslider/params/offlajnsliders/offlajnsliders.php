<?php
defined('_JEXEC') or die('Restricted access');

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_smartslider'.DS.'tables');

class JElementOfflajnSliders extends JElementOfflajnList
{

	var	$_name = 'OfflajnSliders';

	function universalfetchElement($name, $value, &$node){
    $value = htmlspecialchars(html_entity_decode($value, ENT_QUOTES), ENT_QUOTES);
    $db =& JFactory::getDBO();
   /* $query = 'SELECT a.id, a.name, a.type , IF(ISNULL(c.slider),0,SUM(1)) AS count'
		. ' FROM #__offlajn_slider AS a'
		. ' LEFT JOIN #__offlajn_slide AS c ON a.id = c.slider'
		. ' WHERE a.published = 1 AND c.published = 1'
		. ' GROUP BY a.id'
		. ' ORDER BY a.name'
		;*/
		$query = 'SELECT a.id, a.name, a.type '
		. ' FROM #__offlajn_slider AS a'
		. ' WHERE a.published = 1 '
		. ' GROUP BY a.id'
		. ' ORDER BY a.name'
		;
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		foreach($rows AS $row){
      $node->addChild('option',array('value' => $row->id))->setData(ucfirst($row->name.' ['.$row->type.'] '));
    }
    if(isset($_GET['slider']) && $_GET['slider'] > 0){
      $value = $_GET['slider'];
    }
    return parent::universalfetchElement($name, $value, $node);
	}
	/*
  function getInput(){
    $this->value = htmlspecialchars(html_entity_decode($this->value, ENT_QUOTES), ENT_QUOTES);

    $options = array ();
    $db =& JFactory::getDBO();
    $query = 'SELECT a.id, a.name, a.type , IF(ISNULL(c.slider),0,SUM(1)) AS count'
		. ' FROM #__offlajn_slider AS a'
		. ' LEFT JOIN #__offlajn_slide AS c ON a.id = c.slider'
		. ' WHERE a.published = 1 AND c.published = 1'
		. ' GROUP BY a.id'
		. ' ORDER BY a.name'
		;
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		foreach($rows AS $row){
      $options[] = JHTML::_('select.option', $row->id, $row->name.' ['.$row->type.'] - '. $row->count .' slides');
    }
    if(isset($_GET['slider']) && $_GET['slider'] > 0){
      $this->value = $_GET['slider'];
    }
		return JHTML::_('select.genericlist',  $options, $this->name, 'class="inputbox"', 'value', 'text', $this->value);
	}*/
}

if(version_compare(JVERSION,'1.6.0','ge')) {
  class JFormFieldOfflajnSliders extends JElementOfflajnSliders {}
}