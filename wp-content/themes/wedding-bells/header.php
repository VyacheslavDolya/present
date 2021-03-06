<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<?php if (get_option('wb_uploadfavicon')) { ?><link rel="shortcut icon" href="<?php echo get_option('wb_uploadfavicon'); ?>" /><?php } // favicon ?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/skeleton.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

<?php if (get_option('wb_typography') == 'default.css') { // typography stylesheets check ?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/typography/default.css" type="text/css" media="screen" />
<?php } elseif (get_option('wb_typography') == 'flipped.css') { ?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/typography/flipped.css" type="text/css" media="screen" />
<?php } ?>

<link href="http://fonts.googleapis.com/css?family=Droid+Serif" rel="stylesheet" type="text/css" />

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

<?php wp_head(); ?>

<?php echo stripslashes(get_option('wb_ga_code')); // Google Analytics or other embed ?>
<link href='http://fonts.googleapis.com/css?family=Ovo|Great+Vibes' rel='stylesheet' type='text/css'>
</head>

<body <?php body_class(); ?>>
<div class="wrapper">
    <div class="row container" id="navrow">
            <?php if ( has_nav_menu( 'primary-menu' ) ) { ?>
                    <?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'theme_location' => 'primary-menu', 'container_class' => 'sixteen columns navwrap', 'menu_id' => 'nav' ) ); ?>
            <?php } else { ?>
                    <div class="sixteen navwrap columns">
                            <ul id="nav">
                                <li class="<?php if(is_home() || is_front_page()){ echo 'current_page_item'; }?>"><a href="<?php echo home_url(); ?>/"><?php _e('Home', 'weddingbells'); ?></a></li>
                                    <?php wp_list_pages('title_li='); ?>
                            </ul>
                    </div><!-- 16/menulist -->
            <?php } ?>
    </div><!-- row -->
<div class="container" id="shadow">

    

    <div class="names">
        <table>
            <tr>
                <td class="left">
                    <div class="title">
                        <a href="<?php echo home_url(); ?>">Dmitry & Alexandra</a>
                    </div>
                    <div class="description">
                        <span class="swirl_left">
                            <span class="swirl_right">15 june 2013</span>
                        </span>
                    </div>
                </td>
                <td class="right">
                    <div class="gerb">
                        <img src="<?php echo bloginfo('template_directory'); ?>/images/logo.png" alt="Dmitry & Alexandra"/>
                   </div>
                </td>
            </tr>
        </table>
    </div>

	<div id="header">
    <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Header Slider')) : ?>
        <?php if (get_option('wb_enable_slider')) { // Slider ?>
            <div class="flexslider">
                    <ul class="slides">
                    <?php query_posts('post_type=slides&posts_per_page=-1'); ?>
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                            <li><?php the_post_thumbnail('slide-image'); ?></li>
                    <?php endwhile; endif; wp_reset_query(); ?>
                    </ul>
            </div>		
            <?php } else { // Regular header image ?>
                    <img src="<?php header_image(); ?>" alt="Header" />
            <?php } ?>
    <?php endif; ?>
		
	</div><!-- #header -->
<?php if(is_home() || is_front_page()):?>
        <div class="home_title">
                <?php if (get_option('wb_uploadlogo')) { // Logo ?>
                        <a href="<?php echo home_url(); ?>"><img src="<?php echo get_option('wb_uploadlogo'); ?>" alt="logo" /></a>
                <?php } else { ?>
                        <h2>
                            <?php bloginfo('name'); ?>
                            <span>
                                <?php if (!get_option('wb_disable_tagline')) { ?><?php bloginfo('description'); ?><?php } // Show or hide tagline ?>
                            </span>
                        </h2>
                        
                <?php } ?>
        </div><!-- title-description -->
<?php endif;?>