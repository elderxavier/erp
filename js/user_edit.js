jQuery(document).ready(function(){

    jQuery('.reset-pass-button').click(function(){
        resetPass(jQuery(this).data().id);
    });

});

/***********************************************************************************************************************/


var showPreLoaderHideButton = function()
{
    jQuery('.button-reset-holder').addClass('hidden');
    jQuery('.pre-loader-holder').removeClass('hidden');

    jQuery('.success-message').addClass('hidden');
    jQuery('.send-err').addClass('hidden');
    jQuery('.create-err').addClass('hidden');
};

var showButtonHidePreLoader = function()
{
    jQuery('.button-reset-holder').removeClass('hidden');
    jQuery('.pre-loader-holder').addClass('hidden');
};

var resetPass = function(id){

    jQuery.ajax({ url: '/users/resetpassword/'+id, beforeSend: function(){
        showPreLoaderHideButton();
    }}).done(function(data)
    {
        var response = JSON.parse(data);

        if(response.code == 'OK')
        {
            showButtonHidePreLoader();
            jQuery('.success-message').removeClass('hidden');
        }
        if(response.code == 'SEND_ERROR')
        {
            showButtonHidePreLoader();
            jQuery('.send-err').removeClass('hidden');
            jQuery('.pass-new').html(response.password);
        }
        if(response.code == 'CREATE_ERROR')
        {
            showButtonHidePreLoader();
            jQuery('.create-err').removeClass('hidden');
        }
    });

};