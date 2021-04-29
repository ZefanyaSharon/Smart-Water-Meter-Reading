<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login_attempts_model extends MY_Model {

	public $table_name = 'login_attempts';

	public function __construct() {
		$this->validation_fields = [
			['field' => 'id','label' => 'Primary Key','rules' => 'trim'],
			['field' => 'ip_address','label' => 'IP Address','rules' => 'trim'],
			['field' => 'login','label' => 'Login','rules' => 'trim'],
			['field' => 'time','label' => 'Time','rules' => 'trim'],
		];
		parent::__construct();
	}

	/**
	 * Fungsi yang digunakan untuk mengatur formating data yang akan disimpan dalam database
	 * @param [in] $data Array Data yang akan diproses
	 * @return Array
	 */
	public function data_format($data) {
		return parent::data_format($data);
	}
}