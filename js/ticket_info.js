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

});