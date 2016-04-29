<?php

/**
 * Description of upload
 *
 * @author TUNG-PC
 */
class upload extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data = Array();
        $content = $this->load->view($this->path_theme_view . "upload/index", $data, true);
        $header_page = $this->load->view($this->path_theme_view . "upload/head", $data, true);
        $title = NULL;
        $description = NULL;

        $this->master_page($content, $header_page, $title, $description);
    }

}
