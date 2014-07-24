/**
 * Created by Wolfdark on 21.07.14.
 */

jQuery(document).ready(function(){

    var hidden_id = jQuery("#cli_id");
    var client_field = jQuery(".auto-complete-clients");
    var city_filter_select = jQuery(".ajax-filter-city");
    var user_list_select = jQuery(".filtered-users");

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
        select:function(event,ui){
            //when selected - add id to hidden field
            hidden_id.val(ui.item.id);
            //add special text attribute to hidden field
            hidden_id.attr('txt',ui.item.label);
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
                //if found id
                if(data != 'NOT_FOUND')
                {
                    //set id to hidden field
                    hidden_id.val(data);

                    //set special text attribute
                    hidden_id.attr('txt',client_field.val());
                }
                //if not found
                else
                {
                    //set id to hidden field
                    hidden_id.val('');
                }
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