<?php

define('JOOMLA_BASE', dirname(__FILE__).DIRECTORY_SEPARATOR);

define('_JREQUEST_NO_CLEAN', 1);

define('_JEXEC', 1);

define('JPATH_BASE', dirname(__FILE__));
require_once JPATH_BASE.'/includes/defines.php';

require_once JPATH_BASE.'/includes/helper.php';
require_once JPATH_BASE.'/includes/framework.php';
require_once JPATH_BASE.'/includes/mysqlwp.php';
require_once JPATH_BASE.'/includes/JUserWP.php';
require_once JPATH_BASE.'/includes/toolbar.php';
require_once JPATH_BASE.'/includes/JPluginHelper.php';


$obj = new stdClass;
$obj->id = 3;
$obj->name = 'wpadministrator';
$obj->path = dirname(__FILE__);
JApplicationHelper::addClientInfo($obj);

$GLOBALS['EXISTINGJOOMLATABLES'] = array(
  '#__offlajn_slide',
  '#__offlajn_slider'
);

$instance = JFactory::getSession()->get('user');

if (!($instance instanceof JUserWP))
{
	$instance = JUserWP::getInstance();
  JFactory::getSession()->set('user', $instance);
}

// Instantiate the application.
$app = JFactory::getApplication('wpadministrator');
//$_REQUEST['tmpl'] = 'component';
OfflajnJPluginHelper::importPlugin( 'system' );

$app->initialise();

$obj->path = JPATH_ADMINISTRATOR;

$lang = JFactory::getLanguage();
$lang->load('lib_joomla', JPATH_ADMINISTRATOR);
$app->route();

$app->dispatch();

$app->render();

?>