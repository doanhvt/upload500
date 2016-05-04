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
//        $this->load->library('upload');
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
//        $path = './uploads';
//        $files = $_FILES;
//        $total_videos = count($_FILES['userfile']['name']);
        $type = $_FILES['userfile']['type'];
        $data_post = $this->input->post();
//        var_dump($data_post);
//        die();
        $config = $this->__set_upload_options();
        $this->load->library('upload');
        $this->upload->initialize($config);
        if ($this->upload->do_multi_upload("userfile")) {
            $data['upload_data'] = $this->upload->get_multi_upload_data();
            echo '<p class = "bg-success">' . count($data['upload_data']) . 'File(s) successfully uploaded.</p>';
        } else {
            $errors = array('error' => $this->upload->display_errors('<p class = "bg-danger">', '</p>'));
            foreach ($errors as $k => $error) {
                echo $error;
            }
        }


//        $file_path = array();
//        for ($i = 0; $i < $total_videos; ++$i) {
//            $name_video = $_FILES['userfile']['name'] = $files['userfile']['name'] [$i];
//            $_FILES['userfile']['type'] = $files ['userfile']['type'] [$i];
//            $_FILES['userfile']['tmp_name'] = $files ['userfile']['tmp_name'] [$i];
//            $_FILES['userfile']['error'] = $files ['userfile']['error'] [$i];
//            $_FILES['userfile']['size'] = $files['userfile']['size'] [$i];
//
//            $this->upload->initialize($this->__set_upload_options());
//            $this->upload->do_upload('userfile');
//            $file_path[] = base_url("img/$name_video");
//        }
//
//        var_dump($file_path);
//        $temp_video = $this->upload->do_multi_upload("userfile");
//        $this->upload->do_upload ($_FILES['userfile']);
//        echo "<pre>";
//        var_dump($number_of_files);
//        
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
                                    <input type="text" id="datepicker-' . $i . '" class="form-control date" name="study_date"/>
                                    <span class="input-group-addon">
                                        <i class="ace-icon fa fa-calendar"></i>
                                    </span>
                                </div>
                            </td>';
                $select .= "<td>" . $this->time_study($i) . "</td>";
                $select .= "<td>" . $this->class_type($i) . "</td>";
                $select .= "<td></td>";
                $select .= "<td></td>";
                $select .= "<td></td>";
                $select .= "<td></td>";
                $select .= "<td></td>";
                $select .= '<td><input type="hidden" size="10" id="code_v' . $i . '" name="video_code" value="" />'
                        . '<p id="video"><span id="code' . $i . '"></span><span id="time_app_' . $i . '"></span>'
                        . '<span id="class_app_' . $i . '"><span>'
                        . '</p>'
                        . '</td>';
                $select .= "<td></td>";
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
                        $("#code_v' . $i . '").attr("value",val + "_");
                        $("#code_v' . $i . '").attr("val_app",val + "_");
                        $(".time_type_' . $i . '").prop("disabled", false); 
                    });
                    var time_type = "";
                    $(".time_type_' . $i . '").change(function(){
                        var temp = $(this).val();
                        time_type = temp;
                        $("#time_app_' . $i . '").text(temp + "_");
                        var val_code_video = $("#code_v' . $i . '").attr("val_app");
                        var date_time = val_code_video + time_type;  
                        $("#code_v' . $i . '").attr("value",date_time);
                        $("#code_v' . $i . '").attr("val_app_dt",date_time + "_");
                        $(".class_type_' . $i . '").prop("disabled", false);
                        $("#datepicker-' . $i . '").prop("disabled", true);    
                    });
                                        
                    $(".class_type_' . $i . '").change(function(){
                        var cl_type = $(this).val();
                        $("#class_app_' . $i . '").text(cl_type + "_");
                        var val_code_video_1 = $("#code_v' . $i . '").attr("val_app_dt");
                        var date_time_class = val_code_video_1 + cl_type;
                        $("#code_v' . $i . '").attr("value",date_time_class);
                        $(".time_type_' . $i . '").prop("disabled", true);        
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
        $html .= "<select name='time' id='number' class='time_type_$i' disabled='disabled'>";
        $html .= '<option selected="selected">---</option>';
        $time = $this->m_time->get_time();
        if (isset($time)) {
            foreach ($time as $key => $value) {
                $html .= '<option value="' . $value->time . '">' . $value->time . '</option>';
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
        $html_class = "<select name='class' id='number' class='class_type_$i' disabled='disabled'>";
        $html_class .= '<option selected="selected">---</option>';
        if (isset($class)) {
            foreach ($class as $key_class => $value_class) {
                $html_class .= '<option value="' . $value_class->name . '">' . $value_class->name . '</option>';
            }
            $html_class .= '</select>';
            return $html_class;
        } else {
            return FALSE;
        }
    }

}
