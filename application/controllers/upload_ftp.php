<?php

/**
 * Description of upload_ftp
 *
 * @author TUNG-PC
 */
class upload_ftp extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data = Array();
        $data['ajax_link'] = site_url('upload_ftp/do_upload_videos');

        $content = $this->load->view($this->path_theme_view . "upload/index_ftp", $data, true);
        $header_page = $this->load->view($this->path_theme_view . "upload/head", $data, true);
        $title = NULL;
        $description = NULL;
        $this->master_page($content, $header_page, $title, $description);
    }

    public function do_upload_videos() {

        $config['upload_path'] = './uploads';
        $config['allowed_types'] = '*';
        $this->load->library('upload', $config);

        $this->load->library('ftp');

//        if ($this->upload->do_upload('book_file')) {
//            //Get uploaded file information
//            $upload_data = $this->upload->data();
//            $fileName = $upload_data['file_name'];
//
//            //File path at local server
//            $source = 'uploads/2016-05-13/' . $fileName;
//
//            //Load codeigniter FTP class
//            $this->load->library('ftp');
//
//            //FTP configuration
//            $ftp_config['hostname'] = '127.0.0.1';
//            $ftp_config['username'] = 'root';
//            $ftp_config['password'] = '';
//            $ftp_config['debug'] = TRUE;
//
//            //Connect to the remote server
//            $this->ftp->connect($ftp_config);
//
//            //File upload path of remote server
//            $destination = '/uploads/2016-05-13/' . $fileName;
//
//            //Upload file to the remote server
//            $this->ftp->upload($source, "." . $destination);
//
//            //Close FTP connection
//            $this->ftp->close();
//
//            //Delete file from local server
//            @unlink($source);
//        }
        //
        $config['hostname'] = '123.30.171.66';
        $config['username'] = 'dev_nativevideo';
        $config['password'] = 'topica@123';
        $config['port'] = 21;
        $config['passive']  = FALSE;
        $config['debug'] = TRUE;

        $this->ftp->connect($config);
        $file = $_FILES["book_file"]["name"];
//        $this->ftp->upload($_FILES['book_file']['tmp_name'], "uploads/2016-05-13/" . $_FILES['book_file']['name'], "ascii", 0775);
//        $this->ftp->upload($file, './uploads', 'ascii', 0775);
//        $this->ftp->upload('/local/path/to/myfile.html', '/public_html/myfile.html', 'ascii', 0775);
        $this->ftp->close();
    }

}
