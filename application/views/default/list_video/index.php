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
        <h3 class="header smaller lighter blue"><a id='advanced-search' href='#' style="background-color: #810c15;padding:3px;text-decoration: none;color:white;" href="#">Advanced search &nbsp;&nbsp;&nbsp;<b class="arrow fa fa-angle-down">&nbsp;</b></a></h3>
        <div class="clearfix">
            <div class="pull-right tableTools-container"></div>
        </div>
        <div id='advanced-search-box'>
            <form role='form'>
                <div style="width: 20%;float: left;margin-right:20px;">
                    <div class="form-group">
                        <label for="class"><b>Loại lớp</b></label>
                        <select class="form-control" id="class">
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
                        <input type="text" class="form-control" id="teacher">
                    </div>
                    <div class="form-group">
                        <label for="asistant"><b>Trợ giảng</b></label>
                        <input type="text" class="form-control" id="asistant">
                    </div>
                </div>
                <div class="input-daterange" style="width: 20%;float: left;margin-right:20px;">
                    <div class="form-group">
                        <label for="start"><b>Từ ngày</b></label>
                        <input type="text" class="form-control" id="i_from_date">
                    </div>
                    <div class="form-group">
                        <label for="end"><b>Đến ngày</b></label>
                        <input type="text" class="form-control" id="end">
                    </div>
                    <div class="form-group">
                        <label for="hour"><b>Giờ học</b></label>
                        <select type="text" class="form-control" id="end">
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
                        <input class="input-sm" style="margin-top:26px;background-color: #810c15;color:white;" type="submit" class="form-control" id="submit" value='FILTER'>
                    </div>
                    <div class="form-group">
                        <input class='input-sm' style="margin-top:30px;background-color: #810c15;color:white;" type="button" class="form-control" value='RESET'>
                    </div>
                </div>
                <!--                <div class="input-daterange input-group">
                                    <input type="text" class="input-sm form-control" name='start' />
                                    <span class='input-group-addon'>
                                        <i class="fa fa-exchange"></i>
                                    </span>
                                    <input type='text' class='input-sm form-control'name='end'/>
                                </div>-->
            </form>
        </div>
        <div class="clearfix">
        </div>
        <div class="table-header" style="background-color: #810c15;">
            Results
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
                    if($list_video){                       
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
                            <td><?php echo $user_info->display_name; ?></td>
                            <td><?php echo $item->assistant; ?></td>
                            <td><?php echo $item->cameramen; ?></td>
                            <td><?php echo $item->status_video; ?></td>
                            <td><?php echo $item->note; ?></td>
                            <td><?php echo $item->video_code; ?></td>
                            <td><?php echo $user_info->email; ?></td>
                            <td>
                                <div class="hidden-sm hidden-xs action-buttons">
                                    <a class="blue" href="<?php echo site_url('list_video/view_video'); ?>">
                                        <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                    </a>

                                    <a class="green" href="#">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </a>

                                    <a class="red" href="#">
                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php
                        $count++;
                        }
                    }else{
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
