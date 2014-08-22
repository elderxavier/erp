var empty_list_text = '';

$(function(){
    $(".prod-item  td  button").click(function(e) {
        var id = $(this).data('id');
        delProd(id);
        return false;
    });

    $(document).on('click','.del-btn',function(){
        var id = $(this).data('id');
        delProd(id);
        return false;
    });//click on del-btn

    $(document).on('keyup','.price',function(){
        total();
    });//keyup on price

    $(document).on('keyup','.quant',function(){
        total();
    });//keyup on quant

});

$(document).ajaxComplete(function(){
    $('.add-prod').click(function(e) {
        var objProd = $(this).data();
        addProduct(objProd);
        return false;
    });//click
});

$(document).ready(function(e) {

     empty_list_text = jQuery('#empty-list').find('td').html();

     if(jQuery(".opened-modal-prod").length > 0)
     {
         jQuery("#newProduct").modal('show');
     }

    if(jQuery("#filter-by-code").length > 0)
    {
        filterProds('',jQuery("#filter-by-code").val());
    }

     $(document).on('keydown','.by-name',function(){

        $('.by-name').autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: "/ajax/sellers",
                    dataType: "json",
                    data: {
                        term: request.term
                       
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


    $('#prod-name-input').autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "/ajax/autocompleteproductsname",
                dataType: "json",
                data: {
                    term: request.term
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

    $('#prod-code-input').autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "/ajax/AutoCompleteProductsCode",
                dataType: "json",
                data: {
                    term: request.term
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


    $(document).on('click','#filter-search',function(){
        var value = $('.by-name').val();
        clientFilter(value);
    });//click
    
    
    $(document).on('click','.cust-link',function(e){
        var link = $(this).attr('data-link');
        modalInfo(link);
        return false;
	});// click on body-holder

    jQuery(".filter-btn-do").click(function(){
        filterProds(jQuery('#prod-name-input').val(),jQuery('#prod-code-input').val())
    });

    jQuery(".create-invoice").click(function(){
        jQuery(".added-products").each(function(i,obj)
        {
            var data = jQuery(obj).data();
        });
    });

});//document ready




var clientFilter = function(value){
    console.log(value);
	$('.body-holder table tbody').load('/ajax/sellfilter/',
		{ name : value}
	);	
};//clientFilter

var modalInfo = function(link){
    $.ajaxSetup({async:false});
    $('#modal-user-info').load(link);
    $('.cust-info').modal('show');
};//modalInfo

var filterProds = function(name, code)
{
    jQuery.ajax({ url: '/ajax/FindProductsModal/name/'+name+'/code/'+code, beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data)
    {
        jQuery('#filtered-tbl-body').html(data);
    });
};




var addProduct = function(objProd){
    if($('#empty-list').length > 0){
        $('#empty-list').remove();
    }

    var prodArray = $(".prod-item");
    var prodId = parseInt(objProd.id);
    var elem = "<tr id='"+ prodId +"' class='prod-item' data-id='"+ prodId +"'><td>"+ objProd.name +"</td><td>"+ objProd.code +"</td><td>"+ objProd.unit +"</td><td><input class='quant' type='text' value='1'></td><td><input class='price' type='text' value=''></td><td><button data-id='"+ prodId +"' class='del-btn btn btn-danger btn-xs'><span class='glyphicon glyphicon-minus-sign'></span></button></td></tr>";

    var elemObj = $('#'+objProd.id);
    console.log(elemObj.length);
    if(elemObj.length > 0){
        var value = parseInt(elemObj.find('.quant').val());
        elemObj.find('.quant').val(value + 1);
    }else{
        $(".summ").before(elem);
    }

};//addProduct

var total = function(){
    var total = 0;
    $('.prod-item').each(function() {
        var quant = parseInt($(this).find('.quant').val()) || 0;
        var price = parseInt($(this).find('.price').val()) || 0;

        total = total + quant * price;
    });

    $('#total').html(total)
};//total

var delProd = function(id){
    $('#'+id).remove();
    if($('.prod-item').length == 0 ){
        $(".summ").before("<tr id='empty-list'><td colspan='6'>"+empty_list_text+"</td></tr>");
        $('#total').html('0');
    }else{
        total();
    }

};//delProd