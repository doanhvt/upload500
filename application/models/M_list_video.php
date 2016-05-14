<?php

class M_list_video extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function edit_video($id, $data_update) {
        $this->db->where('id', $id);
        $this->db->update('video', $data_update);
    }

    public function get_list_video() {
        $this->db->select("*");
        $this->db->from("video");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function get_one_video($id) {
        $this->db->select("*");
        $this->db->from("video");
        $this->db->where("id", $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return FALSE;
        }
    }

    public function get_list_class() {
        $this->db->select("*");
        $this->db->from("class");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function get_list_time() {
        $this->db->select("*");
        $this->db->from("time");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function fetch_data($limit, $start) {
        $this->db->limit($limit, $start);
        $this->db->select("*");
        $this->db->from("video");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function get_list_normal_search($value) {
        $this->db->select('vc.*');
        $this->db->from('video as vc');
        $this->db->join('user as u', 'vc.user_id = u.id');
        $this->db->where('u.active', 1);
        $this->db->like('u.display_name', $value);
        $this->db->or_like('vc.assistant', $value);
        $this->db->or_like('u.email', $value);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function normal_search($limit, $start, $value) {
        $this->db->select('vc.*');
        $this->db->from('video as vc');
        $this->db->join('user as u', 'vc.user_id = u.id');
        $this->db->where('u.active', 1);
        $this->db->like('u.display_name', $value);
        $this->db->or_like('vc.assistant', $value);
        $this->db->or_like('u.email', $value);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function get_list_advanced_search($value) {
        $this->db->select('*');
        $this->db->from('video');
        $this->db->where('class_id', $value['class_id']);
        $this->db->where('name_teacher', $value['name_teacher']);
        $this->db->where('assistant', $value['asistant']);
        $this->db->where('class_date >=', $value['class_date']);
        $this->db->where('class_date <=', $value['end_date']);
        $this->db->where('time_id', $value['time_id']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function advanced_search($limit, $start, $value) {
        $this->db->select('*');
        $this->db->from('video');
        $this->db->where('class_id', $value['class_id']);
        $this->db->where('name_teacher', $value['name_teacher']);
        $this->db->where('assistant', $value['asistant']);
        $this->db->where('class_date >=', $value['class_date']);
        $this->db->where('class_date <=', $value['end_date']);
        $this->db->where('time_id', $value['time_id']);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

}
