$(document).ready(function(){
    $('#apply-submit').click(function (){
        $('#progress-modal').modal({
            backdrop: 'static',
            keyboard: false,
            show : true,
        });
    });

    const applyModal = $('.load-apply-modal');
    if(applyModal){
        $('#apply-modal').modal({
            backdrop: 'static',
            keyboard: false,
            show : true,
        });
    }

});
