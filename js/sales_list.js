jQuery(document).ready(function(){


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

    jQuery(".date-picker-cl").datepicker({
        orientation: "bottom left"
    });


    jQuery(document).on('click','.info-open-lnk',function(){
        var href = jQuery(this).attr('href');
        jQuery.ajax({ url: href, beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data)
        {
            jQuery('#modal-operation-info').html(data);
        });
    });

    jQuery(document).on('click','.filter-button-top',function(){
        filter();
        return false;
    });


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

});

/********************************************************************************************************************/

var filter = function()
{
    var client_name = jQuery('#client-name-inputs').val();
    var invoice_code = jQuery('#invoice-code-input').val();
    var client_type = jQuery('#cli-type').val();
    var city = jQuery('#city-selector').val();
    var delivery_status = jQuery("#delivery-status").val();
    var date_from = jQuery("#date-from").val();
    var date_to = jQuery("#date-to").val();

    var filter_url = jQuery(".filter-form").attr('action');

    var params =
    {
        cli_name:client_name,
        cli_type_id:client_type,
        in_code:invoice_code,
        in_status_id:delivery_status,
        stock_city_id:city,
        date_from_str:date_from,
        date_to_str:date_to
    };

    jQuery(".ops-tbl-filter").load(filter_url,params);
};