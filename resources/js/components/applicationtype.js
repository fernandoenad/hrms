$(document).ready(function(){
    let type = $(this).val();
    updateRemarks(type);

    $('#type').change(function(){
        let type = $(this).val();
        updateRemarks(type);
    });
});

function updateRemarks(type){
    if(type == 'New') {
        $('#remarks').attr('disabled', 'disabled');
        $('#remarks').val('Please upload the softcopy of your pertinent documents following '+
            'the relative memorandum guidelines. Good luck on your new application.');
    } else if(type == 'Retain') {
        $('#remarks').attr('disabled', 'disabled');
        $('#remarks').val('All your RQA scores from previous application will be retained. Please '+
            'upload the scanned copy of your letter of intent.');
    } else if(type == 'Update'){
        $('#remarks').removeAttr('disabled');
        $('#remarks').attr('placeholder', 'Indicate the criterion/criteria you wish to be updated '+
            '(e.g. Interview, etc) and please upload a scanned copy of your letter of intent. ');
        $('#remarks').attr('required', 'required');
        $('#remarks').val('');
    } else {
        $('#remarks').attr('disabled', 'disabled');
        $('#remarks').attr('placeholder', '');
        $('#remarks').val('');
    }
}
