<?php

/**
 * Description of detect
 *
 * @author TUNG-PC
 */
class detect extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $dir = 'C:';
//        var_dump(is_dir($dir));

        $free = disk_free_space($dir);
        $total = disk_total_space($dir);
        $free_to_mbs = $free / (1024 * 1024 * 1024);
        $total_to_mbs = $total / (1024 * 1024 * 1024);

        echo 'You have ' . $free_to_mbs . ' MBs from ' . $total_to_mbs . ' total MBs';


        print_r($this->get_disks());
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

}

//disk_total_space("/"); 
//Gigabyte = Byte/(1024*1024*1024)
//http://php.net/manual/en/function.disk-free-space.php
//http://php.net/disk-total-space