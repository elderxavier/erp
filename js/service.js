/**
 * Created by Wolfdark on 21.07.14.
 */

jQuery(document).ready(function(){

    var client_field = jQuery(".auto-complete-clients");

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
                    var form_holder = jQuery(".client-settings");

                    //add content to holder
                    form_holder.html(data);

                    //set found client name
                    jQuery("#cli_found").val(ui.item.label);

                    //show
                    form_holder.removeClass('hidden');
                }

            });

        }
    });

    //when focus out form client-filed
    client_field.focusout(function()
    {
        //if new value entered by hands is not equal to old
        if(jQuery("#cli_found").val() != client_field.val())
        {
            //try find in database by name
            jQuery.ajax({ url: '/ajax/clifi/name/'+client_field.val(), beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data)
            {
                var form_holder = jQuery(".client-settings");

                //add content to holder
                form_holder.html(data);

                //last found
                jQuery("#cli_found").val(client_field.val());

                //show
                form_holder.removeClass('hidden');
            });
        }
    });

    //when selected city
    jQuery(".ajax-filter-city").change(function(){
        jQuery.ajax({ url: '/ajax/workers/city/'+jQuery(this).val(), beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data){
            jQuery(".filtered-users").html(data);
        });
    });

});

//when ajax loaded
jQuery(document).ajaxComplete(function(){

    //get editable type-field
    var editTypeFiled = jQuery('#ed_type');

    //for selectable client type field
    editTypeFiled.editable({
        type: 'select',
        value: 'none',
        name: 'select',
        title: editTypeFiled.attr('title'),
        send: 'newer'
        //when changed value
    }).on('save', function(e, editable){
            //st value to hidden field
            jQuery('#ed_typeH').val(editable.newValue);

            //if switched to company
            if(editable.newValue == 1)
            {
                showFields('both'); //show all fields
                hideFields('phys'); //hide physical fields
                showFields('jur'); //show juridical fields

            }
            //if switched to person
            else
            {
                showFields('both'); //show all fields
                hideFields('jur'); //hide juridical fields
                showFields('phys'); //show physical fields
            }
        });


    //for text items
    jQuery('.text-editable').editable({
        type:  'text',
        name:  'username',
        title: jQuery(this).attr('title'),
        send:  'newer'
        //when changed value
    }).on('save', function(e, editable){
            //get id of current link
            var id =  jQuery(this).attr('id');
            //find by this id hidden field and set value (hidden field has same id, but with H letter in end)
            jQuery('#'+id+'H').val(editable.newValue);
        });
});

/**
 * Adds class 'hidden' to element
 * @param type class name
 */
var hideFields = function(type)
{
    jQuery('.'+type).addClass('hidden');
};

/**
 * Removes class 'hidden' from element
 * @param type
 */
var showFields = function(type)
{
    jQuery('.'+type).removeClass('hidden');
};
