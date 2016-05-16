
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
        appendTr(count_file);
        
        var info_file = [];
        for (var i = 0; i < elem.files.length; ++i) {
            info_file.push({name: elem.files[i].name, size: elem.files[i].size, type: elem.files[i].type});
//            size.push(elem.files[i].size);
//            type.push(elem.files[i].type);
        }
        get_select_time(count_file);
    });
});


function appendTr(count_file) {
    var j = 1;
    for (var i = 0; i < count_file; ++i) {
        $('#info_video').append(
                "<tr>" +
                "<td class='text-center td1'>" + "video " + j + "</td>" +
                "<td></td>" +
                "<td id='time'>" + +"</td>" +
                "<td></td>" +
                "<td></td>" +
                "<td></td>" +
                "<td></td>" +
                "<td></td>" +
                "<td></td>" +
                "<td></td>" +
                "<td></td>" +
                "<td></td>" +
                "</tr>"
                );
        j++;
    }


}

//function loop_time(count_file){
//    var time = [];
//    var temp = get_select_time();
//    alert(temp);
//    for (var i = 0; i < count_file; ++i) {
//        time.push({'time' : get_select_time()});
//    }
//    return time;
//}

//        var time = [];
//        for (var i = 0; i < count_file; ++i) {
//            time.push({'time': select});
//        }
//        console.log(time);

function get_select_time(count_file) {
    var url = $('#url').attr('data-url');
    var data = {};
    var success = function (result) {
        var select = '<select name="number" id="number">';
        select += '<option selected="selected">---</option>';
        $.each(result.data, function (key, value) {
            select += "<option value='" + value.time + "'>" + value.time + "</option>";
        });
        select += '</select>';
        for (var i = 0; i < count_file; ++i) {
            $('#time').html(select);
        }
    };
    var dataType = 'json';
    $.post(url, data, success, dataType);
}


function makeFileList() {
    var select = 'a';
    return select;
//    var elem = document.getElementById("isfile");
//    var names = [];
//    for (var i = 0; i < elem.files.length; ++i) {
//        names.push(elem.files[i].name);
//    }
//
//    console.log(names);
//    alert(names);
}

//multiple file upload with progress bar using jquery

//http://weblogs.asp.net/psheriff/manipulating-html-tables-%E2%80%93-part-1-adding-rows



//        var url = $('#url').attr('data-url');
//        var data = {
//            formData: formData
//        };
//        var success = function (result) {
////            $('#result').html(result);
//            alert(result);
//        };

//        var dataType = 'json';
//        
//        $.post(url, data, success, dataType);

//        $.post({
//           type : 'POST', 
//           url  : url,
//           data : formData,
//           dataType : 'json',
//           success :  function(data){
//               alert(data);
//           }
//        });
//        console.log(info_file);

//    var formData = new FormData($(".e_form_submit")[i]);
//    var formData = new FormData(fileInput.files[i]);
//    var formData = fileInput.files[i];
//    var data = new FormData($('input[name^="userfile"]'));
//        
//    
//    jQuery.each($('input[name^="userfile"]')[0].files, function (i, file) {
//        data.append(i, file);
//    });
//var fileInput = document.getElementById("isfile");
//var form = $('.e_form_submit').serialize();

//+ '?' + form


//    $(document).on("submit", ".e_form_submit", function (e) {
//        e.preventDefault();
//        var obj = $(this);
//        $('#Iswait').show();
//        $('#wait').show();
//        obj.ajaxSubmit({
//            type: "POST",
//            dataType: 'json',
//            async: false,
//            success: function (result) {
//                if (result) {
////                    $('#Iswait').hide();
////                    $('#wait').hide();
//                }
//            }, error: function () {
//
//            }, complete: function () {
//
//            }
//        });
//    });

/* Xử lý code video */
//    $('.date').on('change', function () {
//        var a = $(this).attr('value', $('.date').val());
//        alert(a);
//    });
//    $("#datepicker-' . $i . '").blur(function () {
//        var val = $(this).val();
//        $("#code' . $i . '").text(val);
//    });

//http://stackoverflow.com/questions/7023457/get-input-type-file-value-when-it-has-multiple-files-selected
//https://www.raymondcamden.com/2013/09/10/Adding-a-file-display-list-to-a-multifile-upload-HTML-control/
//https://developer.mozilla.org/en-US/docs/Web/API/HTMLInputElement/multiple
//http://stackoverflow.com/questions/3654179/retrieving-file-names-out-of-a-multi-file-upload-control-with-javascript
//http://stackoverflow.com/questions/19295746/how-to-upload-multiple-files-using-php-jquery-and-ajax
//http://malsup.github.io/demo/progress.html
//HTML5 multiple file upload: upload one by one through AJAX
//http://stackoverflow.com/questions/13656066/html5-multiple-file-upload-upload-one-by-one-through-ajax
//http://zinoui.com/blog/ajax-file-upload
//https://www.new-bamboo.co.uk/blog/2012/01/10/ridiculously-simple-ajax-uploads-with-formdata/
//http://stackoverflow.com/questions/21044798/how-to-use-formdata-for-ajax-file-upload
//http://stackoverflow.com/questions/13656066/html5-multiple-file-upload-upload-one-by-one-through-ajax
//http://stackoverflow.com/questions/11208488/how-to-add-an-array-value-to-new-formdata