$(document).ready(function(e) {

    $('.btn-toggle').click(function(e) {
        $(this).find('.btn').toggleClass('active');
		if($(this).find('.btn-primary').size() > 0)
        {
			$(this).find('.btn').toggleClass('btn-primary');
//            alert('on');
		}
		 $(this).find('.btn').toggleClass('btn-default');
    });

	
});






var ChangeStatus = function(model_class,url_path,id,status)
{
    //http://erpgit.loc/main/changestatus/model_class/ProductCards/id/2/status/1

    var url_string = 'http://erpgit.loc/main/changestatus/';

    //ajax load data
    jQuery.ajax({ url: url_path+'/id/'+id+'/status/'+status,beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data)
    {

    });
};

const VALIDATE_EMPTY = 0;
const VALIDATE_MAX_LEN = 1;
const VALIDATE_MIN_lEN = 2;
const VALIDATE_NUMBER = 3;

var ValidateOnSubmit = function(form_class,obj_rules,arg,func)
{
    if(arg == null || isNaN(arg)){arg = 0;}
    if(func == null || isNaN(func)){func = 0;}

    var can_proceed = true;
    var error_obj = {};

    //when form submitted
    jQuery("."+form_class).submit(function(){

        //check all filed-rules pairs in object
        jQuery.each(obj_rules,function(field_name,rule){

            //get value of current field
            var input_value = jQuery("input[name='"+field_name+"']").val();

            //for all rules
            switch (rule)
            {
                //if validate on emptiness
                case VALIDATE_EMPTY:
                    if(input_value == ''){can_proceed = false;}
                    break;
                //if validate on max length
                case VALIDATE_MAX_LEN:
                    if(input_value.length > arg){can_proceed = false;}
                    break;
                //if validate on min length
                case VALIDATE_MIN_lEN:
                    if(input_value.length < arg){can_proceed = false;}
                    break;
                //if validate on number
                case VALIDATE_NUMBER:
                    if(isNaN(input_value)){can_proceed = false;}
                    break;
            }

        });
    });
};