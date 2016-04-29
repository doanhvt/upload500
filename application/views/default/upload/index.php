<style>
    input[type="text"] {
        padding: 0px 15px;
        height: 42px;
    }
    .btn {
        background: #810c15 !important;
        border-color: #810c15 !important;
        color: #FFF !important;
        font-weight: bold;
    }
    .btn:hover{
        background: #810c15 !important;
        border-color: #810c15 !important;
        color: #FFF !important;
        font-weight: bold;
    }
    span{
        padding-left: 1px;
    }

    input[type="text"]{
        background: #FFF !important;
        border: 1px solid #810c15;
    }
    input[disabled]:hover{
        background: #FFF !important;
        border-color: #810c15!important;
    }

    input::-webkit-input-placeholder {
        color:    #810c15 !important;
    }
    input:-moz-placeholder {
        color:    #810c15 !important;
    }
    input::-moz-placeholder {
        color:    #810c15 !important;
    }
    input:-ms-input-placeholder {
        color:    #810c15 !important;
    }

</style>

<div class="row" style="margin-top: 20px;">
    <div class="col-md-12">
        <div class="col-md-2" style="padding-right: 0px;">
            <p class="h5" style="background-color: #810c15;margin: 0px;color: #FFF;text-align: center;padding: 10px 0px;font-weight: bold;">Upload video <i class="fa fa-caret-down" aria-hidden="true"></i></p>
        </div>
        <div class="col-md-10" style="padding-left: 0px;">
            <p style="border-bottom: 1px solid #810c15;height: 35px;"></p>
        </div>  
    </div>
</div>
<form action="" method="POST">
    <div class="row" style="margin-top: 5%">
        <div class="col-md-12">
            <div class="col-md-offset-2 col-md-6">
                <input type="file" class="filestyle" name="video[]" data-placeholder="Select file ..." multiple>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-offset-2 col-md-6">
                <a href="" style="font-size: 17px;color: #810c15;" id="plus_add">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
</form>

<script>

    $(":file").filestyle({placeholder: "Select file ..."});
    
</script>

