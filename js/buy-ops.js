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

            var product_id = '';
            var client_id = '';
            var product_code = '';
            var product_name = '';
            var client_name = '';
            var current_element_id = $(this).attr('id');

            if(sourceElement_id == 'product-table')
            {
                product_id = $(ui.draggable).attr('product_id');
                product_code = $(ui.draggable).children(".prod_code").text();
                product_name = $(ui.draggable).children(".prod_name").text();
            }
            if(sourceElement_id == 'client-table')
            {
                client_id = $(ui.draggable).attr('client_id');
                client_name = $(ui.draggable).text();
            }

            if(sourceElement_id == 'product-table' && current_element_id == 'inputProduct')
            {
                var html_tr = '' +
                    '<tr>' +
                    '<td><input type="text" name="prod_name['+count_total+']" class="form-control" value="'+product_name+'"></td>' +
                    '<td><input type="text" name="prod_qnt['+count_total+']" class="form-control" value="1"><input type="hidden" value="'+product_id+'" name="prod_id['+count_total+']"></td>' +
                    '</tr>';

//                $(this).attr('value', product_name);
                $(this).children(".table-prods").append(html_tr);
                count_total ++;

            }
            if(sourceElement_id == 'client-table' && current_element_id == 'inputClient')
            {
                $(this).attr('value',client_name);
            }
        }
    });


});

