$(document).ready(function(){
    const registerModal = $('.load-register-modal');

    if(registerModal){
        $('#register-modal').modal({
            backdrop: 'static',
            keyboard: false,
            show : true,
        });
    }
});
