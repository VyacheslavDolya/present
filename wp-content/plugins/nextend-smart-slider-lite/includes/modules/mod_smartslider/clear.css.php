<?php 
/*------------------------------------------------------------------------
# smartslider - Smart Slider
# ------------------------------------------------------------------------
# author    Roland Soos 
# copyright Copyright (C) 2011 Offlajn.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.offlajn.com
-------------------------------------------------------------------------*/
defined('_JEXEC') or die('Restricted access');
global $ratio;

if(!isset($calc)) $calc = 0;

$sp = &$this->env->slider->params;

$ratio = round($sp->get('ratio', 1),2);

if(!$calc){
  $fonts = new OfflajnFontHelper($this->env->slider->params);
  echo $fonts->parseFonts();
}

$count = count($this->env->slides);
  
$tabcolor = OfflajnValueParser::parse( $sp->get('tabbg'));
$bg = $tabcolor[0];
$activebg = $tabcolor[1];
?>

div<?php echo $c['id']; ?> div,
div<?php echo $c['id']; ?> dl,
div<?php echo $c['id']; ?> dd,
div<?php echo $c['id']; ?> ul.tags,
div<?php echo $c['id']; ?> ul.tags li,
div<?php echo $c['id']; ?> ul.slides,
div<?php echo $c['id']; ?> ul li.sslide,
div<?php echo $c['id']; ?> ul li.slide,
div<?php echo $c['id']; ?> ul.vertical,
div<?php echo $c['id']; ?> li.subslide,
div<?php echo $c['id']; ?> h1,
div<?php echo $c['id']; ?> h2,
div<?php echo $c['id']; ?> h3,
div<?php echo $c['id']; ?> h4,
div<?php echo $c['id']; ?> h5,
div<?php echo $c['id']; ?> h6,
div<?php echo $c['id']; ?> p,
div<?php echo $c['id']; ?> .title{
  padding: 0;
  margin: 0;
  border: 0;
  list-style-type: none;
  text-align: left;
  background-color: transparent;
  position: static;
  text-transform: none;
  border-radius: 0;
  -moz-user-select: none;
}

div<?php echo $c['id']; ?> span{
  box-shadow: none;
}

div<?php echo $c['id']; ?>{
    transform: translate3d(0,0,0);
    -ms-transform: translate3d(0,0,0); /* IE 9 */
    -webkit-transform: translate3d(0,0,0); /* Safari and Chrome */
    -o-transform: translate3d(0,0,0); /* Opera */
    -moz-transform: translate3d(0,0,0); /* Firefox */
}

.safari5 <?php echo $c['id']; ?>,
.safari5 <?php echo $c['id']; ?> *:not(.rotated-90){
    -webkit-transform: none !important;
}

div<?php echo $c['id']; ?> .title{
  background:none;
  text-shadow: none;
}


div<?php echo $c['id']; ?> div div .sslide a{
  padding: 0;
  margin: 0;
  border: 0;
  background-color: transparent;
}

<?php echo $c['id']; ?> dt.sslide, 
<?php echo $c['id']; ?> dd.sslide, 
<?php echo $c['id']; ?> li.subslide{
  clear: none;
  border: 0;
}