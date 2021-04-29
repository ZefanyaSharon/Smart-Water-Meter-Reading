<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class User_model extends MY_Model {
	public $table_name = 'users';

	public function __construct() {
		$this->validation_fields = [
			['field' => 'id', 'label' => 'Primary Key', 'rules' => 'trim'],
			['field' => 'username', 'label' => 'Username', 'rules' => 'trim|required'],
			['field' => 'password', 'label' => '', 'rules' => 'trim|required|matches[password_confirm]'],
			['field' => 'password_confirm', 'label' => 'Konfirmasi', 'rules' => 'trim|required'],
			['field' => 'email', 'label' => 'Email', 'rules' => 'trim|required'],
			['field' => 'level', 'label' => 'Level', 'rules' => 'trim|required'],
			['field' => 'id_pengadilan', 'label' => 'Pengadilan', 'rules' => 'trim'],
			['field' => 'jabatan', 'label' => 'Jabatan', 'rules' => 'trim'],
			['field' => 'deskripsi', 'label' => 'Keterangan', 'rules' => 'trim'],
			['field' => 'first_name', 'label' => 'Nama Depan', 'rules' => 'trim|required'],
			['field' => 'last_name', 'label' => 'Nama Belakang', 'rules' => 'trim|required'],
			['field' => 'phone', 'label' => 'No Telepon', 'rules' => 'trim'],
		];
		$this->calculated_fields = [
			['field' => 'remember_selector', 'label' => '', 'rules' => 'trim'],
			['field' => 'remember_code', 'label' => '', 'rules' => 'trim'],
			['field' => 'ip_address', 'label' => 'Nama', 'rules' => 'trim'],
			['field' => 'activation_selector', 'label' => '', 'rules' => 'trim'],
			['field' => 'activation_code', 'label' => '', 'rules' => 'trim'],
			['field' => 'forgotten_password_selector', 'label' => '', 'rules' => 'trim'],
			['field' => 'forgotten_password_code', 'label' => '', 'rules' => 'trim'],
			['field' => 'forgotten_password_time', 'label' => '', 'rules' => 'trim'],
			['field' => 'created_on', 'label' => '', 'rules' => 'trim'],
		];
		parent::__construct();
	}

	/**
	 * Fungsi yang digunakan untuk mengatur formating data yang akan disimpan dalam database
	 * @param [in] $data Array Data yang akan diproses
	 * @return Array
	 */
	public function data_format($data) {
		// $data['nama'] = strtoupper($data['nama']);
		$data['password'] = $this->ion_auth_model->hash_password($data['password']);
		if (isset($data['active'])) {
			$data['active'] = empty($data['active']) ? 0 : 1;
		}

		if(empty($data['password'])){
			unset($data['password']);
		}

		unset($data['password_confirm']);
		return parent::data_format($data);
	}
	function get_list(){
		$query=$this->db->query('SELECT * FROM users');
		return $query->result();
	}
	function deletes($id_pengadilan)
  {
    $this->db->where('id_pengadilan', $id_pengadilan);
    $this->db->delete('users');
  }
  Function cari($keyword){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->like('username',$keyword);
		$this->db->or_like('jabatan',$keyword);
		$result=$this->db->get()->result();

		return $result;
  }
}
