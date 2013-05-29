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
<?php $c['captionurl'] = $c['url'].'../../../captions/'; ?>


<?php echo $c['id']; ?> .sslide .caption{
  position: absolute;
  left: 0;
  top: 0;
  padding: 0;
  display: none;
}

<?php echo $c['id']; ?> .caption a,
<?php echo $c['id']; ?> .caption span,
<?php echo $c['id']; ?> .caption p,
<?php echo $c['id']; ?> .caption h3,
<?php echo $c['id']; ?> .caption h4{
  line-height: 15.6px;
}


<?php echo $c['id']; ?> .caption a,
<?php echo $c['id']; ?> .caption a:visited,
<?php echo $c['id']; ?> .caption a:active,
<?php echo $c['id']; ?> .caption a:hover{
  color: #fff;
  text-decoration: underline;
  <?php if($this->env->slider->params->get('textshadow')): ?>
  text-shadow: rgba(0, 0, 0, 0.5) 1px 1px 1px;
  <?php endif; ?>
}

<?php echo $c['id']; ?> .sslide .caption .animated .content{
  z-index: 11;
  position: relative;
}

<?php echo $c['id']; ?> .sslide .caption .fromright{
 position: absolute;
 width: 0px;
 padding-left: 29px;
 height: 100%;
 right: 0px;
 top: 0;
 height: 0;
 visibility: visible;
}

<?php echo $c['id']; ?> .sslide .caption .fromright .opener{
 background: url('<?php echo $c['captionurl']; ?>images/captionrightplus.png') no-repeat 0 0px;
 position: absolute;
 top:<?php echo $canvasHeight-72; ?>px;
 left: 0;
 width: 29px;
 height: 42px;
 margin-bottom: 30px;
 cursor: pointer;
}

<?php echo $c['id']; ?> .sslide .caption .opened.fromright .opener{
 background-image: url('<?php echo $c['captionurl']; ?>images/captionrightminus.png');
}

<?php echo $c['id']; ?> .sslide .caption .fromright .content{
  height: <?php echo $canvasHeight-15*2; ?>px;
  background: url('<?php echo $c['captionurl']; ?>images/black50.png') repeat;
  padding: 15px 10px;
}

<?php echo $c['id']; ?> .sslide .caption .fromright h3{
  <?php $fonts->printFont('captionfont', 'Title', true); ?>
  margin: 0 0 5px;
}

<?php echo $c['id']; ?> .sslide .caption .fromright p,
<?php echo $c['id']; ?> .sslide .caption .frombottom p{
  text-align: left;
  <?php $fonts->printFont('captionfont', 'Paragraph', true); ?>
}

<?php echo $c['id']; ?> .sslide .caption .fromright a,
<?php echo $c['id']; ?> .sslide .caption .frombottom a, 
<?php echo $c['id']; ?> .sslide .caption .simple a {
  text-align: left;
  <?php $fonts->printFont('captionfont', 'Link', true); ?>
}


<?php echo $c['id']; ?> .sslide .caption .frombottom{
 position: absolute;
 height: 0;
 padding-top: 29px;
 width: 100%;
 bottom: 0px;
 right: 0;
 width: 0;
 visibility: visible;
}

<?php echo $c['id']; ?> .sslide .caption .frombottom .opener{
 background: url('<?php echo $c['captionurl']; ?>images/captionbottomplus.png') no-repeat 0 0px;
 position: relative;
 right: 0;
 height: 29px;
 width: 62px;
 cursor: pointer;
 margin-top: -29px;
 margin-left: -62px;
}

<?php echo $c['id']; ?> .sslide .caption .opened.frombottom .opener{
 background-image: url('<?php echo $c['captionurl']; ?>images/captionbottomminus.png');
}

<?php echo $c['id']; ?> .sslide .caption .frombottom .content{
  position: relative;
  width: 100%;
  width: <?php echo $canvasWidth-10*2; ?>px;
  left: -<?php echo $canvasWidth; ?>px;
  height: 0px;
  background: url('<?php echo $c['captionurl']; ?>images/black50.png') repeat;
  padding: 8px 10px;
}

<?php echo $c['id']; ?> .sslide .caption .frombottom h3{
  <?php $fonts->printFont('captionfont', 'Title', true); ?>
  margin: 0 0 5px;
}

<?php echo $c['id']; ?> .sslide .caption .simple{
  position: relative;
  display: none;
  width: 0px;
  height: 0px;
  top: 0;
  left: 0;
}

<?php echo $c['id']; ?> .sslide .caption .simple h4{
  position: absolute;
  margin: 0;
  display: inline;
  /* Alpha channel*/
  <?php 
    $color = $activebg;
    if(strlen($color) == 6):
  ?>
  background-color: #<?php echo $color; ?>;
  <?php else: 
    $alpha = round(hexdec(substr($color, 6, 2))/255, 1);
    if(hexdec(substr($color, 6, 2)) != 1):
  ?>
    background-color: #<?php echo substr($color, 0, 6); ?>;
    background-color: rgba(<?php echo hexdec(substr($color, 0, 2)); ?>, <?php echo hexdec(substr($color, 2, 2)); ?>, <?php echo hexdec(substr($color, 4, 2)); ?>, <?php echo $alpha; ?>);
    <?php endif; ?>
  <?php endif; ?>
  /* Alpha channel*/
  padding: 1px 10px;
  color: #fff;
  font-family: Arial;
  font-weight: bold;
  font-size: 10px;
  text-transform:uppercase;
  <?php if($this->env->slider->params->get('textshadow')): ?>
  text-shadow: #4a4a4a 1px 1px 1px;
  <?php endif; ?>
}

.dj_ie7 <?php echo $c['id']; ?> .sslide .caption .simple h4{
  background-color: #<?php echo substr($color, 0, 6); ?>;
}

<?php echo $c['id']; ?> .sslide .caption .simple h3{
  margin: 0;
  display: block;
  padding: 11px 10px;
  white-space:nowrap;
  <?php $fonts->printFont('captionfont', 'Title', true); ?>
}

<?php echo $c['id']; ?> .sslide .caption .simple .h3{
  position: absolute;
  background-color: #000000;
  background: url('<?php echo $c['captionurl']; ?>images/black70.png') repeat;
}

<?php echo $c['id']; ?> .sslide .caption .simple p{
  margin: 0;
  padding: 0px 10px 11px;
  <?php $fonts->printFont('captionfont', 'Paragraph', true); ?>
}


<?php echo $c['id']; ?> .sslide .caption .smartcaption{
  position: relative;
  display: none;
  width: 0px;
  height: 0px;
  top: 0;
  left: 0;
}

<?php echo $c['id']; ?> .sslide .caption .smartcaption div.caption-h4,
<?php echo $c['id']; ?> .sslide .caption .smartcaption h4{
  white-space:nowrap;
  position: absolute;
  margin: 0;
  display: inline;
  /* Alpha channel*/
  <?php 
    $color = $activebg;
    if(strlen($color) == 6):
  ?>
  background-color: #<?php echo $color; ?>;
  <?php else: 
    $alpha = round(hexdec(substr($color, 6, 2))/255, 1);
    if(hexdec(substr($color, 6, 2)) != 1):
  ?>
    background-color: #<?php echo substr($color, 0, 6); ?>;
    background-color: rgba(<?php echo hexdec(substr($color, 0, 2)); ?>, <?php echo hexdec(substr($color, 2, 2)); ?>, <?php echo hexdec(substr($color, 4, 2)); ?>, <?php echo $alpha; ?>);
    <?php endif; ?>
  <?php endif; ?>
  /* Alpha channel*/
  padding: 1px 10px;
  text-transform:uppercase;
  <?php $fonts->printFont('captionfont', 'Tag', true); ?>
  
  line-height: <?php
    ob_start();
    $fonts->_printFont('captionfont', 'Tag', null,array('font-size'), true, true);
    echo intval(ob_get_clean())*1.3;
    ?>px;
}

.dj_ie7 <?php echo $c['id']; ?> .sslide .caption .smartcaption div.caption-h4,
.dj_ie7 <?php echo $c['id']; ?> .sslide .caption .smartcaption h4{
  background-color: #<?php echo substr($color, 0, 6); ?>;
}

<?php echo $c['id']; ?> .sslide .caption .smartcaption div.caption-h3,
<?php echo $c['id']; ?> .sslide .caption .smartcaption h3{
  white-space:nowrap;
  position: absolute;
  margin: 0;
  display: block;
  padding: <?php echo 11*$ratio; ?>px <?php echo 10*$ratio; ?>px;
  background: url('<?php echo $c['captionurl']; ?>images/black70.png') repeat;
  <?php $fonts->printFont('captionfont', 'Title', true); ?>
}
<?php echo $c['id']; ?> .sslide .caption{
    width: 100%;
    height: 100%;
    visibility: hidden;
}

<?php echo $c['id']; ?> .sslide .caption .defaultcaption{
    width: 100%;
    height: 100%;
    visibility: hidden;
}

<?php echo $c['id']; ?> .sslide .caption .defaultcaption-title,
<?php echo $c['id']; ?> .sslide .caption .defaultcaption-description{
    background: #000;
    background: RGBA(0,0,0,0.7);
    float:left;
    clear: left;
    box-shadow: inset 0 5px 5px RGBA(0,0,0,0.5), 1px 1px 0 0 RGBA(255,255,255,0.1);
}

<?php echo $c['id']; ?> .sslide .caption .defaultcaption-title{
    margin: 4% 2% 0 5%;
    <?php $fonts->printFont('defaultcaptionfont', 'Title', true); ?>
    padding: <?php echo 8*$ratio; ?>px;
    z-index: 7;
    <?php
    ob_start();
    $fonts->_printFont('defaultcaptionfont', 'Title', null,array('font-size'), true, true);
    $fsize = ob_get_clean();
    if(strpos($fsize, 'px') && intval($fsize) < 8){
    ?>
    display: none;
    <?php
    }
    ?>
}

<?php echo $c['id']; ?> .sslide .caption .defaultcaption-description{
    margin: 2px 2% 0 5%;
    <?php $fonts->printFont('defaultcaptionfont', 'Description', true); ?>
    padding: <?php echo 8*$ratio; ?>px;
    max-width: 90%;
    z-index: 6;
    
    <?php
    ob_start();
    $fonts->_printFont('defaultcaptionfont', 'Description', null,array('font-size'), true, true);
    $fsize = ob_get_clean();
    if(strpos($fsize, 'px') && intval($fsize) < 8){
    ?>
    display: none;
    <?php
    }
    ?>
}

.nextend-csstransitions <?php echo $c['id']; ?>  .sslide.animating .caption .defaultcaption-title,
.nextend-csstransitions <?php echo $c['id']; ?>  .sslide.animating .caption .defaultcaption-description,
.nextend-csstransitions <?php echo $c['id']; ?>  .sslide.selected .caption .defaultcaption-title,
.nextend-csstransitions <?php echo $c['id']; ?>  .sslide.selected .caption .defaultcaption-description{
    visibility: visible;
}