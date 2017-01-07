var ajaxRequest;
$(document).ready(function () {
    $('#loginform').submit(function (e) {
        e.preventDefault();
        ajaxRequest = $.ajax({
            url:'./login',
            type: 'POST',
            data:$(this).serialize()
        });
        ajaxRequest.done(function (response, textStatus, errorThrown) {
            var responseData = $.parseJSON(response);
            if(responseData.status == 1){
                window.location = '/ivc/gallery';//todo: change url
            }
            else{
                $('#errmsg').html(responseData.errmsg);
            }
        })
    });
});