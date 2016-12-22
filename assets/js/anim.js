$(function(){
    $("body").hide();
    $("body").fadeIn(500);
})
$('.present').click(function(){
   $('.top').addClass("transform-active-top");
    setTimeout(function(){
        $('body').fadeOut(500, function(){
            window.location = "cake.html";
        });
    }, 1500);
});
$('.enterButton').click(function(){
   $('body').fadeOut(500, function(){
       window.location = "anim.html";
   });
});
$('.cake').click(function(){
    $('body').fadeOut(500, function(){
        window.location ="index.php";
    });
});