<?php

class MY_Controller extends CI_Controller {

    var $user_id = null;
    var $user_info = null;
    var $site_config = null;

    /**
     * Truyền biến bất quy tắc qua view, biến được gán giá trị trong hàm _setting_config()
     */
    var $path_theme_view = "";
    var $path_theme_file = "";

//    var $path_static_file = "";

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $this->_setting_config();
       if ($this->require_login()) {
           if (!$this->session->userdata('user_profile')) {
               redirect(site_url('login'));
           }
       }
       if (!$this->check_permission()) {
           if ($this->input->is_ajax_request()) {
               $data = array(
                   'status' => 0,
                   'message' => "Bạn không có quyền truy cập chức năng này !"
               );
               echo json_encode($data);
               exit;
           } else {
               echo "<h3 style='text-align:center;color:red;'>Bạn không có quyền truy cập chức năng này !</h3>";
               echo "<p style='text-align:center'><a href=" . site_url('home') . ">Home</a></p>";
               exit;
           }
       }
    }

    protected function check_permission() {
        $this->load->model('m_user');
        $user_info = json_decode($this->session->userdata('user_profile'));
        $role_id = $user_info[0]->role_id;
        if ($role_id) {
            $list_permission = $this->m_user->get_user_permissions($role_id);
            $method = $this->router->fetch_method();
            if (in_array($method, $list_permission) || ($method == 'index') || in_array('*', $list_permission)) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    protected function require_login() {
        return true;
    }

    protected function master_page_blank($content, $header_page = NULL, $title = NULL, $description = NULL, $keywords = NULL, $canonical = NULL) {
        $data["title"] = $title ? $title : "";

        $data["description"] = $description ? $description : ""; //THông tin này về sau sẽ cho vào cơ sở dữ liệu
        $data["keywords"] = $keywords;
        $data["canonical"] = $canonical ? $canonical : NULL;
//        $data["icon"] = $this->site_config->favicon_link;
        /* head chung của các masterPage */
//        $data["header_base"] = null;
        $data["header_base"] = $this->load->view($this->site_config->path_theme_view . "base_master/head", $data, TRUE);
        /* head riêng của các masterPage */
        $data["header_master_page"] = "";
        /* head riêng của các từng page */
        $data["header_page"] = $header_page ? $header_page : "";
        /* Lấy thông tin phần html */
        $data ["content"] = $content;

        $this->load->view($this->site_config->path_theme_view . "base_master/master_page_blank", $data);
    }

    protected function master_page($content, $head_page = NULL, $title = NULL, $description = NULL) {
        $data = Array();
        /* Lấy thông tin phần head */
        $data["title"] = $title ? $title : "Admin";
        $data["description"] = $description ? $description : "Admin page"; //THông tin này về sau sẽ cho vào cơ sở dữ liệu
        /* head chung của các masterPage */ $data["header_base"] = $this->load->view($this->site_config->path_theme_view . "base_master/head", $data, TRUE);
        /* head riêng của các masterPage */
        $data["header_master_page"] = "";
        /* head riêng của các từng page */
        $data["header_page"] = $head_page ? $head_page : "";

        /* Lấy thông tin phần html */
        $data["header"] = $this->get_header();
        $data["menu_bar"] = $this->get_menu_bar();
        $data["breadcrumb"] = $this->get_breadcrumb();
        $data["content"] = $content;
        $data["left_content"] = $this->get_left_content();
        $data["right_content"] = $this->get_right_content();

        $data["footer"] = $this->get_footer();

        $this->load->view($this->site_config->path_theme_view . "base_master/master_page", $data);
    }

    protected function get_header($data = Array()) {
        return $this->load->view($this->site_config->path_theme_view . "base_master/header", $data, TRUE);
    }

    protected function get_menu_bar($data = Array()) {
//        if (!$this->session->userdata('id')) {
//            $ret = "<style>";
//            $ret .= "#sidebar{margin-top: 0 !important; display: none} .wrapper {margin-top: 0 !important;} #content {margin-left: 0;}";
//            $ret .= "</style>";
//            return $ret;
//        }
//
//        $id = $this->session->userdata('id');
//        $data["logout_url"] = site_url('admin/logout');
//        $data["changer_info_url"] = site_url('admin_account/edit/' . $id);
//        $data["logo"] = $this->path_static_file . "images/logo_white.png";
//        $data["avatar"] = $this->path_static_file . "images/default_avatar.png";

        return $this->load->view($this->site_config->path_theme_view . "base_master/menu_bar", $data, TRUE);
    }

    protected function get_left_content($data = Array()) {
        $data["menu_data"] = $this->_get_left_content_data();
        return $this->load->view($this->site_config->path_theme_view . "base_master/left_content", $data, TRUE);
    }

    protected function _get_left_content_data($data = Array()) {
//        $permission = $this->session->userdata['permission'];
//        $this->load->module('permission');
//        $list_permission = $this->permission->get_list_permission($permission);
//        $menu_data = array();
//        foreach ($list_permission as $per) {
//            $list_action = $this->permission->get_list_actions($per->permissionID);
//            if ($list_action) {
//                $menu_data[] = array(
//                    'text' => $per->category,
//                    'icon' => $per->icon,
//                    'url' => '#',
//                    'module' => $per->module,
//                    'controller' => $per->permission,
//                    'child' => $list_action
//                );
//            } else {
//                $menu_data[] = array(
//                    'text' => $per->category,
//                    'icon' => $per->icon,
//                    'module'=>$per->module,
//                    'controller'=>$per->permission,
//                    'url' => site_url($per->module . '/' . $per->permission)
//                );
//            }
//        }
//        return $menu_data;
    }

    protected function get_breadcrumb($data = Array()) {
        $data['params_num'] = $this->uri->total_segments();
//        $permission = $this->session->userdata['permission'];
//        $this->load->module('permission');
//        $list_permission = $this->permission->get_list_permission($permission);
//        if($data['params_num']==2){
//            foreach ($list_permission as $per){
//                if($per->module.$per->permission == $this->uri->segment(1).$this->uri->segment(2)){
//                    echo $per->category;exit;
//                }
//            }
//        }elseif($data['params_num']==3){
//            
//        }
//        var_dump($list_permission);exit;
//        
//        echo current_url();exit;
//        echo $class = $this->router->fetch_class();exit;
//        $method = $this->router->fetch_method();
        return $this->load->view($this->site_config->path_theme_view . "base_master/breadcrumb", $data, TRUE);
    }

    protected function get_right_content($data = Array()) {
        return $this->load->view($this->site_config->path_theme_view . "base_master/right_content", $data, TRUE);
    }

    protected function get_footer($data = Array()) {
        return $this->load->view($this->site_config->path_theme_view . "base_master/footer", $data, TRUE);
    }

    private function _setting_config() {
        $this->site_config = new stdClass();
        $this->site_config->theme_name = "default";
        $this->site_config->path_theme_view = $this->site_config->theme_name . "/";
        $this->site_config->path_theme_file = base_url("themes/" . $this->site_config->theme_name) . "/";
//        $this->site_config->path_static_file = base_url("static/") . "/";
//        $this->site_config->favicon_link = $this->site_config->path_static_file . "icons/favicon.png";

        /* Truyền biến bất quy tắc qua view */
        $this->path_theme_view = $this->site_config->path_theme_view;
        $this->path_theme_file = $this->site_config->path_theme_file;
//        $this->path_static_file = $this->site_config->path_static_file;
//        $this->favicon_link = $this->site_config->path_static_file . "icons/favicon.png";
    }

}
