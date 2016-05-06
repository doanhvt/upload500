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
//        $this->load->library('form_validation');
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
        $files = $_FILES;
        $total_videos = count($_FILES['userfile']['name']);
        $type = $_FILES['userfile']['name'];
        $data_post = $this->input->post();

        // validate info input $data_post
        $data = array();
        $data_return = array();
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
                $data['name'] = $file_name;
                $data['link_video'] = base_url("uploads/$file_name");
                $data['time_upload'] = date("Y-m-d H:i:s");
                $data['class_date'] = $data_post['date_' . $i];
                $data['time_id'] = $data_post['time_' . $i];
                $data['class_id'] = $data_post['class_' . $i];
                $data['video_code'] = $data_post['video_code_' . $i];
                $data['format_file'] = $type_file;
                $data['status_upload'] = '1';
                // Insert data for current file
                $message[$i]['success_' . $i] = $this->m_upload->add_video($data);
                // Message thông báo
                $data_return = array(
                    'status' => TRUE,
                    'msg' => $message[$i]
                );
                
            } else {
                $error[$i]['error' . $i] = $this->upload->display_errors();
                $data_return = array(
                    'status' => FALSE,
                    'msg' => $error[$i]
                );
            }
        }
        echo json_encode($data_return);
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

    public function check_data() {
        $number_file = $this->input->post('number');
        $user_profile = json_decode($this->session->userdata('user_profile'));
//        $name = isset($user_profile) ? $user_profile[0]->email : "";
        $userID = isset($user_profile) ? $user_profile[0]->id : "";
        $name = 'tungnd@topica.edu.vn';
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
                $select .= "<td>" . $this->class_type($i) . "</td>";
                $select .= '<td><input type="text" size="5" id="name_teacher" name="name_teacher" class="input_v"></td>';
                $select .= '<td><input type="text" size="5" id="assistant" name="assistant" class="input_v"></td>';
                $select .= '<td><input type="text" size="5" id="cameramen" name="cameramen" class="input_v"></td></td>';
                $select .= "<td></td>";
                $select .= '<td><textarea rows="2" id="note" name="note" role="textbox" multiline="true" class="editable"></textarea></td>';
                $select .= '<td><input type="hidden" size="10" id="code_v' . $i . '" name="video_code_' . $i . '" value="" />'
                        . '<p id="video"><span id="code' . $i . '"></span><span id="time_app_' . $i . '"></span>'
                        . '<span id="class_app_' . $i . '"><span>'
                        . '</p>'
                        . '</td>';
                $select .= '<td><input type="hidden" name="userid' . $i . '" value="' . $userID . '"/>'
                        . '<p id="email"><span>' . $name . '</span></p>'
                        . '</td>';
                $select .= "<td class='center'>
                                
                            </td>";
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
                        var tem = date + time + cl;    
                        $("#code_v' . $i . '").attr("value",tem);    
                        $(".time_type_' . $i . '").prop("disabled", false);    
                    });
                    
                    $(".time_type_' . $i . '").change(function(){
                        var temp = $(this).val();
                        time_type = temp;
                        $("#time_app_' . $i . '").text(temp + "_");
                        var date = $("#code' . $i . '").text();
                        var time = $("#time_app_' . $i . '").text();
                        var cl = $("#class_app_' . $i . '").text(); 
                        var tem = date + time + cl;
                        $("#code_v' . $i . '").attr("value",tem);  
                        $(".class_type_' . $i . '").prop("disabled", false);    
                    });
                                        
                    $(".class_type_' . $i . '").change(function(){
                        var cl_type = $(this).val();
                        $("#class_app_' . $i . '").text(cl_type + "_");
                        var date = $("#code' . $i . '").text();
                        var time = $("#time_app_' . $i . '").text();
                        var cl = $("#class_app_' . $i . '").text(); 
                        var tem = date + time + cl;
                        $("#code_v' . $i . '").attr("value",tem); 
                        $("#code_v' . $i . '").attr("value",date_time_class);
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
        $html .= '<option selected="selected">---</option>';
        $time = $this->m_time->get_time();
        if (isset($time)) {
            foreach ($time as $key => $value) {
                $html .= '<option value="' . $value->id . '">' . $value->time . '</option>';
            }
            $html .= '</select>';
            return $html;
        } else {
            return FALSE;
        }
    }

    public function class_type($i) {
        $class = $this->m_class->get_class();
        $html_class = "";
        $html_class = "<select name='class_$i' id='number' class='class_type_$i' disabled>";
        $html_class .= '<option selected="selected">---</option>';
        if (isset($class)) {
            foreach ($class as $key_class => $value_class) {
                $html_class .= '<option value="' . $value_class->id . '">' . $value_class->name . '</option>';
            }
            $html_class .= '</select>';
            return $html_class;
        } else {
            return FALSE;
        }
    }

}
