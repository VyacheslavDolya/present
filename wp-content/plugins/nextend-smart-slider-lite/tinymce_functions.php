<?php

function smartslider_addbuttons() {
    // Setup the stylesheet to use for the modal window interaction
    wp_register_style( 'smartslider-ui-styles', smartslider_url( '/lib/tinymce3/smartslider-jquery-ui.css' ) );

    // Return false if the user does not have WYSIWYG editing privileges
    if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
        return false;
    }
    
    // Add buttons to TinyMCE editor if user can edit with WYSIWYG editor
    if ( 'true' == get_user_option( 'rich_editing' ) ) {
        add_filter( 'mce_external_plugins', 'smartslider_add_tinymce_plugin' );
        add_filter( 'mce_buttons', 'smartslider_register_button' );
    }

    // Only load the necessary scripts if the user is on the post/page editing admin pages
    if ( in_array( basename( $_SERVER['PHP_SELF'] ), array( 'post-new.php', 'page-new.php', 'post.php', 'page.php' ) ) ) {
        wp_enqueue_script( 'smartslider-ui-dialog' );
        wp_enqueue_script( 'smartslider-sidebar', smartslider_url( '/lib/smartslider-sidebar.js' ), array('jquery-ui-dialog'), '0.0.1', true );
        wp_enqueue_style( 'smartslider-ui-styles' );
    }
}


function smartslider_register_button( $buttons ) {
    array_push( $buttons, "separator", "smartslider" );
    return $buttons;
}


function smartslider_add_tinymce_plugin( $plugin_array ) {
    if( !smartslider_is_plugin() ) {
        $plugin_array['smartslider'] = smartslider_url( '/lib/tinymce3/editor-plugin.js' );
    }

    return $plugin_array;
}


function smartslider_tinymce_plugin_dialog() {
    global $wpdb;
    if ( in_array( basename( $_SERVER['PHP_SELF'] ), array( 'post-new.php', 'page-new.php', 'post.php', 'page.php' ) ) ) {
      
      $wpdb->offlajn_slide = $wpdb->base_prefix.'offlajn_slide';
      $wpdb->offlajn_slider = $wpdb->base_prefix.'offlajn_slider';
      
      $query = 'SELECT a.*, count(1) AS slides '
        . ' FROM '.$wpdb->offlajn_slider.' AS a'
        . ' LEFT JOIN '.$wpdb->offlajn_slide.' AS b ON a.id = b.slider'
        . ' WHERE a.published = 1'
        . ' GROUP BY a.id';
      $smartsliders = $wpdb->get_results($query, ARRAY_A);
      include( smartslider_dir( '/views/_tinymce-plugin-dialog.php' ) );
    }
}

add_action( 'admin_init', 'smartslider_addbuttons' );
add_action( 'admin_footer', 'smartslider_tinymce_plugin_dialog' );

?>