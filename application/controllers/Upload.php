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
        $data['ajax_link_class'] = site_url('upload/add_info');
        $content = $this->load->view($this->path_theme_view . "upload/index", $data, true);
        $header_page = $this->load->view($this->path_theme_view . "upload/head", $data, true);
        $title = NULL;
        $description = NULL;
        $this->master_page($content, $header_page, $title, $description);
    }

    public function add_info() {
        $data_type_class = $this->input->post('number_class');
        $user_profile = json_decode($this->session->userdata('user_profile'));
        $name = isset($user_profile) ? $user_profile[0]->email : "";
        $id_name = substr($name, 0, strpos($name, "@"));
        $data_return = array();
        if ($data_type_class) {
            switch ($data_type_class) {
                case 1 :
                    $data_return = array(
                        'id' => 1,
                        'name' => $id_name,
                        'readonly' => 'readonly'
                    );
                    break;
                case 2 :
                    $data_return = array(
                        'id' => 2,
                        'name' => $id_name,
                        'readonly' => 'readonly'
                    );
                    break;
                case 3 :
                    $data_return = array(
                        'id' => 3,
                        'name' => $id_name,
                        'readonly' => 'readonly'
                    );
                    break;
                case 4 :
                    $data_return = array(
                        'id' => 4,
                        'name' => $id_name,
                        'readonly' => 'readonly'
                    );
                    break;
            }
            echo json_encode($data_return);
        }
    }

    public function get_disks() {
        if (php_uname('s') == 'Windows NT') {
            // windows 
            $disks = `fsutil fsinfo drives`;
            $disks = str_word_count($disks, 1);
            if ($disks[0] != 'Drives')
                return '';
            unset($disks[0]);
            foreach ($disks as $key => $disk)
                $disks[$key] = $disk . ':\\';
            return $disks;
        }else {
            // unix 
            $data = `mount`;
            $data = explode(' ', $data);
            $disks = array();
            foreach ($data as $token)
                if (substr($token, 0, 5) == '/dev/')
                    $disks[] = $token;
            return $disks;
        }
    }

    public function check_freeg_disks() {
        
    }

    public function do_upload_videos() {
        $data_post = $this->input->post('form');
        $id = (int) $this->input->post('id');
        $sizeFile = (float) $_FILES['userfile']['size'];
//        var_dump($sizeFile);
//        $convertgb = number_format($sizeFile / (1024 * 1024), 3); /* - convert zise to GB -- */
        $memoryDisk = $this->get_disks();
        $current_disk_default = 'C:\\';
        $free = @disk_free_space('C:\\');
        $next_full_disk = "";
        foreach ($memoryDisk as $key => $value) {
            if ($value == $current_disk_default) {
                if ($sizeFile > $free) {
                    continue;
                }
                $next_full_disk = $value;
            }
            // Xử lý full ổ cứng
        }

//        $s = is_dir($next_full_disk . '/Users');

        if ($this->input->is_ajax_request() && $data_post) {
            $this->__process_upload($data_post, $id);
        } else {
            redirect();
        }
    }

    private function __process_upload($data_post, $id) {
        $user_profile_uc = json_decode($this->session->userdata('user_profile'));
        if ($user_profile_uc) {
            $name_uc = isset($user_profile_uc) ? $user_profile_uc[0]->email : "";
        }
        parse_str($data_post, $output_data);
        $data_return = array();
        $this->upload->initialize($this->__set_upload_options());
        if ($this->upload->do_upload('userfile')) {
            $temp_file = (object) $this->upload->data();
            $file_name = $temp_file->file_name;
            $type_file = $temp_file->file_ext;
            $date = date('Y-m-d');
            $data['name'] = $file_name;
            $data['link_video'] = base_url("/uploads/$date/$name_uc/$file_name");
            $data['time_upload'] = date("Y-m-d H:i:s");
            $data['class_date'] = $output_data['date_' . $id];
            $data['time_id'] = $output_data['time_' . $id];
            $data['class_id'] = $output_data['class_' . $id];
            $data['video_code'] = $output_data['video_code_' . $id];
            $data['note'] = $output_data['note_' . $id];
            $data['name_teacher'] = $output_data['name_teacher_' . $id];
            $data['assistant'] = $output_data['assistant_' . $id];
            $data['cameramen'] = $output_data['cameramen_' . $id];
            $data['format_file'] = $type_file;
            $data['user_id'] = $output_data['user_id'];
            $data['des'] = $output_data['des_' . $id];
            $data['note'] = $output_data['note_' . $id];
            $data['status_upload'] = 1;

            $this->m_upload->add_video($data);
            $data_return = array(
                'status' => TRUE,
                'msg' => 'successful',
                'id' => $id
            );
        } else {
            $error = $this->upload->display_errors();
            $data_return = array(
                'status' => FALSE,
                'msg' => $error,
                'id' => $id
            );
        }
        echo json_encode($data_return);
    }

    private function __set_upload_options() {
        $date = date('Y-m-d');
        $config = array();
//        $config ['upload_path'] = './uploads';
        $config ['allowed_types'] = '*';
        $config['overwrite'] = FALSE;
        $config['remove_spaces'] = TRUE;
        $config['encrypt_name'] = TRUE;
        $user_profile_u = json_decode($this->session->userdata('user_profile'));
        if ($user_profile_u) {
            $name_u = isset($user_profile_u) ? $user_profile_u[0]->email : "";
            if (!is_dir('./uploads/' . $date . '/' . $name_u)) {
                mkdir('./uploads/' . $date . '/' . $name_u, 0777, true);
            }
        }
        $config['upload_path'] = './uploads/' . $date . '/' . $name_u;
//        $config ['upload_path'] = $next_full_disk . '/uploads/' . $date . '/' . $name_u;

        return $config;
    }

    public function check_data() {
        /* Dữ liệu giả lập */
        $this->load->model('m_user');
        $return = $this->m_user->check_login('tungnd@topica.edu.vn');
        $json_data = json_encode($return);
        $this->session->set_userdata('user_profile', $json_data);

        $number_file = $this->input->post('number');
        /* end */


        $user_profile = json_decode($this->session->userdata('user_profile'));
        $name = isset($user_profile) ? $user_profile[0]->email : "";
        $userID = isset($user_profile) ? $user_profile[0]->id : "";
        $account_type = isset($user_profile) ? $user_profile[0]->account_type : "";
        $id_name = substr($name, 0, strpos($name, "@"));
        $data_return = array();
        if (isset($number_file)) {
            $select = "";
            $datepicker = "";
            $j = 1;
            for ($i = 0; $i < $number_file; ++$i) {
                $select .= '<tr>';
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
                $select .= '<td><input type="text" size="5" id="name_teacher_' . $i . '" name="name_teacher_' . $i . '" class="input_v" value=""></td>';
                $select .= '<td><input type="text" size="5" id="assistant_' . $i . '" name="assistant_' . $i . '" class="input_v" value=""></td>';
                $select .= '<td><input type="text" size="5" id="cameramen_' . $i . '" name="cameramen_' . $i . '" class="input_v" value=""></td></td>';
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
                            format: "yyyy-mm-dd",
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
                        var cls = $("option:selected", this).val();
                        var url_class = $("#url_class_type").attr("data_url_class");    
                        var data = {
                                    "number_class" : cls
                                };
                        var success = function (result) {
                            if(result.id == 1){
                                $("#assistant_' . $i . '").attr("readonly", true);;
                                $("#name_teacher_' . $i . '").attr("readonly", false);;    
                                // remove value of input GV
                                $("#name_teacher_' . $i . '").attr("value" ,"").focus().val(""); 
                                $("#name_teacher_app_' . $i . '").empty(); 
                                $("#assistant_' . $i . '").focus().val(result.name);     
                                // End 
                                
                                // Add id = video de hien thi ma video
                                $("#assistant_' . $i . '").attr("value" ,result.name);
                                $("#name_ass_app_' . $i . '").text("_" + result.name);    
                                // End 
                                
                                // Add vao value input code video
                                var date = $("#code' . $i . '").text();
                                var time = $("#time_app_' . $i . '").text();
                                var cl = $("#class_app_' . $i . '").text(); 
                                var name_t = $("#name_teacher_app_' . $i . '").text(); 
                                var name_ass = $("#name_ass_app_' . $i . '").text();     
                                var tem = date + time + cl + name_t + name_ass; 
                                $("#code_v' . $i . '").attr("value",tem);
                                // End
                               
                            }else{
                                $("#name_teacher_' . $i . '").attr("readonly", true);
                                $("#assistant_' . $i . '").attr("readonly", false);    
                                // remove value of input Tro Giang
                                $("#assistant_' . $i . '").attr("value" ,"").val(""); 
                                $("#name_ass_app_' . $i . '").empty(); 
                                $("#name_teacher_' . $i . '").focus().val(result.name);
                                // End
                                
                                // Add id = video de hien thi ma video
                                $("#name_teacher_' . $i . '").attr("value" ,result.name); 
                                $("#name_teacher_app_' . $i . '").text(result.name);
                                // End 
                                
                                // Add vao value input code video
                                var date = $("#code' . $i . '").text();
                                var time = $("#time_app_' . $i . '").text();
                                var cl = $("#class_app_' . $i . '").text(); 
                                var name_t = $("#name_teacher_app_' . $i . '").text(); 
                                var name_ass = $("#name_ass_app_' . $i . '").text();     
                                var tem = date + time + cl + name_t + name_ass;    
                                $("#code_v' . $i . '").attr("value",tem);
                                // End
                                
                            }
                        };
                        var dataType = "json";
                        $.post(url_class, data, success, dataType);
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
        $html .= '<option value="0">---</option>';
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
        if (isset($class)) {
            $html_class .= '<option value="0">---</option>';
            foreach ($class as $key_class => $value_class) {
                $html_class .= '<option value="' . $value_class->id . '" data_class="' . $value_class->name . '">' . $value_class->name . '</option>';
            }

            $html_class .= '</select>';
            return $html_class;
        } else {
            return FALSE;
        }
    }

}
