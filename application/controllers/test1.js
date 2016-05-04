
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