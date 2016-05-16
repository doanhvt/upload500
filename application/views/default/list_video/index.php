<div class="row">
    <div class="col-xs-12"> 
        <div>
            <form id="normal-search-form" method="get" action="<?php echo base_url('list_video/normal_search'); ?>" class="navbar-form navbar-right" >
                <div class="input-group">
                    <input name="q"  placeholder="Search by teacher's name, assitant's name, email" class="form-control" style="width:400px;border-radius:4px 0px 0px 4px !important;"/>
                    <div class="input-group-btn">
                        <button id="normal-search-btn" class="btn btn-info" style="border:1px solid #F5F5F5;border-radius:0px 4px 4px 0px !important;background-color: #810c15 !important;">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="clearfix">
        </div>
        <h3 class="header smaller lighter blue"><a id='advanced-search' style="background-color: #810c15;padding:3px;text-decoration: none;color:white;">Advanced search &nbsp;&nbsp;&nbsp;<b class="arrow fa fa-angle-down">&nbsp;</b></a></h3>
        <div class="clearfix">
            <div class="pull-right tableTools-container"></div>
        </div>
        <div id='advanced-search-box'>
            <form method="get" id="advanced-search-form" action="<?php echo site_url('list_video/advanced_search'); ?>">
                <div style="width: 20%;float: left;margin-right:20px;">
                    <div class="form-group">
                        <label for="class"><b>Loại lớp</b></label>
                        <select name="class-id" class="form-control" id="class">
                            <?php
                            foreach ($list_class as $class_item) {
                                ?>
                                <option value="<?php echo $class_item->id; ?>"><?php echo $class_item->name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="teacher"><b>Giáo viên</b></label>
                        <input name="teacher" type="text" class="form-control" id="teacher">
                    </div>
                    <div class="form-group">
                        <label for="asistant"><b>Trợ giảng</b></label>
                        <input name="asistant" type="text" class="form-control" id="asistant">
                    </div>
                </div>
                <div class="input-daterange" style="width: 20%;float: left;margin-right:20px;">
                    <div class="form-group">
                        <label for="start"><b>Từ ngày</b></label>
                        <input name="start-date" type="text" class="form-control" id="i_from_date">
                    </div>
                    <div class="form-group">
                        <label for="end"><b>Đến ngày</b></label>
                        <input name="end-date" type="text" class="form-control" id="end">
                    </div>
                    <div class="form-group">
                        <label for="hour"><b>Giờ học</b></label>
                        <select name="hour" type="text" class="form-control" >
                            <?php
                            foreach ($list_time as $time_item) {
                                ?>
                                <option value='<?php echo $time_item->id; ?>'><?php echo $time_item->start . " - " . $time_item->end; ?></option>
                                <?php
                            }
                            ?>

                        </select>
                    </div>
                </div>
                <div style="width: 10%;float: left;">
                    <div class="form-group">
                        <button type="submit" class=" form-control" style="margin-top:26px;background-color: #810c15;color:white;"  id="submit-search">FILTER</button>
                    </div>
                </div>
            </form>

        </div>
        <div class="clearfix">
        </div>
        <div class="table-header" style="background-color: #810c15;">
            Results
        </div>
        <!-- Trigger the modal with a button -->
        <script>
            videojs.options.silverlight.xap = "video-js.xap";
        </script>
        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-center">Video</h4>
                    </div>
                    <div class="modal-body">
                    <video id="video" width="100%" class="video-js vjs-default-skin" controls data-setup='{ "techOrder": ["silverlight"] }'>
                            <source src="" type="video/x-ms-wmv">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
            <!-- edit modal-->
            <div id="editModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title text-center"><b>Edit video info</b></h4>
                        </div>
                        <div class="modal-body">
                            <label><b>Ghi chú chi tiết: </b></label><br>
                            <textarea id="note_video" style="width:100%;">                           
                            </textarea>
                        </div>
                        <div class="modal-footer">
                            <button note_video="" id_video="" url="<?php echo site_url('list_video/edit_video/'); ?>" id="edit-confirm" type="button" class="btn btn-default">Confirm</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- div.table-responsive -->

            <!-- div.dataTables_borderWrap -->
            <div>
                <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Thời điểm video được upload</th>
                            <th>Ngày học</th>
                            <th>Giờ học</th>
                            <th>Loại lớp</th>
                            <th>Tên giáo viên</th>
                            <th>Trợ giảng</th>
                            <th>Người quay</th>
                            <th>Tình trạng video</th>
                            <th>Ghi chú chi tiết</th>
                            <th>Mã video</th>
                            <th>Username</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id='table_id'>
                        <?php
                        if ($list_video) {
                            $count = 1;
                            foreach ($list_video as $item) {
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $item->time_upload; ?></td>
                                    <td><?php echo $item->class_date; ?></td>
                                    <td>
                                        <?php
                                        foreach ($list_time as $time_check) {
                                            if ($item->time_id == $time_check->id) {
                                                echo $time_check->start . ' - ' . $time_check->end;
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        foreach ($list_class as $class_check) {
                                            if ($item->class_id == $class_check->id) {
                                                echo $class_check->name;
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $item->name_teacher; ?></td>
                                    <td><?php echo $item->assistant; ?></td>
                                    <td><?php echo $item->cameramen; ?></td>
                                    <td><?php echo $item->des; ?></td>
                                    <td><?php echo $item->note; ?></td>
                                    <td><?php echo $item->video_code; ?></td>
                                    <td><?php echo $user_info->email; ?></td>
                                    <td>
                                        <div class="hidden-sm hidden-xs action-buttons">
                                            <button type_video="<?php echo $item->format_file; ?>" link_video="<?php echo $item->link_video ?>" class="blue btn-view" data-toggle="modal" data-target="#myModal">
                                                <i class="ace-icon fa fa-eye bigger-130"></i>
                                            </button>

                                            <button class="green btn-edit" id_video="<?php echo $item->id; ?>" note_video="<?php echo $item->note; ?>" data-toggle="modal" data-target="#editModal">
                                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                                            </button>

                                            <button class="red">
                                                <a href="<?php echo site_url('list_video/download_video/' . $item->id); ?>"> 
                                                    <i class="ace-icon fa fa-download bigger-130"></i>
                                                    <a/>             
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    $count++;
                                }
                            } else {
                                echo "<tr><td>Không tìm thấy kết quả !</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <div id="pagination" style="text-align: center;">
                        <?php echo $links; ?>
                    </div>            
                </div>
            </div>
        </div>
        <!-- inline scripts related to this page -->
