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
     * When clicked on 'filter' button
     */
    jQuery(document).on('click','.filter-button-top',function(){
        filter();
        return false;
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
     * When clicked on pagination page
     */
    jQuery(document).on('click','.links-pages',function(){
        var filters_data = jQuery('.paginator').data(); //get post-filter-params
        var current_page = jQuery(this).html(); //get page nuber
        reFilterByPage(current_page,filters_data); //filter and reload pager
    });

});

/********************************************************************************************************************/


/**
 * Filter table by page (uses page nu,ber, and filter parameters) loads filtered table and paginator
 * @param page
 * @param filterData
 */
var reFilterByPage = function(page,filterData)
{
    filterData.page = page; //set page to post-params

    var form = jQuery(".filter-form"); //get form

    var filter_url = form.attr('action'); // get filter-table load url
    //var filter_url = '/sell/filtertable';
    var pages_url = form.data().pages; //get paginator load url
    //var pages_url = '/sell/ajaxpages'

    jQuery(".ops-tbl-filter").load(filter_url,filterData); //load table
    loadPager(filterData); //load pagintaor

};//reFilterByPage


/**
 * Filter by params and load table
 */
var filter = function()
{
    //get all params from inputs
    var client_name = jQuery('#client-name-inputs').val();
    var invoice_code = jQuery('#invoice-code-input').val();
    var client_type = jQuery('#cli-type').val();
    var city = jQuery('#city-selector').val();
    var delivery_status = jQuery("#delivery-status").val();
    var date_from = jQuery("#date-from").val();
    var date_to = jQuery("#date-to").val();

    //get filter-ajax url
    var filter_url = jQuery(".filter-form").attr('action');
    //var filter_url = '/sell/filtertable';

    //post-params for filtering
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

    //load table
    jQuery(".ops-tbl-filter").load(filter_url,params);
    //load pages
    loadPager(params);
};//filter


/**
 * Load pages by filtering-params (count of pages depends on count of records in filtered table)
 * @param params
 */
var loadPager = function(params)
{
    var pages_url = jQuery(".filter-form").data().pages;
    jQuery(".pages-holder").load(pages_url,params);
};//load pager