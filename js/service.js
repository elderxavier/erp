/**
 * Created by Wolfdark on 21.07.14.
 */


var CLIENT_NAME_FILED_CLASS = "auto-complete-clients";
var CLIENT_ID_FIELD_ID = "cli_id";


jQuery(document).ready(function(){

    var hidden_id = jQuery("#"+CLIENT_ID_FIELD_ID);
    var client_field = jQuery("."+CLIENT_NAME_FILED_CLASS);

    //add auto-complete feature
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

    //when focus out
    client_field.focusout(function()
    {
        //if value entered by hands
        if(hidden_id.attr('txt') != client_field.val()){

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

});