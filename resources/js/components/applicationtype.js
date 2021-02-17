$(document).ready(function(){
    $('#type').change(function(){
        let type = $(this).val();
        
        if(type == 'New') {
            $('#remarks').attr('disabled', 'disabled');
            $('#remarks').val('Good luck on your new application.');
        } else if(type == 'Retain') {
            $('#remarks').attr('disabled', 'disabled');
            $('#remarks').val('All your RQA scores from previous application will be retained.');
        } else {
            $('#remarks').removeAttr('disabled');
            $('#remarks').val('');
        }
    });
});

