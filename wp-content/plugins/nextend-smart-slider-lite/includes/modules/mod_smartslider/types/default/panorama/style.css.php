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
include ($c['clearcss']);
?>

<?php echo $c['id']; ?> a:hover{
  text-decoration: none;
}

<?php
$size = OfflajnValueParser::parse($sp->get('size'));
$cwidth = $size[1][0];
$cheight = $size[2][0];
?>

<?php echo $c['id']; ?>{
  position: relative;
  width: <?php echo $cwidth; ?>px;
  margin: 0 auto;
}

<?php
$buttonskin = OfflajnValueParser::parse($sp->get('buttonskin', 'new-dark|*|1'));
if($buttonskin[1] == 1):
$controli = '';
$ciheight = 69;
$ciwidth = 50;
if(!$this->calc){
  $ciheight = intval(69*$ratio);
  if($ciheight < 35) $ciheight = 30;
  $ciwidth = intval(50*($ciheight/69));
  $path = dirname(__FILE__).DIRECTORY_SEPARATOR.'images/buttons.png';
  if(defined('ABSPATH')){
    if(is_file($path)){
      $controli = $this->themeCacheUrl.$c['helper']->ResizeImage($path, 0, $ciheight);
    }

  }else if(is_file($path)){
    $controli = $this->themeCacheUrl.$c['helper']->ResizeImage($path, 0, $ciheight);
  }
  $fciwidth = $GLOBALS['width'];
} 

?>
    <?php echo $c['id']; ?> .controllLeft, <?php echo $c['id']; ?> .controllRight{
        position: absolute;
        left: 0;
        top: 50%;
        width: <?php echo $ciwidth; ?>px;
        margin-top: <?php echo $ciheight/-2; ?>px;
        height: <?php echo $ciheight; ?>px;
        z-index: 5;
        background: url('<?php echo $controli; ?>') no-repeat;
        cursor: pointer;
        <?php if ($this->env->slider->params->get('leftrightcontrol', 1) == 0): ?>
        display: none;
        <?php
    endif; ?>
        opacity: 0;
        transform: translate3d(-50px,0,0);
        -ms-transform: translate3d(-50px,0,0); /* IE 9 */
        -webkit-transform: translate3d(-50px,0,0); /* Safari and Chrome */
        -o-transform: translate3d(-50px,0,0); /* Opera */
        -moz-transform: translate3d(-50px,0,0); /* Firefox */
        
        transition: opacity 0.4s ease 0s, transform 0.4s ease 0s;
        -ms-transition: opacity 0.4s ease 0s, -ms-transform 0.4s ease 0s;
        -moz-transition: opacity 0.4s ease 0s, -moz-transform 0.4s ease 0s;
        -webkit-transition: opacity 0.4s ease 0s, -webkit-transform 0.4s ease 0s;
        -o-transition: opacity 0.4s ease 0s, -o-transform 0.4s ease 0s;
    }
    
    <?php echo $c['id']; ?> .controllRight{
        left: auto;
        right: 0;
        transform: translate3d(50px,0,0);
        -ms-transform: translate3d(50px,0,0); /* IE 9 */
        -webkit-transform: translate3d(50px,0,0); /* Safari and Chrome */
        -o-transform: translate3d(50px,0,0); /* Opera */
        -moz-transform: translate3d(50px,0,0); /* Firefox */
    }
    
    <?php echo $c['id']; ?> .controllRight:ACTIVE,
    <?php echo $c['id']; ?> .controllLeft:ACTIVE{
        margin-top: <?php echo $ciwidth/-2; ?>px;
    }
    
    <?php echo $c['id']; ?>.new-large .controllLeft{
        background-position: 0px center;
    }
    
    <?php echo $c['id']; ?>.new-large  .controllRight{
        background-position: <?php echo $ciwidth*-1; ?>px center;
    }
    
    <?php echo $c['id']; ?>.new-dark .controllLeft{
        background-position: <?php echo $ciwidth*-2; ?>px center;
    }
    
    <?php echo $c['id']; ?>.new-dark  .controllRight{
        background-position: <?php echo $ciwidth*-3; ?>px center;
    }
    
    <?php echo $c['id']; ?>.new-light .controllLeft{
        background-position: <?php echo $ciwidth*-4; ?>px center;
    }
    
    <?php echo $c['id']; ?>.new-light  .controllRight{
        background-position: <?php echo $ciwidth*-5; ?>px center;
    }
    
    <?php echo $c['id']; ?>:HOVER .controllLeft,
    <?php echo $c['id']; ?>:HOVER .controllRight{
        opacity: 1;
        transform: translate3d(0,0,0);
        -ms-transform: translate3d(0,0,0); /* IE 9 */
        -webkit-transform: translate3d(0,0,0); /* Safari and Chrome */
        -o-transform: translate3d(0,0,0); /* Opera */
        -moz-transform: translate3d(0,0,0); /* Firefox */
    }
<?php
endif;
?>

<?php
$shadoww = $cwidth;
?>

<?php
$shadow = '';
if (!$this->calc && $sp->get('shadow') != '') {
  if (defined('ABSPATH')) {
    $sh = $sp->get('shadow');
    if (strpos($sh, site_url()) === 0) {
      $path = ABSPATH . str_replace(site_url() , '', $sh);
      if (is_file($path)) {
        $shadow = $this->themeCacheUrl . $c['helper']->ResizeImage(ABSPATH . str_replace(site_url() , '', $sh) , $shadoww, 0);
      }
    } else {
      $shadow = $sh;
      $GLOBALS['height'] = 100;
    }
  } else if (is_file(JPATH_SITE . $sp->get('shadow'))) {
    $shadow = $this->themeCacheUrl . $c['helper']->ResizeImage(JPATH_SITE . $sp->get('shadow') , $shadoww, 0);
  }
}
?>

<?php echo $c['id']; ?> .shadow{
  width: <?php echo $cwidth; ?>px;
  background: url('<?php echo $shadow; ?>') no-repeat;
  height: <?php echo isset($GLOBALS['height']) ? $GLOBALS['height'] : 0; ?>px;
}

<?php if ($shadow): ?>
  <?php echo $c['id']; ?> .shadow{
    width: <?php echo $shadoww; ?>px;
    background: url('<?php echo $shadow; ?>') no-repeat;
    height: <?php echo isset($GLOBALS['height']) ? $GLOBALS['height'] : 0; ?>px;
    margin: 0 auto;
    margin-top: -<?php echo round(($cheightOld - $cheight) / 2) - 6; ?>px;
  }
<?php
else: ?>
  <?php echo $c['id']; ?> .shadow{
    display: none;
  }
<?php
endif; ?>

<?php echo $c['id']; ?> .slinner{
  width: <?php echo $cwidth; ?>px;
  height: <?php echo $cheight; ?>px;
  position: relative;
  overflow:hidden;
}

<?php echo $c['id']; ?> .slinner .mainframepipe{
  width: <?php echo $count * $cwidth; ?>px;
  height: <?php echo $cheight; ?>px;
  margin-left: 0;
  position: absolute;
  top:0;
  left: 0;
}

<?php echo $c['id']; ?> .slinner .sslide{
  width: <?php echo $cwidth; ?>px;
  height: <?php echo $cheight; ?>px !important;
  position: relative;
  float: left;
  overflow: hidden;
}

<?php if ($sp->get('transition', 1) == 2): ?>
    <?php echo $c['id']; ?> .slinner .sslide{
        position: absolute;
        top:0;
        left:0;
        z-index: 1;
    }
    
    .nextend-csstransitions <?php echo $c['id']; ?>  .sslide.selected{
        z-index: 2;
    }
<?php
endif; ?>

<?php
$canvasHeight = $cheight;
$canvasWidth = $cwidth;
?>

<?php echo $c['id']; ?> .sslide .canvas{
  height: <?php echo $canvasHeight; ?>px;
  width: <?php echo $canvasWidth; ?>px;
  overflow: hidden;
}
<?php if ($sp->get('css3transition', 1) == 1): ?>
    <?php
    
    $css3animation = OfflajnValueParser::parse($sp->get('css3animation', '1|*|random|*|random'));
    $mainanimation = OfflajnValueParser::parse($sp->get('mainanimation'));
    $duration = $mainanimation[0][0] / 1000;
    $easing = dojoEasingToCSSEasing($mainanimation[1]);
    if($css3animation[0] != 1):
    ?>
        <?php if ($sp->get('transition', 1) == 1): ?>
            .nextend-csstransitions <?php echo $c['id']; ?>  .mainframepipe{
                transform: translate3d(0,0,0);
                -ms-transform: translate3d(0,0,0); /* IE 9 */
                -webkit-transform: translate3d(0,0,0); /* Safari and Chrome */
                -o-transform: translate3d(0,0,0); /* Opera */
                -moz-transform: translate3d(0,0,0); /* Firefox */
                transition: transform <?php echo $duration ?>s <?php echo $easing; ?> 0s;
                -ms-transition: -ms-transform <?php echo $duration ?>s <?php echo $easing; ?> 0s;
                -moz-transition: -moz-transform <?php echo $duration ?>s <?php echo $easing; ?> 0s;
                -webkit-transition: -webkit-transform <?php echo $duration ?>s <?php echo str_replace('-', '', $easing); ?> 0s;
                -webkit-transition: -webkit-transform <?php echo $duration ?>s <?php echo $easing; ?> 0s;
                -o-transition: -o-transform <?php echo $duration ?>s <?php echo $easing; ?> 0s;
            }
        <?php
      elseif ($sp->get('transition', 1) == 2): ?>
            .nextend-csstransitions <?php echo $c['id']; ?>  .sslide{
                transform: translate3d(0,0,0);
                -ms-transform: translate3d(0,0,0); /* IE 9 */
                -webkit-transform: translate3d(0,0,0); /* Safari and Chrome */
                -o-transform: translate3d(0,0,0); /* Opera */
                -moz-transform: translate3d(0,0,0); /* Firefox */
                transition: opacity <?php echo $duration ?>s <?php echo $easing; ?> 0s;
                -ms-transition: opacity <?php echo $duration ?>s <?php echo $easing; ?> 0s;
                -moz-transition: opacity <?php echo $duration ?>s <?php echo $easing; ?> 0s;
                -webkit-transition: opacity <?php echo $duration ?>s <?php echo str_replace('-', '', $easing); ?> 0s;
                -webkit-transition: opacity <?php echo $duration ?>s <?php echo $easing; ?> 0s;
                -o-transition: opacity <?php echo $duration ?>s <?php echo $easing; ?> 0s;
                opacity: 0;
                z-index: 1;
            }
            
            .nextend-csstransitions <?php echo $c['id']; ?>  .sslide.selected{
                opacity: 1;
                z-index: 2;
            }
        <?php
      endif; ?>
    <?php
  else: ?>
  .nextend-csstransitions <?php echo $c['id']; ?>  .sslide{
    position: absolute;
    top: 0;
    left: 0;
    -webkit-animation-fill-mode: both;
    -moz-animation-fill-mode: both;
    -ms-animation-fill-mode: both;
    -o-animation-fill-mode: both;
    animation-fill-mode: both;
    -webkit-animation-duration: <?php echo $duration ?>s;
    -moz-animation-duration: <?php echo $duration ?>s;
    -ms-animation-duration: <?php echo $duration ?>s;
    -o-animation-duration: <?php echo $duration ?>s;
    animation-duration: <?php echo $duration ?>s;
    z-index:1;
    display:none;
  }
  
  .hinge {
        -webkit-animation-duration: <?php echo 2*$duration ?>s;
        -moz-animation-duration: <?php echo 2*$duration ?>s;
        -ms-animation-duration: <?php echo 2*$duration ?>s;
        -o-animation-duration: <?php echo 2*$duration ?>s;
        animation-duration: <?php echo 2*$duration ?>s;
    }
  
  .nextend-csstransitions <?php echo $c['id']; ?>  .sslide.animating{
    z-index:2;
    display:block;
  }
  .nextend-csstransitions <?php echo $c['id']; ?>  .sslide.selected{
    z-index:3;
    display:block;
  }
  
  <?php
  include dirname(__FILE__).DIRECTORY_SEPARATOR.'animate.css';
  ?>
    <?php
  endif; ?>
<?php
endif; ?>



<?php
if (!$this->calc && isset($c['captioncss'])) {
  include ($c['captioncss']);
}
if (!$this->calc && isset($c['contentcss'])) {
  include ($c['contentcss']);
}
?>


<?php if ($sp->get('css3transition', 1) == 1 && $css3animation[0] == 1): ?>
<?php echo $c['id']; ?> .sslide .caption .fromright,
<?php echo $c['id']; ?> .sslide .caption .frombottom{
  display: none;
}

<?php echo $c['id']; ?> .sslide.animating .caption .fromright,
<?php echo $c['id']; ?> .sslide.selected .caption .fromright,
<?php echo $c['id']; ?> .sslide.animating .caption .frombottom,
<?php echo $c['id']; ?> .sslide.selected .caption .frombottom{
  display: block;
}
<?php
endif; ?>