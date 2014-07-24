var current_file_index = 0;

jQuery(document).ready(function(){

    jQuery(document).on('change','.file-sel',function(){

        //if changed last filed
        if(jQuery(this).attr('spec-index') == current_file_index)
        {
            //increase current index
            current_file_index++;

            //html tr-block for table with file-filed
            var html_block = '<tr class="file-select"><td colspan="3"><input type="file" name="ProductCardForm[files]['+current_file_index+']" class="form-control file-sel" spec-index="'+current_file_index+'"></td>';

            //add block to table
            jQuery(".file-table").append(html_block);
        }
    });

    jQuery(document).on('click','.ajax-del-file', function(){

        //get file id from special attribute
        var file_id = jQuery(this).attr('spec-id');

        jQuery.ajax({ url: jQuery(this).attr('href'), beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data){

            if(data == 'SUCCESS')
            {
                //remove tr DOM element
                jQuery("#file_id_"+file_id).remove();
            }
        });

        return false;
    });

});