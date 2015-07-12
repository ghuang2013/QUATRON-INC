$(document).ready(function(){
    
    $('.pager').hide();
    
    $in = $('#in');
    $up = $('#up');
    $userForm = $('#userForm');
    /*
        user sign-up/log-in form 
        switch bet. nav tabs
        using ajax method to load form content
    */
    $('.navform').load('inc/form.php?method=Login&class=navbar-form');
    
    $('#userForm').load('inc/form.php?method=Login');
    $in.on('click',function(){
        $up.removeClass('active');
        $in.addClass('active');
        $userForm.load('inc/form.php?method=Login');
    });
    
    $up.on('click',function(){
        $up.addClass('active');
        $in.removeClass('active');
        $userForm.load('inc/form.php?method=SignUp');
    });
    /*
        result hover effects
    */
    $('#result').on('mouseenter','.each_entry',function(){
        $(this).css("background-color","aliceblue");
    }).on('mouseleave','.each_entry',function(){
        $(this).css("background-color","white");
    });
});