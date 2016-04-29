$(document).ready(function () {
    $('.input-daterange').datepicker({autoclose:true});

    $("#advanced-search").click(function () {
        $("#advanced-search-box").toggle('5000','linear');
    });
})
