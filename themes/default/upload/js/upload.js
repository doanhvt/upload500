
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
	$(document).on("click", "#btn-sbm", function (e) {
		e.preventDefault();
		var file_upload = $('#isfile').val();
		if (file_upload == "") {
			alert("File không được để trống.");
			return false;
		} else {
			$('#btn-sbm').attr('disabled', 'disabled');
			var obj = $('.e_form_submit');
			ajax_data(obj);
		}
	});

	$(document).on("click", "#close", function (e) {
		e.preventDefault();
		$('#Iswait').hide();
		$('#wait').hide();
	});

});


function ajax_data(obj) {
	$('#Iswait').show();
	$('#wait').show();
	var url = obj.attr("action");
	obj.ajaxSubmit({
		type: "POST",
		url: url,
		dataType: 'json',
		async: false,
		success: function (result) {
			if (result.error) {
				$('#myModal').modal({
					show: 'false',
				});
				var temp = "";
				var array = $.map(result.error, function (value, index) {
					temp += value;
				});
				$('.modal-body').html(temp);
			}
			var sucess = [];
			var error = [];
			$.each(result, function (idx, obj) {
				if (obj.status == true) {
					$.each(obj.msg, function (id, val) {
						$('#success_' + idx).html("<i class='ace-icon glyphicon glyphicon-ok'></i>");
						sucess.push(idx);
					});
					// $('#Iswait').hide();
					// $('#wait').hide();
					$('#myModal_1').modal({
						show: 'false',
					});
				} else {
					/*error upload*/
					$.each(obj.msg, function (id, val) {
						$('#error_' + idx).html("<i class='ace-icon glyphicon glyphicon-remove'></i>");
						error.push(idx);
					});
					// $('#Iswait').hide();
					// $('#wait').hide();
					$('#myModal_1').modal({
						show: 'false',
					});
				}
			});
			if(sucess.length != 0){
				var number_video_success = 'Số video upload thành công ' + sucess.length;
				$('#success_true').html(number_video_success);
			}
			if(error.length != 0){
				var number_video_error = 'Số video upload không thành công ' + error.length;
				$('#success_false').html(number_video_error);
			}
			
		}, error: function () {

		}, complete: function () {
			$('#btn-sbm').removeAttr('disabled');
		}
	});
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