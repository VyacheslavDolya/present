<?php
defined('_JEXEC') or die;
$doc = JFactory::getDocument();

$doc->addStyleSheet('templates/system/css/system.css');
$doc->addStyleSheet('templates/'.$this->template.'/css/template.css');
?>
<div style="min-width:1110px;" id="content-box">
	<div id="toolbar-box">
		<div class="m">
      <?php
      /* SUBMENU */
      $document	= JFactory::getDocument();
      $renderer	= $document->loadRenderer('module');
			$toolbar = new stdClass;
			$toolbar->params = null;
			$toolbar->module = 'mod_toolbar';
			$toolbar->id = 0;
			$toolbar->user = 0;
      echo $renderer->render($toolbar, array());
			$title = new stdClass;

$title->id = 15;
$title->title = 'Title';
$title->module = 'mod_title';
$title->position = 'title';
$title->content = '';
$title->showtitle = 1;
$title->params = '';
$title->menuid = 0;
$title->user = 0;
$title->name = 'title';
$title->style = ''; 
      echo $renderer->render($title, array());
      ?>
		</div>
	</div>
<?php
/* SUBMENU */
if (!JRequest::getInt('hidemainmenu')){
  $submenu = new stdClass;
  $submenu->params = null;
  $submenu->module = 'mod_submenu';
  $submenu->id = 0;
  $submenu->user = 0;
  echo $renderer->render($submenu, array('style'=>'rounded', 'id' => 'submenu-box'));
}
?>

	<jdoc:include type="message" />
	<div id="element-box">
		<div class="m">
			<jdoc:include type="component" />
			<div class="clr"></div>
		</div>
	</div>
	<noscript>
		<?php echo  JText::_('JGLOBAL_WARNJAVASCRIPT') ?>
	</noscript>
</div>