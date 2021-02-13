$(document).ready(function(){   
    let status =  $('#application-status').val();
    updateremarks(status);

    $('#application-status').change(function(){
        let status =  $('#application-status').val();
        updateremarks(status);
    });
});

function updateremarks(status){
    if(status == 2){
        $('#application-remarks').val('Pending...');
        $('#application-remarks').removeAttr('readonly');
    } else if(status == 3) {
        $('#application-remarks').val('Application confirmed, congratulations!');
        $('#application-remarks').attr('readonly', 'readonly');
    } else if(status == 4) {
        $('#application-remarks').val('');
        $('#application-remarks').attr('placeholder', 'Indicate reason for declination.');
        $('#application-remarks').attr('required', 'required');
        $('#application-remarks').removeAttr('readonly');
    }
}

