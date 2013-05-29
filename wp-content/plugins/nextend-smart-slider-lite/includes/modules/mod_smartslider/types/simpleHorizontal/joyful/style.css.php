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

include($c['clearcss']);
?>

<?php
  $count = count($this->env->slides);

  $size = OfflajnValueParser::parse( $sp->get('size'));
  $cwidth = $size[1][0];
  $cheight = $size[2][0];
  
  $outerborder = OfflajnValueParser::parse($sp->get('outerborder'));
  
  $pdngOut = $outerborder[0][0];
  $paddingOut = array($pdngOut, $pdngOut, $pdngOut, $pdngOut);

  $controllHeight = round(33*$ratio);
  if($this->env->slider->params->get('ctrlbar', 1) == 0){
    $controllHeight = -1;
  }
  
  $bak_size = OfflajnValueParser::parse( $sp->get('bak_size'));
  
  if(!$size[0]){
    $cwidth+= $paddingOut[1]+$paddingOut[3];
    $cheight+=$paddingOut[0]+$paddingOut[2]+$controllHeight+1;
  }lse if(isset($bak_size[0]) && $bak_size[0] == 0){
    $cheight =$bak_size[2][0]*$ratio+$paddingOut[0]+$paddingOut[2]+$controllHeight+1;
  }
?>

<?php echo $c['id']; ?> a:hover{
  text-decoration: none;
}

<?php echo $c['id']; ?> ul, <?php echo $c['id']; ?> .sslide{
  padding: 0;
  margin: 0;
  list-style-type: none;
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
  border-radius: <?php echo OfflajnValueParser::parseUnit($sp->get('borderradius', '0|*|0|*|0|*|0|*|px'), ' '); ?>;
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
  <?php if(!$sp->get('ctrlbarover')): ?>  
    height: <?php echo $cheight; ?>px;
  <?php else: ?>
    height: <?php echo $cheight - $controllHeight-1; ?>px;  
  <?php endif; ?>
  padding: <?php echo implode('px ', $paddingOut); ?>px;
  
  <?php 
    $bgshadow = $sp->get("bgshadow",1);
    if($bgshadow){
      print("
        box-shadow: 0px -1px 7px RGBA(0,0,0,0.3);
      ");
    }
  ?>
  
}

.dj_ie7 <?php echo $c['id']; ?> .outer{
  background-color: #<?php echo substr($color, 0, 6); ?>;
}

<?php echo $c['id']; ?> .slinner{
  width: <?php echo $cwidth; ?>px;
  height: <?php echo $cheight; ?>px;
  overflow: hidden;
  position: relative;
  padding: 0;
}

<?php echo $c['id']; ?> .controll{
  position: absolute;
  width: <?php echo $cwidth; ?>px;
  height: <?php echo $controllHeight; ?>px;
  left: 0;
  bottom: 0;
  <?php if(!$sp->get('ctrlbarover')): ?>  
  background: url('<?php echo $c['url']; ?>images/pattern.png') repeat;
  /* Alpha channel*/
  <?php 
    $color1 = $color = $bg;
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
  
  /* Alpha channel*/
  <?php 
    $color = $outerborder[1];
    if(strlen($color) == 6):
  ?>
  border-top: 1px solid #<?php echo $color; ?>;
  <?php else: 
    $alpha = round(hexdec(substr($color, 6, 2))/255, 1);
    if(hexdec(substr($color, 6, 2)) != 1):
  ?>
    border-top: 1px solid <?php echo substr($color, 0, 4); ?>;
    border-top: 1px solid rgba(<?php echo hexdec(substr($color, 0, 2)); ?>, <?php echo hexdec(substr($color, 2, 2)); ?>, <?php echo hexdec(substr($color, 4, 2)); ?>, <?php echo $alpha; ?>);
    <?php endif; ?>
  <?php endif; ?>
  /* Alpha channel*/
  <?php if($this->env->slider->params->get('ctrlbar', 1) == 0):?>
  display: none;
  <?php endif; ?>
  <?php else: ?>
    top: <?php echo $cheight - 2*$controllHeight; ?>px;  
  <?php endif; ?>
}

.dj_ie7 <?php echo $c['id']; ?> .controll{
  background-color: #<?php echo substr($color1, 0, 6); ?>;
  border-top: 1px solid #<?php echo substr($color, 0, 6); ?>;
}

<?php echo $c['id']; ?> .controllbtn{
  line-height: 32px;
  text-transform: uppercase;
  cursor: pointer;
  
  /*font chooser*/
  <?php if(!$this->calc) $fonts->printFont('controllfont', 'Text'); ?>
  /*font chooser*/
}

<?php echo $c['id']; ?> .controll .left{
  position: absolute;
  left: 0;
  top: 0;
  <?php if(!$sp->get('ctrlbarover')): ?>
  /* Alpha channel*/
  <?php 
    $color = $outerborder[1];
    if(strlen($color) == 6):
  ?>
  border-right: 1px solid #<?php echo $color; ?>;
  <?php else: 
    $alpha = round(hexdec(substr($color, 6, 2))/255, 1);
    if(hexdec(substr($color, 6, 2)) != 1):
  ?>
    border-right: 1px solid <?php echo substr($color, 0, 4); ?>;
    border-right: 1px solid rgba(<?php echo hexdec(substr($color, 0, 2)); ?>, <?php echo hexdec(substr($color, 2, 2)); ?>, <?php echo hexdec(substr($color, 4, 2)); ?>, <?php echo $alpha; ?>);
    <?php endif; ?>
  <?php endif; ?>
  /* Alpha channel*/
  <?php endif; ?>
  height: <?php echo $controllHeight; ?>px;
}

.dj_ie7 <?php echo $c['id']; ?> .controll .left{
  <?php if(!$sp->get('ctrlbarover')): ?>
    border-right: 1px solid #<?php echo substr($color, 0, 6); ?>;
  <?php endif; ?>
}

<?php echo $c['id']; ?> .controll .left > div{
  background: url('<?php echo $c['url']; ?>images/arrowleft.png') no-repeat left center;
  padding: 0 10px 0 20px;
  height: <?php echo $controllHeight; ?>px;
}

<?php echo $c['id']; ?> .controll .right{
  position: absolute;
  right: 0;
  top: 0;
  <?php if(!$sp->get('ctrlbarover')): ?>
  /* Alpha channel*/
  <?php 
    $color = $outerborder[1];
    if(strlen($color) == 6):
  ?>
  border-left: 1px solid #<?php echo $color; ?>;
  <?php else: 
    $alpha = round(hexdec(substr($color, 6, 2))/255, 1);
    if(hexdec(substr($color, 6, 2)) != 1):
  ?>
    border-left: 1px solid <?php echo substr($color, 0, 4); ?>;
    border-left: 1px solid rgba(<?php echo hexdec(substr($color, 0, 2)); ?>, <?php echo hexdec(substr($color, 2, 2)); ?>, <?php echo hexdec(substr($color, 4, 2)); ?>, <?php echo $alpha; ?>);
    <?php endif; ?>
  <?php endif; ?>
  /* Alpha channel*/
<?php endif; ?>
  height: <?php echo $controllHeight; ?>px;
  text-align: right;
}

.dj_ie7 <?php echo $c['id']; ?> .controll .right{
  <?php if(!$sp->get('ctrlbarover')): ?>
    border-left: 1px solid #<?php echo substr($color, 0, 6); ?>;
  <?php endif; ?>    
}

<?php echo $c['id']; ?> .controll .right > div{
  background: url('<?php echo $c['url']; ?>images/arrowright.png') no-repeat right center;
  padding: 0 20px 0 10px;
  height: <?php echo $controllHeight; ?>px;
}

<?php echo $c['id']; ?> .controll .right:hover, <?php echo $c['id']; ?> .controll .left:hover{
  background: #<?php echo substr($activebg,0,6); ?> url('<?php echo $c['url']; ?>images/pattern.png') repeat;
}

<?php echo $c['id']; ?> .controll .right:active, <?php echo $c['id']; ?> .controll .left:active{
  box-shadow:inset 1px 1px 5px RGBA(0,0,0,0.6);
}

<?php echo $c['id']; ?> .controll .dots{
  height: <?php echo $controllHeight; ?>px;
  margin: 0 auto;
}

<?php echo $c['id']; ?> .controll .dots .dot{
  background: url('<?php echo $c['url']; ?>images/dot.png') no-repeat center center;
  width: 13px;
  height: <?php echo $controllHeight; ?>px;
  padding: 0 3px;
  float: left;
  cursor: pointer;
}

<?php echo $c['id']; ?> .controll .dots .dot.selected{
  background-image: url('<?php if(!$this->calc) echo $this->themeCacheUrl.$c['helper']->ColorizeImage(dirname(__FILE__).'/images/dotselected.png', $bg, '188DD9'); ?>');
}

<?php
$canvasWidth = $cwidth;
$canvasHeight = $cheight = $cheight-$controllHeight-1;
?>

<?php echo $c['id']; ?> .slinner .slides{
  height: <?php echo $canvasHeight; ?>px;
  width: 200000px;
  position: absolute;
  top: 0;
  left: 0;
}

<?php echo $c['id']; ?> .slinner .sslide{
  width: <?php echo $canvasWidth; ?>px;
  height: <?php echo $canvasHeight; ?>px !important;
  float: left;
  position: relative;
  overflow: hidden;
  padding: 0;
  border: 0;
}

<?php echo $c['id']; ?> .slinner .canvas{
  width: <?php echo $canvasWidth; ?>px;
  height: <?php echo $canvasHeight; ?>px;
  float: left;
}

<?php if($sp->get('css3transition', 1) == 1): ?>
    <?php
    $mainanimation = OfflajnValueParser::parse($sp->get('mainanimation'));
    $duration = $mainanimation[0][0]/1000;
    $easing = dojoEasingToCSSEasing($mainanimation[1]);
    ?>
    .nextend-csstransitions <?php echo $c['id']; ?> .slinner .slides{
        margin-top:0px;
        transform: translate3d(0,0,0);
        -ms-transform: translate3d(0,0,0); /* IE 9 */
        -webkit-transform: translate3d(0,0,0); /* Safari and Chrome */
        -o-transform: translate3d(0,0,0); /* Opera */
        -moz-transform: translate3d(0,0,0); /* Firefox */
    }
    
    .nextend-csstransitions <?php echo $c['id']; ?> .controll .dots .dot.selected{
      background: url('<?php echo $c['url']; ?>images/dot.png') no-repeat center center;
    }
    
    <?php if($sp->get('transition', 1) == 1): ?>
    
    .nextend-csstransitions <?php echo $c['id']; ?> .slinner .slides{
        transition: all <?php echo $duration ?>s <?php echo $easing; ?> 0s;
        -moz-transition: all <?php echo $duration ?>s <?php echo $easing; ?> 0s;
        -webkit-transition: all <?php echo $duration ?>s <?php echo str_replace('-','',$easing); ?> 0s;
        -webkit-transition: all <?php echo $duration ?>s <?php echo $easing; ?> 0s;
        -o-transition: all <?php echo $duration ?>s <?php echo $easing; ?> 0s;
    }
    
    <?php for($i = 0; $i < count($this->env->slides); $i++ ): ?>
    .nextend-csstransitions <?php echo $c['id']; ?>.new-activeslide<?php echo $i; ?> .slinner .slides{
        transform: translate3d(<?php echo -$canvasWidth*$i; ?>px,0,0);
        -ms-transform: translate3d(<?php echo -$canvasWidth*$i; ?>px,0,0);
        -webkit-transform: translate3d(<?php echo -$canvasWidth*$i; ?>px,0,0);
        -o-transform: translate3d(<?php echo -$canvasWidth*$i; ?>px,0,0);
        -moz-transform: translate3d(<?php echo -$canvasWidth*$i; ?>px,0,0);
    }
    
    .nextend-csstransitions <?php echo $c['id']; ?>.new-activeslide<?php echo $i; ?> .controll .dots div.dot.dot-<?php echo $i; ?>{
      background-image: url('<?php if(!$this->calc) echo $this->themeCacheUrl.$c['helper']->ColorizeImage(dirname(__FILE__).'/images/dotselected.png', substr($activebg,0,6), '188DD9'); ?>');
    }
    <?php endfor; ?>
    <?php else: ?>
    .nextend-csstransitions <?php echo $c['id']; ?> .slinner .slides .sslide{
        position: absolute;
        opacity: 0;
        transition: opacity <?php echo $duration ?>s <?php echo $easing; ?> 0s;
        -moz-transition: opacity <?php echo $duration ?>s <?php echo $easing; ?> 0s;
        -webkit-transition: opacity <?php echo $duration ?>s <?php echo str_replace('-','',$easing); ?> 0s;
        -webkit-transition: opacity <?php echo $duration ?>s <?php echo $easing; ?> 0s;
        -o-transition: opacity <?php echo $duration ?>s <?php echo $easing; ?> 0s;
        z-index: 1;
    }
    .nextend-csstransitions <?php echo $c['id']; ?> .slinner .slides .sslide .canvas{
        position:absolute;
        top:0;
        left: 0;
    }
    <?php for($i = 0; $i < count($this->env->slides); $i++ ): ?>
    .nextend-csstransitions <?php echo $c['id']; ?>.new-activeslide<?php echo $i; ?> .slinner .slides .slide-<?php echo $i; ?>{
        opacity: 1;
        z-index: 2;
    }
    
    .nextend-csstransitions <?php echo $c['id']; ?>.new-activeslide<?php echo $i; ?> .controll .dots div.dot.dot-<?php echo $i; ?>{
      background-image: url('<?php if(!$this->calc) echo $this->themeCacheUrl.$c['helper']->ColorizeImage(dirname(__FILE__).'/images/dotselected.png', substr($activebg,0,6), '188DD9'); ?>');
    }
    <?php endfor; ?>
    <?php endif; ?>
<?php endif; ?>

<?php if($sp->get('transition', 1) == 2): ?>
    <?php echo $c['id']; ?> .canvas{
      position: absolute;
      top: 0;
      left: 0;
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

<?php echo $c['id']; ?> .slinner .canvas .onlybackground{
  box-shadow:inset 0px 0px 1px RGBA(255,255,255,0.8);
}