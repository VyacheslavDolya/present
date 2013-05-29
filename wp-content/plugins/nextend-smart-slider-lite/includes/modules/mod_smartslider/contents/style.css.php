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

<?php $c['contenturl'] = $c['url'].'../../../contents/'; ?>

<?php echo $c['id']; ?> .canvas{
  /* Alpha channel*/
  <?php 
    $color = $this->env->slider->params->get('bgcolor', 'ffffff');
    if(strlen($color) == 6):
  ?>
  background-color: #<?php echo $this->env->slider->params->get('bgcolor'); ?>;
  <?php else: 
    $alpha = round(hexdec(substr($color, 6, 2))/255, 1);
    if(hexdec(substr($color, 6, 2)) != 1):
  ?>
    background-color: #<?php echo substr($color, 0, 6); ?>;
    background: rgba(<?php echo hexdec(substr($color, 0, 2)); ?>, <?php echo hexdec(substr($color, 2, 2)); ?>, <?php echo hexdec(substr($color, 4, 2)); ?>, <?php echo $alpha; ?>);
    <?php endif; ?>
  <?php endif; ?>
  /* Alpha channel*/
}

<?php echo $c['id']; ?> .canvas a,
<?php echo $c['id']; ?> .canvas a:visited,
<?php echo $c['id']; ?> .canvas a:active,
<?php echo $c['id']; ?> .canvas a:hover{
  text-decoration: none;
  <?php $fonts->printFont('paragraphfont', 'Link', true); ?>
}

<?php echo $c['id']; ?> .column{
  margin: 15px 25px 15px;
  position: relative;
  height: <?php echo $canvasHeight-15*2; ?>px;
  float: none;
}

<?php echo $c['id']; ?> .column h3, 
<?php echo $c['id']; ?> .column h3 a{
  margin: 0;
  <?php $fonts->printFont('headingfont', 'Heading', true); ?>
}

<?php echo $c['id']; ?> .column h4{
  margin: 5px 0 0 0;
  <?php $fonts->printFont('headingfont', 'Subheading', true); ?>
}

<?php
$tmpratio = $ratio;
$ratio = 1;
?>
<?php echo $c['id']; ?> .column .tags{
  position: absolute;
  top: 0;
  right: 0;
  list-style-type: none;
  height: 23px;
}

<?php echo $c['id']; ?> .column .tags li{
  float: left;
  margin-left: 10px;
  display: block;
  height: 23px;
}

<?php echo $c['id']; ?> .column .tags li,
<?php echo $c['id']; ?> .column .tags a,
<?php echo $c['id']; ?> .column .tags span{
  height: 23px;
  display: block;
  <?php $fonts->printFont('paragraphfont', 'Tag', true); ?>
  line-height: 23px;
}

.dj_ie7 <?php echo $c['id']; ?> .column .tags span span,
.dj_ie8 <?php echo $c['id']; ?> .column .tags span span{
  zoom:1;
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=0);
}

<?php echo $c['id']; ?> .column .tags a span{
  cursor: pointer;
}

<?php 
$tag = '';
if(!$this->calc) $tag = $this->themeCacheUrl.$c['helper']->ColorizeImage(dirname(__FILE__).'/images/tag.png', substr($activebg,0,6), '188DD9'); 
?>


<?php echo $c['id']; ?> .column .tags li{
  background: url('<?php echo $tag; ?>') no-repeat 0 -52px;
  padding-left: 14px;
}

<?php echo $c['id']; ?> .column .tags li span{
  background: url('<?php echo $tag; ?>') no-repeat right -26px;
  padding-right: 4px;
}

<?php echo $c['id']; ?> .column .tags li span > span{
  background: url('<?php echo $tag; ?>') repeat-x 0 -1px;
  padding: 0 5px;
}

<?php
$ratio = $tmpratio;
?>

<?php echo $c['id']; ?> .column .hr{
  background: url('<?php echo $c['contenturl']; ?>images/dottedpattern.png') repeat-x;
  height: 7px;
  margin: 4px 0 6px;
  clear: both;
}


<?php echo $c['id']; ?> .column p{
  margin: 0;
  <?php $fonts->printFont('paragraphfont', 'Paragraph', true); ?>
}

<?php echo $c['id']; ?> .twocolumn p.col50.col1{
  float: left;
}

<?php echo $c['id']; ?> .twocolumn p.col50{
  width: 49%;
  float: right;
}

<?php echo $c['id']; ?> .threecolumn .columns{
  position: relative;
}

<?php echo $c['id']; ?> .threecolumn p.col33{
  width: 31%;
  position:absolute;
  right: 0;
  top: 0;
}

<?php echo $c['id']; ?> .threecolumn p.col33.col1{
  left: 0;
}

<?php echo $c['id']; ?> .threecolumn p.col33.col2{
  left: 50%;
  margin-left: -15.5%;
}

<?php echo $c['id']; ?> .threecolumn p.col33.normalflow{
  position: static;
  float:left;
  visibility: hidden;
}

<?php echo $c['id']; ?> .column .readmorecont{
  margin-top: 5px;
}

<?php 
$plussign = '';
if(!$this->calc) $plussign = $this->themeCacheUrl.$c['helper']->ColorizeImage(dirname(__FILE__).'/images/plussign.png', substr($activebg,0,6), '188DD9'); 
?>

<?php echo $c['id']; ?> .column a.ss-readmore,
<?php echo $c['id']; ?> .column a.ss-readmore:LINK,
<?php echo $c['id']; ?> .column a.ss-readmore:HOVER,
<?php echo $c['id']; ?> .column a.ss-readmore:ACTIVE,
<?php echo $c['id']; ?> .column a.ss-readmore:VISITED,
<?php echo $c['id']; ?> .column a.readmore,
<?php echo $c['id']; ?> .column a.readmore:LINK,
<?php echo $c['id']; ?> .column a.readmore:HOVER,
<?php echo $c['id']; ?> .column a.readmore:ACTIVE,
<?php echo $c['id']; ?> .column a.readmore:VISITED{
  background: url('<?php echo $plussign; ?>') no-repeat left center;
  background-size: contain;
  padding: 0 0 1px <?php echo 20*$ratio; ?>px;
  float: left;
  margin-top:6px;
  border: 0;
  <?php $fonts->printFont('readmorefont', 'Small', true); ?>
}

<?php echo $c['id']; ?> .rightimage .col1{
  float: left;
}

<?php echo $c['id']; ?> .rightimage .col2{
  text-align: center;
  float: right;
  height: 100%;
}

<?php echo $c['id']; ?> .rightimage .col2 a{
  display: block;
  height:100%;
  width:100%;
}

<?php echo $c['id']; ?> .leftimage .col1{
  text-align: center;
  float: left;
  height: 100%;
}

<?php echo $c['id']; ?> .leftimage .col1 a{
  display: block;
  height:100%;
  width:100%;
}

<?php echo $c['id']; ?> .leftimage .col2{
  float: right;
  height: 100%;
}

<?php
$tmpratio = $ratio;
$ratio = 1;
?>

<?php echo $c['id']; ?> .column .readmorebig, <?php echo $c['id']; ?> .column .readmorebig span{
  display: block;
  <?php $fonts->printFont('readmorefont', 'Big', true); ?>
  line-height: 31px;
}
<?php 
$readmore = '';
if(!$this->calc) $readmore = $this->themeCacheUrl.$c['helper']->ColorizeImage(dirname(__FILE__).'/images/readmore.png', substr($activebg,0,6), '188DD9'); 
?>

<?php echo $c['id']; ?> .column .readmorebig{
 position:absolute;
 bottom: 10px;
 right: 0;
 background: url('<?php echo $readmore; ?>') no-repeat 0 -62px;
 background-image: url('<?php echo $readmore; ?>');
 padding-left: 8px;
}

<?php echo $c['id']; ?> .column .readmorebig span{
 background: url('<?php echo $readmore; ?>') no-repeat right -31px;
 padding-right: 28px;
}

<?php echo $c['id']; ?> .column .readmorebig span > span{
 background: url('<?php echo $readmore; ?>') repeat-x;
 text-align: center;
 padding: 0 5px;
 text-transform: uppercase;
}


<?php
$ratio = $tmpratio;
?>

<?php echo $c['id']; ?> .rightimage .col1{
  height: 100%;
  position: relative;
}

<?php echo $c['id']; ?> .rightimage .readmorebig{
  left: 0;
  right: auto;
}

<?php echo $c['id']; ?> .onlybackground{
  background-repeat: no-repeat;
  background-size: cover;
}

<?php echo $c['id']; ?> .onlybackground a{
  display: block;
  width: 100%;
  height: 100%;
}
/*
*Quotes
*/

<?php echo $c['id']; ?> .quotes.centerquote {
  font-family: "PT Sans",Arial,Helvetica;
  font-size: 17px;
}


<?php echo $c['id']; ?> .quotes.centerquote .quotemark_b {
  width: 102px;
  height: 82px;
  background: url('<?php echo $this->themeCacheUrl.$c['helper']->ColorizeImage(dirname(__FILE__).'/images/quotemark_b.png', substr($activebg,0,6), '188DD9') ?>') no-repeat;
  float: left;
  margin-right: 5px;
}

<?php echo $c['id']; ?> .quotes.centerquote .quote_text {
  font-style: italic;
}

<?php echo $c['id']; ?> .quotes.centerquote .quote_signature {
  margin-top: 10px;
  font-weight: bold;
  font-style: italic;
  float: right;
}

<?php echo $c['id']; ?> .quotes.leftimage,
<?php echo $c['id']; ?> .quotes.leftimage_s,
<?php echo $c['id']; ?> .quotes.rightimage,
<?php echo $c['id']; ?> .quotes.rightimage_s {
  font-family: "PT Sans",Arial,Helvetica;
  font-size: 17px;
  font-style: italic;
}

<?php echo $c['id']; ?> .quotes.leftimage .col1,
<?php echo $c['id']; ?> .quotes.leftimage_s .col1 {
  text-align: center;
  float: left;
}

<?php echo $c['id']; ?> .quotes.leftimage .col2,
<?php echo $c['id']; ?> .quotes.leftimage_s .col2 {
  float: right;
}

<?php echo $c['id']; ?> .quotes.leftimage .col2 .quote_text,
<?php echo $c['id']; ?> .quotes.rightimage .col1 .quote_text {
  background: url('<?php echo $this->themeCacheUrl.$c['helper']->ColorizeImage(dirname(__FILE__).'/images/quotemark_b_bg.png', substr($activebg,0,6), '188DD9') ?>') no-repeat center center;
  height: 184px;
  display: table;
  min-width: 234px;
}

<?php echo $c['id']; ?> .quotes.leftimage .col2 .quote_text p,
<?php echo $c['id']; ?> .quotes.rightimage .col1 .quote_text p {
   display: table-cell;
  vertical-align: middle;
}

<?php echo $c['id']; ?> .quotes.leftimage .col2 .quote_signature,
<?php echo $c['id']; ?> .quotes.leftimage_s .col2 .quote_signature,
<?php echo $c['id']; ?> .quotes.rightimage .col1 .quote_signature,
<?php echo $c['id']; ?> .quotes.rightimage_s .col1 .quote_signature {
  float: right;
  font-weight: bold;
}

<?php echo $c['id']; ?> .quotes.rightimage .col1,
<?php echo $c['id']; ?> .quotes.rightimage_s .col1 {
  float: left;
}

<?php echo $c['id']; ?> .quotes.rightimage .col2,
<?php echo $c['id']; ?> .quotes.rightimage_s .col2 {
  text-align: center;
  float: right;
}

<?php echo $c['id']; ?> .quotes.leftimage_s .col2 .quotemark_s,
<?php echo $c['id']; ?> .quotes.rightimage_s .col1 .quotemark_s {
  width: 80px;
  height: 64px;
  background: url('<?php echo $this->themeCacheUrl.$c['helper']->ColorizeImage(dirname(__FILE__).'/images/quotemark_s.png', substr($activebg,0,6), '188DD9') ?>') no-repeat;
  float: left;
  margin-right: 5px;
}

<?php echo $c['id']; ?> .quotes.leftimage_s .col2 .quote_text,
<?php echo $c['id']; ?> .quotes.rightimage_s .col2 .quote_text {

}