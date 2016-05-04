<?php

class M_list_video extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_list_video() {
        $this->db->select("*");
        $this->db->from("video_copy");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
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
        $this->db->from("video_copy");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }else{
            return FALSE;
        }
    }
    public function normal_search(){
        
    }
}
