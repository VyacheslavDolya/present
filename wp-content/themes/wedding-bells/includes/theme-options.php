<?php
add_action( 'admin_init', 'weddingbells_options_js' );

function weddingbells_options_js() {
	if ( current_user_can( 'edit_theme_options' ) && isset( $_GET['page'] ) && $_GET['page'] == basename(__FILE__) ) {
		wp_enqueue_script( 'media-upload' );
		add_thickbox();
		wp_enqueue_script( 'wb', get_template_directory_uri().'/includes/themeoptions.js', array('jquery') );
	}
}

$typography_path = TEMPLATEPATH . '/typography/';
$typography = array();
if ( is_dir($typography_path) ) {
    if ($typography_dir = opendir($typography_path) ) { 
        while ( ($typography_file = readdir($typography_dir)) !== false ) {
            if(stristr($typography_file, ".css") !== false) {
                $typography[] = $typography_file;
            }
        }    
    }
}

$themename = "Wedding Bells";
$shortname = "wb";

$options = array(

array( "name" => __($themename." Options", "weddingbells"), "type" => "title"),

array( "name" => __("Style Settings", "weddingbells"), "type" => "open"),
	
	array( "name" => __("Typography set", "weddingbells"),
		"desc" => __("Default = Serif headings, Sans-serif paragraphs<br /> Flipped = Sans-serif headings, Serif paragraphs", "weddingbells"),
		"id" => $shortname."_typography",
		"type" => "select",
		"std" => "",
		"options" => $typography ),
	
array( "type" => "close"),
array( "name" => __("Header Settings", "weddingbells"), "type" => "open"),

	array( "name" => __("Upload logo", "weddingbells"),
		"desc" => __("Upload a logo. This will replace the site name/tagline.", "weddingbells"),
		"id" => $shortname."_uploadlogo",
		"upload" => true,
		"type" => "upload",
		"class" => "logo-image-input",
		"std" => ""),
		
	array( "name" => __("Hide Tagline", "weddingbells"),
		"desc" => __("Check to disable the site description/tagline text.", "weddingbells"),
		"id" => $shortname."_disable_tagline",
		"type" => "checkbox",
		"std" => ""),
		
	array( "name" => __("Header Slider", "weddingbells"),
		"desc" => __("Check to enable a slider that will replace the header image.", "weddingbells"),
		"id" => $shortname."_enable_slider",
		"type" => "checkbox",
		"std" => ""),
	
array( "type" => "close"),
array( "name" => __("Misc Settings", "weddingbells"), "type" => "open"),

	array( "name" => __("Upload favicon", "weddingbells"),
		"id" => $shortname."_uploadfavicon",
		"type" => "upload",
		"std" => ""),

	array( "name" => __("Google Analytics Code", "weddingbells"),
		"desc" => __("Paste your Google Analytics or other tracking code in this box.", "weddingbells"),
		"id" => $shortname."_ga_code",
		"type" => "textarea",
		"std" => ""),

array( "type" => "close")

);

function mytheme_add_admin() {

global $themename, $shortname, $options;

if ( $_GET['page'] == basename(__FILE__) ) {

	if ( 'save' == $_REQUEST['action'] ) {

		foreach ($options as $value) {
		update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

foreach ($options as $value) {
	if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }

	header("Location: themes.php?page=theme-options.php&saved=true");
die;

}
else if( 'reset' == $_REQUEST['action'] ) {

	foreach ($options as $value) {
		delete_option( $value['id'] ); }

	header("Location: themes.php?page=theme-options.php&reset=true");
die;

}
}


}

add_action('admin_menu', 'my_admin_add_page');
	function my_admin_add_page() {
	    global $my_admin_page, $themename;
	    $my_admin_page = add_theme_page($themename.__(" Options","weddingbells"), __("Theme Options", "weddingbells"), 'edit_themes', basename(__FILE__), 'mytheme_admin');
}

function mytheme_admin() {

	global $themename, $shortname, $options;
	$i=0;

		if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' '.__('settings saved.', 'weddingbells').'</strong></p></div>';
		if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' '.__('settings reset.', 'weddingbells').'</strong></p></div>';

?>
<div class="wrap">
	<div id="icon-themes" class="icon32"><br /></div>
	
	<h2><?php echo $themename; ?> <?php _e('Settings', 'weddingbells'); ?></h2>

	<form method="post">
	
<?php foreach ($options as $value) {
switch ( $value['type'] ) {
// Open
case "open": ?>

	<h3><?php echo $value['name']; ?></h3>
	<table class="form-table">
	
<?php break;
// Close
case "close": ?>

	</table>
	<br />

<?php break;
// Title
case "title": ?>

<?php break;
// Text input
case 'text': ?>

	<tr valign="top">
		<th scope="row"><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
	 	<td>
	 		<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" class="small-text" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>" />
	 		<span class="description"><?php echo $value['desc']; ?></span>
		</td>
	</tr>

<?php break;
// Textarea
case 'textarea': ?>

	<tr valign="top">
		<th scope="row"><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
	 	<td>
	 		<textarea class="large-text" name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows="8"><?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id']) ); } else { echo $value['std']; } ?></textarea>
			 <span class="description"><?php echo $value['desc']; ?></span>
	 	</td>
	 </tr>

<?php break;
// Select
case 'select': ?>

	<tr valign="top">
	<th scope="row"><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
	<td>
		<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
		<?php foreach ($value['options'] as $option) { ?>
				<option <?php if (get_option( $value['id'] ) == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?>
		</select>
		<br />
		<span class="description"><?php echo $value['desc']; ?></span>
	</td>
	</tr>

<?php break;
// Checkbox
case "checkbox": ?>

	<tr valign="top">
	<th scope="row"><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
	<td>
		<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
		<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
	
		<span class="description"><?php echo $value['desc']; ?></span>
	</td>
	</tr>
	
<?php break;
// Upload
case "upload": ?>

	<tr valign="top">
	<th scope="row"><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
	<td>
		<input id="<?php echo $value['id']; ?>" type="text" name="<?php echo $value['id']; ?>" class="<?php echo $value['class']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id']) ); } else { echo $value['std']; } ?>" />
		<input id="<?php echo $value['id']; ?>_upload_button" type="button" value="<?php _e('Upload', 'weddingbells'); ?>" data-type="image" data-field-id="<?php echo $value['id']; ?>" class="button" />
		
		<span class="description"><?php echo $value['desc']; ?></span>
	</td>
	</tr>
	
<?php break;
// Radio
case "radio": ?>
	
	<tr valign="top">
	<th scope="row"><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
	<td>
		
		<?php foreach ($value['options'] as $key => $option) { print_r(get_option('wb_typography')); ?>
		<?php if(get_option("wb_typography")==$key){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
			<input type="radio" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php checked($option,$key,false); ?> /> <span class="description"><?php echo $option; ?></span><br/>
		<?php } ?>	
	</td>
	</tr>	
	

<?php break;
}
}
?>

		<p class="submit">
			<input name="save" class="button-primary" type="submit" value="<?php _e('Save changes','weddingbells'); ?>" />
			<input type="hidden" name="action" value="save" />
		</p>
	</form>

	<form method="post" action="">
		<p class="submit">
			<input name="reset" type="submit" value="<?php _e('Reset','weddingbells'); ?>" />
			<input type="hidden" name="action" value="reset" />
		</p>
	</form>

</div><!-- wrap -->

<?php }
add_action('admin_menu', 'mytheme_add_admin');
?>