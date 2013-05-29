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

<?php
  include($c['clearcss']);
?>

<?php
  $size = OfflajnValueParser::parse( $sp->get('size'));
  $cwidth = $size[1][0];
  $cheight = $size[2][0];
  
  $outerborder = OfflajnValueParser::parse($sp->get('outerborder'));
  $innerborder = OfflajnValueParser::parse($sp->get('innerborder'));
  
  $pdngOut = $outerborder[0][0];
  $paddingOut = array($pdngOut, $pdngOut, $pdngOut, $pdngOut);
  
  $pdngIn = $innerborder[0][0];
  $paddingIn = array($pdngIn, $pdngIn, $pdngIn, $pdngIn);
  
  $marginDt = array(2, 0, 2, 2);
  $paddingDt = array(3, 3, 3, 3);
  
  $titleWidth = round(38*$ratio/2)*2; // Always even fix
  
  $marginDd = array(2, 2, 2, -2);
  $paddingDd = array(0, 0, 0, 2);

  if($size[0] == 0){ // 0 => canvas 1 => slider
    $cwidth+= $paddingOut[1]+$paddingOut[3]+$paddingIn[1]+$paddingIn[3]+ $count * ($marginDt[1] + $marginDt[3] + $titleWidth + $marginDd[1] + $marginDd[3] + $paddingDd[1] + $paddingDd[3]);
    $cheight+= $paddingOut[0]+$paddingOut[2]+$paddingIn[0]+$paddingIn[2]+$marginDd[0]+$marginDd[2]+$paddingDd[0]+$paddingDd[2];
  }
?>

<?php echo $c['id']; ?> a:hover{
  text-decoration: none;
}

<?php echo $c['id']; ?> dl, <?php echo $c['id']; ?> dd, <?php echo $c['id']; ?> dt{
  padding: 0;
  margin: 0;
  float:left;
}

<?php echo $c['id']; ?>{
  width: <?php echo $cwidth; ?>px;
  margin: 0 auto;
}

<?php 
  $shadow = '';
  if(!$this->calc && $sp->get('shadow') != ''){
    if(defined('ABSPATH')){
      $sh = $sp->get('shadow');
      if(strpos($sh, site_url()) === 0){
        $path = ABSPATH.str_replace(site_url(),'',$sh);
        if(is_file($path)){
          $shadow = $this->themeCacheUrl.$c['helper']->ResizeImage(ABSPATH.str_replace(site_url(),'',$sh), $cwidth, 0);
        }
      }else{
        $shadow = $sh;
        $GLOBALS['height'] = 100;
      }
    }else if(is_file(JPATH_SITE.$sp->get('shadow'))){
      $shadow = $this->themeCacheUrl.$c['helper']->ResizeImage(JPATH_SITE.$sp->get('shadow'), $cwidth, 0);
    }
  } 
?>

<?php echo $c['id']; ?> .shadow{
  width: <?php echo $cwidth; ?>px;
  background: url('<?php echo $shadow; ?>') no-repeat;
  height: <?php echo isset($GLOBALS['height'])?$GLOBALS['height']:0; ?>px;
}

<?php
  $cwidth = $cwidth-$paddingOut[1]-$paddingOut[3];
  $cheight = $cheight-$paddingOut[0]-$paddingOut[2];
?>
<?php echo $c['id']; ?> .outer{
  border-radius: <?php echo OfflajnValueParser::parseUnit($sp->get('borderradius', '1|*|1|*|1|*|1|*|px'), ' '); ?>;
  /* Alpha channel*/
  <?php 
    $color = $outerborder[1];
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
  width: <?php echo $cwidth; ?>px;
  height: <?php echo $cheight; ?>px;
  padding: <?php echo implode('px ', $paddingOut); ?>px;
}

.dj_ie7 <?php echo $c['id']; ?> .outer{
  background-color: #<?php echo substr($color, 0, 6); ?>;
}

<?php
  $cwidth = $cwidth-$paddingIn[1]-$paddingIn[3];
  $cheight = $cheight-$paddingIn[0]-$paddingIn[2];
?>
<?php echo $c['id']; ?> .slinner{
  width: <?php echo $cwidth; ?>px;
  height: <?php echo $cheight; ?>px;
  /* Alpha channel*/
  <?php 
    $color = $innerborder[1];
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
  padding: <?php echo implode('px ', $paddingIn); ?>px;
  overflow: hidden;
}

.dj_ie7 <?php echo $c['id']; ?> .slinner{
  background-color: #<?php echo substr($color, 0, 6); ?>;
}

<?php echo $c['id']; ?> dl{
  width: <?php echo $cwidth+100; ?>px;
  height: <?php echo $cheight; ?>px;
  float:left;
}

<?php
  $cheight = $cheight-$marginDt[0]-$marginDt[2];
  $titleHeight = $cheight;
?>

<?php echo $c['id']; ?> dt.sslide{
  position: relative;
  width: <?php echo $titleWidth - $paddingDt[1] - $paddingDt[3]; ?>px;
  height: <?php echo $titleHeight - $paddingDt[0] - $paddingDt[2]; ?>px !important;
  float:left;
  background: url('<?php echo $c['url']; ?>images/black10.png') repeat;
  /* Alpha channel*/
  <?php 
    $color = $bg;
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
  cursor: pointer;
  margin: <?php echo implode('px ', $marginDt); ?>px;
  padding: <?php echo implode('px ', $paddingDt); ?>px;
}

.dj_ie7 <?php echo $c['id']; ?> dt.sslide{
  background-color: #<?php echo substr($color, 0, 6); ?>;
}

<?php echo $c['id']; ?> dt .slideinner{
  float: left;
  width: <?php echo $titleWidth - $paddingDt[1] - $paddingDt[3]; ?>px;
  height: <?php echo $titleHeight - $paddingDt[0] - $paddingDt[2]; ?>px;
  /* Alpha channel*/
  <?php 
    $color = $bg;
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
  display: block;
}

.dj_ie7 <?php echo $c['id']; ?> dt .slideinner{
  background-color: #<?php echo substr($color, 0, 6); ?>;
}

<?php echo $c['id']; ?> dt .slidepattern{
  position: relative;
  width: <?php echo $titleWidth; ?>px;
  height: <?php echo $cheight; ?>px;
  background: url('<?php echo $c['url']; ?>images/pattern.png') repeat;
  overflow: hidden;
  z-index: 3;
  margin: -<?php echo $paddingDt[0]; ?>px 0 0 -<?php echo $paddingDt[3]; ?>px;
  display: block;
}

<?php echo $c['id']; ?> dt.sslide .rotated-90{
  -moz-transform-origin: center center;
  -moz-transform: rotate(-90deg);
  -webkit-transform: rotate(-90deg);
  -o-transform: rotate(-90deg);
  transform: rotate(-90deg);
  zoom: 1;

  height: <?php echo $cheight-10; ?>px;
  width: <?php echo $cheight-10; ?>px;
  display: block;
  margin: 5px;
  float:left;
}

.dj_ie7 <?php echo $c['id']; ?> dt.sslide .rotated-90,
.dj_ie8 <?php echo $c['id']; ?> dt.sslide .rotated-90{
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
}

.dj_ie9 <?php echo $c['id']; ?> dt.sslide .rotated-90{
  -ms-transform: rotate(-90deg);
}

<?php echo $c['id']; ?> dt.sslide .title{
  height: <?php echo $titleWidth-5*2; ?>px;
  padding: 0 0 0 10px;
  display: block;
  text-align: left;
  
  /*font chooser*/
  <?php if(!$this->calc) $fonts->printFont('tabfont', 'Tab'); ?>
  /*font chooser*/
  line-height: <?php echo $titleWidth-5*2; ?>px;
}

.dj_ie7 <?php echo $c['id']; ?> dt.sslide .title,
.dj_ie8 <?php echo $c['id']; ?> dt.sslide .title{
  background: url('<?php echo $c['url']; ?>images/patternrot90.png') repeat;
  /* Alpha channel*/
  <?php 
    $color = $bg;
    if(strlen($color) == 6):
  ?>
  background-color: #<?php echo $color; ?>;
  <?php else: 
    $alpha = round(hexdec(substr($color, 6, 2))/255, 1);
    if(hexdec(substr($color, 6, 2)) != 1):
  ?>
    background-color: #<?php echo substr($color, 0, 6); ?>;
    <?php endif; ?>
  <?php endif; ?>
  /* Alpha channel*/
}

<?php echo $c['id']; ?> dt.selected, <?php echo $c['id']; ?> dt.sslide:HOVER{
  background: url('<?php echo $c['url']; ?>images/black20.png') repeat;
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
}

.dj_ie7 <?php echo $c['id']; ?> dt.selected, 
.dj_ie7 <?php echo $c['id']; ?> dt.sslide:HOVER{
  background-color: #<?php echo substr($color, 0, 6); ?>;
}

<?php echo $c['id']; ?> dt.selected .slideinner, <?php echo $c['id']; ?> dt.sslide:HOVER .slideinner{
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
}

.dj_ie7 <?php echo $c['id']; ?> dt.selected .slideinner, 
.dj_ie7 <?php echo $c['id']; ?> dt.sslide:HOVER .slideinner{
  background-color: #<?php echo substr($color, 0, 6); ?>;
}


.dj_ie7 <?php echo $c['id']; ?> dt.sslide.selected .title,
.dj_ie8 <?php echo $c['id']; ?> dt.sslide.selected .title,
.dj_ie7 <?php echo $c['id']; ?> dt.sslide:HOVER .title,
.dj_ie8 <?php echo $c['id']; ?> dt.sslide:HOVER .title{
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
    <?php endif; ?>
  <?php endif; ?>
  /* Alpha channel*/
}

<?php echo $c['id']; ?> dt.sslide.selected .title, <?php echo $c['id']; ?> dt.sslide:HOVER .title{
  /*font chooser*/
  <?php if(!$this->calc) $fonts->printFont('tabfont', 'Selected', true); ?>
  /*font chooser*/
  line-height: <?php echo $titleWidth-5*2; ?>px;
}

<?php echo $c['id']; ?> dt.selected{
  cursor: auto;
}

<?php echo $c['id']; ?> dt.sslide .dots{
  position: absolute;
  left: 0;
  top: <?php echo 45*$ratio; ?>px;
  <?php if($this->env->slider->params->get('slidenumbering') && $this->env->slider->params->get('slideicons')): ?>
  top: <?php echo 70*$ratio; ?>px;
  <?php endif; ?>
  width: <?php echo $titleWidth; ?>px;
  z-index: 5;
  display: block;
    <?php if (!$this->env->slider->params->get('showdots', 1)): ?> 
   display: none;    
  <?php endif; ?>
}

<?php echo $c['id']; ?> dt.sslide .dots .dot{
  width: 10px;
  height: 11px;
  background: url('<?php echo $c['url']; ?>images/emptydot.png') no-repeat;
  margin: 3px auto 0;
  cursor: pointer;
  display: block;
}

.nextend-backgroundsize <?php echo $c['id']; ?> dt.sslide .dots .dot{
  width: <?php echo round(9*$ratio); ?>px;
  height: <?php echo round(9*$ratio); ?>px;
  background-size: 100% 100%;
  margin: <?php echo round(3*$ratio); ?>px auto 0;
}

<?php echo $c['id']; ?> dt.sslide .dots .dot.active{
  background-image: url('<?php echo $c['url']; ?>images/filleddot.png');
  cursor: auto;
}

<?php echo $c['id']; ?> dt.sslide.selected .dots .dot.active, <?php echo $c['id']; ?> dt.sslide:hover .dots .dot.active{
}

/*Circles with numbers*/

<?php echo $c['id']; ?> dt.sslide .dots .circle {
  width: <?php echo 15*$ratio; ?>px;
  height: <?php echo 15*$ratio; ?>px;
  line-height: <?php echo 15*$ratio; ?>px;
  background: url('<?php echo $c['url']; ?>images/numberingbg.png') no-repeat;
  margin: 3px auto 0;
  text-align: center;
  padding-top: 1px;
  cursor: pointer;
  color: #fff; 
  display: block;
  font-family: Arial;
  font-size: <?php echo 11*$ratio; ?>px;
  text-shadow: 0 1px 1px #000000;
  top: 0;
  background-size: 100% 100%;
}

<?php echo $c['id']; ?> dt.sslide .dots .circle.active{
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
  font-weight: bold;
}

.dj_ie7 <?php echo $c['id']; ?> dt.sslide .dots .circle.active{
  background-color: #<?php echo substr($color, 0, 6); ?>;
}

/*Arrows*/

<?php echo $c['id']; ?> dt.sslide .arrowup {
  visibility: hidden;
  cursor: pointer;
  width: 100%;
  height: 30px;
  background: url('<?php echo $c['url']; ?>images/up.png') no-repeat center center;
}

<?php echo $c['id']; ?> dt.sslide .topline {
  top: 0;
  height: 2px;
  background: url('<?php echo $c['url']; ?>images/black20.png') repeat;
}

<?php echo $c['id']; ?> dt.sslide .col {
  height: 2px;
  width: 100%;
  background: url('<?php echo $c['url']; ?>images/black20.png') repeat;
}

<?php echo $c['id']; ?> dt.sslide .arrowup.show {
  visibility: visible;
}

<?php echo $c['id']; ?> dt.sslide .arrowup.show:HOVER {
 
 }

<?php echo $c['id']; ?> dt.sslide .arrowdown {
  visibility: hidden;
  cursor: pointer;
  width: 100%;
  height: 30px;
  background: url('<?php echo $c['url']; ?>images/down.png') no-repeat center center;
}

<?php echo $c['id']; ?> dt.sslide .bottomnline {
  height: 2px;
  background: url('<?php echo $c['url']; ?>images/black20.png') repeat;
}

<?php echo $c['id']; ?> dt.sslide .bottomline {
  height: 2px;
  background: url('<?php echo $c['url']; ?>images/black20.png') repeat;
  bottom: 0;
  width: 100%;
  position: absolute;
}

<?php echo $c['id']; ?> dt.sslide .arrowdown.show {
  visibility: visible;
}

<?php echo $c['id']; ?> dt.sslide .arrowdown.show:HOVER {

}
<?php echo $c['id']; ?> dt.sslide .dots .numbers{
  width: 100%;
}

<?php echo $c['id']; ?> dt.sslide .dots .nums {
  text-align: center;
 /* border-top: 1px solid #3E3E3E;
  border-bottom: 1px solid #3E3E3E;*/
  
 /* box-shadow: 0px 0.5px 1px rgba(255, 255, 255, 0.4) inset;*/
  padding: 7px 0 7px 0;
   /*font chooser*/
  <?php if(!$this->calc) $fonts->printFont('slidenumberfont', 'Text'); ?>
  /*font chooser*/
  text-align: center;
}

<?php echo $c['id']; ?> dt.sslide .numbering{
  position: absolute;
  top: 8px;
  width: 100%;
  padding: 5px 0;
  display: block;
  <?php if(!$this->env->slider->params->get('slidenumbering')): ?>
  display: none;
  <?php endif; ?>
  background: url('<?php echo $c['url']; ?>images/black20.png') repeat;

  /*font chooser*/
<?php if(!$this->calc) $fonts->printFont('tabfont', 'Tab'); ?>
  /*font chooser*/
  text-align: center;
}

<?php echo $c['id']; ?> dt.sslide.selected .numbering, <?php echo $c['id']; ?> dt.sslide:HOVER .numbering{
  /*font chooser*/
  <?php if(!$this->calc) $fonts->printFont('tabfont', 'Selected', true); ?>
  /*font chooser*/
  text-align: center;
}

<?php echo $c['id']; ?> dt.sslide .icon{
  display: block;
  position: absolute;
  top: 10px;
  <?php if($this->env->slider->params->get('slidenumbering') && $this->env->slider->params->get('slideicons')): ?>
  top: <?php echo 45*$ratio; ?>px;
  <?php endif; ?>
  width: 100%;
  height: 20px;
  background-repeat: no-repeat;
  background-position: center center;
  <?php if(!$this->env->slider->params->get('slideicons')): ?>
  display: none;
  <?php endif; ?>
}

.nextend-backgroundsize <?php echo $c['id']; ?> dt.sslide .icon{
  height: <?php echo round(20*$ratio); ?>px;
  background-size: contain;
}

<?php echo $c['id']; ?> dd.sslide{
  position: relative;
  height: <?php echo $cheight; ?>px;
  width: 0px;
  float: left;
  margin: <?php echo implode('px ', $marginDd); ?>px;
  padding: <?php echo implode('px ', $paddingDd); ?>px;
  overflow: hidden;
}

.dj_ie7 <?php echo $c['id']; ?> dd.sslide{

}

<?php echo $c['id']; ?> dd.sslide.selected{

  z-index: 4;
}

<?php
$canvasWidth = $cwidth - $count * ($marginDt[1] + $marginDt[3] + $titleWidth + $marginDd[1] + $marginDd[3] + $paddingDd[1] + $paddingDd[3]);
$canvasHeight = $cheight;
?>
<?php echo $c['id']; ?> dd.sslide.selected{
  width: <?php echo $canvasWidth; ?>px;
}

<?php echo $c['id']; ?> dd.sslide .arrowdown{
  width: 32px;
  height: 32px;
  background: url('<?php echo $c['url']; ?>images/arrowdown.png') no-repeat;
  position: absolute;
  left: 50%;
  bottom: 10px;
  margin-left: -16px;
  cursor: pointer;
  z-index: 2;
  display: none;
  opacity:0;
}

<?php echo $c['id']; ?> dd.sslide .arrowup{
  width: 32px;
  height: 32px;
  background: url('<?php echo $c['url']; ?>images/arrowup.png') no-repeat;
  position: absolute;
  left: 50%;
  top: 10px;
  margin-left: -16px;
  cursor: pointer;
  z-index: 2;
  display: none;
  opacity:0;
}

<?php echo $c['id']; ?> dd.sslide .arrowdown:hover, <?php echo $c['id']; ?> dd.sslide .arrowup:hover{
  opacity: 1;
}

<?php echo $c['id']; ?> dl dd.sslide .show{
  display: block;
  opacity:0.6;
}

<?php echo $c['id']; ?> dd.sslide .vertical{
  margin: 0;
  padding: 0;
  position: absolute;
}

<?php echo $c['id']; ?> dd.sslide .vertical li.subslide{
  margin: 0;
  padding: 0;
  position: relative;
  display:block;
  height: <?php echo $cheight; ?>px;
  width: <?php echo $canvasWidth; ?>px;
  float: left;
  overflow: hidden;
}

<?php echo $c['id']; ?> dd.sslide .canvas{
  height: <?php echo $cheight; ?>px;
  width: <?php echo $canvasWidth; ?>px;
  float: left;
  overflow: hidden;
  position: absolute;
  top:0;
}

<?php if($sp->get('css3transition', 1) == 1): ?>
    <?php
    $mainanimation = OfflajnValueParser::parse($sp->get('mainanimation'));
    $duration = $mainanimation[0][0]/1000;
    $easing = dojoEasingToCSSEasing($mainanimation[1]);
    ?>
    .nextend-csstransitions <?php echo $c['id']; ?> .slinner dd.sslide{
        transform: translate3d(0,0,0);
        -ms-transform: translate3d(0,0,0); /* IE 9 */
        -webkit-transform: translate3d(0,0,0); /* Safari and Chrome */
        -o-transform: translate3d(0,0,0); /* Opera */
        -moz-transform: translate3d(0,0,0); /* Firefox */
    }
    
    .nextend-csstransitions <?php echo $c['id']; ?>.nextend-animation .slinner dd.sslide{
        transition: width <?php echo $duration ?>s <?php echo $easing; ?> 0s;
        -ms-transition: width <?php echo $duration ?>s <?php echo $easing; ?> 0s;
        -moz-transition: width <?php echo $duration ?>s <?php echo $easing; ?> 0s;
        -webkit-transition: width <?php echo $duration ?>s <?php echo str_replace('-','',$easing); ?> 0s;
        -webkit-transition: width <?php echo $duration ?>s <?php echo $easing; ?> 0s;
        -o-transition: width <?php echo $duration ?>s <?php echo $easing; ?> 0s;
    }
    
    <?php
    $secondaryanimation = OfflajnValueParser::parse($sp->get('secondaryanimation'));
    $duration = $secondaryanimation[0][0]/1000;
    $easing = dojoEasingToCSSEasing($secondaryanimation[1]);
    ?>
    .nextend-csstransitions <?php echo $c['id']; ?> .slinner .sslide > ul{
        transform: translate3d(0,0,0);
        -ms-transform: translate3d(0,0,0); /* IE 9 */
        -webkit-transform: translate3d(0,0,0); /* Safari and Chrome */
        -o-transform: translate3d(0,0,0); /* Opera */
        -moz-transform: translate3d(0,0,0); /* Firefox */
        transition: transform <?php echo $duration ?>s <?php echo $easing; ?> 0s;
        -ms-transition: -ms-transform <?php echo $duration ?>s <?php echo $easing; ?> 0s;
        -moz-transition: -moz-transform <?php echo $duration ?>s <?php echo $easing; ?> 0s;
        -webkit-transition: -webkit-transform <?php echo $duration ?>s <?php echo str_replace('-','',$easing); ?> 0s;
        -webkit-transition: -webkit-transform <?php echo $duration ?>s <?php echo $easing; ?> 0s;
        -o-transition: -o-transform <?php echo $duration ?>s <?php echo $easing; ?> 0s;
    }
    .nextend-csstransitions <?php echo $c['id']; ?> .slinner .sslide .subslide{
        transform: translate3d(0,0,0);
        -ms-transform: translate3d(0,0,0); /* IE 9 */
        -webkit-transform: translate3d(0,0,0); /* Safari and Chrome */
        -o-transform: translate3d(0,0,0); /* Opera */
        -moz-transform: translate3d(0,0,0); /* Firefox */
    }
    
    .nextend-csstransitions <?php echo $c['id']; ?> dd.sslide{
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
<?php endif; ?>

<?php
if(!$this->calc && isset($c['captioncss'])){
  include($c['captioncss']);
}

if(!$this->calc && isset($c['contentcss'])){
  include($c['contentcss']);
}
?>
