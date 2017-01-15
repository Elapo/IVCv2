var ajaxRequest;
$(document).ready(function () {
    var cnt = 0;
    var upload = $('#imgupload');
    var formPart = $('.uploadThis').clone();
    var body = $('body');
    var fileInput = $('.imupload');
    var videoInput = '<input type="text" class="videoLink">';

    upload.submit(function (e) {
        e.preventDefault();
        var imagesToUpload = $('.uploadFormPart');
        imagesToUpload.each(function() {
            var self = $(this);
            var fields = $(this).find('.inputField');
            if(!fields[0].files[0]) return;
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
            }).uploadProgress(function (e) {
                if(e.lengthComputable){
                    var perc = Math.round((e.loaded * 100) / e.total);
                    self.find('#myBar').css('width', perc+"%");
                }
            }).done(function (response, textStatus, errorThrown) {
                //console.log(response);
                var responsedata = $.parseJSON(response);
                if (responsedata.status == 1) {
                    console.log("upload done");
                    setTimeout(function () {
                       self.fadeOut("slow", function () {
                           self.remove();
                        });
                    }, 1000);
                }
                else {
                    self.appendChild('<div style="color: red;">Upload Failed: '+ responsedata.errmsg +'</div>');//fixme
                }
            });
        });
    });
    body.on('change', '.imupload',function () {
        var tar =$(this).parent().find('.preview');
        readURL(this, tar);
        tar.css('visibility', 'visible')
    });

    body.on('click', '.deleteUpload', function () {
        //todo: get element & remove
    });

    $('#addUpload').on('click', function (e) {
        e.preventDefault();
        formPart.removeClass('uploadThis').attr('id', 'formPart' + cnt++).appendTo('#multiform');
        $("html, body").animate({ scrollTop: $(document).height() }, "fast");
        formPart = formPart.clone();
    });
    body.on('click','.removeUpload', function () {
        $(this).parent().remove();
    });

    body.on('change', '.videoCB', function () {
        console.log("changing input");

        var upload = $(this).parent().parent().find('.imupload');
        console.log(upload);
        if(upload) upload.replaceWith(videoInput);
        else $(this).parent().parent().find('.videoLink').replaceWith(fileInput);
    });
});
function readURL(input, tar) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            tar.attr('src', e.target.result);
            //console.log(e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
