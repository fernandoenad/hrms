$(document).ready(function(){
    $('#type').change(function(){
        let type = $(this).val();
        
        if(type == 'New' || type == 'Retain')
            $('#remarks').attr('disabled', 'disabled');
        else
            $('#remarks').removeAttr('disabled');
    });
});

