<?php

class M_user extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_list_account() {
        $this->db->select('*');
        $this->db->from('account_type');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function user_search($limit, $start, $search_value) {
        $this->db->limit($limit, $start);
        $this->db->select("u.*,r.name,at.name as account_type_name");
        $this->db->from("user as u");
        $this->db->join("role as r", "u.role_id = r.id");
        $this->db->join("account_type as at", "u.account_type = at.id");
        $this->db->where("u.active", 1);
        $this->db->where_in("email", $search_value);
        $this->db->or_where_in("display_name", $search_value);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function get_list_user_search($data_search) {
        $this->db->select("*");
        $this->db->from("user");
        $this->db->where("active", 1);
        $this->db->where_in("email", $data_search);
        $this->db->or_where_in("display_name", $data_search);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function delete_user($id) {
        $data_update = array(
            'active' => 0
        );
        $this->db->where('id', $id);
        $this->db->update('user', $data_update);
    }

    public function check_duplicate_user($email) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email', $email);
        $this->db->where('active', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function add_user($data) {
        $this->db->insert('user', $data);
    }

    public function edit_user($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('user', $data);
    }

    public function get_list_permission() {
        $this->db->select('*');
        $this->db->from("role");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function get_one_user($id) {
        $this->db->select("u.*,r.name,at.name as account_type_name");
        $this->db->from("user as u");
        $this->db->join("account_type as at", "u.account_type = at.id");
        $this->db->join("role as r", "u.role_id = r.id");
        $this->db->where("u.id", $id);
        $this->db->where("u.active", 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return FALSE;
        }
    }

    public function get_list_user() {
        $this->db->select("*");
        $this->db->from("user");
        $this->db->where("active", 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function get_list_user_limit($limit, $start) {
        $this->db->limit($limit, $start);
        $this->db->select("u.*,r.name,at.name as account_type_name");
        $this->db->from("user as u");
        $this->db->join("account_type as at", "u.account_type = at.id");
        $this->db->join("role as r", "u.role_id = r.id");
        $this->db->where("u.active", 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function check_login($email) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email', $email);
        $this->db->limit(1);
        $result = $this->db->get();
        if ($result->num_rows() == 1) {
            return $result->result();
        } else {
            return FALSE;
        }
    }

    public function get_user_permissions($role_id) {
        $permission = array();
        $this->db->select('*');
        $this->db->from('action');
        $this->db->where('role_id', $role_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $value) {
                $permission[] = $value->name;
            }
            return $permission;
        } else {
            return FALSE;
        }
    }

}
