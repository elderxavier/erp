var empty_list_text = '';

$(function(){

    empty_list_text = jQuery('#empty-list').find('td').html();

    $(document).on('click','.add-prod',function(){
        var objProd = $(this).data();
        addProduct(objProd);
        return false;
    });//click

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


    $('.by-name').autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "/buy/sellers",
                dataType: "json",
                data: {
                    term: request.term

                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        minLength: 1
    });

    $('.by-number').autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "/buy/sellers",
                dataType: "json",
                data: {
                    code: request.term

                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        minLength: 1
    });

    $('#prod-name-input').autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "/buy/autocompleteproductsname",
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
                url: "/buy/AutoCompleteProductsCode",
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

        clientFilter(m_value,m_code);
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
    var tbl_body = jQuery(".make-invoice-body");

    //clean all containers
    hidden_field_container.html("");
    tbl_body.html('');

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
            tbl_body.append(html_tr_info);
            //append hidden fields
            hidden_field_container.append(html_fields);

            //increase sum
            total_price += (price * qnt);
        }

    });
    //append last hidden fields
    hidden_field_container.append('<input type="hidden" name="BuyForm[stock]" value="'+stock_id+'">');
    hidden_field_container.append('<input type="hidden" name="BuyForm[signer_name]" value="'+signer_name+'">');
    hidden_field_container.append('<input type="hidden" name="BuyForm[invoice_code]" value="'+inv_code+'">');

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

var clientFilter = function(value,code_v){
	$('.body-holder table tbody').load('/buy/sellfilter/',
		{ name : value, code: code_v}
	);	
};//clientFilter


var modalInfo = function(link){
    $.ajaxSetup({async:false});
    $('#modal-user-info').load(link);
    $('.cust-info').modal('show');
};//modalInfo

var filterProds = function(name, code)
{
    jQuery('#filtered-tbl-body').load('/buy/FindProductsModal/',
        {name:name,code:code}
    );
};//filterProds

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