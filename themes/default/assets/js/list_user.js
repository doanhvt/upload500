$(document).ready(function () {
    $(".edit_info").click(function () {
        var url = $(this).attr("url");
        $.ajax({
            type: 'post',
            url: url,
            dataType: 'json',
            data: null,
            success: function (data) {
                $('.modal-body-edit').html(data.modal_body);
           }
       })
    });
    $(".delete_info").click(function () {
        if (confirm("Are you sure you want to delete this?")) {
            var url = $(this).attr("url");
            $.ajax({
                type: 'post',
                url: url,
                dataType: 'json',
                data: null,
                success: function (data) {
                    if (data.status == 1) {
                        alert(data.mesage)
                        location.reload();
                    }else{
                        alert(data.message)
                        location.reload();
                    }
                }
            })
        }
        else {
            return false;
        }
    });
    $("#confirm-edit").click(function () {
        var url = $('#edit_form').attr('action');
        var obj = $('#edit_form').serialize();
        $.ajax({
            type: 'post',
            url: url,
            dataType: 'json',
            data: obj,
            success: function (data) {
                if (data.status == 1) {
                    alert(data.message)
                    location.reload();
                }else{
                    alert(data.message);
                    location.reload();
                }
            }
        })
    })
    $("#confirm-add").click(function () {
        var url = $('#add-form').attr('action');
        var obj = $('#add-form').serialize();
        $.ajax({
            type: 'post',
            url: url,
            dataType: 'json',
            data: obj,
            success: function (data) {
                if (data.status == 1) {
                    alert(data.message);
                    location.reload();
                }else if(data.status == 2){
                    alert(data.message);
                }
                else {
                    alert(data.message);
                    location.reload();
                }
            }
        })
    });
})
