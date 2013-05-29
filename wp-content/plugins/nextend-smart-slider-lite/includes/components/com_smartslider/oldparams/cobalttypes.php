<?php 
/*------------------------------------------------------------------------
# smartslider - Smart Slider
# ------------------------------------------------------------------------
# author    Roland Soos
# copyright Copyright (C) 2012 Offlajn.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.nextendweb.com
-------------------------------------------------------------------------*/
?>
<?php
defined('_JEXEC') or die('Restricted access');

if(version_compare(JVERSION,'2.5.6','lt')) {
  jimport ( 'joomla.application.component.model' );
}else{
  jimport ( 'joomla.application.component.modellegacy' );
}
JLoader::import( 'types', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_cobalt' . DS . 'models' );
JLoader::import( 'fields', JPATH_SITE . DS . 'components' . DS . 'com_cobalt' . DS . 'models' );



class JElementCobalttypes extends JElement {
  
	var	$_name = 'cobalttypes';
  
  var $fields;

	function fetchElement($name, $value, &$node, $control_name){
    if(version_compare(JVERSION,'2.5.6','lt')) {
      $model = JModel::getInstance( 'types', 'CobaltModel' );
    }else{
      $model = JModelLegacy::getInstance( 'types', 'CobaltModel' );
    }
    if(version_compare(JVERSION,'2.5.6','lt')) {
      $fieldsmodel = JModel::getInstance( 'fields', 'CobaltModel' );
    }else{
      $fieldsmodel = JModelLegacy::getInstance( 'fields', 'CobaltModel' );
    }

	  $option = array();
	  $class = "class=inputbox";
	  
    $result = $model->getItems();
    
    $this->fields = array();
    foreach($result as $res) {
		  $fieldsmodel->setState('fields.type_id', $res->id);
      $fields = $fieldsmodel->getItems();
      $this->fields[$res->id]->data = array('Title');
      $this->fields[$res->id]->name = array('title');
      $this->fields[$res->id]->data[] = array('Record url');
      $this->fields[$res->id]->name[] = array('recordurl');
      foreach($fields AS $f){
        $this->fields[$res->id]->data[] = $f->label;
        $this->fields[$res->id]->name[] = 'field'.$f->id;
      }
      $options[] = JHTML::_('select.option', $res->id, $res->name);
    }
    DojoLoader::addScript('
      var cobaltccktypefields = dojo.fromJson(\''.addslashes(json_encode($this->fields)).'\');
      var cobaltccktype = dojo.byId("paramsgeneratortypes");
      var cobaltckkfn = function(){
        window.slidegenerator.data["CobaltCck"].contentvalue = cobaltccktypefields[cobaltccktype.options[cobaltccktype.selectedIndex].value];
        window.slidegenerator.runs = 0;
        window.slidegenerator.onShowForm(true);
      };
      cobaltckkfn();
      dojo.connect(cobaltccktype, "change", cobaltckkfn);
    ');
    return JHTML::_('select.genericlist', $options, 'params['.$name.']', $class , 'value', 'text',  $value, $control_name.$name);
	}
  
  function getFields($id){
    if(isset($this->fields[$id]) )
      return $this->fields[$id];
    return array();
  }
}

/*

Array
(
    [0] => stdClass Object
        (
            [id] => 1
            [key] => kf9518087b81e84cda5e6944614fe6c52
            [label] => Post
            [type_id] => 1
            [field_type] => html
            [params] => {"core":{"show_intro":"1","show_full":"1","show_feed":"0","show_compare":"1","required":"0","searchable":"0","description":"","xml_tag_name":"","field_class":"","show_lable":"3","label_break":"0","lable_class":"","icon":"","field_view_access":"1","field_view_message":"You cannot view this field","field_submit_access":"1","field_submit_message":"You cannot submit this field","field_edit_access":"1","field_edit_message":"You cannot edit this field"},"params":{"template_input":"default.php","template_output_list":"default.php","template_output_full":"default.php","default_value":"","intro":"2000","hide_intro":"0","readmore":"0","readmore_lbl":"Read More...","editor":"tinymce","short":"0","height":"300","plugins":["pagebreak"],"allow_html":"3","tags_mode":"1","filter_tags":"iframe, script","attr_mode":"1","filter_attr":"rel"},"emerald":{"subscr_iid":"","subscr_skip":"3","subscr_skip_author":"1","subscr_skip_moderator":"1","field_display_subscription_count":"0","field_display_subscription_msg":"You cannot view this field. Subscriptions of author of this record has expired","field_view_subscription_count":"0","field_view_subscription_msg":"You can view this field if you have following subscription(s).","field_submit_subscription_count":"0","field_submit_subscription_msg":"You can add this field if you have following subscription(s).","field_edit_subscription_count":"0","field_edit_subscription_msg":"You can edit this field if you have following subscription(s)."}}
            [checked_out] => 0
            [checked_out_time] => 0000-00-00 00:00:00
            [published] => 1
            [ordering] => 0
            [access] => 1
            [group_id] => 0
            [asset_id] => 41
            [filter] => 0
            [user_id] => 11
            [group_title] => 
            [group_descr] => 
            [group_icon] => 
            [gordering] => 
        )

    [1] => stdClass Object
        (
            [id] => 2
            [key] => k938300955781fd5bbb2cd754752040ca
            [label] => Product Image
            [type_id] => 1
            [field_type] => image
            [params] => {"core":{"show_intro":"1","show_full":"1","show_feed":"0","show_compare":"1","required":"0","searchable":"0","description":"","xml_tag_name":"","field_class":"","show_lable":"3","label_break":"0","lable_class":"","icon":"","field_view_access":"1","field_view_message":"You cannot view this field","field_submit_access":"1","field_submit_message":"You cannot submit this field","field_edit_access":"1","field_edit_message":"You cannot edit this field"},"params":{"template_input":"default.php","template_output_list":"list.php","template_output_full":"full.php","select_type":"0","directory":"images","show_subfolders":"0","allow_caption":"0","default_img":"","subfolder":"image","list_mode":"1","lightbox_list":"0","img_list_hspace":"0","img_list_vspace":"0","thumbs_list_height":"100","thumbs_list_width":"100","thumbs_list_quality":"80","thumbs_list_mode":"6","thumbs_list_stretch":"0","full_mode":"0","lightbox_full":"0","img_hspace":"0","img_vspace":"0","thumbs_height":"100","thumbs_width":"100","thumbs_quality":"80","thumbs_mode":"6","thumbs_stretch":"0"},"emerald":{"subscr_iid":"","subscr_skip":"3","subscr_skip_author":"1","subscr_skip_moderator":"1","field_display_subscription_count":"0","field_display_subscription_msg":"You cannot view this field. Subscriptions of author of this record has expired","field_view_subscription_count":"0","field_view_subscription_msg":"You can view this field if you have following subscription(s).","field_submit_subscription_count":"0","field_submit_subscription_msg":"You can add this field if you have following subscription(s).","field_edit_subscription_count":"0","field_edit_subscription_msg":"You can edit this field if you have following subscription(s)."}}
            [checked_out] => 0
            [checked_out_time] => 0000-00-00 00:00:00
            [published] => 1
            [ordering] => 0
            [access] => 1
            [group_id] => 0
            [asset_id] => 42
            [filter] => 0
            [user_id] => 11
            [group_title] => 
            [group_descr] => 
            [group_icon] => 
            [gordering] => 
        )

    [2] => stdClass Object
        (
            [id] => 3
            [key] => kd320245a42c34394396fcc3adbde0b71
            [label] => Video
            [type_id] => 1
            [field_type] => video
            [params] => {"core":{"show_intro":"1","show_full":"1","show_feed":"0","show_compare":"1","required":"0","searchable":"0","description":"","xml_tag_name":"","field_class":"","show_lable":"3","label_break":"0","lable_class":"","icon":"","field_view_access":"1","field_view_message":"You cannot view this field","field_submit_access":"1","field_submit_message":"You cannot submit this field","field_edit_access":"1","field_edit_message":"You cannot edit this field"},"params":{"template_input":"default.php","template_output_list":"default.php","template_output_full":"default.php","command":"c:\\ffmpeg\\bin\\ffmpeg.exe","skin":"glow","file_formats":"avi, mp4, mpeg, flv, ogv","only_one":"0","upload":"1","method":"auto","max_count":"0","max_size":"10240","subfolder":"video","delete_access":"1","allow_edit_title":"1","allow_add_descr":"1","sort":"0 ASC","module_width":"100","embed":"1","embed_max_count":"0","link":"1","link_max_count":"0","subscr_iid":"","subscr_skip":"3","subscr_skip_author":"1","subscr_skip_moderator":"1","subscription_count":"0","subscription_msg":"You cannot download this file. You have to be subscribed member","subscription_redirect":"1","can_select_subscr":"0"},"emerald":{"subscr_iid":"","subscr_skip":"3","subscr_skip_author":"1","subscr_skip_moderator":"1","field_display_subscription_count":"0","field_display_subscription_msg":"You cannot view this field. Subscriptions of author of this record has expired","field_view_subscription_count":"0","field_view_subscription_msg":"You can view this field if you have following subscription(s).","field_submit_subscription_count":"0","field_submit_subscription_msg":"You can add this field if you have following subscription(s).","field_edit_subscription_count":"0","field_edit_subscription_msg":"You can edit this field if you have following subscription(s)."}}
            [checked_out] => 0
            [checked_out_time] => 0000-00-00 00:00:00
            [published] => 1
            [ordering] => 0
            [access] => 1
            [group_id] => 0
            [asset_id] => 43
            [filter] => 0
            [user_id] => 11
            [group_title] => 
            [group_descr] => 
            [group_icon] => 
            [gordering] => 
        )

    [3] => stdClass Object
        (
            [id] => 4
            [key] => kbae24eb02df5adfa98a6145a4bdd4e93
            [label] => Gallery
            [type_id] => 1
            [field_type] => gallery
            [params] => {"core":{"show_intro":"1","show_full":"1","show_feed":"0","show_compare":"1","required":"0","searchable":"0","description":"","xml_tag_name":"","field_class":"","show_lable":"3","label_break":"0","lable_class":"","icon":"","field_view_access":"1","field_view_message":"You cannot view this field","field_submit_access":"1","field_submit_message":"You cannot submit this field","field_edit_access":"1","field_edit_message":"You cannot edit this field"},"params":{"template_input":"default.php","template_output_list":"list.php","template_output_full":"full.php","method":"auto","file_formats":"jpg, png, jpeg, gif, bmp","max_count":"0","max_size":"2048","subfolder":"gallery","delete_access":"1","allow_edit_title":"1","original_width":"1024","original_height":"1024","full_width":"800","full_height":"600","full_quality":"100","full_stretch":"0","lightbox_click":"0","thumbs_list_width":"100","thumbs_list_height":"100","thumbs_list_quality":"80","thumbs_list_mode":"1","thumbs_list_stretch":"0","thumbs_list_random":"1","thumbs_list_theme":"book.css","thumbs_resize_mode":"1","column_width":"600","max_height":"250","image_in_row":"5","image_padding":"2","image_border":"2","image_border_color":"#e0e0e0","image_border_radius":"5","image_shadow":"inset 0px 0px 10px 5px rgba(0, 0, 0, 0.3)","thumbs_width":"100","thumbs_height":"100","thumbs_quality":"80","thumbs_background_color":"#FFFFFF","thumbs_mode":"1","thumbs_stretch":"0","show_mode":"gallerybox","theme":"Dark","rate_access":"1","tmpl_rating":"crown.bfa270a2e4a59d8d89dccf47a6df951f","allow_comments":"0","allow_info":"0","show_avatar":"1","avatar_width":"40","avatar_height":"40","show_comment_avatar":"1","comment_avatar_width":"20","comment_avatar_height":"20","show_username":"0","comment_author":"1","record_author":"1","allow_download":"1","count_views":"1","show_location":"1","subscr_iid":"","subscr_skip":"3","subscr_skip_author":"1","subscr_skip_moderator":"1","subscription_count":"0","subscription_msg":"You cannot download this file. You have to be subscribed member","subscription_redirect":"1","can_select_subscr":"0"},"emerald":{"subscr_iid":"","subscr_skip":"3","subscr_skip_author":"1","subscr_skip_moderator":"1","field_display_subscription_count":"0","field_display_subscription_msg":"You cannot view this field. Subscriptions of author of this record has expired","field_view_subscription_count":"0","field_view_subscription_msg":"You can view this field if you have following subscription(s).","field_submit_subscription_count":"0","field_submit_subscription_msg":"You can add this field if you have following subscription(s).","field_edit_subscription_count":"0","field_edit_subscription_msg":"You can edit this field if you have following subscription(s)."}}
            [checked_out] => 0
            [checked_out_time] => 0000-00-00 00:00:00
            [published] => 1
            [ordering] => 0
            [access] => 1
            [group_id] => 0
            [asset_id] => 44
            [filter] => 0
            [user_id] => 11
            [group_title] => 
            [group_descr] => 
            [group_icon] => 
            [gordering] => 
        )

)
*/