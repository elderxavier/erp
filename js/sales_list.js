jQuery(document).ready(function(){


    jQuery("#client-name-inputs").autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "/ajax/clients",
                dataType: "json",
                data: {
                    term: request.term,
                    type: jQuery("#cli-type").val()
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        minLength: 1
    });

    jQuery(".date-picker-cl").datepicker({
        orientation: "bottom left"
    });


    jQuery(document).on('click','.info-open-lnk',function(){
        var href = jQuery(this).attr('href');
        jQuery.ajax({ url: href, beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data)
        {
            jQuery('#modal-operation-info').html(data);
        });
    });


    jQuery(document).on('click','.gen-pdf',function(){
        var href = jQuery(this).attr('href');
        var id = jQuery(this).data().id;

        jQuery.ajax({ url: href, beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data)
        {
            var key = (JSON.parse(data)).key;
            var link = (JSON.parse(data)).link;

            jQuery('#op_id_'+id).find('.invoice-code').html(key);
            jQuery(".file-load-frame").attr("src",link);
        });

        return false;
    });

});