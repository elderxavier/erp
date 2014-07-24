var current_file_index = 0;

var FILE_FIELDS_NAME = 'files';
var CLASS_FILE_BUTTON_SELECT = 'file-sel';
var CLASS_TABLE_FILES = 'file-table';
var FORM_NAME = 'ProductCardForm';
var CLASS_FILE_DEL_LINK = 'ajax-del-file';
var ID_TR = 'file_id_';

jQuery(document).ready(function(){

    jQuery(document).on('change','.'+CLASS_FILE_BUTTON_SELECT,function(){

        //if changed last filed
        if(jQuery(this).attr('spec-index') == current_file_index)
        {
            //increase current index
            current_file_index++;

            //html tr-block for table with file-filed
            var html_block = '<tr class="file-select"><td colspan="3"><input type="file" name="'+FORM_NAME+'['+FILE_FIELDS_NAME+']['+current_file_index+']" class="form-control '+CLASS_FILE_BUTTON_SELECT+'" spec-index="'+current_file_index+'"></td>';

            //add block to table
            jQuery("."+CLASS_TABLE_FILES).append(html_block);
        }
    });

    jQuery(document).on('click','.'+CLASS_FILE_DEL_LINK, function(){

        //get file id from special attribute
        var file_id = jQuery(this).attr('spec-id');

        jQuery.ajax({ url: jQuery(this).attr('href'), beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data){

            if(data == 'SUCCESS')
            {
                //remove tr DOM element
                jQuery("#"+ID_TR+file_id).remove();
            }
        });

        return false;
    });

});