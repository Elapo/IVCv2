var ajaxRequest;
$(document).ready(function(){
    $('#contactme').submit(function(e){
        e.preventDefault();
        ajaxRequest = $.ajax({
            url:'includes/mail.php',
            type: 'POST',
            data:$(this).serialize()
        });
        ajaxRequest.done(function (response, textStatus, errorThrown) {
            var responsedata = $.parseJSON(response);
            if(responsedata.status == 1){
                $('.response').html("Thank you for contacting me! Your email has been sent successfully");
            }
            else{
                alert("error while sending email");
                console.log(response);
            }
        })
    });
});