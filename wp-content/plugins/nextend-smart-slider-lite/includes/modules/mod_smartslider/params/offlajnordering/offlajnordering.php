<?php
defined('_JEXEC') or die('Restricted access');

class JElementOfflajnOrdering extends JElementOfflajnMultiSelectList {
  
  var $_name = 'OfflajnOrdering';
  
  function universalfetchElement($name, $value, &$node) {

    $class = ($node->attributes('class') ? 'class="' . $node->attributes('class') . '"' : 'class="inputbox"');
    $this->loadFiles();
    $this->loadFiles('OfflajnMultiSelectList');
    $sliderid = $this->_parent->row->slider;
    if (!property_exists($this->_parent->row, 'id')) $this->_parent->row->id = '';
    $id = $this->_parent->row->id;
    $db = & JFactory::getDBO();
    $db->setQuery('SET @rank=-1;');
    $db->query();
    $db->setQuery('UPDATE #__offlajn_slide SET ordering = (@rank:=@rank+1) WHERE slider = "' . $sliderid . '" ORDER BY ordering ASC');
    $db->query();
    $query = 'SELECT id, title, ordering, groupprev' . ' FROM #__offlajn_slide ' . ' WHERE slider = "' . $sliderid . '"' . ' ORDER BY ordering';
    $db->setQuery($query);
    $rows = $db->loadObjectList();
    $selected = '';
    $options = array();
    $main = null;
    foreach($rows as $row) {
      $text = '';
      if ($row->groupprev == 0 || $main == null) {
        $main = $row;
      } else if ($row->groupprev == 1 && $main != null) {
        $text.= '-- ';
      }
      $val = $row->ordering;
      if ($row->id == $id) {
        $selected = $val;
        $text.= 'Current slide';
      } else {
        $text.= $row->title;
      }
      $node->addChild('option', array(
        'value' => $val
      ))->setData(ucfirst($text));
    }
    if ($id == '') {
      $c = count($rows);
      $selected = $c;
      $node->addChild('option', array(
        'value' => $selected
      ))->setData(ucfirst('Current slide'));
    }
    $field = parent::universalfetchElement($name, $selected, $node);
    DojoLoader::addScript('
      new OfflajnOrdering({
        node : dojo.byId("' . $this->id . '")
      });
    ');
    return $field;
  }
}
