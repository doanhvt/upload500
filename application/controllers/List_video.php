<?php

class List_video extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_list_video');
        $this->load->model('m_user');
    }

    public function index() {
        // $this->page();
        $data = Array();
        $data['user_info'] = $this->m_user->get_one_user(1);
        $data['list_class'] = $this->m_list_video->get_list_class();
        $data['list_time'] = $this->m_list_video->get_list_time();
        /* Pagination */
        $config = array();
        $config["base_url"] = base_url("list_video/index");
        $config["total_rows"] = count($this->m_list_video->get_list_video());
        $config["per_page"] = 2;
        $config["uri_segment"] = 3;
        $config['num_tag_open'] = '<div style="text-align: center;background-color:#810c15;width:30px;height:30px;display:inline-block;color:white;margin:1px;border-radius:3px 3px 3px 3px;border:1px solid #EEEEEE">';
        $config['num_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<div style="text-align: center;background-color:#810c15;width:30px;height:30px;display:inline-block;color:white;margin:1px;border-radius:3px 3px 3px 3px;border:1px solid #EEEEEE">';
        $config['cur_tag_close'] = '</div>';
        $config['prev_link'] = FALSE;
        $config['next_link'] = FALSE;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["list_video"] = $this->m_list_video->fetch_data($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        /* End pagination */
        $content = $this->load->view($this->path_theme_view . "list_video/index", $data, true);
        $header_page = $this->load->view($this->path_theme_view . "list_video/header", $data, true);
        $title = NULL;
        $description = NULL;
        $this->master_page($content, $header_page, $title, $description);
    }

    public function page() {
        $data = Array();
        $data['user_info'] = $this->m_user->get_one_user(1);
        $data['list_class'] = $this->m_list_video->get_list_class();
        $data['list_time'] = $this->m_list_video->get_list_time();
        /* Pagination */
        $config = array();
        $config["base_url"] = base_url("list_video/page");
        $config["total_rows"] = count($this->m_list_video->get_list_video());
        $config["per_page"] = 2;
        $config["uri_segment"] = 3;
        $config['num_tag_open'] = '<div style="text-align: center;background-color:#810c15;width:30px;height:30px;display:inline-block;color:white;margin:1px;border-radius:3px 3px 3px 3px;border:1px solid #EEEEEE">';
        $config['num_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<div style="text-align: center;background-color:#810c15;width:30px;height:30px;display:inline-block;color:white;margin:1px;border-radius:3px 3px 3px 3px;border:1px solid #EEEEEE">';
        $config['cur_tag_close'] = '</div>';
        $config['prev_link'] = FALSE;
        $config['next_link'] = FALSE;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["list_video"] = $this->m_list_video->fetch_data($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        /* End pagination */
        $content = $this->load->view($this->path_theme_view . "list_video/index", $data, true);
        $header_page = $this->load->view($this->path_theme_view . "list_video/header", $data, true);
        $title = NULL;
        $description = NULL;
        $this->master_page($content, $header_page, $title, $description);
    }

    public function view_video() {
        echo 'view';
    }

    public function normal_search() {
//        $data['user_info'] = $user_info = $this->m_user->get_one_user(1);
//        $data['list_class'] = $list_class = $this->m_list_video->get_list_class();
//        $data['list_time'] = $list_time = $this->m_list_video->get_list_time();

        /* Pagination */
        $config = array();
        $config["base_url"] = base_url("list_video/normal_search");
//        $config["total_rows"] = count($data);
        $config["per_page"] = 2;
        $config["uri_segment"] = 3;
        $config['num_tag_open'] = '<div style="text-align: center;background-color:#810c15;width:30px;height:30px;display:inline-block;color:white;margin:1px;border-radius:3px 3px 3px 3px;border:1px solid #EEEEEE">';
        $config['num_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<div style="text-align: center;background-color:#810c15;width:30px;height:30px;display:inline-block;color:white;margin:1px;border-radius:3px 3px 3px 3px;border:1px solid #EEEEEE">';
        $config['cur_tag_close'] = '</div>';
        $config['prev_link'] = FALSE;
        $config['next_link'] = FALSE;
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        if ($this->input->get('q') != '') {
            $data_view['user_info'] = $user_info = $this->m_user->get_one_user(1);
            $data_view['list_class'] = $list_class = $this->m_list_video->get_list_class();
            $data_view['list_time'] = $list_time = $this->m_list_video->get_list_time();

            $this->session->set_userdata(array('normal-search' => $this->input->get('q')));
            $data_view['search_session'] = $this->session->userdata('normal-search');
            $data = $this->m_list_video->get_list_normal_search($this->input->get('q'));
            $config["total_rows"] = count($data);
            $this->pagination->initialize($config);
            $data["data_search"] = $data_search = $this->m_list_video->normal_search($config["per_page"], $page, $this->input->get('q'));
            $data_view["links"] = $links = $this->pagination->create_links();
            /* End pagination */
            $html = "";
            $count = 1;
            if ($data_search) {
                foreach ($data_search as $data_search_item) {
                    $html .= "<tr>";
                    $html .= "<td>" . $count . "</td>";
                    $html .= "<td>" . $data_search_item->time_upload . "</td>";
                    $html .= "<td>" . $data_search_item->class_date . "</td>";
                    foreach ($list_time as $time_check) {
                        if ($data_search_item->time_id == $time_check->id) {
                            $html.= "<td>" . $time_check->start . " - " . $time_check->end . "</td>";
                        }
                    }
                    foreach ($list_class as $class_check) {
                        if ($data_search_item->class_id == $class_check->id) {
                            $html.= "<td>" . $class_check->name . "</td>";
                        }
                    }
                    $html .= "<td>" . $user_info->display_name . "</td>";
                    $html .= "<td>" . $data_search_item->assistant . "</td>";
                    $html .= "<td>" . $data_search_item->cameramen . "</td>";
                    $html .= "<td>" . $data_search_item->status_video . "</td>";
                    $html .= "<td>" . $data_search_item->note . "</td>";
                    $html .= "<td>" . $data_search_item->video_code . "</td>";
                    $html .= "<td>" . $user_info->email . "</td>";

                    $html .= "<td>";
                    $html .= "<div class='hidden-sm hidden-xs action-buttons'>
                    <a class='blue' href='" . site_url('list_video/view_video') . "'>
                        <i class='ace-icon fa fa-search-plus bigger-130'></i>
                    </a>

                    <a class='green' href='#'>
                        <i class='ace-icon fa fa-pencil bigger-130'></i>
                    </a>

                    <a class='red' href='#'>
                        <i class='ace-icon fa fa-trash-o bigger-130'></i>
                    </a>
                </div>";
                    $html .= "</td>";
                    $count++;
                }
                $data_view['html'] = $html;
                $content = $this->load->view($this->path_theme_view . "normal-search/index", $data_view, true);
                $header_page = $this->load->view($this->path_theme_view . "normal-search/header", $data_view, true);
                $title = NULL;
                $description = NULL;
                $this->master_page($content, $header_page, $title, $description);
            } else {
                $data_view['user_info'] = $user_info = $this->m_user->get_one_user(1);
                $data_view['list_class'] = $list_class = $this->m_list_video->get_list_class();
                $data_view['list_time'] = $list_time = $this->m_list_video->get_list_time();
                $data_view['search_session'] = '';
                $content = $this->load->view($this->path_theme_view . "normal-search/index", $data_view, true);
                $header_page = $this->load->view($this->path_theme_view . "normal-search/header", $data_view, true);
                $title = NULL;
                $description = NULL;
                $this->master_page($content, $header_page, $title, $description);
            }
        } else {
            $data_view['user_info'] = $user_info = $this->m_user->get_one_user(1);
            $data_view['list_class'] = $list_class = $this->m_list_video->get_list_class();
            $data_view['list_time'] = $list_time = $this->m_list_video->get_list_time();
            $data_view['search_session'] = $search_session = $this->session->userdata('normal-search');
            $data = $this->m_list_video->get_list_normal_search($search_session);
            $config["total_rows"] = count($data);
            $this->pagination->initialize($config);
            $data_view["data_search"] = $data_search = $this->m_list_video->normal_search($config["per_page"], $page, $search_session);
            $data_view["links"] = $links = $this->pagination->create_links();
            /* End pagination */
            $html = "";
            $count = 1;
            if ($data_search) {
                foreach ($data_search as $data_search_item) {
                    $html .= "<tr>";
                    $html .= "<td>" . $count . "</td>";
                    $html .= "<td>" . $data_search_item->time_upload . "</td>";
                    $html .= "<td>" . $data_search_item->class_date . "</td>";
                    foreach ($list_time as $time_check) {
                        if ($data_search_item->time_id == $time_check->id) {
                            $html.= "<td>" . $time_check->start . " - " . $time_check->end . "</td>";
                        }
                    }
                    foreach ($list_class as $class_check) {
                        if ($data_search_item->class_id == $class_check->id) {
                            $html.= "<td>" . $class_check->name . "</td>";
                        }
                    }
                    $html .= "<td>" . $user_info->display_name . "</td>";
                    $html .= "<td>" . $data_search_item->assistant . "</td>";
                    $html .= "<td>" . $data_search_item->cameramen . "</td>";
                    $html .= "<td>" . $data_search_item->status_video . "</td>";
                    $html .= "<td>" . $data_search_item->note . "</td>";
                    $html .= "<td>" . $data_search_item->video_code . "</td>";
                    $html .= "<td>" . $user_info->email . "</td>";
                    $html .= "<td>";
                    $html .= "<div class='hidden-sm hidden-xs action-buttons'>
                <a class='blue' href='" . site_url('list_video/view_video') . "'>
                    <i class='ace-icon fa fa-search-plus bigger-130'></i>
                </a>
                <a class='green' href='#'>
                    <i class='ace-icon fa fa-pencil bigger-130'></i>
                </a>
                <a class='red' href='#'>
                    <i class='ace-icon fa fa-trash-o bigger-130'></i>
                </a>
            </div>";
                    $html .= "</td>";
                    $count++;
                }
                $data_view['html'] = $html;
                $content = $this->load->view($this->path_theme_view . "normal-search/index", $data_view, true);
                $header_page = $this->load->view($this->path_theme_view . "normal-search/header", $data_view, true);
                $title = NULL;
                $description = NULL;
                $this->master_page($content, $header_page, $title, $description);
            }
        }
    }

}
