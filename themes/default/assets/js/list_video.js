$(document).ready(function () {
    $("#advanced-search-box").hide();
    $('.input-daterange').datepicker({autoclose: true});
    $("#advanced-search").click(function () {
        $("#advanced-search-box").toggle('5000', 'linear');
    });

    $(document).on('click', '#normal-search-btn', function (e) {
        e.preventDefault();
        var url = $('#normal-search-form').attr('url');
        var search_value = $('input[name="normal-search-input"]').val();
        $.ajax({
            type: 'post',
            url: url,
            dataType: 'json',
            data: {
                search_value: search_value
            },
            success: function (data) {
                $('#table_id').html(data.table_body);
            }
        });
    })
})
