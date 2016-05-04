
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
        var obj = $(this);
        obj.ajaxSubmit({
            type: "POST",
            dataType: 'json',
            async: false,
            success: function (result) {

            }, error: function () {

            }, complete: function () {

            }
        });
    });

    /* Xử lý code video */
//    $('.date').on('change', function () {
//        var a = $(this).attr('value', $('.date').val());
//        alert(a);
//    });
//    $("#datepicker-' . $i . '").blur(function () {
//        var val = $(this).val();
//        $("#code' . $i . '").text(val);
//    });
    
});

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



