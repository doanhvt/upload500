<?php

/**
 * Description of M_upload
 *
 * @author TUNG-PC
 */
class M_upload extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function add_video($infoVideo = array()) {
        $this->db->insert('video', $infoVideo);
        return $this->db->insert_id();
    }
    
    /**
     * Hàm thêm nhiều row cùng lúc trong 1 câu truy vấn
     * @param   Array   $data   Là MẢNG CÁC MẢNG có cấu trúc tương tự $schema
     * @return  Int     Số row được thêm vào
     */
    function add_muti($data) {
        $this->db->insert_batch($this->_table_name, $data);
        return $this->db->affected_rows();
    }

}
