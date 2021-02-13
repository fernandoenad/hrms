$(document).ready(function(){
    let lastnosidate_mark = $('#lastnosidate_mark');
    let retirementdate_mark = $('#retirementdate_mark');
    let confirmationdate_mark = $('#confirmationdate_mark');

    setNOSIDate(lastnosidate_mark);
    setRetirementDate(retirementdate_mark);
    setCSCConfirmationDate(retirementdate_mark);

    lastnosidate_mark.click(function(){
        setNOSIDate(lastnosidate_mark);
    });

    retirementdate_mark.click(function(){
        setRetirementDate(retirementdate_mark);
    });

    confirmationdate_mark.click(function(){
        setCSCConfirmationDate(confirmationdate_mark);
    });
});

function setNOSIDate(lastnosidate_mark){
    let lastnosidate = $('#lastnosidate');

    if(lastnosidate_mark.prop('checked') == true){
        lastnosidate.attr('readonly', 'readonly');
    } else{
        lastnosidate.removeAttr('readonly');
    }
}

function setRetirementDate(retirementdate_mark){
    let retirementdate = $('#retirementdate');

    if(retirementdate_mark.prop('checked') == true){
        retirementdate.attr('readonly', 'readonly');
    } else{
        retirementdate.removeAttr('readonly');
    }
}

function setCSCConfirmationDate(confirmationdate_mark){
    let confirmationdate = $('#confirmationdate');

    if(confirmationdate_mark.prop('checked') == true){
        confirmationdate.attr('readonly', 'readonly');
    } else{
        confirmationdate.removeAttr('readonly');
    }
}

