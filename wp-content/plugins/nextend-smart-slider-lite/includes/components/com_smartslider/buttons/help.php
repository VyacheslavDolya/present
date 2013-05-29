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
jimport('joomla.html.toolbar.button');

class JButtonHelpSlider extends JButton{

	var $_name = 'Help';

	function fetchButton( $type='Help')
	{
		$text	= JText::_('Help');
		$class	= $this->fetchIconClass('help');

		$html	= "<a href=\"http://www.nextendweb.com/smart-slider#support\" target=\"_blank\" class=\"toolbar\">\n";
		$html .= "<span class=\"$class\" title=\"$text\">\n";
		$html .= "</span>\n";
 		$html	.= "$text\n";
		$html	.= "</a>\n";

		return $html;
	}

	function fetchId($name)
	{
		return 'Slider-'."help";
	}
}

class JToolbarButtonHelpSlider extends JButtonHelpSlider{
}