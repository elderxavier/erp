jQuery(document).ready(function(){

    jQuery(".info-open-lnk").click(function(){
        var href = jQuery(this).attr('href');
        jQuery.ajax({ url: href, beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data)
        {
            jQuery('#modal-operation-info').html(data);
        });
    });


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

});