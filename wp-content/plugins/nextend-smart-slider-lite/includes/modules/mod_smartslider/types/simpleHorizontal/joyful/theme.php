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
$slideids = array();
?>
<script type="text/javascript">
var captions = new Array;
var resizeableimages = new Array;
</script>
<div id="<?php echo $id; ?>" class="new-activeslide0">
  <div class="outer">
    <div class="slinner">
      <ul class="slides">
      <?php 
      $x=0;
      foreach($tthis->slides as $slide): 
        $slideids[$slide->id] = array($x);
        $classes = array();
        if($x == 0)
          $classes[] = 'selected';
          
        $class = implode(' ', $classes);
        ?>
        <li class="<?php echo $class; ?> sslide slide-<?php echo $x; ?>">
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
        </li>
      <?php ++$x; endforeach; ?>
      </ul>
      <div class="controll">
        <?php if($tthis->slider->params->get('ctrlbtn', 1)): ?>
        <div class="left controllbtn"><div><?php echo (JText::_('SS-Previous') != 'SS-Previous' ? JText::_('SS-Previous') : 'Previous'); ?></div></div>
        <?php endif; ?>
        <div class="dots" style="width: <?php echo count($tthis->slides)*19; ?>px;">
          <?php foreach($tthis->slides as $k => $slide): ?>
            <div class="dot dot-<?php echo $k; ?>""></div>
          <?php ++$x; endforeach; ?>
        </div>
        <?php if($tthis->slider->params->get('ctrlbtn', 1)): ?>
        <div class="right controllbtn"><div><?php echo (JText::_('SS-Next') != 'SS-Next' ? JText::_('SS-Next') : 'Next'); ?></div></div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="shadow"></div>
</div>
<?php
  $autoplay = OfflajnValueParser::parse($tthis->slider->params->get('autoplay'));
  $mainanim = OfflajnValueParser::parse($tthis->slider->params->get('mainanimation'));
?>
<script type="text/javascript">
var <?php echo $id?>captions = odojo.clone(captions);
var <?php echo $id?>resizeableimages = odojo.clone(resizeableimages);
odojo.addOnLoad(odojo, function(){
  var dojo = this;
  new OfflajnSliderSimpleHorizontal({
    node: dojo.byId('<?php echo $id; ?>'),
    rawcaptions: <?php echo $id?>captions,
    autoplay: <?php echo $autoplay[2][0]; ?>,
    autoplayinterval: <?php echo $autoplay[0][0]; ?>,
    restartautoplay: <?php echo $autoplay[1]; ?>,
    maineasing: <?php echo $mainanim[1]; ?>,
    maininterval: <?php echo $mainanim[0][0]; ?>,
    mousescroll: <?php echo $tthis->slider->params->get('mousescroll', 1); ?>,
    transition: <?php echo $tthis->slider->params->get('transition', 1); ?>,
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