jQuery(document).ready(function(){

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
        return false;
    });

    /**
     * Auto-complete for client-names
     */
    jQuery("#name-surname").autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "/users/autocomplete",
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

});

/***********************************************************************************************************************/

var getParamsFromInputs = function()
{
    var name_surname = jQuery("#name-surname").val();
    var position_id = jQuery("#position_id").val();
    var city_id = jQuery("#city_id").val();

    return {
        name_surname : name_surname,
        position_id: position_id,
        city_id : city_id
    };
};

var filter = function(params)
{
    var filter_url = '/users/filter';
    jQuery(".table-holder").load(filter_url,params);
};