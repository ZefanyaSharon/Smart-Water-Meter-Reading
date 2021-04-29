<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends MY_Controller {
	public $form_action;

	public function __construct() {
		parent::__construct();
		authentication_check();
		$this->controller_name = __CLASS__;
		$this->page_title      = 'Management Profile';
		$this->id_menu	        = '11e8ba5ad4317c70a47f313131393530';
		$this->load->model(['ion_auth_model', 'user_model']);
		$this->load->library('Lib_menu');
		$this->UserId     = $this->session->userdata('user_id');
		$this->level      = $this->session->userdata('level');
		$this->Username   = $this->session->userdata('username');
	}

	public function index() {
		$id              = $this->UserId;
		$data_detail     = $this->get_detail($id);
		$form_action     = 'backend/' . $this->controller_name . '/update/?id=' . $id;

		$data = [
			'controller_name' => $this->controller_name,
			'breadcrumbs'     =>$this->lib_menu->generate_breadcrumb($this->id_menu, 'Form'),
			'form_action'     => $form_action,
			'data_detail'     => $data_detail,
			'form_attributes' => [
				'id'     => 'form_' . strtolower($this->controller_name),
				'name'   => 'form_' . strtolower($this->controller_name),
				'method' => 'POST',
			],
			'id' => $id
		];

		if (!empty($this->_addition_display)) {
			$data = array_merge($data, $this->_addition_display);
		}

		$content = $this->load->view($this->layout . '/' . $this->controller_name . '/form', $data, true);
		$this->_load_layout($content);
		// parent::index();
	}

	/**
	 * Digunakan untuk query data detail
	 * @param [in] $id string Primary key dari data yang akan diambil
	 * @return Database result object
	 */
	protected function get_detail($id) {
		$result = new stdClass();

		$this->db->select('usr.*, pen.pengadilan AS nama_pengadilan');
		$this->db->from('users AS usr');
		$this->db->join('pengadilan AS pen', 'pen.id = usr.id_pengadilan', 'LEFT');
		$this->db->where('usr.id', $id);
		$t_user = $this->db->get();
		if ($t_user->num_rows() > 0) {
			$result = $t_user->first_row();
		}

		return $result;
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
		$this->user_model->remove_fields(['username', 'level', 'id_pengadilan', 'active']);
		$this->user_model->modify_rules_fields('password', 'trim|matches[password_confirm]');
		$this->user_model->modify_rules_fields('password_confirm', 'trim');

		if (in_array($action, ['insert', 'update'])) {
			$this->form_validation->set_rules_multiple([
				'user_model' => 'single',
			]);
			$validation = $this->form_validation->run();
		}

		// -- Let's check .... --
		return $validation;
		// return TRUE; // -- You can by pass validation here ..
	}

	public function update() {
		$objects         = ['user_model'];
		$this->load->model($objects);

		parent::_update($objects, function ($data, $for_delete) {
			// -- Header --
			$user_id = $this->user_model->update($data['user_model']);

			return $this->db->trans_status();
		});
	}
}
