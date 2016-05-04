<?php

/**
 * Description of time
 *
 * @author TUNG-PC
 */
class m_time extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_time() {
        $this->db->select("id, CONCAT(start, ' - ' , end) as time", false);
        $this->db->from('time');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

}
