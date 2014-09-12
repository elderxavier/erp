$(document).ready(function(e) {


    $(document).on('click','.add-prod', function(){
		var objSender = $(this).data();		
		addSender(objSender);
		return false;
	});//click  add-product
	
	$('#emails-to-holder').on('click','.remove-mail',function(){
		var objSender = $(this).data();		
		delSender(objSender);
		return false;
	});//click  add-product
	
	$(document).on('click','.filter-btn', function(){
        var name = $('#cli-name').val();
        var code = $('#cli-code').val();
        filterTable(name,code);
    });// click at the filter button

    /**
     * Auto-complete for client-names
     */
    jQuery('#cli-name').autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "/products/autocompleteforfiltration",
                dataType: "json",
                data: {
                    name: request.term

                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        minLength: 1
    });

    /**
     * Auto-complete for client-codes
     */
    jQuery('#cli-code').autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "/products/autocompleteforfiltration",
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


});//document ready


function addSender(objSender){

    var empty_list_notice = $('#empty-list');

	if(empty_list_notice.length > 0){
		empty_list_notice.remove();
	}
	
	if($('#cust_' + objSender.id).length > 0){
		return false;
	}

	var elem = '<li class="mail-info" id="cust_' + objSender.id +'">';
	elem += '<a title="user@mail.re" href="mailt:'+objSender.mail+'">'+objSender.name+'</a>';
	elem += '<a href="#"  class="remove-mail" data-id="'+ objSender.id +'"><span class="glyphicon glyphicon-remove-circle"></span></a></li>';
	console.log(elem);
	$('#emails-to-holder').append(elem);
    return true;
	
}//addSender


function delSender(objSender){
	$('#cust_' + objSender.id).remove();
	
	if($('.mail-info').length < 1){
		$('#emails-to-holder').append('<li id="empty-list">Put here user emails</li>');
	}
}

function filterTable(name,code)
{
    var url = '/products/renderfilteredpartforletters';
    $(".filtered-body").load(url,{name:name,code:code});
}