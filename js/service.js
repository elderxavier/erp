jQuery(document).ready(function(){


    var client_filter = jQuery(".client-filter");

    /**
     * When client type chosen
     */
    jQuery(".ajax-select-client-type").change(function(){

        if(jQuery(this).val() != '')
        {
            //show client-select form
            jQuery(".client-select-block").removeClass('hidden');
        }
        else
        {
            jQuery(".client-select-block").addClass('hidden');
        }
    });

    //auto-complete filter-field
    client_filter.autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "/ajax/clients",
                dataType: "json",
                data: {
                    start: request.term,
                    type: jQuery(".ajax-select-client-type").val()
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        minLength: 1,
        //when selected
        select:function(event,ui){

            var id = ui.item.id; //get id of client
            var label = ui.item.label; //get entered word

            loadFilteredData(label,jQuery(".ajax-select-client-type").val(),'filtered-clients');
        }
    });

    //when focus out
    client_filter.focusout(function()
    {
        if(jQuery(this).val() != '')
        {
            loadFilteredData(jQuery(this).val(),jQuery(".ajax-select-client-type").val(),'filtered-clients');
        }

    });


    jQuery('.modal-new-client-form').submit(function(){

        var type = jQuery(this).attr('id');
        var errors = [];

        switch (type)
        {
            case 'juridical-form':
                errors = checkRequired(['vat_code','company_code','company_name','phone1','email1'],'Juridical',true);
                break;
            case 'physical-form':
                errors = checkRequired(['name','surname','vat_code','personal_code','phone1','email1'],'Physical',true);
                break;
        }

        if(errors.length > 0)
        {
            return false;
        }
        else
        {

        }

        return true;
    });

});

jQuery(document).ajaxComplete(function(){
   jQuery('.load-modal-client').click(function(){

       var href = jQuery(this).attr('href');
       var container = jQuery(this).attr('data-target');

       //try find in database by name
       jQuery.ajax({ url: href, beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data)
       {
           jQuery(container).html(data);
       });
   });
});

/**
 * Loads result of ajax filter-query to container
 * @param words filter-param
 * @param type type of clients
 * @param container_class class of container
 */
function loadFilteredData(words,type,container_class)
{
    //try find in database by name
    jQuery.ajax({ url: '/ajax/clientsfilter/words/'+words+'/type/'+type, beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data)
    {
        jQuery('.'+container_class).html(data);
    });
}

function checkRequired(fields,type,highlight_errors)
{
    //errors
    var errors = [];

    //through all names
    for(var i = 0; i < fields.length; i++)
    {
        var jqField = jQuery('[name="Client'+type+'['+fields[i]+']"]');
//        if(jqField.isArray())jqField = jqField[0];

        if(jqField.val() == '')
        {
            errors.push(fields[i]);

            if(highlight_errors)
            {
                jQuery('#'+type+'_'+fields[i]+'_err').removeClass('hidden');
            }
        }
        else
        {
            jQuery('#'+type+'_'+fields[i]+'_err').addClass('hidden');
        }
    }

    return errors;
}
