$(document).ready(function(e) {


    $(document).on('click','.add-prod', function(){
		var objSender = $(this).data();		
		addSender(objSender);
		return false;
	});//click on add-sender button
	
	$('#emails-to-holder').on('click','.remove-mail',function(){
		var objSender = $(this).data();		
		delSender(objSender);
		return false;
	});//click on delete-sender button
	
	$(document).on('click','.filter-btn', function(){
        var name = $('#cli-name').val();
        var code = $('#cli-code').val();
        filterTable(name,code);
    });// click at the filter button

    $('.add-option').click(function(){
        var objTemplate = $(this).data();
        addTemplate(objTemplate);
        return false;
    });// click at the add-template button

    $('.btn-submit').click(function(){
        var data = createDataForPost();
        createLetterAndLoad(data);
    }); //click on create letter

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
    });//auto-complete

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
    });//auto-complete


});//document ready


/**
 * Adds sender to
 * @param objSender
 * @returns {boolean}
 */
function addSender(objSender){

    $('#empty-list').css({'display':'none'});

	if($('#cust_' + objSender.id).length > 0){
		return false;
	}

	var elem = '' +
        '<li data-id="'+objSender.id+'" class="mail-info" id="cust_' + objSender.id +'">' +
        '<a title="user@mail.re" href="mailto:'+objSender.mail+'">'+objSender.name+'</a>' +
        '<a href="#"  class="remove-mail" data-id="'+ objSender.id +'"><span class="glyphicon glyphicon-remove-circle"></span></a></li>';
	console.log(elem);
	$('#emails-to-holder').append(elem);
    return true;
	
}//addSender

/**
 * Adds text of template
 * @param objTemplate
 */
function addTemplate(objTemplate)
{
    var text = '';
    var id = objTemplate.id;
    var _url = '/products/LoadTemplate/'+id;
    jQuery.ajax({ url: _url, beforeSend: function(){/*TODO: pre-loader*/}}).done(function(data)
    {
        jQuery(".template-text-area").val(data);
    });
}

/**
 * Deletes sender from list
 * @param objSender
 */
function delSender(objSender){
	$('#cust_' + objSender.id).remove();
	
	if($('.mail-info').length < 1){
        $('#empty-list').css({'display':'block'});
	}
}
/**
 * Does table filtration by name and code
 * @param name
 * @param code
 */
function filterTable(name,code)
{
    var url = '/products/renderfilteredpartforletters';
    $(".filtered-body").load(url,{name:name,code:code});
}

/**
 * Returns array of data to send POST request
 * @returns {{recipients: Array, files: Array, product_id: string, text: string}}
 */
function createDataForPost()
{
    var data = {recipients:[],files:[],product_id:'',text:''};

    jQuery('.mail-info').each(function(i,obj){
        data.recipients.push($(obj).data().id);
    });

    jQuery('.files:checked').each(function(i,obj){
            data.files.push($(obj).data().id);
    });

    data.product_id = jQuery('#prod-hidden-id').val();
    data.text = jQuery('.template-text-area').val();

    return data;
}

function createLetterAndLoad(data)
{
    var url = '/products/createletter';
    $(".modal-body").load(url,data);
}
