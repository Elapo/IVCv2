var ajaxRequest;
$(document).ready(function () {
    var cnt = 0;
    var upload = $('#imgupload');
    var formPart = $('.uploadThis').clone();
    upload.submit(function (e) {
        e.preventDefault();
        var imagesToUpload = $('.uploadFormPart');
        imagesToUpload.each(function() {
            var fields = $(this).find('.inputField');
            var data = new FormData();
            data.append('img', fields[0].files[0]);
            data.append('desc', fields[1].value);
            data.append('cat', fields[2].value);
            ajaxRequest = $.ajax({
                url: './upload',
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                data: data
            });
            ajaxRequest.done(function (response, textStatus, errorThrown) {
                //console.log(response);
                var responsedata = $.parseJSON(response);
                if (responsedata.status == 1) {
                    alert("upload completed");
                    //console.log(responsedata.file);
/*                    var imglink = "assets/art/".concat(responsedata.file);
                    $("#uploadedim").attr("src", imglink);*/
                }
                else {
                    alert("fail");
                    //console.log(responseData.err);
                }
            });
             /*ajaxRequest.error(function () {
                alert('error');
             });*/
        });
    });
    $('body').on('change', '.imupload',function () {
        var tar =$(this).parent().find('.preview');
        readURL(this, tar);
        tar.css('visibility', 'visible')
    });
    // $('#imupload').change(function () {
    //     readURL(this);
    // });

    $('#addUpload').on('click', function (e) {
        e.preventDefault();
        formPart.removeClass('uploadThis').attr('id', 'formPart' + cnt++).appendTo('#multiform');
        $("html, body").animate({ scrollTop: $(document).height() }, "fast");
        formPart = formPart.clone();
    });
});
function readURL(input, tar) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            console.log(tar);
            tar.attr('src', e.target.result);
            //console.log(e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
