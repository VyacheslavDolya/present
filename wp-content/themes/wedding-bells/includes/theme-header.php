<?php
define('HEADER_TEXTCOLOR', '2e2c6a'); //  Default text color
define('HEADER_IMAGE', '%s/images/default.jpg'); // %s is theme dir uri, set a default image
define('HEADER_IMAGE_WIDTH', 960); //  Default image width is actually the div's height
define('HEADER_IMAGE_HEIGHT', 450);  // Default image height
define('NO_HEADER_TEXT', false );

add_custom_image_header( 'weddingbells_header_style', 'weddingbells_admin_header_style', 'weddingbells_admin_header_image' );

if ( ! function_exists( 'weddingbells_header_style' ) ) :

function weddingbells_header_style() {
?>
<style type="text/css">
	<?php //  Has the text been hidden? If so, set display to equal none  
	if ( 'blank' == get_header_textcolor() ) { ?>
		#header .title-description {
		    display: none;
		}
	<?php } else { //  Otherwise, set the color to be the user selected one ?>
		#header h1 a {
		    color: #<?php header_textcolor() ?>;
		}
	<?php } ?>
</style>
<?php
}
endif; // End of weddingbells_header_style

if ( ! function_exists( 'weddingbells_admin_header_style' ) ) :

function weddingbells_admin_header_style() { 
?>
<style type="text/css">
	.appearance_page_custom-header #headimg {
		width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
	}
	#headimg {
	    background: url(<?php header_image() ?>) no-repeat;
	    height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	    width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
	    padding: 0;
	    font-family: Georgia, serif;
	    position: relative;
	}
	#headimg .title-description {
		position: absolute;
		top: 40px;
		left: 40px;
		padding: 30px;
		background: rgb(255, 255, 255); /* Fallback */
		background: rgba(255, 255, 255, 0.8);
		float: left;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		border-radius: 5px;
		display: block;
		visibility: visible;	
	}
	#headimg h1 {
		font-family: Georgia, serif;
		font-size: 3em;
		color: #2e2c6a;
		margin: 0px 0px 9px 0px;
		font-weight: normal;
	}
	#headimg h2 {
		font-family: Georgia, serif;
		font-size: 1.6em;
		color: #55548f;
		font-style: italic;
		margin: 0;
	}
	#headimg h1 a {
	    color: #<?php header_textcolor() ?>;
	    text-decoration: none;
	    border-bottom: none;
	}
	<?php if ( 'blank' == get_header_textcolor() ) { ?>
	#headimg .title-description {
	    display: none;
	    visibility: hidden;
	}
	#headimg h1 a, #headimg #desc {
	    color: #<?php echo HEADER_TEXTCOLOR ?>;
	}
<?php } ?>
</style>
<?php }

endif; // End of weddingbells_admin_header_style

if ( ! function_exists( 'weddingbells_admin_header_image' ) ) :

function weddingbells_admin_header_image() { ?>
	<div id="headimg">

		<div class="title-description">
			<h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
			<h2><?php bloginfo('description'); ?></h2>	
		</div>
	
	</div>
<?php }
endif; // End of weddingbells_admin_header_image
?>