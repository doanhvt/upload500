<?php

class List_video extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data = Array();
//        $data['user_name'] = $this->session->userdata('username');
        $content = $this->load->view($this->path_theme_view . "list_video/index", $data, true);
        $header_page = $this->load->view($this->path_theme_view . "list_video/header", $data, true);
        $title = NULL;
        $description = NULL;

        $this->master_page($content, $header_page, $title, $description);
    }

}
