<?php 
/*------------------------------------------------------------------------
# smartslider - Smart Slider
# ------------------------------------------------------------------------
# author    Roland Soos 
# copyright Copyright (C) 2011 Offlajn.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.offlajn.com
-------------------------------------------------------------------------*/
?>
<?php
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view' );
Nextendjimport( 'joomla.utilities.simplexml' );


class sliderViewslider extends JViewLegacy{
	function display($tpl = null){
	  $mainframe = &JFactory::getApplication();
	  
		JToolBarHelper::title(   JText::_( SMARTS?'Slider and Tabber Manager':(SMARTSLIDER?'Slider Manager':'Tabber Manager') ) .' - '. JText::_( SMARTS?'Edit Slider/Tabber':(SMARTSLIDER?'Edit Slider':'Edit Tabber') ), 'generic.png' );
		
    $bar = & JToolBar::getInstance('toolbar');
    if(!defined('WP_ADMIN')){
        $bar->appendButton('Standard', 'savenew', 'Save & Generate', 'savegenerate', false, false);
    }else{
        wp_enqueue_style('thickbox');
        wp_enqueue_style('media');
        wp_enqueue_script("jquery");
        wp_enqueue_script('thickbox');
    }
    
    JToolBarHelper::save();
		JToolBarHelper::apply();
		JToolBarHelper::cancel();
		$model = $this->getModel();
		
		$id	= JRequest::getInt('id', 0);
		$model->setId($id);
		$row = $model->getData();
	  
		$user =& JFactory::getUser();
		if($row->id > 0)
		  $row->checkout( $user->get('id') );
		
		$p = $row->params;

		$row->params = new OfflajnJParameter('','');
    parseParams($row->params, $p);
    if(SMARTCONTENTTABS){
		  $xmlfile = dirname(__FILE__).DS.'..'.DS.'..' . DS . 'forms' . DS . 'tabber.xml';
		}
    if(SMARTSLIDER){
		  $xmlfile = dirname(__FILE__).DS.'..'.DS.'..' . DS . 'forms' . DS . 'slider.xml';
		}
		$xml = new JSimpleXML();
    $xml->loadFile($xmlfile);
    $sel = &$xml->document->params[0]->param[2];
    if($row->id > 0){
      $xml->document->params[0]->removeChild($sel);
    }
    
		$params = new OfflajnJParameter( '');
    $params->setXML($xml->document->params[0]);
    $params->setXML($xml->document->params[1]);
    $params->addElementPath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_smartslider'.DS.'params');
    $params->row = &$row;
		
		if(isset($_SESSION['sliderparams']) && count($_SESSION['sliderparams']) > 0 ){
		  $row = (object)$_SESSION['sliderparams'];
		  $subparams = new JParameter('','');
		  $subparams->bind($row->params);
		  $row->params = $subparams;
      $params->bind($row->params->toArray());
      $params->row = $row;
		  unset($_SESSION['sliderparams']);
		}else{
		  $params->bind($row);
		  $params->bind($row->params->toArray());
		}

		$this->assignRef('defaultparams', $params->render('params'));
		
    if(!defined('WP_ADMIN'))
		  $this->assignRef('generatorparams', $params->render('','generator'));
    
    $this->assignRef('row', $row);
		
		
		parent::display($tpl);
	}
}