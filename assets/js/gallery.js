$('document').ready(function() {
    if (imgs)
    var src, currArt, maxID = imgs.length - 1;
    
    var overlay = $(".overlay");
    var arrowL = $('.arrow-left');
    var arrowR = $('.arrow-right');
    var arrows = document.getElementsByClassName('arrow');
    var descArea = $('#artdesc');
    overlay.hide();
    $(".galleryimg").click(function() {
        overlay.fadeIn("fast");
        currArt = $(this).attr('id');
        changeHighlight(currArt, descArea);
        console.log(currArt);
    });
    overlay.click(function(e) {
        if (e.target != arrows[0] && e.target != arrows[1]) {
            overlay.fadeOut("fast");
        }
        if (imgs[currArt]['isVideo'] == 1) {
            $('iframe')[0].src = "";
        }
    });
    arrowR.click(function() {
        if (currArt == maxID) {
            currArt = 0;
        } else {
            currArt++;
        }
        changeHighlight(currArt, descArea);
        console.log(currArt);
    });
    arrowL.click(function() {
        if (currArt == 0) {
            currArt = maxID;
        } else {
            currArt--;
        }
        changeHighlight(currArt, descArea);
        console.log(currArt);
    });
    overlay.on("swipeleft", function() {
        if (currArt == maxID) {
            currArt = 0;
        } else {
            currArt++;
        }
        changeHighlight(currArt, descArea);
        console.log(currArt);
    });
    overlay.on("swiperight", function() {
        if (currArt == 0) {
            currArt = maxID;
        } else {
            currArt--;
        }
        changeHighlight(currArt, descArea);
        console.log(currArt);
    });
});

function changeHighlight(id, txt) {
    $(".gallery-selected-img").fadeOut(200, function() {
        var w, h;
        $(this).empty();
        if (imgs[id].isVideo == 0) {
            $(this).append('<img src=' + imgs[id]['link'] + '>');
            $(".gallery-selected-img img").on('load', function() {
                var w = $(this).width();
                console.log('Setting paragraph width to: ' + (w));
                $("#artdesc").width((w - 40)); //because padding and margin
            });
        } else {
            w = $(window).width() * 0.7;
            h = Math.round(w * 0.5625);
            $(this).append('<iframe id="player" width="' + w + '" height="' + h + '" src="https://www.youtube.com/embed/' + imgs[id]['link'] + '?enablejsapi=1" frameborder="0" allowfullscreen></iframe>');
            txt.width(w);
        }
        txt.html(desc[id]);
    }).fadeIn(200);
}

function getImgData() {
    
}