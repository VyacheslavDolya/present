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
  padding: 0 5px 0 5px;
}

fieldset.adminform .imagelist .radiobtn{
  padding: 0 5px;
  margin: 0;
  display: inline;
  float: none;
}

fieldset.adminform .imagelist input{
  margin: 0;
  display: inline;
  float: none;
}

fieldset.adminform .imagelist img{
  margin: 0;
  display: inline;
  float: none;
}
</style>
<form action="index.php" method="post" name="adminForm" id="adminForm" style="margin-bottom: 500px;">
  <div id="nextend-configurator-lightbox" class="nextend-no-style">
    <div class="pane-sliders">		
      <div class="col <?php if(defined('WP_ADMIN')) { ?> col50 width-50 fltlft <?php }else{ ?>col100 width-100 <?php } ?>" id="defaultparams">			
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
      
      <div class="col100 width-100 fltlft">
        <div style="margin: 0 5px;">
          <?php echo plgSystemOfflajnParams::renderNewTab('content', 'Content', '
            <div style="margin: 4px 10px 0;">
            '.plgSystemOfflajnParams::renderNewTab('contenttemplate', 'Template', $this->contentparams, 'alwaysopen').'
            '.plgSystemOfflajnParams::renderNewTab('contenteditor', 'Editor', '', 'alwaysopen').'
            </div>
          '); ?>
    		</div>	
      </div>	
      
      <div class="col100 width-100 fltlft">
        <div style="margin: 0 5px;">
          <?php echo plgSystemOfflajnParams::renderNewTab('caption', 'Caption', '
            <div style="margin: 4px 10px 0;">
            '.plgSystemOfflajnParams::renderNewTab('captiontemplate', 'Template', $this->captionparams, 'alwaysopen').'
            '.plgSystemOfflajnParams::renderNewTab('captioneditor', 'Editor', '', 'alwaysopen').'
            </div>
          '); ?>
    		</div>	
      </div>	
      	
      <div class="clr">
      </div>		
      <input type="hidden" name="sliderid" value="<?php echo (JRequest::getVar('task') == 'add') ? JRequest::getInt('sliderid') : $this->row->slider ?>" />
      <input type="hidden" name="slider" value="<?php echo (JRequest::getVar('task') == 'add') ? JRequest::getInt('sliderid') : $this->row->slider ?>" />
      <input type="hidden" name="prevtask" value="<?php echo JRequest::getCmd( 'task' ) ?>" />
      <input type="hidden" name="option" value="com_smartslider" />
      <input type="hidden" name="controller" value="slide" />
      <input type="hidden" name="task" value="" />		
      <input type="hidden" name="id" value="<?php if(property_exists($this->row, 'id')) echo $this->row->id; ?>" /> 		
      <?php echo JHTML::_( 'form.token' ); ?> 		
      <div class="insertselector">
        <fieldset>
          <legend>Choose</legend>
          <div class="closeinsert"></div>
          <div class="draginsert"></div>
          
          <div class="smartinsert"></div>
          <div class="specialinsert"></div>
        
          <div class="selector"></div>
          
          <div class="inserttext">
            <div class="inserttext_left"><?php echo JTEXT::_('Press the'); ?>&nbsp;</div>
               <div class="helpinsertbutton_left"><div class="helpinsertbutton_right"><div class="helpinsertbutton"><?php echo JTEXT::_('insert'); ?></div></div></div> 
               <div style="float: left;margin-left: 5px;"><?php echo JTEXT::_('or'); ?></div> 
               <div class="helpinsertbutton_left" style="margin-left: 5px;"><div class="helpinsertbutton_right"><div class="helpinsertbutton"><?php echo JTEXT::_('replace'); ?></div></div></div>
            <div class="inserttext_right"><?php echo JTEXT::_(' button next to the input elements to paste the selected value.'); ?></div>
          </div>
          
          <div class="cancelbutton_left"><div class="cancelbutton_right"><div class="cancelbutton"><?php echo JTEXT::_('Close');?></div></div></div>
      </fieldset>
      
      </div>
    </div>
  </div>
</form>