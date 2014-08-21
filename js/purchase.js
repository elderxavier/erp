$(document).ready(function(e) {
    
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


jQuery(document).ajaxComplete(function(){

    $('.add-prod').click(function(e) {
        var objProd = $(this).data();
        addProduct(objProd);
        return false;
    });//click

});


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

var addProduct = function(objProd){
    var idEl = jQuery("#added-prod-"+objProd.id);
    if(!idEl.length)
    {
        var elem = "<tr class='added-products' data-name='"+objProd.name+"' data-code='"+objProd.code+"' data-unit='"+objProd.unit+"' data-id='"+objProd.id+"' id='added-prod-"+objProd.id+"'><td>"+objProd.name+"</td><td>"+objProd.code+"</td><td>"+objProd.unit+"</td><td><input class='quant' type='text' value='1'></td><td><input class='price' type='text' value='0.00'></td><td><button data-id='"+objProd.id+"' class='del-prod btn btn-danger btn-xs'><span class='glyphicon glyphicon-minus-sign'></span></button></td></tr>";
        $(".summ").before(elem);
        jQuery('.del-prod').bind('click',function(){jQuery("#added-prod-"+jQuery(this).data().id).remove(); return false;});
    }
    else
    {
        idEl.find(".quant").val(parseInt(idEl.find(".quant").val())+1);
    }
};

var filterProds = function(name, code)
{
    jQuery.ajax({ url: '/ajax/FindProductsModal/name/'+name+'/code/'+code, beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data)
    {
        jQuery('#filtered-tbl-body').html(data);
    });
};