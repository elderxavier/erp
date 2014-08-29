jQuery(document).ready(function(){


    var client_filter_by_name = jQuery("#client-by-name");

    /**
     * When client type chosen
     */
    jQuery(".ajax-select-client-type").change(function(){

        if(jQuery(this).val() != '')
        {
            //load empty data (filtered by nothing)
            loadFilteredData('',jQuery(this).val(),'filtered-clients','');

            //make container visible
            jQuery(".client-select-block").removeClass('hidden');
            //hide message
            jQuery(".message-select-type").addClass('hidden');

        }
        else
        {
            //hide container
            jQuery(".client-select-block").addClass('hidden');
            //show message
            jQuery(".message-select-type").removeClass('hidden');
        }
    });

    //auto-complete filter-field
    client_filter_by_name.autocomplete({
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
        minLength: 1/*,
        //when selected
        select:function(event,ui){

            var id = ui.item.id; //get id of client
            var label = ui.item.label; //get entered word

            loadFilteredData(label,jQuery(".ajax-select-client-type").val(),'filtered-clients','');
        }
        */
    });

    //when focus out
    /*
     client_filter_by_name.focusout(function()
    {
        if(jQuery(this).val() != '')
        {
            loadFilteredData(jQuery(this).val(),jQuery(".ajax-select-client-type").val(),'filtered-clients','');
        }

    });
    */

    //when clicked filter button
    jQuery("#filter-button").click(function(){
        loadFilteredData(client_filter_by_name.val(),jQuery(".ajax-select-client-type").val(),'filtered-clients',jQuery('#client-by-code').val());
    });

    //when pressed on 'create new client' in modal window
    jQuery('.modal-new-client-form').submit(function(){

        //get type from form ID
        var type = jQuery(this).attr('id');

        //validation fields for every type
        var fields_to_validate = {
            'Juridical': ['vat_code','company_code','company_name','phone1','email1'],
            'Physical' : ['name','surname','vat_code','personal_code','phone1','email1']
        };

        //get error fields
        var errors = checkRequired(fields_to_validate[type],type,true);

        //if errors - returns false
        return (!errors.length > 0);

    });

});

//when all AJAX loaded

jQuery(".filter-wrapper").on('click', '.load-modal-client',function(){

    var href = jQuery(this).attr('href'); //get link
    var container = jQuery(this).attr('data-target'); //container

    //load info to container
    jQuery.ajax({ url: href, beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data)
    {
        jQuery(container).html(data);
    });
});

/**
 * Loads result of ajax filter-query to container
 * @param words filter-param
 * @param type type of clients
 * @param container_class class of container
 * @param code personal or company code
 */
function loadFilteredData(words,type,container_class,code)
{
    var code_postfix = '';
    code != '' ? code_postfix = '/code/'+code : code_postfix = '';

    //try find in database by name
    jQuery.ajax({ url: '/ajax/clientsfilter/words/'+words+'/type/'+type+code_postfix, beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data)
    {
        jQuery('.'+container_class).html(data);
    });
}

/**
 * Validates fields for emptiness and returns array with names of empty fields
 * @param fields array of filed-names
 * @param type juridical or physical
 * @param highlight_errors highlights errors when set to TRUE
 * @returns {Array}
 */
function checkRequired(fields,type,highlight_errors)
{
    //errors
    var errors = [];

    //through all names
    for(var i = 0; i < fields.length; i++)
    {
        var jqField = jQuery('[name="Client'+type+'['+fields[i]+']"]'); //get input element by name and type
//        if(jqField.isArray())jqField = jqField[0];

        if(jqField.val() == '') //if empty
        {
            errors.push(fields[i]); //add to array of errors

            if(highlight_errors) //if should highlight
            {
                jQuery('#'+type+'_'+fields[i]+'_err').removeClass('hidden'); //make text of error visible
            }
        }
        else //if not empty
        {
            jQuery('#'+type+'_'+fields[i]+'_err').addClass('hidden'); //hide error text (if highlighted)
        }
    }

    //return array of names
    return errors;
}
