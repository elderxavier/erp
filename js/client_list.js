jQuery(document).ready(function(){

    /**
     * Auto-complete for client-names
     */
    jQuery('#name').autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "/ajax/clients",
                dataType: "json",
                data: {
                    term: request.term,
                    type: jQuery('#type_id').val()
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        minLength: 1
    });


    /**
     * Filter on change
     */
    jQuery('#type_id, #city_name').change(function(){
        var params = getParamsFromInputs();
        filter(params);
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
    });

});


/********************************************************************************************************************/

/**
 * Returns parameters from inputs for ajax request (POST parameters)
 * @returns {{name: *, code: *, location: *, units: *}}
 */
var getParamsFromInputs = function(){

    var code = jQuery('#code').val();
    var name = jQuery('#name').val();
    var email = jQuery('#email').val();
    var type_id = jQuery('#type_id').val();
    var city_name = jQuery('#city_name').val();

    return {
        code : code,
        email: email,
        name : name,
        type_id: type_id,
        city_name : city_name
    };
};

/**
 * Loads filtered data to table
 * @param params
 */
var filter = function(params)
{
    var filter_url = '/contractors/filterclients';
    jQuery(".table-holder").load(filter_url,params);
};//filter