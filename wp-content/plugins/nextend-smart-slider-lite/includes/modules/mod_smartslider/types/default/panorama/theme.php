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

$sp = &$tthis->slider->params;
$buttonskin = OfflajnValueParser::parse($sp->get('buttonskin', 'new-dark|*|1'));
$slideids = array();
?>
<script type="text/javascript">
var captions = new Array;
var resizeableimages = new Array;
</script>
<div id="<?php echo $id; ?>" class="<?php echo $buttonskin[0]; ?>">
    <div class="slinner">
        <?php if($buttonskin[1] == 1): ?>
            <div class="controllLeft"></div>
            <div class="controllRight"></div>
        <?php endif; ?>
        <div class="mainframepipe">
          <?php 
          $x=0;
          foreach($tthis->slides as $slide): 
            $slideids[$slide->id] = array($x);
            $classes = array();
            if($x == 0)
              $classes[] = 'selected';
              
            $class = implode(' ', $classes);
            ?>
            <div class="<?php echo $class; ?> sslide new-slide-<?php echo $x; ?> <?php if($x == 0){ ?>selected<?php } ?>">
              <script type="text/javascript">
                captions[<?php echo $x; ?>] = new Array;
              </script>
              <?php $child = $slide->childs[0] ?>
              <div class="canvas">
                <?php echo $context['helper']->modulePositionReplacer($child->content); ?>
              </div>
              <script type="text/javascript">
                var caption = null;
              </script>
              <div class="caption">
                <?php echo $child->caption; ?>
              </div>
              <script type="text/javascript">
                captions[<?php echo $x; ?>] = caption;
              </script>
            </div>
          <?php ++$x; endforeach; ?>
        </div>
    </div>
    <div class="shadow"></div>
</div>
<?php
  $autoplay = OfflajnValueParser::parse($tthis->slider->params->get('autoplay'));
  $mainanim = OfflajnValueParser::parse($tthis->slider->params->get('mainanimation'));
  $css3animation = OfflajnValueParser::parse($sp->get('css3animation', '1|*|random|*|random'));
?>
<script type="text/javascript">
var <?php echo $id?>captions = odojo.clone(captions);
var <?php echo $id?>resizeableimages = odojo.clone(resizeableimages);
odojo.addOnLoad(odojo,function(){
  var dojo = this;
  new OfflajnSliderDefault({
    node: dojo.byId('<?php echo $id; ?>'),
    rawcaptions: <?php echo $id?>captions,
    autoplay: <?php echo $autoplay[2][0]; ?>,
    autoplayinterval: <?php echo $autoplay[0][0]; ?>,
    restartautoplay: <?php echo $autoplay[1]; ?>,
    maineasing: <?php echo $mainanim[1]; ?>,
    maininterval: <?php echo $mainanim[0][0]; ?>,
    mousescroll: <?php echo $tthis->slider->params->get('mousescroll', 1); ?>,
    transition: <?php echo $tthis->slider->params->get('transition', 1); ?>,
    css3animation: <?php echo $css3animation[0]; ?>,
    css3animationentrance: '<?php echo $css3animation[1]; ?>',
    css3animationexit: '<?php echo $css3animation[2]; ?>',
    url: '<?php echo JUri::root(); ?>',
    resizeableimages: <?php echo $id?>resizeableimages,
    responsive: <?php echo $sp->get('responsive', 0); ?>,
    responsivescaleup: <?php echo $sp->get('responsivescaleup', 1); ?>,
    css3transition: <?php echo $sp->get('css3transition', 0); ?>,
    imageresize: <?php echo $sp->get('imageresize', 0); ?>,
    slideids: <?php echo json_encode($slideids); ?>
  });
});
</script>