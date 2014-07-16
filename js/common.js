$(document).ready(function(e) {

    $('.btn-toggle').click(function(e) {

        //change status by ajax
        ChangeStatus($(this));

        $(this).find('.btn').toggleClass('active');
		if($(this).find('.btn-primary').size() > 0)
        {
			$(this).find('.btn').toggleClass('btn-primary');
		}
		 $(this).find('.btn').toggleClass('btn-default');
    });
});

/**
 * Changes status of product
 * @param obj
 * @constructor
 */
var ChangeStatus = function(obj)
{
    var url_path = '/main/changeproductstatus/'+ (obj).attr('prod_id');
    //ajax load data
    jQuery.ajax({ url: url_path,beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data){});
};