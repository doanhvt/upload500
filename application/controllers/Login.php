<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('googleplus');
    }

    public function index() {
         $session_login = json_decode($this->session->userdata('is_login'));
        if (isset($session_login)) {
            redirect('');
        }
        $data = Array();
        $code = $this->input->get('code');
        if (isset($code)) {
            $this->googleplus->getAuthenticate();
            $this->googleplus->setAccessToken($code);
            $token = $this->googleplus->getAccessToken();
            if (isset($token)) {
                $infoUser = $this->googleplus->getUserInfo();
                if(isset($infoUser)){
                    // kiểm tra mail trong trong db hoặc insert thêm 
                    // Nếu tồn tại trong db thì login không thì tài khoản của chưa dk cấp quyền
                }
                $json_data = json_encode($infoUser);
                $this->session->set_userdata('user_profile', $json_data);
                $this->session->set_userdata('is_login', true);
            }
            //            redirect('welcome/profile');
        }
        $data['login_url'] = $this->googleplus->loginURL();
        $content = $this->load->view($this->path_theme_view . "login/content", $data, true);
        $header_page = NULL; /* Dữ liệu đẩy thêm vào thẻ <head> (css, js, meta property) */
        $this->master_page_blank($content, $header_page);
    }

//    public function profile() {
//        if ($this->session->userdata('login') != true) {
//            redirect('');
//        }
//        $contents['user_profile'] = $this->session->userdata('user_profile');
//        $this->load->view('profile', $contents);
//    }

    public function logout() {
        $this->session->sess_destroy();
        $this->googleplus->revokeToken();
        redirect('login');
    }

}
