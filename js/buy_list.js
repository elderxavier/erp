jQuery(document).ready(function(){

    /**
     * Date-pickers for date-fields
     */
    jQuery(".date-picker-cl").datepicker({
        orientation: "bottom left"
    });


    /**
     * Auto-complete for suppliers
     */
    jQuery("#supplier-name").autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "/buy/ajax/sellers",
                dataType: "json",
                data: {
                    term: request.term

                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        minLength: 1
    });

    /**
     * When clicked on filter-button
     */
    jQuery("#search-btn").click(function(){
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
    });

    /**
     * When clicked on invoice-code in table
     */
    jQuery(document).on('click','.open-info-lnk',function(){
        var href = jQuery(this).attr('href');
        var modal = jQuery(".modal-content");
        modal.html('');
        modal.load(href);
    });

});

/***********************************************************************************************************************/

var getParamsFromInputs = function()
{
    var invoice_code = jQuery("#invoice-nr").val();
    var supplier_name = jQuery("#supplier-name").val();
    var date_from_str = jQuery("#date-from").val();
    var date_to_str = jQuery("#date-to").val();

    return {
        invoice_code : invoice_code,
        supplier_name : supplier_name,
        date_from_str: date_from_str,
        date_to_str : date_to_str
    };
};

var filter = function(params)
{
    var filter_url = '/buy/ajax/ajaxfilter';
    jQuery(".table-holder").load(filter_url,params);
};