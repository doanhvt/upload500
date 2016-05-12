<?php

class List_user extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_user');
    }

    public function index() {
        $data = Array();
        /* Pagination */
        $config = array();
        $data['list_account_type'] = $this->m_user->get_list_account();
        $data['list_role'] = $this->m_user->get_list_permission();
        $config["base_url"] = base_url("list_user/index");
        $config["total_rows"] = count($this->m_user->get_list_user());
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $config['num_tag_open'] = '<div style="text-align: center;background-color:#810c15;width:30px;height:30px;display:inline-block;color:white;margin:1px;border-radius:3px 3px 3px 3px;border:1px solid #EEEEEE">';
        $config['num_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<div style="text-align: center;background-color:#810c15;width:30px;height:30px;display:inline-block;color:white;margin:1px;border-radius:3px 3px 3px 3px;border:1px solid #EEEEEE">';
        $config['cur_tag_close'] = '</div>';
        $config['prev_link'] = FALSE;
        $config['next_link'] = FALSE;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["list_user"] = $this->m_user->get_list_user_limit($config["per_page"], $page);
//        var_dump($data["list_user"]);exit;
        $data["links"] = $this->pagination->create_links();
        /* End pagination */
        $content = $this->load->view($this->path_theme_view . "list_user/index", $data, true);
        $header_page = $this->load->view($this->path_theme_view . "list_user/header", $data, true);
        $title = NULL;
        $description = NULL;
        $this->master_page($content, $header_page, $title, $description);
    }

    public function get_ajax_data_edit_user($id) {
        $user_info = $this->m_user->get_one_user($id);
        $list_role = $this->m_user->get_list_permission();
        $list_account_type = $this->m_user->get_list_account();
        $modal_body = "";
        $modal_body .= "<form id='edit_form' action='" . site_url('list_user/edit_user/' . $id) . "' method='post' role='form'>";
        $modal_body .= "<div class='form-group'>";
        $modal_body .= "<label for='email'><b>Email:</b></label>";
        $modal_body .= "<input class='form-control' name = 'email' type = 'text' value = '" . $user_info->email . "'>";
        $modal_body .= "</div>";
        $modal_body .= "<div class='form-group'>";
        $modal_body .= "<label for='display_name'><b>Tên hiển thị:<b/></label>";
        $modal_body .= "<input class='form-control' name = 'display_name' type = 'text' value = '" . $user_info->display_name . "'>";
        $modal_body .= "</div>";
        $modal_body .= "<label for='role'><b>Quyền:</b></label><br>";
        $modal_body .= "<select name = 'role'>";
        foreach ($list_role as $list_row_item) {
            if ($user_info->name == $list_row_item->name) {
                $modal_body .= "<option selected='selected' value='" . $list_row_item->id . "'>" . $list_row_item->name . "</option>";
            } else {
                $modal_body .= "<option value='" . $list_row_item->id . "'>" . $list_row_item->name . "</option>";
            }
        }
        $modal_body .="</select><br><br>";
        $modal_body .= "<label for='role'><b>Loại tài khoản:</b></label><br>";
        $modal_body .= "<select name='account_type'>";
        foreach ($list_account_type as $list_account_type_item) {
            if ($user_info->account_type == $list_account_type_item->id) {
                $modal_body .= "<option selected='selected' value='" . $list_account_type_item->id . "'>" . $list_account_type_item->name . "</option>";
            } else {
                $modal_body .= "<option value='" . $list_account_type_item->id . "'>" . $list_account_type_item->name . "</option>";
            }
        }
        $modal_body .="</select><br><br>";
        $modal_body .="</form>";
        $data_return = array(
            'modal_body' => $modal_body
        );
        echo json_encode($data_return);
    }

    public function edit_user($id) {
        $data_update = array(
            'email' => $this->input->post('email'),
            'display_name' => $this->input->post('display_name'),
            'role_id' => $this->input->post('role'),
            'account_type' => $this->input->post('account_type')
        );
        $this->m_user->edit_user($id, $data_update);
        $data_return = array(
            'status' => 1,
            'message' => 'Sửa bản ghi thành công !'
        );
        echo json_encode($data_return);
    }

    public function add_user() {
        $data_insert = $this->input->post();
        if (!$this->m_user->check_duplicate_user($data_insert['email'])) {
            $this->m_user->add_user($data_insert);
            $data_return = array(
                'status' => 1,
                'message' => 'Thêm tài khoản thành công !'
            );
            echo json_encode($data_return);
        } else {
            $data_return = array(
                'status' => 2,
                'message' => 'Email đã tồn tại vui lòng chọn email khác !'
            );
            echo json_encode($data_return);
        }
    }

    public function delete_user($id) {
        $this->m_user->delete_user($id);
        $data_return = array(
            'status' => 1,
            'mesage' => 'Xóa tài khoản thành công !'
        );
        echo json_encode($data_return);
    }

    public function user_search() {
        $data_view['list_account_type'] = $this->m_user->get_list_account();
        $data_view['list_role'] = $this->m_user->get_list_permission();
        $config = array();
        $config["base_url"] = base_url("list_user/user_search");
//        $config["total_rows"] = count($data);
        $config["per_page"] = 1;
        $config["uri_segment"] = 3;
        $config['num_tag_open'] = '<div style="text-align: center;background-color:#810c15;width:30px;height:30px;display:inline-block;color:white;margin:1px;border-radius:3px 3px 3px 3px;border:1px solid #EEEEEE">';
        $config['num_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<div style="text-align: center;background-color:#810c15;width:30px;height:30px;display:inline-block;color:white;margin:1px;border-radius:3px 3px 3px 3px;border:1px solid #EEEEEE">';
        $config['cur_tag_close'] = '</div>';
        $config['prev_link'] = FALSE;
        $config['next_link'] = FALSE;
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        if ($this->input->get('q') != '') {
            $search_value_arr = explode(',', $this->input->get('q'));
            $this->session->set_userdata(array('user-search' => $this->input->get('q')));
            $data = $this->m_user->get_list_user_search($search_value_arr);
            $config["total_rows"] = count($data);
            $this->pagination->initialize($config);
            $data_view["list_user"] = $data_search = $this->m_user->user_search($config["per_page"], $page, $search_value_arr);
            $data_view["links"] = $links = $this->pagination->create_links();
            /* End pagination */
            if ($data_search) {
                $content = $this->load->view($this->path_theme_view . "user_search/index", $data_view, true);
                $header_page = $this->load->view($this->path_theme_view . "user_search/header", $data_view, true);
                $title = NULL;
                $description = NULL;
                $this->master_page($content, $header_page, $title, $description);
            } else {
                $data_view["list_user"] = null;
                $data_view['user_search_session'] = '';
                $content = $this->load->view($this->path_theme_view . "user_search/index", $data_view, true);
                $header_page = $this->load->view($this->path_theme_view . "user_search/header", $data_view, true);
                $title = NULL;
                $description = NULL;
                $this->master_page($content, $header_page, $title, $description);
            }
        } else {
            $search_value_arr = explode(',', $this->session->userdata('user-search'));
            $data = $this->m_user->get_list_user_search($search_value_arr);
            $config["total_rows"] = count($data);
            $this->pagination->initialize($config);
            $data_view["list_user"] = $data_search = $this->m_user->user_search($config["per_page"], $page, $search_value_arr);
            $data_view["links"] = $links = $this->pagination->create_links();
            /* End pagination */
            $content = $this->load->view($this->path_theme_view . "user_search/index", $data_view, true);
            $header_page = $this->load->view($this->path_theme_view . "user_search/header", $data_view, true);
            $title = NULL;
            $description = NULL;
            $this->master_page($content, $header_page, $title, $description);
        }
    }

}
