<?php
defined('_JEXEC') or die('Restricted access');
?>
<div class="nextendpanel dashboard">
  <div id="dashboard-icon" class="opened"></div>
  <h3 class="title" style="background-image:url('<?php echo $logoUrl?>');"><span><?php echo @$this->attr['label']?> DASHBOARD</span></h3>
  <div class="pane-slider content" style="padding-top: 0px; border-top: medium none; padding-bottom: 0px; border-bottom: medium none; overflow: hidden;">
    <div>
    	<div class="column left">
    	 <div class="dashboard-box">
        <div class="box-title">
         General <b>Information</b>
        </div>
        <div class="box-content">
         <?php
          echo $this->generalInfo;
         ?>
        </div>
        </div>
      </div>
    	<div class="column mid">
    	 <div class="dashboard-box">
        <div class="box-title">
         Related <b>News</b>
        </div>
        <div class="box-content">
         <?php
          echo $this->relatedNews;
         ?>
        </div>
      </div>
      </div>
    	<div class="column right">
    	 <div class="dashboard-box">
        <div class="box-title">
         Product <b>Support</b>
        </div>
        <div class="box-content">
          <div class="content-inner">
             If you have any problem with <?php echo @$this->attr['label']?> just write us and we will help ASAP!
             <div style="background-image:url('<?php echo $supportTicketUrl?>');" class="support-ticket-button"><a href="http://www.nextendweb.com/help/support" target="_blank"></a></div>
             <div class="clr"></div>
          </div>
        </div>
        </div>
    	 <div class="dashboard-box">
        <div class="box-title">
         Rate <b>Us</b>
        </div>
        <div class="box-content">
          <div class="content-inner">
            If you use <?php echo @$this->attr['label']?>, please post a rating and a review at the Joomla! Extensions Directory. With this small gesture you will help the community a lot. Thank you very much!
            <div class="clr"></div>
          </div>
        </div>
        </div>
      </div>
      <div class="clr"></div>	
    </div>
  </div>
</div>