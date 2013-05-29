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
      <dl>
      <?php 
      $x=0;
      foreach($tthis->slides as $slide): 
      $classes = array();
      if($x == 0)
        $classes[] = 'selected';
        
      $class = implode(' ', $classes);
      ?>
        <dt class="<?php echo $class; ?> sslide slide-<?php echo $x; ?>">
          <span class="slideinner">
            <span class="slidepattern">
              <span class="rotated-90">
                <span class="title">
                  <?php echo $slide->title; ?>
                </span>  
                </span>
                <span class="numbering">
                    <?php echo $x+1; ?>
                </span>
                <?php 
                $icon = '';
                if(property_exists($slide, 'icon') && $slide->icon != '' && $slide->icon != '-1'){
                  if(defined('ABSPATH')){
                    $icon = $slide->icon;
                  }else{
                    $icon = JURI::root().$slide->icon;
                  }
                }
                ?>
                <span class="icon" style="<?php if($icon != '') : ?>background-image:url('<?php echo $icon; ?>');<?php endif; ?>"></span>
            </span>
          </span>
        </dt>
        <dd class="<?php echo $class; ?> sslide slide-<?php echo $x; ?>">
          <script type="text/javascript">
            captions[<?php echo $x; ?>] = new Array;
          </script>
          <ul class="vertical">
            <?php $y = 0; foreach($slide->childs AS $child){ 
              $slideids[$child->id] = array($x, $y);
            ?>
            <li class="subslide slide-<?php echo $x; ?>-<?php echo $y; ?>">
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
                captions[<?php echo $x; ?>][<?php echo $y; ?>] = caption;
              </script>
            </li>
            <?php ++$y; } ?>
          </ul>
          <div class="arrowdown"></div>
          <div class="arrowup"></div>
        </dd>
      <?php ++$x; endforeach; ?>
      </dl>
    </div>
  </div>
  <div class="shadow"></div>
</div>
  <?php
    $autoplay = OfflajnValueParser::parse($tthis->slider->params->get('autoplay'));
    $mainanim = OfflajnValueParser::parse($tthis->slider->params->get('mainanimation'));
    $secondanim = OfflajnValueParser::parse($tthis->slider->params->get('secondaryanimation'));
?>
<script type="text/javascript">
var <?php echo $id?>captions = odojo.clone(captions);
var <?php echo $id?>resizeableimages = odojo.clone(resizeableimages);
odojo.addOnLoad(odojo,function(){
  var dojo = this;
  new OfflajnSlider({
    node: dojo.byId('<?php echo $id; ?>'),
    rawcaptions: <?php echo $id?>captions,
    autoplay: <?php echo $autoplay[2][0]; ?>,
    autoplayinterval: <?php echo $autoplay[0][0]; ?>,
    restartautoplay: <?php echo $autoplay[1]; ?>,
    maineasing: <?php echo $mainanim[1]; ?>,
    maininterval: <?php echo $mainanim[0][0]; ?>,
    secondaryinterval: <?php echo $secondanim[0][0]; ?>,
    secondaryeasing: <?php echo $secondanim[1]; ?>,
    mousescroll: <?php echo $tthis->slider->params->get('mousescroll', 1); ?>,
    showdots: <?php echo $tthis->slider->params->get('showdots', 1); ?>,
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