jQuery(document).ready(function(){

    var client_filter_by_name = jQuery("#client-by-name");

    if(jQuery(".opened-modal-new-customer-juridical").length > 0)
    {
        jQuery(".new-customer-juridical").modal('show');
    }

    if(jQuery(".opened-modal-new-customer-phys").length > 0)
    {
        jQuery(".new-customer-physical").modal('show');
    }

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
        minLength: 1
    });

    //when clicked filter button
    jQuery("#filter-button").click(function(){
        loadFilteredData(client_filter_by_name.val(),jQuery(".ajax-select-client-type").val(),'filtered-clients',jQuery('#client-by-code').val());
    });
});

//when all AJAX loaded
jQuery(document).ajaxComplete(function(){

    //when clicked on client-info link in table
    jQuery('.load-modal-client').click(function(){

        var href = jQuery(this).attr('href'); //get link
        var container = jQuery(this).attr('data-target'); //container

        //load info to container
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
 * @param code personal or company code
 */
function loadFilteredData(words,type,container_class,code)
{
    var code_postfix = '';
    code != '' ? code_postfix = '/code/'+code : code_postfix = '';

    //try find in database by name
    jQuery.ajax({ url: '/ajax/clientsfiltersell/words/'+words+'/type/'+type+code_postfix, beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data)
    {
        jQuery('.'+container_class).html(data);
    });
}