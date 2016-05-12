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

    .btn-danger, .btn-danger:focus{
        background: #810c15 !important;
        border-color: #810c15 !important;
        color: #FFF !important;
        font-weight: bold;
    }


    .btn:focus, .btn-default:focus{
        background: #810c15 !important;
    }

    .form-group input[disabled], .form-group input:disabled{
        color: #810c15 !important;
    }

    #edit_name{
        height: 32px;
        margin-top: 4px;
    }
    #number{
        margin-top: 6px;
    }
    .td1{
        font-size: 14px;
        font-weight: bold;
    }

    #video{
        height: 30px;
        border: 1px solid #810c15;
        background: #FFF;
        margin-top: 10px;
        width: 100%;
        padding: 5px 7px;
        white-space: nowrap;
    }
    #email{
        margin-top: 16px;
        height: 30px;
        border: 1px solid #810c15;
        background: #FFF;
        margin-top: 10px;
        width: 100px;
        padding: 5px 7px;
        white-space: nowrap;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }
    .input_v{
        height: 35px !important;
        margin-top: 5px;
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
<form action="<?php echo $ajax_link; ?>" method="POST" enctype="multipart/form-data" role="form" class="e_form_submit">
    <div class="row" style="margin-top: 5%">
        <div class="col-md-12">

            <div id="url" data-url="<?php echo site_url('upload/check_data'); ?>"></div>
            <div class="form-group" style="margin: 0px;">
                <div class="col-md-offset-2 col-md-5" style="padding-right: 0px">
                    <input type="text" class="form-control" id="isname" placeholder="Select video to upload ..." disabled value="">
                    <input type="file" name="userfile[]" class="form-control hide" id="isfile" multiple accept="video/*"/>
                </div>
                <div class="col-md-2" style="padding-left: 0px;">
                    <span class="btn btn-default" id="choosfile"> <i class="fa fa-video-camera" aria-hidden="true"></i> Choose file</sapn>
                </div>
            </div>
            <div class="form-group"> 
                <div class="col-md-3">
                    <button type="submit" class="btn btn-default" id="btn-sbm">Upload</button>
                </div>
            </div>

        </div>
    </div>
    <div class="row" style="height: 80px;padding: 10px;">
        <div class="col-md-12">
            <p class="text-center" id="Iswait" style="display: none;font-weight: bold;">
                <label class="text-center">Vui lòng đợi</label> <br/>
                <img style="width: 6%;" src="<?php echo $this->path_theme_file; ?>upload/img/LoaderIcon.gif" alt="" title=""/>
            </p>
        </div>
    </div>
    <div class="row" style="margin-top: 0%;position: relative;">
        <div class="col-md-12" id="wait" style="position: absolute;z-index: 999;width: 98%;margin-left: 13px;height: 100%;background-color: rgba(192,192,195,0.5);top:38px;display: none;">
            <p class="text-center" style="padding-top: 52px;">
                <img src="<?php echo $this->path_theme_file; ?>upload/img/loading-spiral.gif" alt="" title=""/>
            </p>
        </div>

        <div class="col-md-12">
            <div class="table-header" style="background: #810c15;">
                Upload Infomation 
            </div>
            <div class="content">
                <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Thông tin video</th>
                            <th>Ngày học (*)</th>
                            <th>Giờ học</th>
                            <th>Loại lớp</th>
                            <th>Giáo viên</th>
                            <th>Trợ giảng</th>
                            <th>Người quay</th>
                            <th>Tình trạng video</th>
                            <th>Ghi chú chi tiết</th>
                            <th>Mã video</th>
                            <th>Username</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <div class="null">
                    <!--<p class="text-center h5" id="message">Dữ liệu trống ...</p>-->
                </div>
                <div class="result">

                </div>
            </div>
        </div>
    </div>
</form>

<div class="call_datepicker"></div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg hidden" data-toggle="modal" data-target="#myModal"></button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="font-size: 14px;
    color: #810c15;
    font-weight: bold;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #810c14;color: #FFF;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" id="close">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Error</h4>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="close">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg hidden" data-toggle="modal" data-target="#myModal_1"></button>

<!-- Modal -->
<div class="modal fade" id="myModal_1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="font-size: 14px;
    color: #810c15;
    font-weight: bold;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #810c14;color: #FFF;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #FFF;"><span aria-hidden="true" id="close">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Confirm</h4>
            </div>
            <div class="modal-body">
                <p id="success_true" style="font-size: 17px;"></p>
                <p id="success_false" style="font-size: 17px;"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="location.reload();">Close</button>
            </div>
        </div>
    </div>
</div>




<!--<script>

    $(":file").filestyle({placeholder: "Select file ..."});


</script>-->


<!--<form action="" method="POST" enctype="multipart/form-data">
    <div class="row" style="margin-top: 5%">
        <div class="col-md-12">
            <div class="col-md-offset-2 col-md-8" id="inputs">
                
                <input type="file" class="filestyle" id="fileupload" name="video[]" data-placeholder="Select file ..." multiple onChange="makeFileList();"> 
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger">Upload</button>
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
</form>-->
