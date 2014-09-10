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
    });

});

/***********************************************************************************************************************/

var getParamsFromInputs = function()
{
    var name = jQuery("#name").val();
    var surname = jQuery("#surname").val();
    var position_id = jQuery("#position_id").val();
    var city_id = jQuery("#city_id").val();

    return {
        name : name,
        surname : surname,
        position_id: position_id,
        city_id : city_id
    };
};

var filter = function(params)
{
    var filter_url = '/users/filter';
    jQuery(".table-holder").load(filter_url,params);
};