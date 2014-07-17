/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    
    var sourceElement;
    var beingDragged;
    
    var data1 = document.getElementById("data1");
    var data2 = document.getElementById("data2");
    var data3 = document.getElementById("data3");
    
    /**
     * Event when picking object up.
     */
    $('tr').draggable({
        revert: true,
        helper: "clone",
        cursor: "move",
        scroll: true,
        handle: $('.glyphicon-hand-down').parent(),
        start: function (event, ui) {
            beingDragged=$(this);
            sourceElement = $(this).closest('table').attr('id');
            if(sourceElement.toString()==='client-table'){
                $('#inputProduct').attr('disabled', 'disabled');
            }
            else{
                $('#inputClient').attr('disabled', 'disabled');
            }
        },
        stop: function (event, ui) {
            $('.droppable').removeAttr('disabled');
        }
    });
    
    /**
     * Event when dropping object.
     */
    $(".droppable").droppable({
        drop: function (event, ui) {
            var what = $(ui.draggable).text();
            var from = sourceElement;
            var to = $(this).attr('id');
            var isDisabled = $(this).attr('disabled');
            beingDragged.appendTo(from);
            //alert(what +' was dragged from ' + from + ' to ' + to + '.');
            
            if(isDisabled!=='disabled'){
            $(this).attr('value', what);
            $(data1).attr('value', what);
            $(data2).attr('value','was dragged from ' + from);
            $(data3).attr('value', ' to ' + to);
            }
        }
    });
});

