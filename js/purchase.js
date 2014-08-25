var empty_list_text = '';

$(function(){

    empty_list_text = jQuery('#empty-list').find('td').html();

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

    $(document).on('keyup keydown','.price',function(e){
        if(checkSymbolsMy(e))
        {
            total();
            return true;
        }
        return false;
    });//keyup on price


    $(document).on('keyup','.quant',function(){
        total();
    });//keyup on quant


    if(jQuery(".opened-modal-prod").length > 0)
    {
        jQuery("#newProduct").modal('show');
    }

    if(jQuery(".opened-modal-new-supplier").length > 0)
    {
        jQuery(".new-customer").modal('show');
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
        var m_value = $('.by-name').val();
        var m_code = $('.by-number').val();

        if(m_code == '')
        {
            clientFilter(m_value);
        }
        else
        {
            alert('filter by code will be done soon');
        }
    });//click


    $(document).on('click','.cust-link',function(e){
        var link = $(this).attr('data-link');
        modalInfo(link);
        return false;
    });// click on body-holder

    jQuery(".filter-btn-do").click(function(){
        filterProds(jQuery('#prod-name-input').val(),jQuery('#prod-code-input').val())
    });


    jQuery(".create-invoice").click(function(e){
        return createInvoiceFillForm(e);
    });//create invoice

});

$(document).ajaxComplete(function(){
    $('.add-prod').click(function(e) {
        var objProd = $(this).data();
        addProduct(objProd);
        return false;
    });//click
});




var createInvoiceFillForm = function(e)
{
    //total price - zero
    var total_price = 0;
    //get all values and containers
    var stock_id = jQuery('#stock-selector').val();
    var signer_name = jQuery("#signer-name").val();
    var inv_code = jQuery("#invoice-code").val();
    var items = jQuery(".prod-item");
    var hidden_field_container = jQuery(".make-invoice-fields");

    //clean all containers
    hidden_field_container.html("");
    jQuery(".make-invoice-body").html('');

    //check for emptiness
    if(signer_name == '')
    {
        alert('Fill signer name');
        return false;
    }
    if(inv_code == '')
    {
        alert('Fill invoice code');
        return false;
    }

    //for each added product-tr in table
    items.each(function(i,obj)
    {
        var id = jQuery(obj).data().id;
        var name = jQuery(obj).find('#pr-name').html();
        var code = jQuery(obj).find('#pr-code').html();
        var units = jQuery(obj).find('#pr-units').html();
        var qnt = jQuery(obj).find('#pr-qnt').find('.quant').val();
        var price = jQuery(obj).find('#pr-price').find('.price').val();


        //if price not correct - make it zero
        if (isNaN(price)) price = 0;

        //hidden inputs
        var html_fields = '<input type="hidden" name="BuyForm[products]['+id+'][qnt]" value="'+qnt+'">'+'<input type="hidden" name="BuyForm[products]['+id+'][price]" value="'+price+'">';
        //visible table rows
        var html_tr_info = '<tr><td>'+name+'</td><td>'+code+'</td><td>'+units+'</td><td>'+qnt+'</td><td>'+price+'</td></tr>';

        //if quantity set
        if(qnt > 0 && !isNaN(qnt))
        {
            //append html
            jQuery(".make-invoice-body").append(html_tr_info);
            jQuery(".make-invoice-fields").append(html_fields);

            //increase sum
            total_price += (price * qnt);
        }

    });
    //append hidden fields
    hidden_field_container.append('<input type="hidden" name="BuyForm[stock]" value="'+stock_id+'"><input type="hidden" name="BuyForm[signer_name]" value="'+signer_name+'"><input type="hidden" name="BuyForm[invoice_code]" value="'+inv_code+'">');
    //write total price
    jQuery("#sum-invoice").html(total_price);

    //return old event
    return e;
};

var checkSymbolsMy = function(e)
{
    var available_keys = [97, 98, 99, 100, 101, 102, 103, 104, 105, 96, 8, 190, 37, 39, 46, 49, 50, 51, 52, 53, 54, 55, 56, 57, 48];
    return (jQuery.inArray(e.keyCode,available_keys) != -1);
};

/*
var checkSimbols = function(e){
    if (e.keyCode == 8 || e.keyCode == 46) {
        return true;
    }else{
        var letters = '1234567890.';
        return (letters.indexOf(String.fromCharCode(e.which)) != -1);
    }
}
*/

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
        $('.btn-submit').css('display','inline-block');
    }

    var prodArray = $(".prod-item");
    var prodId = parseInt(objProd.id);
    var elem = "<tr id='"+ prodId +"' class='prod-item' data-id='"+ prodId +"'><td id='pr-name'>"+ objProd.name +"</td><td id='pr-code'>"+ objProd.code +"</td><td id='pr-units'>"+ objProd.unit +"</td><td id='pr-qnt'><input class='quant' type='text' value='1'></td><td id='pr-price'><input class='price' type='text' value=''></td><td><button data-id='"+ prodId +"' class='del-btn btn btn-danger btn-xs'><span class='glyphicon glyphicon-minus-sign'></span></button></td></tr>";

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
        var price = parseFloat($(this).find('.price').val()) || 0;

        total = total + quant * price;
    });

    $('#total').html(total)
};//total

var delProd = function(id){
    $('#'+id).remove();
    if($('.prod-item').length == 0 ){
        $(".summ").before("<tr id='empty-list'><td colspan='6'>"+empty_list_text+"</td></tr>");
        $('#total').html('0');
        $('.btn-submit').css('display','none');
    }else{
        total();
    }

};//delProd