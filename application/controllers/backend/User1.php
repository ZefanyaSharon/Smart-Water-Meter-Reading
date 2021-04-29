<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller {
	public function __construct() {
		parent::__construct();
		authentication_check();
		$this->controller_name = __CLASS__;
		$this->page_title      = 'Management User';
		$this->id_menu	        = '11e8d5e61ab3ad70b169313233343530';
		$this->load->model(['ion_auth_model']);

		$this->data_list =
			[
				['label' => 'Username', 'field' => 'username'],
				['label' => 'Nama Depan', 'field' => 'first_name'],
				['label' => 'Nama Belakang', 'field' => 'last_name'],
				['label' => 'Email', 'field' => 'email'],
				['label' => 'Jabatan', 'field' => 'jabatan'],
				['label' => 'Level', 'field' => 'level'],
				['label' => 'Pengadilan', 'field' => 'pengadilan']
			];
	}

	public function index() {
		$this->_addition_display = [];
		parent::index();
	}

	/**
	 * Digunakan untuk query data list
	 * @return string json
	 */
	public function get_list() {
		$this->db->select('u.*');
		// $this->db->select('pdl.pengadilan');
		// $this->db->join('pengadilan AS pdl', 'pdl.id = u.id_pengadilan', 'LEFT');
		$this->db->from('users AS u');
		return parent::get_list();
	}

	/**
	 * Digunakan untuk query data detail
	 * @param [in] $id string Primary key dari data yang akan diambil
	 * @return Database result object
	 */
	protected function get_detail($id) {
		$result = new stdClass();

		$this->db->select('usr.* , pdl.pengadilan');
		$this->db->from('users AS usr');
		$this->db->join('pengadilan AS pdl', 'pdl.id = usr.id_pengadilan', 'LEFT');
		$this->db->where('usr.id', $id);
		$t_user = $this->db->get();
		if ($t_user->num_rows() > 0) {
			$result = $t_user->first_row();
		}

		return $result;
	}

	/**
	 * Form CRUD
	 * @return HTML form
	 */
	public function form() {
		$id = $this->input->get_post('id');

		$this->_addition_display['pengadilan_option'] = $this->pengadilan_model->get()->toDropdownArray('id', 'pengadilan');
		parent::_form();
	}

	public function detail($id) {
		parent::_detail($id);
	}

	/**
	 * Digunakan untuk menentukan nama post yang berbeda dengan nama field
	 * @return Array
	 */
	protected function set_post_field_name() {
		return [
			'user_model' => ['id' => 'user_id'],
		];
	}

	/**
	 * Untuk mengatur validasi inputan user
	 * @param [in]
	 * @return
	 */
	protected function input_validation($action) {
		$validation = true;
		$this->load->helper('Crud');
		if (in_array($action, ['insert', 'update'])) {
			$this->form_validation->set_rules_multiple([
				'user_model' => 'single'
			]);
			$validation = $this->form_validation->run();
		}

		// -- Let's check .... --
		return $validation;
		// return TRUE; // -- You can by pass validation here ..
	}

	public function insert() {
		// -- Load semua model yang digunakan, tampung dalam sebuah array --
		$objects = ['user_model'];
		$this->load->model($objects);
		parent::_insert($objects, function ($data) {
			// -- Using Custom Mode --
			// --- Insert Header --
			$user_id = $this->user_model->insert($data['user_model']);
			return $this->db->trans_status();

			// -- Using Library Mode --
			// $this->load->library('Lib_user');
			// $this->lib_user->insert($data);
			// return $this->db->trans_status();
		});
	}

	public function update() {
		$objects = ['user_model'];
		$this->load->model($objects);
		parent::_update($objects, function ($data, $for_delete) {
			// -- Header --
			$user_id = $this->user_model->update($data['user_model']);

			return $this->db->trans_status();
		});
	}

	public function delete() {
		$objects = ['user_model'];
		$this->load->model($objects);
		parent::_delete($objects, function ($id, $data) {
			$this->user_model->delete($id, $data);
			return $this->db->trans_status();
		});
	}

	public function export($jenis_export) {
		$result = $this->get_list();
		parent::_export($result, $jenis_export, 'pengguna');
	}
}
