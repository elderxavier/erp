$(document).ready(function(e) {

    $('.btn-toggle').click(function(e) {

        var id = jQuery(this).attr('prod_id');

        if(jQuery(this).attr('state') == 1)
        {
            ChangeStatus('ProductCards','http://erpgit.loc/main/changestatus',id,0);
            jQuery(this).attr('state', 0);
        }
        else
        {
            ChangeStatus('ProductCards','http://erpgit.loc/main/changestatus',id,1);
            jQuery(this).attr('state', 1);
        }

        $(this).find('.btn').toggleClass('active');
		if($(this).find('.btn-primary').size() > 0)
        {
			$(this).find('.btn').toggleClass('btn-primary');
		}
		 $(this).find('.btn').toggleClass('btn-default');
    });
});

/**
 * Function sends ajax request to controller, to change status of some records in database
 * @param model_class string class of model
 * @param url_path string path to controller
 * @param id int id of record
 * @param status int active or not
 * @constructor
 */
var ChangeStatus = function(model_class,url_path,id,status)
{
    //ajax load data
    jQuery.ajax({ url: url_path+'/model/'+model_class+'/id/'+id+'/status/'+status,beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data)
    {

    });
};