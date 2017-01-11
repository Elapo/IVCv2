var baseURL = "http://localhost/ivc/"; //todo change
$('document').ready(function(){
    var yt=$('#ytlinkimg');
    var da=$('#dalinkimg');
    var inst=$('#instlinkimg');

    $('#ytlink').hover(function(){
        yt.fadeOut(0, function(){
            yt.attr("src", baseURL+"assets/img/youtubelogored.png").fadeIn(0);
        });
    }, function(){
        yt.fadeOut(0, function(){
            yt.attr("src", baseURL+"assets/img/youtubelogo.png").fadeIn(0);
        });
    });
    
    $('#dalink').hover(function(){
        da.fadeOut(0, function(){
            da.attr("src", baseURL+"assets/img/deviantartlogocolor.png").fadeIn(0);
        });
    }, function(){
        da.fadeOut(0, function(){
            da.attr("src", baseURL+"assets/img/deviantartlogo.png").fadeIn(0);
        });
    });

    $('#instlink').hover(function(){
        inst.fadeOut(0, function(){
            inst.attr("src", baseURL+"assets/img/instagramlogocolor.png").fadeIn(0);
        });
    }, function(){
        inst.fadeOut(0, function(){
            inst.attr("src", baseURL+"assets/img/instagramlogo.png").fadeIn(0);
        });
    });
});