jQuery(document).ready(function(){

    /**
     * Auto-complete for client-names
     */
    jQuery("#client-name-inputs").autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "/ajax/clients",
                dataType: "json",
                data: {
                    term: request.term,
                    type: jQuery("#cli-type").val()
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        minLength: 1
    });

    /**
     * Date-pickers for date-fields
     */
    jQuery(".date-picker-cl").datepicker({
        orientation: "bottom left"
    });


    /**
     * When clicked on operation id (show operation info)
     */
    jQuery(document).on('click','.info-open-lnk',function(){
        var href = jQuery(this).attr('href');
        jQuery.ajax({ url: href, beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data)
        {
            jQuery('#modal-operation-info').html(data);
        });
    });


    /**
     * When clicked on 'generate pdf'
     */
    jQuery(document).on('click','.gen-pdf',function(){
        var href = jQuery(this).attr('href');
        var id = jQuery(this).data().id;

        jQuery.ajax({ url: href, beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data)
        {
            var key = (JSON.parse(data)).key;
            var link = (JSON.parse(data)).link;

            jQuery('#op_id_'+id).find('.invoice-code').html(key);
            jQuery(".file-load-frame").attr("src",link);
        });

        return false;
    });

    /**
     * When clicked on 'filter' button
     */
    jQuery(document).on('click','.filter-button-top',function(){
        var params = getParamsFromInputs();
        filter(params);
        return false;
    });

    /**
     * When clicked on pagination page
     */
    jQuery(document).on('click','.links-pages',function(){
        var params = getParamsFromInputs();
        params.page = jQuery(this).html(); //get page number
        filter(params);
        return false;
    });

});

/********************************************************************************************************************/

/**
 * Returns parameters from inputs for ajax request (POST parameters)
 * @returns {{cli_name: *, cli_type_id: *, in_code: *, in_status_id: *, stock_city_id: *, date_from_str: *, date_to_str: *}}
 */
var getParamsFromInputs = function(){

    //get all params from inputs
    var client_name = jQuery('#client-name-inputs').val();
    var invoice_code = jQuery('#invoice-code-input').val();
    var client_type = jQuery('#cli-type').val();
    var city = jQuery('#city-selector').val();
    var delivery_status = jQuery("#delivery-status").val();
    var date_from = jQuery("#date-from").val();
    var date_to = jQuery("#date-to").val();

    return {
        cli_name:client_name,
        cli_type_id:client_type,
        in_code:invoice_code,
        in_status_id:delivery_status,
        stock_city_id:city,
        date_from_str:date_from,
        date_to_str:date_to
    };
};

/**
 * Filter by params and load table
 */
var filter = function(params)
{
    var filter_url = '/sell/filtertable';
    jQuery(".table-holder").load(filter_url,params);
};//filter