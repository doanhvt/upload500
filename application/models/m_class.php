<?php

/**
 * Description of m_class
 *
 * @author TUNG-PC
 */
class m_class extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_class() {
        $this->db->select("*");
        $this->db->from('class');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

}
