<script type="text/javascript">
    try {
        ace.settings.check('sidebar', 'fixed')
    } catch (e) {
    }
</script>

<div class="sidebar-shortcuts" id="sidebar-shortcuts">
    <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
    </div>
    <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
        <span class="btn btn-success"></span>

        <span class="btn btn-info"></span>

        <span class="btn btn-warning"></span>

        <span class="btn btn-danger"></span>
    </div>
</div><!-- /.sidebar-shortcuts -->

<ul class="nav nav-list">
    <li class="active">
        <a href="<?php echo site_url('home') ?>">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text">Trang chủ</span>
        </a>

        <b class="arrow"></b>
    </li>

    <li class="">
        <a href="<?php echo site_url('upload');?>">
            <i class="menu-icon fa fa-upload"></i>
            <span class="menu-text">
                Upload video
            </span>
        </a>
    </li>
    <li class="">
        <a href="<?php echo site_url('list_video') ?>">
            <i class="menu-icon fa fa-list"></i>
            <span class="menu-text">
                Danh sách video
            </span>
        </a>
    </li>

    <li class="">
        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-cog"></i>
            <span class="menu-text"> Setting </span>

            <b class="arrow fa fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu">
            <li class="">
                <a href="tables.html">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Phân quyền tài khoản
                </a>

                <b class="arrow"></b>
            </li>

            <li class="">
                <a href="<?php echo site_url('list_user'); ?>">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Danh sách tài khoản
                </a>

                <b class="arrow"></b>
            </li>
        </ul>
    </li>

</ul><!-- /.nav-list -->

<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
    <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
</div>

<script type="text/javascript">
    try {
        ace.settings.check('sidebar', 'collapsed')
    } catch (e) {
    }
</script>