<?php

class M_user extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_one_user($id) {
        $this->db->select("*");
        $this->db->from("user");
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return FALSE;
        }
    }

}
