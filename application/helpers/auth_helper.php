<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Determine who you are
* @param [in]
* @return
*/
if ( ! function_exists('authentication_check')) {
	function authentication_check() {
		$CI =&get_instance();
		$CI->load->library('ion_auth');
		if ($CI->ion_auth->logged_in() == false) {
			$CI->session->set_flashdata('message', 'Authentication failed');
			redirect('auth/login', 'refresh');
		}
	}
}

/**
 * ACL Check
* @param [in]
* @return
*/
if ( ! function_exists('authorization_check')) {
	function authorization_check($aco, $aro, $username = '') {
		return true;
		$CI        =&get_instance();
		if ($CI->input->is_cli_request()) {
			$v_check = $this->acl->checkAclDefault($aco, $username, $aro);
			if (empty($v_check)) {
				die('Pengguna ini tidak memiliki hak akses untuk halaman ini');
			}
		} else {
			$v_check   = $CI->session->userdata($aco . '_' . $aro);

			if (empty($v_check)) {
				set_message('warning', 'Pengguna ini tidak memiliki hak akses untuk halaman ini');
				redirect('backend/home');
			}
		}
	}
}
