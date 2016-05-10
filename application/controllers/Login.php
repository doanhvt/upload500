<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Login extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('m_user');
		$this->load->library('googleplus');
	}

	public function index() {
		// if($this->session->userdata('is_login') == true){
		// 	redirect('');
		// }
		
		$data = Array();
		$code = $this->input->get('code');
		if (isset($code)) {
			$this->googleplus->getAuthenticate();
			$token = $this->googleplus->getAccessToken();
			$infoUser = $this->googleplus->getUserInfo();
			if ($token) {
				$infoUser = $this->googleplus->getUserInfo();
				if(isset($infoUser)){
                    // kiểm tra mail trong trong db hoặc insert thêm 
                    // Nếu tồn tại trong db thì login không thì tài khoản của chưa dk cấp quyền
					if($infoUser['email']){
						$return = $this->m_user->check_login($infoUser['email']);
						if($return){
							$json_data = json_encode($return);
							$this->session->set_userdata('user_profile', $json_data);
							// $this->session->set_userdata('is_login', true);	
							redirect('');	
						}else{
							$this->session->sess_destroy();
							$this->googleplus->revokeToken();
							$this->session->set_flashdata('msg_error', 'Tài khoản của bạn chưa được cấp quyền truy cập hệ thống liên hệ quản trị viên.');
						}
						
					}
					
				}

			}
		}
		$data['login_url'] = $this->googleplus->loginURL();
		$content = $this->load->view($this->path_theme_view . "login/content", $data, true);
		$header_page = NULL; /* Dữ liệu đẩy thêm vào thẻ <head> (css, js, meta property) */
		$this->master_page_blank($content, $header_page);
	}

//    public function profile() {
//        if ($this->session->userdata('login') != true) {
//            redirect('');
//        }
//        $contents['user_profile'] = $this->session->userdata('user_profile');
//        $this->load->view('profile', $contents);
//    }
	protected function require_login() {
		return false;
	}
	protected function check_permission() {
		return true;
	}
	public function logout() {
		$this->session->sess_destroy();
		$this->googleplus->revokeToken();
		redirect('login');
	}

}
