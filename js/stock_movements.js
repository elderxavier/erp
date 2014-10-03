jQuery(document).ready(function(){

    /**
     * Date-pickers for date-fields
     */
    jQuery(".date-picker-cl").datepicker({
        orientation: "bottom left"
    });

    /**
     * Clicked on filter-button
     */
    jQuery(document).on('click','.filter-button-top',function(){
        var params = getParamsFromInputs();
        filter(params);
        return false;
    });

    /**
     * Filter on change
     */
    jQuery('#from-stock, #to-stock').change(function(){
        var params = getParamsFromInputs();
        filter(params);
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

    /**
     * When clicked on generate pdf
     */
    jQuery(document).on('click','.pdf-gen-link',function(){
        var href = jQuery(this).attr('href');
        jQuery(".file-load-frame").attr('src',href);
        return false;
    });
});

/***************************************************************************************************************************************************/

/**
 * Returns values of inputs for ajax filtration
 * @returns {{movement_id: *, src_stock_id: *, trg_stock_id: *, date_from_str: *, date_to_str: *}}
 */
var getParamsFromInputs = function(){

    var movement_id = jQuery('#mov-id').val();
    var src_stock_id = jQuery('#from-stock').val();
    var trg_stock_id = jQuery('#to-stock').val();
    var date_from_str = jQuery('#date-from').val();
    var date_to_str = jQuery('#date-to').val();

    return {
        movement_id : movement_id,
        src_stock_id : src_stock_id,
        trg_stock_id : trg_stock_id,
        date_from_str : date_from_str,
        date_to_str: date_to_str
    };
};

var filter = function(params)
{
    var filter_url = '/stock/ajax/movementfilter';
    jQuery(".table-holder").load(filter_url,params);
};