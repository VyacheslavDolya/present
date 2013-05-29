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
?>
<style>
fieldset.adminform .radiobtn{
  float: left;
  clear: none;
  min-width: 0;
  padding: 0 20px 0 5px;
}
</style>
<form action="index.php" method="post" name="adminForm" id="adminForm">
  <div id="nextend-configurator-lightbox" class="nextend-no-style">
    <div class="pane-sliders">
  		<div class="col <?php if(defined('WP_ADMIN')) { ?> col50 width-50 fltlft <?php }else{ ?>col100 width-100 <?php } ?>">
  		  <div style="margin: 0 5px;">
          <?php echo plgSystemOfflajnParams::renderNewTab('details', 'Details', $this->defaultparams, 'alwaysopen'); ?>
  		  </div>
  		</div>
       <?php if(defined('WP_ADMIN')) { ?>
    		<div class="col col50 width-50 fltlft">
    		  <div style="margin: 0 5px;">
            <iframe width="465" height="273" src="http://demo.nextendweb.com/smartslider/Smart-Slider/smart-slider-pro<?php if(defined('SS_LITE')){ ?>mo<?php } ?>.html?tmpl=component"></iframe>
    		  </div>
    		</div>
       <?php } ?>
      <div class="clr"></div>
      
      <div class="col width-50 fltlft">
        <div style="margin: 0 5px;">
          <?php echo plgSystemOfflajnParams::renderNewTab('type', 'Slider Type', ''); ?>
        </div>
  		</div>
      
  		<div class="col width-50 fltlft">
        <div style="margin: 0 5px;">
          <?php echo plgSystemOfflajnParams::renderNewTab('themechooser', 'Theme Chooser', ''); ?>
        </div>
        <div style="margin: 0 5px;">
          <?php echo plgSystemOfflajnParams::renderNewTab('thememanager', 'Theme Manager', ''); ?>
        </div>
      </div>
      
      <div class="clr"></div>
      <?php if(!defined('WP_ADMIN')): ?>
      <div class="col fltlft" style="width: 100%;">
        <div style="margin: 0 5px;">
          <?php echo plgSystemOfflajnParams::renderNewTab('slidegenerator', 'Slide Generator', '
          <div id="slidegenerator">
          '.$this->generatorparams.'
  				  <div id="generatorform"></div>
  				  <div class="clr"></div>
  				  
          '.plgSystemOfflajnParams::renderNewTab('Content positions', 'Content positions', '
            <div id="contents"></div>
            <div id="contentmanager"></div>
  				  <div id="additionalfields"></div>
  				  <div id="contentaddbuttons"></div>
          ', 'alwaysopen').'
  				  
            
          '.plgSystemOfflajnParams::renderNewTab('Caption positions', 'Caption positions', '
  				  <div id="captions"></div>
  				  <div id="captionmanager"></div>
  				  <div id="additionalcaptions"></div>
  				  <div id="captionaddbuttons"></div>
          ', 'alwaysopen').'
  				  
  				
  		  	</div>
  		  	'); ?>
        </div>
  		</div>
      <?php endif; ?>
  		
  		<div class="clr"></div>
  
  		<input type="hidden" name="option" value="com_smartslider" />
  		<input type="hidden" name="controller" value="slider" />
  		<input type="hidden" name="task" value="" />
  		<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
  		<?php echo JHTML::_( 'form.token' ); ?>
    </div>
  </div>
</form>