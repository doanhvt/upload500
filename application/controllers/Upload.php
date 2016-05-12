<?php

/**
 * Description of upload
 *
 * @author TUNG-PC
 */
class Upload extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_time');
        $this->load->model('m_class');
        $this->load->library('upload');
        $this->load->model('m_upload');
        $this->load->library('form_validation');
    }

    public function index() {
        $data = Array();
        $data['ajax_link'] = site_url('upload/do_upload_videos');
        $content = $this->load->view($this->path_theme_view . "upload/index", $data, true);
        $header_page = $this->load->view($this->path_theme_view . "upload/head", $data, true);
        $title = NULL;
        $description = NULL;
        $this->master_page($content, $header_page, $title, $description);
    }

    public function do_upload_videos() {
        $total_videos = count($_FILES['userfile']['name']);
        $data_post = $this->input->post();
        if ($this->input->is_ajax_request() && $data_post) {
            $check_validate = $this->__validate_data($total_videos, $data_post);
            if (!$check_validate) {
                $this->__process_upload($total_videos, $data_post);
            }
        } else {
            redirect();
        }
    }

    private function __process_upload($total_videos, $data_post) {
        $data = array();
        $data_return = array();
        $type = $_FILES['userfile']['name'];
        $files = $_FILES;
        $message = array();
        $error = array();
        $data_result = array();
        $k = 1;
        for ($i = 0; $i < $total_videos; ++$i) {
            $_FILES['userfile']['name'] = $files['userfile']['name'] [$i];
            $_FILES['userfile']['type'] = $files ['userfile']['type'] [$i];
            $_FILES['userfile']['tmp_name'] = $files ['userfile']['tmp_name'] [$i];
            $_FILES['userfile']['error'] = $files ['userfile']['error'] [$i];
            $_FILES['userfile']['size'] = $files['userfile']['size'] [$i];
            $this->upload->initialize($this->__set_upload_options());
            if ($this->upload->do_upload('userfile')) {
                $temp_file = (object) $this->upload->data();
                $file_name = $temp_file->file_name;
                $type_file = $temp_file->file_type;
                // Output data
                $date = date('Y-m-d');
                $data['name'] = $file_name;
                $data['link_video'] = base_url("/uploads/$date/$file_name");
                $data['time_upload'] = date("Y-m-d H:i:s");
                $data['class_date'] = $data_post['date_' . $i];
                $data['time_id'] = $data_post['time_' . $i];
                $data['class_id'] = $data_post['class_' . $i];
                $data['video_code'] = $data_post['video_code_' . $i];
                $data['note'] = $data_post['note_' . $i];
                $data['name_teacher'] = $data_post['name_teacher_' . $i];
                $data['assistant'] = $data_post['assistant_' . $i];
                $data['cameramen'] = $data_post['cameramen_' . $i];
                $data['format_file'] = $type_file;
                $data['user_id'] = $data_post['user_id'];
                $data['des'] = $data_post['des_' . $i];
                $data['note'] = $data_post['note_' . $i];
                $data['status_upload'] = 1;
                // Insert data for current file
                $message['message'][$i]['video ' . $k] = $this->m_upload->add_video($data);
                // Message thông báo
                $data_return = array(
                    'status' => TRUE,
                    'msg' => $message['message'][$i]
                );
            } else {
                $error[$i]['error' . $i] = $this->upload->display_errors();
                $data_return = array(
                    'status' => FALSE,
                    'msg' => $error[$i]
                );
            }
            $k++;
            $data_result[] = $data_return;
        }
        echo json_encode($data_result);
    }

    private function __set_upload_options() {
        $date = date('Y-m-d');
        $config = array();
        $config ['upload_path'] = './uploads';
        $config ['allowed_types'] = 'mp4|wmv';
        $config['overwrite'] = FALSE;
        $config['remove_spaces'] = TRUE;
        $config['encrypt_name'] = TRUE;
        if (!is_dir('./uploads/' . $date . '/')) {
            mkdir('./uploads/' . $date . '/', 0777, true);
        }
        $config['upload_path'] = './uploads/' . $date;
        return $config;
    }

    private function __validate_data($total_vid, $data_post) {
        $data_error['error'] = array();
        $m = 1;
        for ($j = 0; $j < $total_vid; ++$j) {
            $this->form_validation->set_rules('date_' . $j, 'studying date of video "' . $m . '"', 'trim|required|xss_clean');
            $this->form_validation->set_rules('time_' . $j, 'studying time of video "' . $m . '"', 'trim|required|xss_clean');
            $this->form_validation->set_rules('class_' . $j, 'class type of video "' . $m . '"', 'trim|required|xss_clean');
            $this->form_validation->set_rules('video_code_' . $j, 'Code video of video "' . $m . '"', 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                $data_error['error']['date_' . $j] = form_error('date_' . $j . '');
                $data_error['error']['time_' . $j] = form_error('time_' . $j . '');
                $data_error['error']['class_' . $j] = form_error('class_' . $j . '');
                $data_error['error']['video_code_' . $j] = form_error('video_code_' . $j . '');
            }
            $m++;
        }
        if (count($data_error['error']) > 0) {
            echo json_encode($data_error);
            exit();
        }
    }

    public function check_data() {
        /* Dữ liệu giả lập */
//        $this->load->model('m_user');
//        $return = $this->m_user->check_login('tungnd@topica.edu.vn');
//
//        $json_data = json_encode($return);
//        $this->session->set_userdata('user_profile', $json_data);



       $number_file = $this->input->post('number');
        /* end */


        $user_profile = json_decode($this->session->userdata('user_profile'));
        $name = isset($user_profile) ? $user_profile[0]->email : "";
        $userID = isset($user_profile) ? $user_profile[0]->id : "";
        $account_type = isset($user_profile) ? $user_profile[0]->account_type : "";
        $id_name = substr($name, 0, strpos($name, "@"));
        $name_teacher = "";
        $assistant = "";
        $cameramen = "";
        $readonly_tea = "";
        $readonly_ass = "";
        $readonly_came = "";
        switch ($account_type) {
            case 1 :
                $name_teacher = $id_name;
                $readonly_tea = 'readonly';
                break;
            case 2 :
                $assistant = $id_name;
                $readonly_ass = 'readonly';
                break;
            case 3 :
                $cameramen = $id_name;
                $readonly_came = 'readonly';
                break;
        }
        $data_return = array();
        if (isset($number_file)) {
            $select = "";
            $datepicker = "";
            $j = 1;
            for ($i = 0; $i < $number_file; ++$i) {
                $select .= "<tr>";
                $select .= "<td class='text-center' style='line-height: 55px;'> video " . $j . "</td>";
                $select .= '<td style="width: 10%;" id="date' . $i . '">
                                <div class="input-group input-group-sm" style="padding-top: 6px;">
                                    <input type="text" id="datepicker-' . $i . '" class="form-control date" name="date_' . $i . '"/>
                                    <span class="input-group-addon">
                                        <i class="ace-icon fa fa-calendar"></i>
                                    </span>
                                </div>
                            </td>';
                $select .= "<td>" . $this->time_study($i) . "</td>";
                $select .= "<td>" . $this->class_type($i, $account_type) . "</td>";
                $select .= '<td><input type="text" size="5" id="name_teacher_' . $i . '" name="name_teacher_' . $i . '" class="input_v" value="' . $name_teacher . '" ' . $readonly_tea . '></td>';
                $select .= '<td><input type="text" size="5" id="assistant_' . $i . '" name="assistant_' . $i . '" class="input_v" value="' . $assistant . '" ' . $readonly_ass . '></td>';
                $select .= '<td><input type="text" size="5" id="cameramen_' . $i . '" name="cameramen_' . $i . '" class="input_v" value="' . $cameramen . '" ' . $readonly_came . '></td></td>';
                $select .= '<td><input type="text" size="5" id="des_' . $i . '" name="des_' . $i . '" class="input_v"></td>';
                $select .= '<td><textarea rows="2" id="note" name="note_' . $i . '" role="textbox" multiline="true" class="editable"></textarea></td>';
                $select .= '<td><input type="hidden" size="10" id="code_v' . $i . '" name="video_code_' . $i . '" value="" />'
                        . '<p id="video"><span id="code' . $i . '"></span><span id="time_app_' . $i . '"></span>'
                        . '<span id="class_app_' . $i . '"></span>'
                        . '<span id="name_teacher_app_' . $i . '"></span>'
                        . '<span id="name_ass_app_' . $i . '"></span>'
                        . '</p>'
                        . '</td>';
                $select .= '<td><input type="hidden" name="user_id" value="' . $userID . '"/>'
                        . '<p id="email"><span>' . $name . '</span></p>'
                        . '</td>';
                $select .= '<td class="center">
                                <span style="color: #33CC33;font-size: 16px;line-height: 55px;" id="success_' . $i . '">
                                </span>
                                <span style="color: #810c15;font-size: 16px;line-height: 55px;" id="error_' . $i . '">
                                </span>
                            </td>';
                $select .= "</tr>";
                $datepicker .= '<script type="text/javascript">
                    jQuery(function ($) {
                        $("#datepicker-' . $i . '").datepicker({
                            format: "dd/mm/yyyy",
                            showOtherMonths: true,
                            selectOtherMonths: false,
                            autoclose: true,
                            todayHighlight: true,
                        });
                    });
                    $("#datepicker-' . $i . '").change(function() {
                        var val = $(this).val();
                        val = val.replace("/", "");
                        val = val.replace("/", "");
                        $("#code' . $i . '").text(val + "_");
                        var date = $("#code' . $i . '").text();
                        var time = $("#time_app_' . $i . '").text();
                        var cl = $("#class_app_' . $i . '").text(); 
                        var name_t = $("#name_teacher_app_' . $i . '").text(); 
                        var name_ass = $("#name_ass_app_' . $i . '").text(); 
                        var tem = date + time + cl + name_t + name_ass;  
                        $("#code_v' . $i . '").attr("value",tem);    
                        $(".time_type_' . $i . '").prop("disabled", false);    
                    });
                    
                    $(".time_type_' . $i . '").change(function(){
                        var temp = $("option:selected", this).attr("data_time");
                        time_type = temp;
                        $("#time_app_' . $i . '").text(temp + "_");
                        var date = $("#code' . $i . '").text();
                        var time = $("#time_app_' . $i . '").text();
                        var cl = $("#class_app_' . $i . '").text(); 
                        var name_t = $("#name_teacher_app_' . $i . '").text(); 
                        var name_ass = $("#name_ass_app_' . $i . '").text(); 
                        var tem = date + time + cl + name_t + name_ass;
                        $("#code_v' . $i . '").attr("value",tem);  
                        $(".class_type_' . $i . '").prop("disabled", false);    
                    });
                                        
                    $(".class_type_' . $i . '").change(function(){
                        var cl_type = $("option:selected", this).attr("data_class");
                        $("#class_app_' . $i . '").text(cl_type + "_");
                        var date = $("#code' . $i . '").text();
                        var time = $("#time_app_' . $i . '").text();
                        var cl = $("#class_app_' . $i . '").text(); 
                        var name_t = $("#name_teacher_app_' . $i . '").text(); 
                        var name_ass = $("#name_ass_app_' . $i . '").text(); 
                        var tem = date + time + cl + name_t + name_ass;
                        $("#code_v' . $i . '").attr("value",tem); 
                        $("#code_v' . $i . '").attr("value",date_time_class);
                    });
                    
                    var data_ass = $("#assistant_' . $i . '").val();   
                    var data_teacher = $("#name_teacher_' . $i . '").val();
                    if(data_ass != ""){
                        $("#name_ass_app_' . $i . '").text("_" + data_ass);
                    } 
                    if(data_teacher != ""){
                        $("#name_teacher_app_' . $i . '").text(data_teacher);
                    } 
                    $("#name_teacher_' . $i . '").keyup(function(){
                        $("#name_teacher_app_' . $i . '").text(this.value);
                        var date = $("#code' . $i . '").text();
                        var time = $("#time_app_' . $i . '").text();
                        var cl = $("#class_app_' . $i . '").text(); 
                        var name_t = $("#name_teacher_app_' . $i . '").text(); 
                        var name_ass = $("#name_ass_app_' . $i . '").text(); 
                        var tem = date + time + cl + name_t + name_ass; 
                        $("#code_v' . $i . '").attr("value",tem); 
                    });
                    $("#assistant_' . $i . '").keyup(function(){
                        $("#name_ass_app_' . $i . '").text("_" + this.value);
                        var date = $("#code' . $i . '").text();
                        var time = $("#time_app_' . $i . '").text();
                        var cl = $("#class_app_' . $i . '").text(); 
                        var name_t = $("#name_teacher_app_' . $i . '").text(); 
                        var name_ass = $("#name_ass_app_' . $i . '").text(); 
                        var tem = date + time + cl + name_t + name_ass;
                        $("#code_v' . $i . '").attr("value",tem); 
                    });
                    </script>';
                $j++;
            }

            $data_return = array(
                'status' => TRUE,
                'msg' => 'Thành công',
                'data' => $select,
                'js' => $datepicker
            );
        } else {
            $data_return = array(
                'status' => FALSE,
                'msg' => 'Thất bại',
            );
        }

        echo json_encode($data_return);
    }

    public function time_study($i) {
        $html = "";
        $html .= "<select name='time_$i' id='number' class='time_type_$i' disabled>";
        $html .= '<option value="">---</option>';
        $time = $this->m_time->get_time();
        if (isset($time)) {
            foreach ($time as $key => $value) {
                $html .= '<option value="' . $value->id . '" data_time="' . $value->time . '">' . $value->time . '</option>';
            }
            $html .= '</select>';
            return $html;
        } else {
            return FALSE;
        }
    }

    public function class_type($i, $account_type) {
        $class = $this->m_class->get_class();
        $html_class = "";
        $html_class = "<select name='class_$i' id='number' class='class_type_$i' disabled>";
        $html_class .= '<option value="">---</option>';
        if (isset($class)) {
            switch ($account_type) {
                case 1 :
                    $html_class .= '<option value="2" data_class="SC basic">SC basic</option>'
                            . '<option value="3" data_class="SC inter">SC inter</option>'
                            . '<option value="4" data_class="SB">SB</option>';
                    break;
                case 2 :
                    $html_class .= '<option value="1" data_class="LS basic">LS basic</option>';
                    break;
                case 3 :
                    foreach ($class as $key_class => $value_class) {
                        $html_class .= '<option value="' . $value_class->id . '" data_class="' . $value_class->name . '">' . $value_class->name . '</option>';
                    }
                    break;
            }
            $html_class .= '</select>';
            return $html_class;
        } else {
            return FALSE;
        }
    }

}
