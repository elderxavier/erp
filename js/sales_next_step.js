$(function(){

    $(document).on('click','.add-prod',function(){
        var objProd = $(this).data();
        addProduct(objProd);
        return false;
    });//click

    $(document).on('click','.add-option',function(){
        var objOpt = $(this).data();
        addOption(objOpt);
        return false;
    });//add-option click;

    $(document).on('click','.del-btn-opt',function(){
        delOpt(this);
        return false;
    });//click on del-btn-opt


    $(document).on('click','.del-btn',function(){
        var id = $(this).data('id');
        delProd(id);
        return false;
    });//click on del-btn

    $("#product-list-holder").on('keyup keydown','input.price',function(e){
        var value = $(this).val();
        console.log(value);
        if(checkSymbols(e,value)){
            total();
        }else{
            total();
            return false;
        }

    });//keyup on price


    $("#product-list-holder").on('keyup keydown','input.discount',function(e){
        var value = $(this).val();
        if(checkSymbols(e,value)){
            if(value > 100){
                $(this).val(100);
            }
            total();
        }else{
            total();
            return false;
        }

    });//keyup on price

    $('#vat').change(function(e) {
//        var vat = $(this).val();
        var vat = parseFloat($('#vat option:selected').text());
        var $span = $(".summ-plus-vat > .name > span");
        $span.html(vat);
        total();
    });



    //auto-complete filter-field
    jQuery("#prod-name").autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "/ajax/AutoCompleteFromStockByName",
                dataType: "json",
                data: {
                    term: request.term,
                    stock: jQuery("#stock-selector").val()
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        minLength: 1
    });

    //auto-complete filter-field
    jQuery("#prod-code").autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "/ajax/AutoCompleteFromStockByCode",
                dataType: "json",
                data: {
                    term: request.term,
                    stock: jQuery("#stock-selector").val()
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        minLength: 1
    });

    jQuery("#filter-button").click(function(){

        filterByNameCodeStock($("#prod-name").val(),$("#prod-code").val(),$("#stock-selector").val());
    });


    jQuery(".btn-submit").click(function(){
//        alert('test');
        loadFormByAddedItems();
    });


});//$(function)

/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

var loadFormByAddedItems = function()
{
    var tableBody = jQuery(".modal-tbl-body");
    var totalModal = jQuery("#total-modal");
    var totalVatModal = jQuery("#total-plus-vat-modal");
    var hiddenFieldsBlock = jQuery(".hidden-fields-modal");

    var product_trs = jQuery(".prod-item");
    var options_trs = jQuery(".prod-option");

    var vat = parseFloat($('#vat option:selected').text());
    jQuery(".vat-percent").html(vat);

    var total_price = 0;
    var total_price_vat = 0;

    tableBody.html('');
    totalModal.html('');
    totalVatModal.html('');
    hiddenFieldsBlock.html('');

    product_trs.each(function(i,obj)
    {
        var id = jQuery(obj).data().id;
        var name = jQuery(obj).find('.name').html();
        var code = jQuery(obj).find('.code').html();
        var units = jQuery(obj).find('.unit').html();
        var qnt = jQuery(obj).find('.quant').html();
        var price = parseFloat(jQuery(obj).find('.price').val());
        var discount_percent = jQuery(obj).find('.discount').val();

        total_price += (price - ((price)*(discount_percent/100)))*qnt;

        tableBody.append("<tr><td>"+name+"</td><td>"+code+"</td><td>"+units+"</td><td>"+qnt+"</td><td>"+price+"</td><td>"+discount_percent+"</td></tr>");
        hiddenFieldsBlock.append("<input type='hidden' value='"+qnt+"' name='SaleFrom[products]["+id+"][qnt]'>");
        hiddenFieldsBlock.append("<input type='hidden' value='"+price+"' name='SaleFrom[products]["+id+"][price]'>");
        hiddenFieldsBlock.append("<input type='hidden' value='"+discount_percent+"' name='SaleFrom[products]["+id+"][discount]'>");
    });

    options_trs.each(function(i,obj)
    {
        var id =  jQuery(obj).data().id;
        var name = jQuery(obj).find('.name').html();
        var price = parseFloat(jQuery(obj).find('.price').val());

        total_price += price;

        tableBody.append("<tr><td colspan='4'>"+name+"</td><td>"+price+"</td><td>-</td></tr>");
        hiddenFieldsBlock.append("<input type='hidden' value='"+price+"' name='SaleFrom[options]["+id+"][price]'>");
    });

    hiddenFieldsBlock.append("<input type='hidden' value='"+parseFloat(jQuery("#stock-selector").val())+"' name='SaleFrom[stock_id]'>");
    hiddenFieldsBlock.append("<input type='hidden' value='"+parseFloat(jQuery("#client-id").val())+"' name='SaleFrom[client_id]'>");
    hiddenFieldsBlock.append("<input type='hidden' value='"+parseFloat($('#vat').val())+"' name='SaleFrom[vat_id]'>");

    total_price_vat = total_price + (total_price * (vat/100));

    totalModal.html(total_price.toFixed(2));
    totalVatModal.html(total_price_vat.toFixed(2));
};//loadFormByAddedItems

var filterByNameCodeStock = function(name,code,stock)
{
    jQuery('#filtered-body').load('/ajax/filterbystockcodeandname/',
        {name:name,code:code,stock:stock}
    );

};//filterByNameCodeStock


var checkSymbols = function(e,value)
{
    /*
    if (e.keyCode == 8 || e.keyCode == 46) {
        return true;
    }
    */

    var splitVal = value.split('.',2);
    if(splitVal[1] && splitVal[1].length == 2 ){
        return false;
    }

    var available_keys = [97, 98, 99, 100, 101, 102, 103, 104, 105, 96, 8, 190, 37, 39, 46, 49, 50, 51, 52, 53, 54, 55, 56, 57, 48, 188];
    return (jQuery.inArray(e.keyCode,available_keys) != -1);
};

var addOption = function(objOpt){
    if($('#empty-list').length > 0){
        $('#empty-list').remove();
        $('.btn-submit').css('display','inline-block');
    }

    var elem = "<tr id='opt" + objOpt.id + "' data-id='"+objOpt.id+"' class='prod-option'><td class='name' colspan='3'>" + objOpt.name + "</td><td class='quant'>1</td><td><input class='price opt-price' type='text' value='0' ></td><td></td><td><button class='del-btn-opt btn btn-danger btn-xs' data-id='4' title='Delete product'><span class='glyphicon glyphicon-minus-sign'></span></button></td></tr>";
    if($('#opt'+objOpt.id).length > 0){
        return false;
    }else{
        $(".summ").before(elem);
    }

};//addOption

var addProduct = function(objProd){
    if($('#empty-list').length > 0){
        $('#empty-list').remove();
        $('.btn-submit').css('display','inline-block');
    }

    var prodArray = $(".prod-item");
    var prodId = parseInt(objProd.id);
    var elem = "<tr id='"+ prodId +"' class='prod-item' data-id='"+ prodId +"'><td class='name'>"+ objProd.name +"</td><td class='code'>"+ objProd.code +"</td><td class='unit'>"+ objProd.unit +"</td><td class='quant'>1</td><td><input class='price opt-price' type='text' value='' ></td><td><input type='text' value='0' class='discount' /></td><td><button title='Delete product' data-id='"+ prodId +"' class='del-btn btn btn-danger btn-xs'><span class='glyphicon glyphicon-minus-sign'></span></button></td></tr>";

    var elemObj = $('#'+objProd.id);
    if(elemObj.length > 0){
        var value = parseInt(elemObj.find('.quant').html(),10);
        if(value == objProd.quant){
            return false
        }else{
            elemObj.find('.quant').html(value + 1);
            total();
        }
    }else{
        if($('.prod-option').length > 0 ){
            $('.prod-option').first().before(elem);
        }else{
            $(".summ").before(elem);
        }

    }

};//addProduct


var total = function(){
    var total = 0;
    $('.prod-item, .prod-option').each(function() {
        var quant = parseFloat($(this).find('.quant').html()) || 0;
        quant = (Math.round(quant *100))/100;
        var price = parseFloat($(this).find('input.price').val()) || 0;
        price = (Math.round(price *100))/100;
        var discount = parseFloat($(this).find('.discount').val()) || 0;
        discount = (Math.round(discount *100))/100;
        console.log(discount);
        total = total + quant * (price - (price * discount)/100);
        total = (Math.round(total *100))/100;
    });

    //add vat
//    var vat = parseFloat($('#vat').val());
    var vat = parseFloat($('#vat option:selected').text());
    console.log(vat);
    var totalWithVat = total + (total * vat) /100;
    totalWithVat = (Math.round(totalWithVat*100))/100;

    $('#total-plus-vat').html((totalWithVat).toFixed(2));
    $('#total').html(total.toFixed(2));
};//total


var delProd = function(id){
    $('#'+id).remove();
    if($('.prod-item').length == 0 ){
        $(".summ").before("<tr id='empty-list'><td colspan='6'>No data</td></tr>");
        $('#total').html('0');
        $('.btn-submit').css('display','none');
    }else{
        total();
    }

};//delProd


var delOpt = function(objOpt){
    $(objOpt).parent().parent().remove();

    if($('.prod-item').length == 0 ){
        $(".summ").before("<tr id='empty-list'><td colspan='6'>No data</td></tr>");
        $('#total').html('0');
        $('.btn-submit').css('display','none');
    }else{
        total();
    }

};//delProd