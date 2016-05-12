$(document).ready(function () {
    $("#advanced-search-box").hide();
    $('.input-daterange').datepicker({autoclose: true});
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
    $('#myModal').on('hidden.bs.modal', function () {
        var v = document.getElementById('view-video');
        v.pause();
    })
//    $(document).on('click', '#normal-search-btn', function (e) {
//        e.preventDefault();
//        var url = $('#normal-search-form').attr('url');
//        var search_value = $('input[name="normal-search-input"]').val();
//        $.ajax({
//            type: 'post',
//            url: url,
//            dataType: 'json',
//            data: {
//                search_value: search_value
//            },
//            success: function (data) {
//                $('#table_id').html(data.table_body);
//                $('#pagination').html(data.links);
//            }
//        });
//    })
})
