/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    
    var sourceElement_id;
    var beingDragged;
    var count_total = 0;

    /**
     * Event when picking object up.
     */
    $('tr').draggable({
        revert: true,
        helper: "clone",
        cursor: "move",
        scroll: true,
        handle: $('.glyphicon-hand-down').parent(),
        start: function (event, ui)
        {
            beingDragged=$(this);
            sourceElement_id = $(this).closest('table').attr('id');
        },
        stop: function (event, ui)
        {
            //$('.droppable').removeAttr('disabled');
        }
    });
    
    /**
     * Event when dropping object.
     */
    $(".droppable").droppable({
        drop: function (event, ui) {

            //declare main properties
            var product_id = '';
            var client_id = '';
            var product_code = '';
            var product_name = '';
            var client_name = '';
            var current_element_id = $(this).attr('id');

            //if dragged product
            if(sourceElement_id == 'product-table')
            {
                //get product properties from source element
                product_id = $(ui.draggable).attr('product_id');
                product_code = $(ui.draggable).children(".prod_code").text();
                product_name = $(ui.draggable).children(".prod_name").text();
            }
            //if dragged client (or supplier)
            if(sourceElement_id == 'client-table')
            {
                //get client properties
                client_id = $(ui.draggable).attr('client_id');
                client_name = $(ui.draggable).text();
            }

            //if we drag product to product table
            if(sourceElement_id == 'product-table' && current_element_id == 'inputProduct')
            {
                //quantity not increased
                var increased_qnt = false;

                //create html block with fields
                var html_tr = '' +
                    '<tr class="prod-block">' +
                    '<td><input disabled type="text" name="prod_name['+count_total+']" class="form-control" value="'+product_name+'"></td>' +
                    '<td class="qnt-id"><input type="text" name="prod_qnt['+count_total+']" class="form-control" value="1"><input class="hidden-id" type="hidden" value="'+product_id+'" name="prod_id['+count_total+']"></td>' +
                    '<td class="price-td"><input type="text" name="prod_price['+count_total+']" class="form-control" value="0.00"></td>' +
                    '</tr>';

                //check all added products
                jQuery(".hidden-id").each(function(){
                    //if product with this id already added to table
                    if(jQuery(this).attr('value') == product_id)
                    {
                        //just increase quantity
                        var parent_td = jQuery(this).parent();
                        var old_qnt = jQuery(parent_td).find('input:first').val();
                        jQuery(parent_td).find("input:first").val(parseInt(old_qnt)+1);

                        //now we increased quantity
                        increased_qnt = true;
                    }
                });

                //$(this).attr('value', product_name);

                //if quantity wasn't increased
                if(!increased_qnt)
                {
                    //add html block to table
                    $(this).children(".table-prods").append(html_tr);
                    //increase count of added blocks
                    count_total ++;
                }
            }

            //if we drag client to client field
            if(sourceElement_id == 'client-table' && current_element_id == 'inputClient')
            {
                //add to field name of client
                $(this).val(client_name);
                //add client id to hidden field
                $(".cli-id").val(client_id);

            }
        }
    });


    //when clicked on 'make invoice'
    jQuery(".invoice-make").click(function(){

        //get supplier id, stock_id, array of product, invoice code, signer-name
        var supplier_id = jQuery(".cli-id").val();
        var stock_id = jQuery(".stock-id").val();
        var prod_blocks = jQuery(".prod-block");
        var invoice_code = jQuery("#invoice_code_input").val();
        var signer_name = jQuery("#signer_name_input").val();

        //get error message
        var _error_title = jQuery("#error_window_title").val();
        var _error_message = jQuery("#error_message").val();
        var _modal_window_title = jQuery("#modal_window_title").val();


        //if something gone wrong
        if(isNaN(supplier_id) || isNaN(stock_id) || prod_blocks.length == 0 || invoice_code == '' || signer_name == '')
        {
            //open modal window with error
            error(_error_title,_error_message);
        }
        //if all right
        else
        {
            //declare array of products
            var products_arr = [];

            //pass through all product-items
            prod_blocks.each(function(){

                //get <td> block with id and quantity fields
                var td_id_qnt = jQuery(this).find(".qnt-id");
                //get <td> block with price field
                var td_price = jQuery(this).find(".price-td");

                //get quantity input element
                var qnt_input = jQuery(td_id_qnt).find("input:first");
                //get id input element
                var id_input = jQuery(td_id_qnt).find(".hidden-id");
                //get price input element
                var price_input = jQuery(td_price).find("input:first");

                //get quantity if it's number, if not get zero
                var quantity = isNaN(qnt_input.val()) ? 0 : qnt_input.val();
                //get id of product
                var card_id = id_input.val();
                //get price if it's number, if not get zero
                var price_val = isNaN(price_input.val()) ? 0 : price_input.val();

                //add product info to array
                products_arr.push({id:card_id,qnt:quantity,price:price_val});
            });

            //create settings object
            var settings = {
                supplier: supplier_id,
                stock: stock_id,
                inv_code: invoice_code,
                signer: signer_name,
                products : products_arr
            };

            //convert to json
            var json_settings = JSON.stringify(settings);

            //ajax load data
            jQuery.ajax({ url: '/ajax/buyform/data/'+ json_settings,beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data)
            {
                modal(_modal_window_title,data);
            });

        }

        //stop click event
        return false;
    });

    //when clicked on 'view invoice' link
    jQuery(".modal-link-opener").click(function(){

        //get href
        var href = jQuery(this).attr('href');

        //load to modal window
        jQuery.ajax({ url: href,beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data)
        {
            modal('test',data);
        });

        //stop click event
        return false;

    });

});

/**
 * Shows modal window with error message
 * @param title
 * @param message
 */
var error = function(title,message)
{
    var dialog_div = jQuery(".dialog");
    dialog_div.dialog({

        title: title,
        resizable:false,
        modal:true,
        buttons:{
            'OK': function(){
                $(this).dialog( "close" );
            }
        },
        position: {
            my: "center",
            at: "center"
        }
    });

    dialog_div.html(message);
};

/**
 * Show modal window with some content
 * @param window_name
 * @param content
 */
var modal = function(window_name,content)
{
    var dialog_div = jQuery(".dialog");

    dialog_div.dialog({
        title: window_name,
        resizable:false,
        modal:true,

        minHeight: 300,
        minWidth: 400,

        position: {
            my: "center",
            at: "center"
        },
        buttons: {}
    });

    //add content to container
    dialog_div.html(content);

    //event for close button
    jQuery(".close-modal-w").click(function(){
        dialog_div.dialog("close");
    });
};

