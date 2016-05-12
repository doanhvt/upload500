<div class="row">
    <div class="col-xs-12">     
        <div>
            <button data-toggle="modal" data-target="#addModal" class="btn btn-info" style="border:1px solid #F5F5F5;border-radius:4px 4px 4px 4px !important;background-color: #810c15 !important;">
                <span class="glyphicon glyphicon-plus"> Thêm tài khoản</span>
            </button>
            <form id="user-search-form" method="get" action="<?php echo site_url('list_user/user_search'); ?>" class="navbar-form navbar-right" >
                <div class="input-group">
                    <input name="q"  placeholder="Danh sách các tài khoản cách nhau bằng dấu phẩy" class="form-control" style="width:400px;border-radius:4px 0px 0px 4px !important;" value="<?php $user_search = $this->session->userdata('user-search');
echo isset($user_search) ? $user_search : ""; ?>"/>
                    <div class="input-group-btn">
                        <button id="user-search-btn" type="submit" class="btn btn-info" style="border:1px solid #F5F5F5;border-radius:0px 4px 4px 0px !important;background-color: #810c15 !important;">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="clearfix">
        </div>
        <div id="addModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                Modal content
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-center"><b>Thêm mới tài khoản</b></h4>
                    </div>
                    <div class='modal-body'>
                        <form id="add-form" role="form" action="<?php echo site_url("list_user/add_user"); ?>" >
                            <div class="form-group">
                                <label for='email'><b>Email:</b></label>
                                <input type="text" name="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for='display_name'><b>Tên hiển thị:<b/></label>
                                <input type="text" name="display_name" class="form-control">
                            </div>
                            <label for='role_id'><b>Quyền:</b></label><br>
                            <select name="role_id">
                                <?php
                                foreach ($list_role as $list_role_item) {
                                    ?>
                                    <option value="<?php echo $list_role_item->id ?>"><?php echo $list_role_item->name; ?></option>
                                    <?php
                                }
                                ?>
                            </select><br><br>
                            <label for='account_type'><b>Loại tài khoản:</b></label><br>
                            <select name="account_type">
                                <?php
                                foreach ($list_account_type as $list_account_type_item) {
                                    ?>
                                    <option value="<?php echo $list_account_type_item->id ?>"><?php echo $list_account_type_item->name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button id="confirm-add" type="" class="btn btn-default" >Xác nhận</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    </div>
                </div>

            </div>
        </div>
        <!-- Trigger the modal with a button -->
        <!--<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>-->

        <!-- Modal -->
        <div id="editModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-center"><b>Sửa thông tin tài khoản</b></h4>
                    </div>
                    <div class="modal-body modal-body-edit">

                    </div>
                    <div class="modal-footer">
                        <button id="confirm-edit" type="" class="btn btn-default" >Xác nhận</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    </div>
                </div>

            </div>
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
                        <th>Tài khoản</th>
                        <th>Tên hiển thị</th>
                        <th>Quyền</th>
                        <th>Loại tài khoản</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id='table_id'>
                    <?php
                    if ($list_user) {
                        $count = 1;
                        foreach ($list_user as $list_user_item) {
                            ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $list_user_item->email; ?></td>
                                <td><?php echo $list_user_item->display_name; ?></td>
                                <td><?php echo $list_user_item->name; ?></td>
                                <td><?php echo $list_user_item->account_type_name; ?></td>
                                <td>
                                    <div class="hidden-sm hidden-xs action-buttons">
                                        <button data-toggle="modal" data-target="#editModal" class="green edit_info" value="<?php echo $list_user_item->id; ?>"  url="<?php echo site_url('list_user/get_ajax_data_edit_user/' . $list_user_item->id); ?>">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </button>                                
                                        <button class="red delete_info" value="<?php echo $list_user_item->id; ?>" url="<?php echo site_url('list_user/delete_user/' . $list_user_item->id); ?>">
                                            <i class="ace-icon fa fa-trash-o bigger-130" ></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            $count++;
                        }
                    } else {
                        echo '<tr><td>Không tìm thấy kết quả</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
            <div id="pagination" style="text-align: center;">
<?php echo isset($links) ? $links : ""; ?>
            </div>            
        </div>
    </div>
</div>
<!-- inline scripts related to this page -->
