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
        $config["per_page"] = 10;
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

    public function download_video($id) {
        $video = $this->m_list_video->get_one_video($id);
        if ($video) {
            //Get the file from whatever the user uploaded (NOTE: Users needs to upload first), @See http://localhost/CI/index.php/upload
            $data = file_get_contents($video->link_video);
            //Read the file's contents
            $name = $video->link_video;

            //use this function to force the session/browser to download the file uploaded by the user 
            force_download($name, $data);
        } else {
            echo "Video không tồn tại !";
        }
    }

    public function edit_video() {
        if ($this->input->post()) {
            $update_data = array(
                'note' => $this->input->post('note_video')
            );
            $this->m_list_video->edit_video($this->input->post('id_video'), $update_data);
            $data_return = array(
                'status' => 1,
                'message' => 'Sửa thông tin video thành công !'
            );
            echo json_encode($data_return);
        } else {
            $data_return = array(
                'status' => 2,
                'message' => 'Sửa thông tin video không thành công !'
            );
            echo json_encode($data_return);
        }
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

    public function normal_search() {
//        $data['user_info'] = $user_info = $this->m_user->get_one_user(1);
//        $data['list_class'] = $list_class = $this->m_list_video->get_list_class();
//        $data['list_time'] = $list_time = $this->m_list_video->get_list_time();

        /* Pagination */
        $config = array();
        $config["base_url"] = base_url("list_video/normal_search");
//        $config["total_rows"] = count($data);
        $config["per_page"] = 10;
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
                    $html .= "<td>" . $data_search_item->name_teacher . "</td>";
                    $html .= "<td>" . $data_search_item->assistant . "</td>";
                    $html .= "<td>" . $data_search_item->cameramen . "</td>";
                    $html .= "<td>" . $data_search_item->des . "</td>";
                    $html .= "<td>" . $data_search_item->note . "</td>";
                    $html .= "<td>" . $data_search_item->video_code . "</td>";
                    $html .= "<td>" . $user_info->email . "</td>";

                    $html .= "<td>";

                    $html .= "<div class='hidden-sm hidden-xs action-buttons'>
                                <button type_video='" . $data_search_item->format_file . "' link_video='" . $data_search_item->link_video . "' class='blue btn-view' data-toggle='modal' data-target='#myModal'>
                                    <i class='ace-icon fa fa-eye bigger-130'></i>
                                </button>

                                <button class='green btn-edit' id_video='" . $data_search_item->id . "' note_video='" . $data_search_item->note . "' data-toggle='modal' data-target='#editModal'>
                                            <i class='ace-icon fa fa-pencil bigger-130'></i>
                                </button>

                                <button class='red'>
                                    <a href='" . site_url('list_video/download_video/' . $data_search_item->id) . "'> 
                                        <i class='ace-icon fa fa-download bigger-130'></i>
                                    <a/>             
                                </button>
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
                    $html .= "<td>" . $data_search_item->name_teacher . "</td>";
                    $html .= "<td>" . $data_search_item->assistant . "</td>";
                    $html .= "<td>" . $data_search_item->cameramen . "</td>";
                    $html .= "<td>" . $data_search_item->status_video . "</td>";
                    $html .= "<td>" . $data_search_item->note . "</td>";
                    $html .= "<td>" . $data_search_item->video_code . "</td>";
                    $html .= "<td>" . $user_info->email . "</td>";
                    $html .= "<td>";
                    $html .= "<div class='hidden-sm hidden-xs action-buttons'>
                                <button type_video='" . $data_search_item->format_file . "' link_video='" . $data_search_item->link_video . "' class='blue btn-view' data-toggle='modal' data-target='#myModal'>
                                    <i class='ace-icon fa fa-eye bigger-130'></i>
                                </button>

                                <button class='green btn-edit' id_video='" . $data_search_item->id . "' note_video='" . $data_search_item->note . "' data-toggle='modal' data-target='#editModal'>
                                            <i class='ace-icon fa fa-pencil bigger-130'></i>
                                </button>

                                <button class='red'>
                                    <a href='" . site_url('list_video/download_video/' . $data_search_item->id) . "'> 
                                        <i class='ace-icon fa fa-download bigger-130'></i>
                                    <a/>             
                                </button>
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

    public function advanced_search() {
        /* Pagination */
        $config = array();
        $config["base_url"] = base_url("list_video/advanced_search");
//        $config["total_rows"] = count($data);
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config['num_tag_open'] = '<div style="text-align: center;background-color:#810c15;width:30px;height:30px;display:inline-block;color:white;margin:1px;border-radius:3px 3px 3px 3px;border:1px solid #EEEEEE">';
        $config['num_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<div style="text-align: center;background-color:#810c15;width:30px;height:30px;display:inline-block;color:white;margin:1px;border-radius:3px 3px 3px 3px;border:1px solid #EEEEEE">';
        $config['cur_tag_close'] = '</div>';
        $config['prev_link'] = FALSE;
        $config['next_link'] = FALSE;
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        if ($this->input->get()) {
            $data_view['user_info'] = $user_info = $this->m_user->get_one_user(1);
            $data_view['list_class'] = $list_class = $this->m_list_video->get_list_class();
            $data_view['list_time'] = $list_time = $this->m_list_video->get_list_time();
            $search_value = array(
                'class_id' => $this->input->get('class-id'),
                'name_teacher' => $this->input->get('teacher'),
                'asistant' => $this->input->get('asistant'),
                'class_date' => $this->input->get('start-date'),
                'end_date' => $this->input->get('end-date'),
                'time_id' => $this->input->get('hour')
            );
            $this->session->set_userdata(array('advanced-search' => $search_value));
            $data = $this->m_list_video->get_list_advanced_search($search_value);
            $config["total_rows"] = count($data);
            $this->pagination->initialize($config);
            $data["data_search"] = $data_search = $this->m_list_video->advanced_search($config["per_page"], $page, $search_value);
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
                    $html .= "<td>" . $data_search_item->name_teacher . "</td>";
                    $html .= "<td>" . $data_search_item->assistant . "</td>";
                    $html .= "<td>" . $data_search_item->cameramen . "</td>";
                    $html .= "<td>" . $data_search_item->des . "</td>";
                    $html .= "<td>" . $data_search_item->note . "</td>";
                    $html .= "<td>" . $data_search_item->video_code . "</td>";
                    $html .= "<td>" . $user_info->email . "</td>";
                    $html .= "<td>";
                    $html .= "<div class='hidden-sm hidden-xs action-buttons'>
                                <button type_video='" . $data_search_item->format_file . "' link_video='" . $data_search_item->link_video . "' class='blue btn-view' data-toggle='modal' data-target='#myModal'>
                                    <i class='ace-icon fa fa-eye bigger-130'></i>
                                </button>

                                <button class='green btn-edit' id_video='" . $data_search_item->id . "' note_video='" . $data_search_item->note . "' data-toggle='modal' data-target='#editModal'>
                                            <i class='ace-icon fa fa-pencil bigger-130'></i>
                                </button>

                                <button class='red'>
                                    <a href='" . site_url('list_video/download_video/' . $data_search_item->id) . "'> 
                                        <i class='ace-icon fa fa-download bigger-130'></i>
                                    <a/>             
                                </button>
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
            $data_view['search_session_advanced'] = $search_session = $this->session->userdata('advanced-search');
            $data = $this->m_list_video->get_list_advanced_search($search_session);
            $config["total_rows"] = count($data);
            $this->pagination->initialize($config);
            $data_view["data_search"] = $data_search = $this->m_list_video->advanced_search($config["per_page"], $page, $search_session);
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
                    $html .= "<td>" . $data_search_item->name_teacher . "</td>";
                    $html .= "<td>" . $data_search_item->assistant . "</td>";
                    $html .= "<td>" . $data_search_item->cameramen . "</td>";
                    $html .= "<td>" . $data_search_item->status_video . "</td>";
                    $html .= "<td>" . $data_search_item->note . "</td>";
                    $html .= "<td>" . $data_search_item->video_code . "</td>";
                    $html .= "<td>" . $user_info->email . "</td>";
                    $html .= "<td>";
                    $html .= "<div class='hidden-sm hidden-xs action-buttons'>
                                <button type_video='" . $data_search_item->format_file . "' link_video='" . $data_search_item->link_video . "' class='blue btn-view' data-toggle='modal' data-target='#myModal'>
                                    <i class='ace-icon fa fa-eye bigger-130'></i>
                                </button>

                                <button class='green btn-edit' id_video='" . $data_search_item->id . "' note_video='" . $data_search_item->note . "' data-toggle='modal' data-target='#editModal'>
                                            <i class='ace-icon fa fa-pencil bigger-130'></i>
                                </button>

                                <button class='red'>
                                    <a href='" . site_url('list_video/download_video/' . $data_search_item->id) . "'> 
                                        <i class='ace-icon fa fa-download bigger-130'></i>
                                    <a/>             
                                </button>
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
