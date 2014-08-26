/**
 * Document ready
 */
jQuery(function(){

    //if quick-client creation form ahs errors - show modal with form
    if(jQuery(".opened-modal-new-customer").length > 0)
    {
        jQuery(".new-customer").modal('show');
    }

    //auto-complete for names
    jQuery('.by-name').autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "/ajax/ClientsForSales",
                dataType: "json",
                data: {
                    auto_complete: 1,
                    name: request.term
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        minLength: 1
    });

    //auto-complete for codes
    jQuery('.by-number').autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "/ajax/ClientsForSales",
                dataType: "json",
                data: {
                    auto_complete: 1,
                    code: request.term
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        minLength: 1
    });

    //ajax filtering
    $(document).on('click','#filter-search',function(){
        var m_value = $('.by-name').val();
        var m_code = $('.by-number').val();
        clientFilter(m_value,m_code);
    });//click

    //load client info
    $(document).on('click','.cust-link',function(e){
        var link = $(this).attr('data-link');
        modalInfo(link);
        return false;
    });// click on body-holder

});



/**********************************************************************************************************************/

//loads filtered table of clients to container
var clientFilter = function(value,code_v){
    jQuery.ajax({ url: '/ajax/ClientsForSales/name/'+value+'/code/'+code_v+'/auto_complete/0', beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data)
    {
        jQuery('.body-holder table tbody').html(data);
    });
};//clientFilter


//loads info to modal window and shows
var modalInfo = function(link){
    $.ajaxSetup({async:false});
    $('#modal-user-info').load(link);
    $('.cust-info').modal('show');
};//modalInfo
