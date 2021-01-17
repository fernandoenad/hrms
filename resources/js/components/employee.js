$(document).ready(function(){
    let lastnosidate_mark = $('#lastnosidate_mark');
    let retirementdate_mark = $('#retirementdate_mark');

    setNOSIDate(lastnosidate_mark);
    setRetirementDate(retirementdate_mark);

    lastnosidate_mark.click(function(){
        setNOSIDate(lastnosidate_mark);
    });

    retirementdate_mark.click(function(){
        setRetirementDate(retirementdate_mark);
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

