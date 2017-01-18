var ajaxRequest;
$(document).ready(function () {
    var cnt = 0;
    var upload = $('#imgupload');
    var formPart = $('.uploadThis').clone();
    var body = $('body');
    var fileInput = $('.imupload');
    var videoInput = '<label class="videoLink">Video Link: <input type="text" class="inputField"></label>';

    upload.submit(function (e) {
        e.preventDefault();
        var imagesToUpload = $('.uploadFormPart');
        imagesToUpload.each(function() {
            //todo: check for videocb and change Formdata accordingly
            var self = $(this);
            var checkbox = self.find('.videoCB');
            if(checkbox.is(":checked")){
                uploadVideo(self);
            }
            else uploadImage(self);


        });
    });
    body.on('change', '.imupload',function () {
        var tar =$(this).parent().find('.preview');
        readURL(this, tar);
        tar.css('visibility', 'visible')
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
        console.log(fileInput);

        var upload = $(this).parent().parent().find('.imupload');
        if(upload.length > 0) upload.replaceWith(videoInput);
        else $(this).parent().parent().find('.videoLink').replaceWith(fileInput);
    });
});

function uploadImage(self) {
    console.log("upload image");
    var fields = self.find('.inputField');
    if(!fields[0].files[0]) return; //check if file exists

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
}

function uploadVideo(self) {
    console.log("upload video");
    var fields = self.find('.inputField');

    var data = new FormData();
    data.append('link', fields[0].value);
    data.append('desc', fields[1].value);
    data.append('cat', fields[2].value);

    ajaxRequest = $.ajax({
        url: './uploadvideo',
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
}

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
