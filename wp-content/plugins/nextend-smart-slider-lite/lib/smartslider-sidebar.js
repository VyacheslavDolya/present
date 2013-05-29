jQuery(document).ready(function(){
    jQuery('#smartslider_tinymce_dialog').dialog({
        autoOpen: false,
        buttons: {
            "Insert": function(){
                insertSelectedDeck();
            },
            "Cancel": function(){
                jQuery(this).dialog('close');
            }
        },
        open: function(){
            if( jQuery('#smartslider_tinymce_dialog tbody tr.selected').length == 0  ){
                jQuery('#smartslider_tinymce_dialog tbody tr:first').addClass('selected');
				if( jQuery('#smartslider_tinymce_dialog tbody tr:first').hasClass('dynamic') ){
					jQuery('#smartslider_tinymce_dimension_h').val('370px');
				}else{
					jQuery('#smartslider_tinymce_dimension_h').val('300px');
				}
            }
        },
        width: 450,
        height: 'auto',
        draggable: false,
        resizable: false,
        title: 'Insert Smart Slider',
        dialogClass: parseInt(jQuery().jquery.split(".")[1]) === 2 ? 'ui-smartslider-2' : 'ui-smartslider'
    }).find('tbody tr').click(function(event){
        event.preventDefault();
        jQuery('#smartslider_tinymce_dialog tbody tr').removeClass('selected');
        jQuery(this).addClass('selected');
        if( jQuery(this).hasClass('dynamic') ){
            jQuery('#smartslider_tinymce_dimension_h').val('370px');
        }else{
            jQuery('#smartslider_tinymce_dimension_h').val('300px');
        }
        
    });
    
    function insertSelectedDeck(){
        var smartslider_id = jQuery('#smartslider_tinymce_dialog tbody tr.selected')[0].id.split("_")[2];
        var width = jQuery('#smartslider_tinymce_dimension_w').val();
        var height = jQuery('#smartslider_tinymce_dimension_h').val();
    
        var smartslider_str = " [SmartSlider " + smartslider_id + "";
        smartslider_str += "] ";
        
        if (typeof(tinyMCE) != 'undefined' && (ed = tinyMCE.activeEditor) && !ed.isHidden()) {
            ed.focus();
            if (tinymce.isIE) {
                ed.selection.moveToBookmark(tinymce.EditorManager.activeEditor.windowManager.bookmark);
            }
            ed.execCommand('mceInsertContent', false, smartslider_str);
        } else {
            edInsertContent(edCanvas, smartslider_str);
        }
        
        jQuery('#smartslider_tinymce_dialog').dialog('close');
    }
    
    jQuery('#smartslider-meta-sidebar a.smartslider-sidebar-insert').bind('click', function(event){
        event.preventDefault();
        jQuery('#smartslider_tinymce_dialog').dialog('open');
    });
    
    jQuery("#ed_toolbar").append('<input type="button" class="ed_button insertsmartslider" value="smartslider" />');
    jQuery("#ed_toolbar .insertsmartslider").click(function(){
        jQuery('#smartslider_tinymce_dialog').dialog('open');
    });
    
});