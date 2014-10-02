jQuery(document).ready(function(){

    jQuery('.date-picker-srv').datepicker({
        orientation: "bottom left"
    });

    //when selected city
    jQuery(".ajax-filter-city").change(function(){
        jQuery.ajax({ url: '/services/workers/city/'+jQuery(this).val(), beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data){
            jQuery(".filtered-users").html(data);
        });
    });

});