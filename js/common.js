$(document).ready(function(e) {


    $(document).on('click','.btn-toggle',function() {
        ChangeStatus($(this));

        $(this).find('.btn').toggleClass('active');
        if($(this).find('.btn-primary').size() > 0)
        {
            $(this).find('.btn').toggleClass('btn-primary');
        }
        $(this).find('.btn').toggleClass('btn-default');
    });//click


    $('#filter-select').change(function(e){
        var catValue = $(this).val();
        if(catValue > 0){
            ajaxFilter(catValue);
        }

    });
});

/**
 * Changes status of product
 * @param obj
 * @constructor
 */
var ChangeStatus = function(obj)
{
    var url_path = '/products/changeproductstatus/'+ (obj).attr('prod_id');
    //ajax load data
    jQuery.ajax({ url: url_path,beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data){});
};

/**
 * Doing ajax filtering for products
 * @param category
 * @returns {boolean}
 */
/*
var ajaxFilter = function(category){
    $('.table tbody').load('/ajax/product',
        {
            category: category
        },
        function(data){}
    );
    return false;
};
*/