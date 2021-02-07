$(document).ready(function(){
    $('#confirmdataprivacy').click(function(){
        if($(this).prop("checked") == true){
            $('#rms-reg-submit').removeAttr('disabled');
        } else {
            $('#rms-reg-submit').attr('disabled', 'disabled');
        }

    });
});

