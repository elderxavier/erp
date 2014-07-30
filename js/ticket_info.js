$(document).ready(function(e) {
	
	$.fn.editable.defaults.mode = 'inline';

    jQuery("#ed_msg_ticket").editable({
		  type:  'textarea'
	}).on('save', function(e, editable){
            //get id of current link
            var id =  jQuery(this).attr('id');
            //find by this id hidden field and set value (hidden field has same id, but with H letter in end)
            jQuery('#'+id+'H').val(editable.newValue);
        });

    jQuery('#ed_problem_type').editable({
        type: 'select',
        name: 'select-name',
        title: 'test',
        send: 'newer'
        //when changed value
    }).on('save', function(e, editable){
            //get id of current link
            var id =  jQuery(this).attr('id');
            //find by this id hidden field and set value (hidden field has same id, but with H letter in end)
            jQuery('#'+id+'H').val(editable.newValue);
        });

    //when selected city
    jQuery(".ajax-filter-city").change(function(){
        jQuery.ajax({ url: '/ajax/workers/city/'+jQuery(this).val(), beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data){
            jQuery(".filtered-users").html(data);
        });
    });


    //when clicked on 'view' link
    jQuery(".modal-link-opener").click(function(){

        //get href
        var href = jQuery(this).attr('href');

        //load to modal window
        jQuery.ajax({ url: href,beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data)
        {
            modal('test',data);
        });

        //stop click event
        return false;

    });

});

/**
 * Show modal window with some content
 * @param window_name
 * @param content
 */
var modal = function(window_name,content)
{
    var dialog_div = jQuery(".dialog");

    dialog_div.dialog({
        title: window_name,
        resizable:false,
        modal:true,

        minHeight: 300,
        minWidth: 400,

        position: {
            my: "center",
            at: "center"
        },
        buttons: {}
    });

    //add content to container
    dialog_div.html(content);

    //event for close button
    jQuery(".close-modal-w").click(function(){
        dialog_div.dialog("close");
    });
};