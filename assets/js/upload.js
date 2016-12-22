var ajaxRequest;
$(document).ready(function () {
    var upload = $('#imgupload');
    upload.submit(function (e) {
        e.preventDefault();
        ajaxRequest = $.ajax({
            url:'includes/upload.php',
            type: 'POST',
            cache:false,
            contentType:false,
            processData:false,
            data:new FormData(this)
        });
        ajaxRequest.done(function (response, textStatus, errorThrown) {
            console.log(response);
            var responsedata = $.parseJSON(response);
            if(responsedata.status == 1){
                alert("upload completed");
                console.log(responsedata.file);
                var imglink = "assets/art/".concat(responsedata.file);
                $("#uploadedim").attr("src", imglink);
            }
            else{
                alert("fail");
                console.log(responseData.err);
            }
        });
        ajaxRequest.error(function () {
            alert('error');
        });
    });
    $('#imupload').change(function () {
        readURL(this);
    });
});
function readURL(input) {
    if (input.files && input.files[0]) {
        console.log("hay");
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#preview').attr('src', e.target.result);
            console.log(e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
