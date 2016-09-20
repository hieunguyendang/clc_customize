jQuery(document).ready(function(){
    "use strict";
    function runImport(datatype, percent){
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action': 'sampledata',
                'datatype':  datatype,
            },
            success: function(data, textStatus, XMLHttpRequest){
                jQuery('.sns-importprocess-width').css({
                    'width' : percent + '%',
                    '-moz-transition' : 'width 1s',
                    '-o-transition' : 'width 1s',
                    '-webkit-transition' : 'width 1s',
                    'transition' : 'width 1s'
                });
                jQuery('#sns-importmsg .status').html(' Importing: ' + percent + '%');
                percent = percent + 25;
                if ( datatype == 'theme' ){
                    runImport("slider", percent);
                    jQuery('#sns-import-tablecontent ul li.theme-cfg i').attr('class', 'fa fa-check');
                    jQuery('#sns-import-tablecontent ul li.revslider-cfg i').attr('class', 'fa fa-spin fa-circle-o-notch');
                }
                if ( datatype == 'slider' ){
                    runImport("content", percent);
                    jQuery('#sns-import-tablecontent ul li.revslider-cfg i').attr('class', 'fa fa-check');
                    jQuery('#sns-import-tablecontent ul li.all-content i').attr('class', 'fa fa-spin fa-circle-o-notch');
                }
                if ( datatype == 'content' ){
                    runImport("widget", percent);
                    jQuery('#sns-import-tablecontent ul li.all-content i').attr('class', 'fa fa-check');
                    jQuery('#sns-import-tablecontent ul li.widget-cfg i').attr('class', 'fa fa-spin fa-circle-o-notch');
                }
                if ( datatype == 'widget' ){
                    jQuery('#sns-importmsg').html(data);
                    jQuery('#sns-import-tablecontent ul li.widget-cfg i').attr('class', 'fa fa-check');
                }
            }
        });
    }
    jQuery('#btn_sampledata').click(function(){
        var c = confirm("Are you want import demo content?");
        if (c == true) {
            jQuery('.sns-importprocess').show();
            jQuery(this).attr('disabled','true');
            jQuery('#sns-importmsg .status').html('Importing');
            runImport("theme", 25);
        }
    });
});