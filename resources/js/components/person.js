$(document).ready(function(){
    $('#firstname').keyup(function(){
        updateUsername();
    });

    $('#lastname').keyup(function(){
        updateUsername();
    });

});

function updateUsername(){
    let username = $('#username');
    let firstname = $('#firstname');
    let lastname = $('#lastname');
    let newuname = firstname.val()+'.'+lastname.val();
    
    newuname = newuname.replace(/\s+/g,'');

    username.val(newuname.toLowerCase());
}
