<?php

class SmartSliderWidget extends WP_Widget
{
  function SmartSliderWidget()
  {
    
    $widget_ops = array('classname' => 'SmartSliderWidget', 'description' => 'Displays a Smart Slider.' );
    $this->WP_Widget('SmartSliderWidget', 'Smart Slider', $widget_ops);
  }
 
  function form($instance)
  {
    global $wpdb;
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
    $selected_slider = $instance['slider'];
    $sliders = $wpdb->get_results( "SELECT id, name FROM $wpdb->offlajn_slider WHERE published=1" );
    
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
  <p><label for="<?php echo $this->get_field_id('slider'); ?>">Slider: 
    <?php 
    if (is_array($sliders) && count($sliders)>0) {
      ?>
      <select name="<?php echo $this->get_field_name('slider'); ?>" id="<?php echo $this->get_field_id('slider'); ?>">
      <?php
      foreach ($sliders as $slider) { ?>
        <option class="widefat" value="<?php echo attribute_escape($slider->id); ?>" <?php if($selected_slider==$slider->id) echo "selected=selected" ?>><?php echo attribute_escape($slider->name); ?></option>
    <?php
      }
    ?>
      </select>
    <?php
    }
  ?>
  </label>
  </p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['slider'] = $new_instance['slider'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    global $smartslider;
    extract($args, EXTR_SKIP);
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title))
      echo $before_title . $title . $after_title;
 
    echo do_shortcode("[SmartSlider ".$instance['slider']."]");
 
    echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("SmartSliderWidget");') );
?>