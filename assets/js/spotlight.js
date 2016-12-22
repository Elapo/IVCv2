$('document').ready(function() {
    var imgs = refreshArray();
    $(".spotlight-image").click(function() {
        /*$('.spotlight-selected').toggleClass("spotlight-selected");
        $(this).toggleClass("spotlight-selected");*/
        var tempimg = { left: "", right: "", center: "" };
        if ($(this).attr("id") == imgs.left.attr("id")) {
            tempimg.left = imgs.right.attr("src");
            tempimg.right = imgs.center.attr("src");
            tempimg.center = imgs.left.attr("src");
        } else if ($(this).attr("id") == imgs.right.attr("id")) {
            tempimg.left = imgs.center.attr("src");
            tempimg.right = imgs.left.attr("src");
            tempimg.center = imgs.right.attr("src");
        } else {
            //do nothing
        }

        if (tempimg.left != "") {
            imgs.left.attr("src", tempimg.left);
            imgs.center.attr("src", tempimg.center);
            imgs.right.attr("src", tempimg.right);
        }
    });
});

function refreshArray() {
    return { left: $("#spotlight-left"), center: $("#spotlight-center"), right: $("#spotlight-right") };
}