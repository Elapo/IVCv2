var ajaxRequest
$(document).ready(function () {
    $('#loginform').submit(function (e) {
        e.preventDefault();
        ajaxRequest = $.ajax({
            url:'includes/loginuser.php',
            type: 'POST',
            data:$(this).serialize()
        });
        ajaxRequest.done(function (response, textStatus, errorThrown) {
            var responseData = $.parseJSON(response);
            if(responseData.status == 1){
                window.location = '/iris-vc/gallery.php';
            }
            else{
                $('#errmsg').html(responseData.errmsg);
            }
        })
    });
});