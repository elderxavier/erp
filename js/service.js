/**
 * Created by Wolfdark on 21.07.14.
 */

jQuery(document).ready(function(){

    var hidden_id = jQuery("#cli_id");
    var client_field = jQuery(".auto-complete-clients");
    var city_filter_select = jQuery(".ajax-filter-city");
    var user_list_select = jQuery(".filtered-users");
    var form_holder = jQuery(".client-settings");

    $.fn.editable.defaults.mode = 'inline';

    //add auto-complete feature for client-field
    client_field.autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "/ajax/clients",
                dataType: "json",
                data: {
                    start: request.term
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        minLength: 1,
        //when selected
        select:function(event,ui){
            //get id
            var id = ui.item.id;

            //load client info by id
            jQuery.ajax({ url: '/ajax/clifiid/id/'+id, beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data)
            {
                //if loaded successfully
                if(data != 'ERROR')
                {
                    //add content to holder
                    form_holder.html(data);

                    //show
                    form_holder.removeClass('hidden');
                }

            });

        },
        open: function() {
            $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
        },
        close: function() {
            $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
        }
    });

    //when focus out form client-filed
    client_field.focusout(function()
    {
        //if new value entered by hands
        if(hidden_id.attr('txt') != client_field.val())
        {
            //try find in database by name
            jQuery.ajax({ url: '/ajax/clifi/name/'+client_field.val(), beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data)
            {
                //add content to holder
                form_holder.html(data);

                //show
                form_holder.removeClass('hidden');
            });
        }
    });

    //when selected city
    city_filter_select.change(function(){
        jQuery.ajax({ url: '/ajax/workers/city/'+jQuery(this).val(), beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data){
            user_list_select.html(data);
        });
    });

});


jQuery(document).ajaxComplete(function(){

    //for selectable client type field
    jQuery('#ed_type').editable({
        type: 'select',
        value: 0,
        name: 'select',
        title: jQuery(this).attr('title'),
        send: 'newer'
        //when changed value
    }).on('rendered', function(e, editable){

            //st value to hidden field
            jQuery('#ed_typeH').val(editable.value);

            //if switched to company
            if(editable.value == 1)
            {
                hideFields('phys');
                showFields('jur');
            }
            //if switched to person
            else
            {
                hideFields('jur');
                showFields('phys');
            }

        });


    //for text items
    jQuery('.text-editable').editable({
        type:  'text',
        name:  'username',
        title: jQuery(this).attr('title'),
        send:  'newer'
        //when changed value
    }).on('rendered', function(e, editable){
            //get id of current link
            var id =  jQuery(this).attr('id');
            //find by this id hidden field and set value (hidden field has same id, but with H letter in end)
            jQuery('#'+id+'H').val(editable.value);
        });
});


var hideFields = function(type)
{
    jQuery('.'+type).addClass('hidden');
};

var showFields = function(type)
{
    jQuery('.'+type).removeClass('hidden');
};
