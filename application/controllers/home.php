<?php

class Home extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data = Array();
//        $data['user_name'] = $this->session->userdata('username');
//        $content = $this->load->view($this->path_theme_view . "home/index", $data, true);
        $content ='';
        $header_page = NULL; /* Dữ liệu đẩy thêm vào thẻ <head> (css, js, meta property) */
        $title = NULL;
        $description = NULL;

        $this->master_page($content, $header_page, $title, $description);
    }

}
