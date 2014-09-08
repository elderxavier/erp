$(function(){

    jQuery(".filter-holder").on('click','.add-prod',function(){
        var objProd = $(this).data();
        addProduct(objProd);
        return false;
    });

    $('#product-list-holder').on('click','.del-btn',function(){
        var id = $(this).data('id');
        delProd(id);
        return false;
    });//click on del-btn

    jQuery("#filter-btn-prods").click(function(){
        filter_prods();
        return false;
    });

    jQuery('#prod-name-src').autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "/stock/autocompleteproductcardsbystock",
                dataType: "json",
                data: {
                    name: request.term,
                    stock: jQuery("#stock-id-src").val()
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        minLength: 1
    });//auto-complete for name

    jQuery('#prod-code-src').autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "/stock/autocompleteproductcardsbystock",
                dataType: "json",
                data: {
                    code: request.term,
                    stock: jQuery("#stock-id-src").val()
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        minLength: 1
    });//auto-complete for code


    jQuery("#stock-id-src").change(function(){
        var option = jQuery(this).find('option:selected');
        var data = option.data();
        jQuery(".src-address").html(data.address+', '+data.city+', '+data.postcode);
    }); //changing stock

    jQuery("#stock-id-trg").change(function(){
        var option = jQuery(this).find('option:selected');
        var data = option.data();
        jQuery(".trg-address").html(data.address+', '+data.city+', '+data.postcode);
    }); //changing stock

    jQuery(".btn-submit").click(function(){
        if(!stock_equal())
        {
            fill_form();
        }
        else
        {
            alert('Selected stocks are equal!');
            return false;
        }
        return true;
    });

});// end $(function())


var addProduct = function(objProd){

    var empty_list = $('#empty-list');

    if(empty_list.length > 0){
        empty_list.remove();
        $('.btn-submit').css('display','inline-block');
    }
    console.log(objProd);
    var elemObj = $('#'+objProd.id);

    if(elemObj.length > 0)
    {
        var value = parseInt(elemObj.find('.quant').html());
        if(value < objProd.quant) elemObj.find('.quant').html(value + 1);
    }
    else
    {
        var weightNet = (parseFloat(objProd.wghnet))/1000;
        var weightGross = (parseFloat(objProd.wghgross))/1000;

        var elem = "" +
            "<tr data-id='"+ objProd.id +"' class='prod-item' id='"+ objProd.id +"'>" +
            "<td class='_name'>"+objProd.name+"</td>" +
            "<td class='_code'>"+objProd.code+"</td>" +
            "<td class='_unit'>"+objProd.unit+"</td>" +
            "<td class='quant'>1</td>" +
            "<td class='_dimension'>"+objProd.dimension+"</td>" +
            "<td class='_sizes'>"+objProd.sizes+"</td>" +
            "<td class='weight-net'>" + weightNet +"</td>" +
            "<td class='weight-gross'>" + weightGross + "</td>" +
            "<td><a class='del-btn btn btn-danger btn-xs' data-id='"+ objProd.id +"' title='Delete product'><span class='glyphicon glyphicon-minus-sign'></span></a></td>" +
            "</tr>";

        $(".summ").before(elem);
    }
    total();
};//addProduct



var delProd = function(id){
    $('#'+id).remove();
    if($('.prod-item').length == 0 ){
        $(".summ").before("<tr id='empty-list'><td colspan='9'>No data</td></tr>");
        $('.btn-submit').css('display','none');
    }
    total();

};//delProd


var total = function(){
    var totalNet = 0;
    var totalGross = 0;
    $('.prod-item').each(function() {
        var quant = parseFloat($(this).find('.quant').html()) || 0;
        //quant = (Math.round(quant *100))/100;
        var weightNet = parseFloat($(this).find('.weight-net').html()) || 0;
        weightNet = (Math.round(weightNet *1000))/1000;
        var weightGross = parseFloat($(this).find('.weight-gross').html()) || 0;
        weightGross = (Math.round(weightGross *1000))/1000;

        totalNet = totalNet + quant * weightNet;
        totalGross = totalGross + quant * weightGross;

    });


    totalNet = (Math.round(totalNet *1000))/1000;
    totalGross = (Math.round(totalGross *1000))/1000;
    $('#total-net').html(totalNet.toFixed(3));
    $('#total-gross').html(totalGross.toFixed(3));
};//total


var filter_prods = function()
{
    var prod_name = jQuery("#prod-name-src").val();
    var prod_code = jQuery("#prod-code-src").val();
    var stock_id = jQuery("#stock-id-src").val();

    jQuery(".filtered-prods").load('/stock/prodfilter',{name:prod_name,code:prod_code, stock:stock_id});
};


var stock_equal = function()
{
    var stock_from_id = jQuery("#stock-id-src").val();
    var stock_to_id = jQuery("#stock-id-trg").val();

    return stock_from_id == stock_to_id;
};

var fill_form = function()
{
    //get form containers for fields
    var container = jQuery(".body-modal-prods");
    var container_fields = jQuery(".hidden-fields");
    var con_stock_from = jQuery(".vis-stock-from");
    var con_stock_to = jQuery(".vis-stock-to");

    //get source stock and target stock ID's
    var stock_from_id = jQuery("#stock-id-src").val();
    var stock_to_id = jQuery("#stock-id-trg").val();

    //get source stock and target stock names
    var stock_from_name = jQuery('#stock-id-src').find('option:selected').html();
    var stock_to_name = jQuery('#stock-id-trg').find('option:selected').html();

    //clean all visual containers and hidden-fields containers
    container.html('');
    container_fields.html('');
    con_stock_from.html('');
    con_stock_to.html('');

    //get all added products
    var added_products = jQuery(".prod-item");

    //strings for HTML
    var str_prods_html = '';
    var str_fields_html = '';

    //each added product
    added_products.each(function(i,obj){

        //get all product info
        var id = jQuery(obj).data().id;
        var name = jQuery(obj).find('._name').html();
        var code = jQuery(obj).find('._code').html();
        var units = jQuery(obj).find('._unit').html();
        var qnt = jQuery(obj).find('.quant').html();
        var dimension = jQuery(obj).find('._dimension').html();
        var sizes = jQuery(obj).find("._sizes").html();
        var weight_net = jQuery(obj).find('.weight-net').html();
        var weight_gross = jQuery(obj).find('.weight-gross').html();

        //add table row to html
        str_prods_html +=
            '<tr>'+
            '<td>'+name+'</td>' +
            '<td>'+code+'</td>' +
            '<td>'+units+'</td>' +
            '<td>'+qnt+'</td>' +
            '<td>'+dimension+'</td>' +
            '<td>'+sizes+'</td>' +
            '<td>'+weight_net+'</td>' +
            '<td>'+weight_gross+'</td>' +
            '</tr>';

        //add hidden field to html
        str_fields_html +=
            '<input type="hidden" name="MovementForm[products]['+id+']" value="'+qnt+'">';

    });

    str_prods_html += '' +
        '<tr>' +
        '<td colspan="3"></td>' +
        '<td colspan="3">Total NET</td>' +
        '<td colspan="2">'+jQuery('#total-net').html()+' KG</td>' +
        '</tr>';

    str_prods_html += '' +
        '<tr>' +
        '<td colspan="3"></td>' +
        '<td colspan="3">Total GROSS</td>' +
        '<td colspan="2">'+jQuery('#total-gross').html()+' KG</td>' +
        '</tr>';

    //add hidden source stock and target stock id to html
    str_fields_html += '' +
        '<input type="hidden" name="MovementForm[src_stock]" value="'+stock_from_id+'">' +
        '<input type="hidden" name="MovementForm[trg_stock]" value="'+stock_to_id+'">';

    //add HTML to form
    container.html(str_prods_html);
    container_fields.html(str_fields_html);
    con_stock_from.html(stock_from_name);
    con_stock_to.html(stock_to_name);
};