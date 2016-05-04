<?php

class List_video extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_list_video');
        $this->load->model('m_user');
    }

    public function index() {
        $this->page();
    }
    public function page() {
        $data = Array();
        $data['user_info'] = $this->m_user->get_one_user(1);
        $data['list_class'] = $this->m_list_video->get_list_class();
        $data['list_time'] = $this->m_list_video->get_list_time();
        /*Pagination*/
        $config = array();
        $config["base_url"] = base_url("list_video/page");
        $config["total_rows"] = count($this->m_list_video->get_list_video());
        $config["per_page"] = 2;
        $config["uri_segment"] = 3;
        $config['num_tag_open'] = '<div style="text-align: center;background-color:#EEEEE;width:30px;height:30px;display:inline-block;color:white;margin:1px;border-radius:3px 3px 3px 3px;border:1px solid #EEEEEE">';
        $config['num_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<div style="text-align: center;background-color:#337AB7;width:30px;height:30px;display:inline-block;color:white;margin:1px;border-radius:3px 3px 3px 3px;border:1px solid #EEEEEE">';
        $config['cur_tag_close'] = '</div>';
        $config['prev_link'] = FALSE;
        $config['next_link'] = FALSE;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["list_video"] = $this->m_list_video->fetch_data($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        /*End pagination*/
        $content = $this->load->view($this->path_theme_view . "list_video/index", $data, true);
        $header_page = $this->load->view($this->path_theme_view . "list_video/header", $data, true);
        $title = NULL;
        $description = NULL;
        $this->master_page($content, $header_page, $title, $description);
    }
    public function normal_search(){
        var_dump($this->input->post());exit;
    }

}
