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


	public function check_login($email) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email', $email);
        $this -> db -> limit(1);
        $result = $this->db->get();
        if ($result->num_rows() == 1) {
            return $result->result();
        } else {
            return FALSE;
        }
    }


}
