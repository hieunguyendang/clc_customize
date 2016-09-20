jQuery(document).ready(function($){
	// 
	
	// SNS_Widget_Layered_Nav
	$(document).on('change', '.sns_wcan_type, .sns_wcan_attributes', function (e) {
        var t = this,
            container   = $(this).parents('.widget-content').find('.sns_wcan_placeholder').html(''),
            attributes  = $(this).parents('.widget-content').find('.sns-wcan-attribute-list');

        var data = {
            action   : 'sns_wcan_select_type',
            id       : $('input[name=widget_id]', $(t).parents('.widget-content')).val(),
            name     : $('input[name=widget_name]', $(t).parents('.widget-content')).val(),
            attribute: $('.sns_wcan_attributes', $(t).parents('.widget-content')).val(),
            value    : $('.sns_wcan_type', $(t).parents('.widget-content')).val()
        };
        
       $.post(ajaxurl, data, function (response) {
            container.html(response.content);
            $(document).trigger('sns_colorpicker');
        }, 'json');
    });

    //color-picker
    $(document).on('sns_colorpicker',function () {
        $('.sns-colorpicker').each(function () {
            $(this).wpColorPicker();
        });
    }).trigger('sns_colorpicker');

});