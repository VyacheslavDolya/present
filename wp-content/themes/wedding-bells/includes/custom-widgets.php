<?php
/** 125x125 ads widget **/
add_action( 'widgets_init', 'ad125_load_widgets' );

function ad125_load_widgets() {
	register_widget( 'Ad125_Widget' );
}

class Ad125_Widget extends WP_Widget {

	function Ad125_Widget() {
	
		$widget_ops = array( 'classname' => 'ad125', 'description' => __('A widget for your 125x125 ads.', 'ad125') );

		$control_ops = array( 'width' => 350, 'height' => 350, 'id_base' => 'ad125-widget' );

		$this->WP_Widget( 'ad125-widget', __('Ads 125x125 Widget', 'ad125'), $widget_ops, $control_ops );
	}

function widget( $args, $instance ) {
       extract( $args );

       $ad_1_img = $instance['ad_1_img'];
       $ad_1_alt = $instance['ad_1_alt'];
       $ad_1_url = $instance['ad_1_url'];
       $ad_2_img = $instance['ad_2_img'];
       $ad_2_alt = $instance['ad_2_alt'];
       $ad_2_url = $instance['ad_2_url'];
       $ad_3_img = $instance['ad_3_img'];
       $ad_3_alt = $instance['ad_3_alt'];
       $ad_3_url = $instance['ad_3_url'];
       $ad_4_img = $instance['ad_4_img'];
       $ad_4_alt = $instance['ad_4_alt'];
       $ad_4_url = $instance['ad_4_url'];
       
       
       if(isset($instance['add_nofollow'])){
           $add_nofollow = $instance['add_nofollow'];
       }
       else{
           $add_nofollow = false;
       }
             
       if($add_nofollow){
           $noFollowLink = 'rel="nofollow"';
       }

    echo $before_widget;

           if ( $ad_1_img!="http://" && $ad_1_img!="" && $ad_1_url!="http://" && $ad_1_url!="") {
              echo '<a href="'.$ad_1_url.'" '.$noFollowLink.'><img src="'.$ad_1_img.'" alt="'.$ad_1_alt.'" /></a>';
           }
              
           if ( $ad_2_img!="http://" && $ad_2_img!="" && $ad_2_url!="http://"  && $ad_2_url!="") {
              echo '<a href="'.$ad_2_url.'" '.$noFollowLink.'><img src="'.$ad_2_img.'" alt="'.$ad_2_alt.'" /></a>';
           }

           if ( $ad_3_img!="http://" && $ad_3_img!="" && $ad_3_url!="http://" && $ad_3_url!="" ) {
              echo '<a href="'.$ad_3_url.'" '.$noFollowLink.'><img src="'.$ad_3_img.'" alt="'.$ad_3_alt.'" /></a>';
           }

           if ( $ad_4_img!="http://" && $ad_4_img!="" && $ad_4_url!="http://" && $ad_4_url!="" ) {
              echo '<a href="'.$ad_4_url.'" '.$noFollowLink.'><img src="'.$ad_4_img.'" alt="'.$ad_4_alt.'" /></a>';
           }
          
      echo $after_widget;

   }

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['add_nofollow'] = $new_instance['add_nofollow'];
		$instance['ad_1_img'] = strip_tags( $new_instance['ad_1_img'] );
		$instance['ad_1_alt'] = strip_tags( $new_instance['ad_1_alt'] );
		$instance['ad_1_url'] = strip_tags( $new_instance['ad_1_url'] );
		$instance['ad_2_img'] = strip_tags( $new_instance['ad_2_img'] );
		$instance['ad_2_alt'] = strip_tags( $new_instance['ad_2_alt'] );
		$instance['ad_2_url'] = strip_tags( $new_instance['ad_2_url'] );
		$instance['ad_3_img'] = strip_tags( $new_instance['ad_2_img'] );
		$instance['ad_3_alt'] = strip_tags( $new_instance['ad_2_alt'] );
		$instance['ad_3_url'] = strip_tags( $new_instance['ad_2_url'] );
		$instance['ad_4_img'] = strip_tags( $new_instance['ad_2_img'] );
		$instance['ad_4_alt'] = strip_tags( $new_instance['ad_2_alt'] );
		$instance['ad_4_url'] = strip_tags( $new_instance['ad_2_url'] );

		return $instance;
	}

	function form( $instance ) {

		$defaults = array( 	'add_nofollow' => false,
							'ad_1_img' => __('http://', 'ad125'),
							'ad_1_alt' => __('', 'ad125'),
							'ad_1_url' => __('http://', 'ad125'),
							'ad_2_img' => __('http://', 'ad125'),
							'ad_2_alt' => __('', 'ad125'),
							'ad_2_url' => __('http://', 'ad125'),
							'ad_3_img' => __('http://', 'ad125'),
							'ad_3_alt' => __('', 'ad125'),
							'ad_3_url' => __('http://', 'ad125'),
							'ad_4_img' => __('http://', 'ad125'),
							'ad_4_alt' => __('', 'ad125'),
							'ad_4_url' => __('http://', 'ad125')
							);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<!-- Checkbox for nofollow option -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['add_nofollow'], true ); ?> id="<?php echo $this->get_field_id( 'add_nofollow' ); ?>" name="<?php echo $this->get_field_name( 'add_nofollow' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'add_nofollow' ); ?>"><?php _e('Add rel=nofollow to ad URLs?', 'ad125'); ?></label>
		</p>

		<!-- Ad #1 -->
		<p>
			<label for="<?php echo $this->get_field_id( 'ad_1_img' ); ?>"><?php _e('Ad #1 Image URL:', 'ad125'); ?></label>
			<input id="<?php echo $this->get_field_id( 'ad_1_img' ); ?>" name="<?php echo $this->get_field_name( 'ad_1_img' ); ?>" value="<?php echo $instance['ad_1_img']; ?>" class="widefat" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'ad_1_alt' ); ?>"><?php _e('Ad #1 Image alt text:', 'ad125'); ?></label>
			<input id="<?php echo $this->get_field_id( 'ad_1_alt' ); ?>" name="<?php echo $this->get_field_name( 'ad_1_alt' ); ?>" value="<?php echo $instance['ad_1_alt']; ?>" class="widefat" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'ad_1_url' ); ?>"><?php _e('Ad #1 URL:', 'ad125'); ?></label>
			<input id="<?php echo $this->get_field_id( 'ad_1_url' ); ?>" name="<?php echo $this->get_field_name( 'ad_1_url' ); ?>" value="<?php echo $instance['ad_1_url']; ?>" class="widefat" />
		</p>
		
		<!-- Ad #2 -->
		<p>
			<label for="<?php echo $this->get_field_id( 'ad_2_img' ); ?>"><?php _e('Ad #2 Image URL:', 'ad125'); ?></label>
			<input id="<?php echo $this->get_field_id( 'ad_2_img' ); ?>" name="<?php echo $this->get_field_name( 'ad_2_img' ); ?>" value="<?php echo $instance['ad_2_img']; ?>" class="widefat" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'ad_2_alt' ); ?>"><?php _e('Ad #2 Image alt text:', 'ad125'); ?></label>
			<input id="<?php echo $this->get_field_id( 'ad_2_alt' ); ?>" name="<?php echo $this->get_field_name( 'ad_2_alt' ); ?>" value="<?php echo $instance['ad_2_alt']; ?>" class="widefat" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'ad_2_url' ); ?>"><?php _e('Ad #2 URL:', 'ad125'); ?></label>
			<input id="<?php echo $this->get_field_id( 'ad_2_url' ); ?>" name="<?php echo $this->get_field_name( 'ad_2_url' ); ?>" value="<?php echo $instance['ad_2_url']; ?>" class="widefat" />
		</p>
		
		<!-- Ad #3 -->
		<p>
			<label for="<?php echo $this->get_field_id( 'ad_3_img' ); ?>"><?php _e('Ad #3 Image URL:', 'ad125'); ?></label>
			<input id="<?php echo $this->get_field_id( 'ad_3_img' ); ?>" name="<?php echo $this->get_field_name( 'ad_3_img' ); ?>" value="<?php echo $instance['ad_3_img']; ?>" class="widefat" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'ad_3_alt' ); ?>"><?php _e('Ad #3 Image alt text:', 'ad125'); ?></label>
			<input id="<?php echo $this->get_field_id( 'ad_3_alt' ); ?>" name="<?php echo $this->get_field_name( 'ad_3_alt' ); ?>" value="<?php echo $instance['ad_3_alt']; ?>" class="widefat" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'ad_3_url' ); ?>"><?php _e('Ad #3 URL:', 'ad125'); ?></label>
			<input id="<?php echo $this->get_field_id( 'ad_3_url' ); ?>" name="<?php echo $this->get_field_name( 'ad_3_url' ); ?>" value="<?php echo $instance['ad_3_url']; ?>" class="widefat" />
		</p>
		
		<!-- Ad #4 -->
		<p>
			<label for="<?php echo $this->get_field_id( 'ad_4_img' ); ?>"><?php _e('Ad #4 Image URL:', 'ad125'); ?></label>
			<input id="<?php echo $this->get_field_id( 'ad_4_img' ); ?>" name="<?php echo $this->get_field_name( 'ad_4_img' ); ?>" value="<?php echo $instance['ad_4_img']; ?>" class="widefat" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'ad_4_alt' ); ?>"><?php _e('Ad #4 Image alt text:', 'ad125'); ?></label>
			<input id="<?php echo $this->get_field_id( 'ad_4_alt' ); ?>" name="<?php echo $this->get_field_name( 'ad_4_alt' ); ?>" value="<?php echo $instance['ad_4_alt']; ?>" class="widefat" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'ad_4_url' ); ?>"><?php _e('Ad #4 URL:', 'ad125'); ?></label>
			<input id="<?php echo $this->get_field_id( 'ad_4_url' ); ?>" name="<?php echo $this->get_field_name( 'ad_4_url' ); ?>" value="<?php echo $instance['ad_4_url']; ?>" class="widefat" />
		</p>


	<?php
	}
}

?>
<?php
/** Social Media Badges Widget **/

add_action( 'widgets_init', 'social_load_widgets' );

function social_load_widgets() {
	register_widget( 'Social_Widget' );
}

class Social_Widget extends WP_Widget {

	/*** Widget setup. */
	function Social_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'social', 'description' => __('A widget for your Facebook, Twitter and RSS links.', 'social') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 350, 'height' => 350, 'id_base' => 'social-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'social-widget', __('Social Media Widget', 'social'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$facebook = $instance['facebook'];
		$twitter = $instance['twitter'];
		$rssfeed = $instance['rssfeed'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display name from widget settings if one was input. */
		if ( $facebook )
			printf( '<a href="' . __('%1$s', 'social') . '"><img src="'. get_template_directory_uri(). '/images/facebook_icon.png" alt="facebook" /></a>', $facebook );
			
		/* Display name from widget settings if one was input. */
		if ( $twitter )
			printf( '<a href="' . __('%1$s', 'social') . '"><img src="'. get_template_directory_uri(). '/images/twitter_icon.png" alt="twitter" /></a>', $twitter );
			
		/* Display name from widget settings if one was input. */
		if ( $rssfeed )
			printf( '<a href="' . __('%1$s', 'social') . '"><img src="'. get_template_directory_uri(). '/images/rss_icon.png" alt="rss" /></a>', $rssfeed );


		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['facebook'] = strip_tags( $new_instance['facebook'] );
		$instance['twitter'] = strip_tags( $new_instance['twitter'] );
		$instance['rssfeed'] = strip_tags( $new_instance['rssfeed'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'facebook' => __('http://', 'social'), 'twitter' => __('http://', 'social'), 'rssfeed' => 'http://' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e('Your Facebook address:', 'social'); ?></label>
			<input id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" value="<?php echo $instance['facebook']; ?>" class="widefat" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e('Your Twitter address:', 'social'); ?></label>
			<input id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" value="<?php echo $instance['twitter']; ?>" class="widefat" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'rssfeed' ); ?>"><?php _e('Your RSS feed address:', 'social'); ?></label>
			<input id="<?php echo $this->get_field_id( 'rssfeed' ); ?>" name="<?php echo $this->get_field_name( 'rssfeed' ); ?>" value="<?php echo $instance['rssfeed']; ?>" class="widefat" />
		</p>


	<?php
	}
}

?>
<?php
/** Recent photoblogs Widget **/

add_action( 'widgets_init', 'photoblog_load_widgets' );

function photoblog_load_widgets() {
	register_widget( 'Photoblog_Widget' );
}

class Photoblog_Widget extends WP_Widget {

	function Photoblog_Widget() {
		$widget_ops = array('classname' => 'widget_recent_photoblog_entries', 'description' => __( "The most recent photoblog posts on your site", 'weddingbells') );
		$this->WP_Widget('recent-photoblog-posts', __('Recent Photoblog Posts', 'weddingbells'), $widget_ops);
		$this->alt_option_name = 'widget_recent_photoblog_entries';

		add_action( 'save_post', array(&$this, 'flush_widget_cache') );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('widget_recent_photoblog_posts', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( isset($cache[$args['widget_id']]) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Photoblog Posts', 'weddingbells') : $instance['title'], $instance, $this->id_base);
		if ( !$number = (int) $instance['number'] )
			$number = 10;
		else if ( $number < 1 )
			$number = 2;
		else if ( $number > 12 )
			$number = 12;

		$r = new WP_Query(array('showposts' => $number, 'post_type' => 'photoblog', 'nopaging' => 0, 'post_status' => 'publish', 'caller_get_posts' => 1));
		if ($r->have_posts()) :
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul>
		<?php  while ($r->have_posts()) : $r->the_post(); ?>
		<li><a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php the_post_thumbnail('photoblog-small-size'); ?></a></li>
		<?php endwhile; ?>
		</ul><div class="clear"></div>
		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_recent_photoblog_posts', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_photoblog_entries']) )
			delete_option('widget_recent_photoblog_entries');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_recent_photoblog_posts', 'widget');
	}

	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		if ( !isset($instance['number']) || !$number = (int) $instance['number'] )
			$number = 4;
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','weddingbells'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of photoblog posts to show:','weddingbells'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
<?php
	}
}
?>