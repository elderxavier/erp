jQuery(document).ready(function(){

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
    });

});


/********************************************************************************************************************/

/**
 * Returns parameters from inputs for ajax request (POST parameters)
 * @returns {{name: *, code: *, location: *, units: *}}
 */
var getParamsFromInputs = function(){

    var code = jQuery('#sel_code').val();
    var name = jQuery('#sel_name').val();
    var category_id = jQuery('#sel_category').val();
    var measure_id = jQuery('#sel_units').val();
    var status = jQuery('#sel_status').val();

    return {
        code : code,
        name : name,
        category_id : category_id,
        measure_id : measure_id,
        status : status
    };
};

/**
 * Loads filtered data to table
 * @param params
 */
var filter = function(params)
{
    var filter_url = '/products/filterproducts';
    jQuery(".table-holder").load(filter_url,params);
};//filter