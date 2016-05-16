
$(document).ready(function () {
    $('.null').html('<p class="text-center h5" id="message">Dữ liệu trống ...</p>');
    $(document).on("click", "#choosfile", function (e) {
        e.preventDefault();
        $("#isfile").click();
    });
    $('#isfile').change(function () {
        var elem = document.getElementById("isfile");
        var count_file = elem.files.length;
        if (count_file && count_file != 0) {
            var value = 'You already selected ' + count_file + ' video';
            $('.null').html('');
            $('#isname').attr('value', value);
            $('#info_video tr').remove();
        }

//        var info_file = [];
//        for (var i = 0; i < elem.files.length; ++i) {
//            info_file.push({name: elem.files[i].name, size: elem.files[i].size, type: elem.files[i].type});
//        }
        get_select_time(count_file);
    });

    /* ajax xử lý upload */
    $(document).on("submit", ".e_form_submit", function (e) {
        e.preventDefault();
        var file_upload = $('#isfile').val();
        if (file_upload == "") {
            alert("File không được để trống.");
            return false;
        } else {
            $('#btn-sbm').attr('disabled', 'disabled');
            var id_media = $('#id_video').attr('id_video');
            upload(id_media);
            return;
        }
    });

});


function upload(i) {
    var obj = $('.e_form_submit');

    var bar = $('.bar');
    var percent = $('.percent');
    var status = $('#status');

    var date = obj.find('#datepicker-' + i).val();
    var time = obj.find('.time_type_' + i).val();
    var cls = obj.find('.class_type_' + i).val();
    if (date.trim() == "") {
        var id = i + 1;
        alert("Mời bạn chọn ngày học của video " + id);
        obj.find('#datepicker-' + i).focus();
        var i = i;
        $('#btn-sbm').removeAttr('disabled');
        return (false);
    }
    if (time.trim() == 0) {
        var id = i + 1;
        alert("Mời bạn chọn giờ học của video " + id);
        obj.find('.time_type_' + i).focus();
        $('#btn-sbm').removeAttr('disabled');
        return (false);
    }

    if (cls.trim() == 0) {
        var id = i + 1;
        alert("Mời bạn chọn loại lớp của video " + id);
        obj.find('.class_type_' + i).focus();
        var i = i;
        $('#btn-sbm').removeAttr('disabled');
        return (false);
    }

    var fileInput = document.getElementById("isfile");
    var length = (fileInput.files.length) - 1;
    var url_2 = $('.e_form_submit').attr('action');
    var form = $('.e_form_submit').serialize();
    data = new FormData();
    data.append('userfile', $('#isfile')[0].files[i]);
    data.append('form', form);
    data.append('id', i);
    $('#Iswait').show();
    $.ajax({
        method: "POST",
        url: url_2,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        beforeSubmit: function () {
            status.empty();
            var percentVal = '0%';
            bar.width(percentVal);
            percent.html(percentVal);
        },
        success: function (res) {
            var sucess = [];
            var error = [];
            if (res.status == true) {
                var id_return = res.id + 1;
                $('#id_video').attr('id_video', id_return);
                $('#success_' + i).html("<i class='ace-icon glyphicon glyphicon-ok'></i>");
                sucess.push(i);
            } else {
                var id_return_er = res.id;
                $('#id_video').attr('id_video', id_return_er);
                $('#error_' + i).html("<i class='ace-icon glyphicon glyphicon-remove'></i>");
                error.push(i);
            }

//            if (sucess.length !== 0) {
//                $('#myModal').modal({
//                    show: 'false',
//                });
//                var number_video_success = 'Số video upload thành công ' + sucess.length;
//                $('#success_true').html(number_video_success);
//                return;
//            }
//            if (error.length !== 0) {
//                $('#myModal').modal({
//                    show: 'false',
//                });
//                var number_video_error = 'Số video upload không thành công ' + error.length;
//                $('#success_false').html(number_video_error);
//                return;
//            }
        }, error: function () {

        }, complete: function () {
            $('#btn-sbm').removeAttr('disabled');
        },
        progress: function (e) {
            if (e.lengthComputable) {
                var percentVal = Math.floor((e.loaded / e.total) * 100) + '%';
                bar.width(percentVal);
                percent.html(percentVal);
            }
        },
    }).done(function () {
        if (i < length) {
            i++;
            upload(i);
        }
    });

//    for (var i = 0, len = fileInput.files.length; i < len; i++) {
//        alert(fileInput.files[i].name);
//    }

}

function get_select_time(count_file) {
    var url = $('#url').attr('data-url');
    var data = {
        'number': count_file
    };
    var success = function (result) {
        if (result.status == true) {
            $('tbody').html(result.data);
            $('.call_datepicker').html(result.js);
        }
    };
    var dataType = 'json';
    $.post(url, data, success, dataType);
}



