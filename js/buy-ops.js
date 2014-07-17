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
            $('.droppable').removeAttr('disabled');
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

            //if we dragged product
            if(sourceElement_id == 'product-table')
            {
                //get product properties from source element
                product_id = $(ui.draggable).attr('product_id');
                product_code = $(ui.draggable).children(".prod_code").text();
                product_name = $(ui.draggable).children(".prod_name").text();
            }
            //if we dragged client (or supplier)
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
                    '<tr>' +
                    '<td><input type="text" name="prod_name['+count_total+']" class="form-control" value="'+product_name+'"></td>' +
                    '<td><input type="text" name="prod_qnt['+count_total+']" class="form-control" value="1"><input class="hidden-id" type="hidden" value="'+product_id+'" name="prod_id['+count_total+']"></td>' +
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


});

