$(function(){

    $('.add-prod').click(function(e) {
        var objProd = $(this).data();
        addProduct(objProd);
        return false;
    });//click

    $('.add-option').click(function(e) {
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

    $(document).on('keyup keypress','.price',function(e){
        console.log(e);
        if(checkSymbolsMy(e)){
            total();
        }else{
            return false;
        }

    });//keyup on price


});//$(function)


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
}//checksSimbols
*/

var addOption = function(objOpt){
    if($('#empty-list').length > 0){
        $('#empty-list').remove();
        $('.btn-submit').css('display','inline-block');
    }

    var elem = "<tr id='opt" + objOpt.id + "' class='prod-option prod-item'><td colspan='3'>" + objOpt.name + "</td><td>1 <input type='hidden' value='1' class='quant' /></td><td><input class='price' type='text' /></td><td><button class='del-btn-opt btn btn-danger btn-xs' data-id='4' title='Delete product'><span class='glyphicon glyphicon-minus-sign'></span></button></td></tr>";
    if($('#opt'+objOpt.id).length > 0){
        console.log($('#opt'+objOpt.id).length);
        return false;
    }else{
        $(".summ").before(elem);
    }

}//addOption

var addProduct = function(objProd){
    if($('#empty-list').length > 0){
        $('#empty-list').remove();
        $('.btn-submit').css('display','inline-block');
    }

    var prodArray = $(".prod-item");
    var prodId = parseInt(objProd.id);
    var elem = "<tr id='"+ prodId +"' class='prod-item' data-id='"+ prodId +"'><td>'"+ objProd.name +"'</td><td>'"+ objProd.code +"'</td><td>'"+ objProd.unit +"'</td><td><input class='quant' type='text' value='1'></td><td><input class='price' type='text' value=''></td><td><button title='Delete product' data-id='"+ prodId +"' class='del-btn btn btn-danger btn-xs'><span class='glyphicon glyphicon-minus-sign'></span></button></td></tr>";

    var elemObj = $('#'+objProd.id);
    console.log(elemObj.length);
    if(elemObj.length > 0){
        var value = parseInt(elemObj.find('.quant').val());
        elemObj.find('.quant').val(value + 1);
        total();
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
    $('.prod-item').each(function() {
        var quant = parseFloat($(this).find('.quant').val()) || 0;
        quant = (Math.round(quant *100))/100;
        var price = parseFloat($(this).find('.price').val()) || 0;
        price = (Math.round(price *100))/100;
        total = total + quant * price;
        total = (Math.round(total *100))/100;
    });

    $('#total').html(total)
}//total


var delProd = function(id){
    $('#'+id).remove();
    if($('.prod-item').length == 0 ){
        $(".summ").before("<tr id='empty-list'><td colspan='6'>No data</td></tr>");
        $('#total').html('0');
        $('.btn-submit').css('display','none');
    }else{
        total();
    }

}//delProd


var delOpt = function(objOpt){
    $(objOpt).parent().parent().remove();

    if($('.prod-item').length == 0 ){
        $(".summ").before("<tr id='empty-list'><td colspan='6'>No data</td></tr>");
        $('#total').html('0');
        $('.btn-submit').css('display','none');
    }else{
        total();
    }

}//delProd