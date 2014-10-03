jQuery(document).ready(function(){

    setInterval(function(){
        jQuery(".active_task").load('/services/ajax/ajaxtaskchecker');
    },5000)

});