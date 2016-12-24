var ajaxRequest;
$(document).ready(function(){
    $('#contactme').submit(function(e){
        e.preventDefault();
        ajaxRequest = $.ajax({
            url:'./contact',
            type: 'POST',
            data:$(this).serialize()
        });
        ajaxRequest.done(function (response, textStatus, errorThrown) {
            var responsedata = $.parseJSON(response);
            if(responsedata.status == 1){
                $('.emailsuccess').html("Thank you for contacting me! Your email has been sent successfully.");
                $('.emailsuccess').removeClass("hidden");
                $("button").prop('disabled', true);
                //todo:empty form, reset captcha
            }
            else{
                alert("error while sending email");
                console.log(response);
            }
        })
    });
});