/**
 * Created by Wolfdark on 21.07.14.
 */

$(function() {
    showModalCreateClientIfNeeded();

    $.fn.editable.defaults.mode = 'inline';

    $('#client-type').change(function(e) {
        var val = $(this).val();
        if(val == ''){
            $('.filter-wrapper').html('<h5 class="text-center">Select client type</h5>');
        }else{
            changeFilter(val);
        }
    });//change

    $(document).on('keydown','.by-name',function(){

        $('.by-name').autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: "/contractors/ajax/ajaxClients",
                    dataType: "json",
                    data: {
                        term: request.term,
                        type: jQuery("#client-type").val()
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            minLength: 1,

            select:function(event,ui){
                var id = ui.item.id; //get id of client
                var label = ui.item.label; //get entered word

            }
        });

    });//live

    $(document).on('click','#filter-search',function(){
        var value = $('.by-name').val();
        var type = $("#client-type").val();

        clientFilter(type,value);
    });//click

    $(document).on('click','.cust-link',function(e){
        var link = $(this).attr('data-link');
        modalInfo(link);
        return false;
    });// click on body-holder

}); // document ready


var modalInfo = function(link){
    $.ajaxSetup({async:false});
    $('#modal-user-info').load(link);
    $('.cust-info').modal('show');
};//modalInfo


var clientFilter = function(type,value){
    console.log(type,value);
    $('.body-holder table tbody').load('/contractors/ajax/cusfiltersales/',
        {type: type, name : value}
    );
};//clientFilter


var changeFilter = function(val){
    $(".filter-wrapper").load('/contractors/ajax/fselector/'+val);
};//changeFilter


var clientForm = function(obj){
    var clientName = obj.val();
    console.log(clientName);
    $('.right-part .form-holder').load('/contractors/ajax/check_customer',
        {name : clientName},function(data){});
};

var showModalCreateClientIfNeeded = function()
{
    var hidden_filed_to_open = jQuery("#open-modal-create-client");
    if(hidden_filed_to_open.length > 0)
    {
        if(hidden_filed_to_open.val() == 1)
        {
            jQuery('.new-customer-juridical').modal('show');
        }
        else
        {
            jQuery('.new-customer-physical').modal('show');
        }
    }
};