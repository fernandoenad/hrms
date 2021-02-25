$(document).ready(function(){
    let lastnosidate_mark = $('#lastnosidate_mark');
    let retirementdate_mark = $('#retirementdate_mark');
    let confirmationdate_mark = $('#confirmationdate_mark');
    let empno_mark = $('#empno_mark');

    setNOSIDate(lastnosidate_mark);
    setRetirementDate(retirementdate_mark);
    setCSCConfirmationDate(confirmationdate_mark);
    setEmpNo(empno_mark);

    lastnosidate_mark.click(function(){
        setNOSIDate(lastnosidate_mark);
    });

    retirementdate_mark.click(function(){
        setRetirementDate(retirementdate_mark);
    });

    confirmationdate_mark.click(function(){
        setCSCConfirmationDate(confirmationdate_mark);
    });

    empno_mark.click(function(){
        setEmpNo(empno_mark);
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

function setEmpNo(empno_mark){
    let oust_empno = $('#oust-empno');
    var n = new Date();
    var n_str = n.getTime();
    var str = n_str.toString();
    var str = str.substr(6,7);

    if(empno_mark.prop('checked') == true){
        oust_empno.val('T-' + str);
        oust_empno.attr('readonly', 'readonly');
    } else{
        oust_empno.removeAttr('readonly');
    }
}


