jQuery(document).ready(function(){

    setInterval(function(){
        jQuery(".active_task").load('/services/ajaxtaskchecker');
    },5000)

});