$(document).ready(function () {
    $("#advanced-search-box").hide();
    $('.input-daterange').datepicker({
        format: "yyyy-mm-dd",
        showOtherMonths: true,
        selectOtherMonths: false,
        autoclose: true,
        todayHighlight: true,
    });
    $("#advanced-search").click(function () {
        $("#advanced-search-box").toggle('5000', 'linear');
    });
    $('.btn-view').click(function () {
        var link_video = $(this).attr('link_video');
        var type_video = $(this).attr('type_video');
        var video = document.getElementById('view-video');
        var sources = video.getElementsByTagName('source');
        sources[0].src = link_video;
        sources[0].type = type_video;
        video.load();
        video.play();
    });
    $('.btn-edit').click(function () {
        var id_video = $(this).attr('id_video');
        var note_video = $(this).attr('note_video');
        $('#note_video').val(note_video);
        $('#edit-confirm').attr('note_video', note_video);
        $('#edit-confirm').attr('id_video', id_video);
    });
    $('#edit-confirm').click(function () {
        var url = $(this).attr('url');
        var id_video = $(this).attr('id_video');
        var note_video = $('#note_video').val();
        $.ajax({
            type: 'post',
            url: url,
            dataType: 'json',
            data: {
                id_video: id_video,
                note_video: note_video
            },
            success: function (data) {
                alert(data.message);
                location.reload();
            }
        })
    });
    $('#myModal').on('hidden.bs.modal', function () {
        var v = document.getElementById('view-video');
        v.pause();
    });
//    $('#submit-search').click(function () {
//        var url = $('#advanced-search-form').attr('action');
//        var obj = $('#advanced-search-form').serialize();
//        $.ajax({
//            type: 'post',
//            url: url,
//            dataType: 'json',
//            data: obj,
//            success: function (data) {
//                alert('ok');
//            }
//        });
//    })
})
