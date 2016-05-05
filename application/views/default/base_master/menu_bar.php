<div class="navbar-container" id="navbar-container">
    <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
        <span class="sr-only">Toggle sidebar</span>

        <span class="icon-bar"></span>

        <span class="icon-bar"></span>

        <span class="icon-bar"></span>
    </button>

    <div class="navbar-header pull-left">
        <a href="index.html" class="navbar-brand">
            <small>
                <!--<i class="fa fa-leaf"></i>-->
                TOPICA NATIVE
            </small>
        </a>
    </div>

    <div class="navbar-buttons navbar-header pull-right" role="navigation">
        <ul class="nav ace-nav">
            <li class="light-blue">
                <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                    <img class="nav-user-photo" src="<?php echo $this->path_theme_file; ?>assets/avatars/user.jpg" alt="Jason's Photo" />
                    <?php $infoUser = json_decode($this->session->userdata('user_profile'));
                        if($infoUser){ ?>
                    <span class="user-info" style="    top: 15px;">
                        <span><?php echo $infoUser[0]->email;?></span>
                    </span>
                    <?php } ?>
                    <i class="ace-icon fa fa-caret-down"></i>
                </a>

                <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                    <li>
                        <a href="#">
                            <i class="ace-icon fa fa-cog"></i>
                            Settings
                        </a>
                    </li>

                    <li>
                        <a href="profile.html">
                            <i class="ace-icon fa fa-user"></i>
                            Profile
                        </a>
                    </li>

                    <li class="divider"></li>

                    <li>
                        <a href="<?php echo site_url('login/logout');?>">
                            <i class="ace-icon fa fa-power-off"></i>
                            Logout
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div><!-- /.navbar-container -->