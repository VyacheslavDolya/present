jQuery(document).ready(function($) {  
  jQuery('#wb_uploadlogo_upload_button').click(function() {
    formfield = jQuery(this).attr('data-field-id');
    tb_show('', 'media-upload.php?post_id=&type=image&TB_iframe=true');
    return false;
  });
  
  jQuery('#wb_uploadfavicon_upload_button').click(function() {
    formfield = jQuery(this).attr('data-field-id');
    tb_show('', 'media-upload.php?post_id=&type=image&TB_iframe=true');
    return false;
  });
  
  window.original_send_to_editor = window.send_to_editor;
  window.send_to_editor = function(html) {
    if(formfield) {
      source = jQuery(html).find('img').attr('src');
      jQuery('#'+formfield).val(source);
      tb_remove();
    }else{
      window.original_send_to_editor(html);
    }
  }
});