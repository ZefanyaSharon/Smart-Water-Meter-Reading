<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attribute extends MY_Controller {
	public function __construct() {
		parent::__construct();
		authentication_check();
		$this->controller_name = __CLASS__;
		$this->page_title      = 'Master Attribute';
		$this->load->model(['attribute_model']);
		$this->id_menu = '11e929bbd1c38a00a752303430333436';

		$this->data_list =
			[
				['label' => 'Category', 'field' => 'category'],
				['label' => 'Key', 'field' => 'key'],
				['label' => 'Value', 'field' => 'value'],
				['label' => 'Label', 'field' => 'label'],
				['label' => 'Default', 'field' => 'is_default'],
				['label' => 'Position', 'field' => 'position'],
				['label' => 'Description', 'field' => 'description'],
				['label' => 'Url Path', 'field' => 'url_path'],
			];
	}

	public function index() {
		parent::index();
	}

	/**
	 * Digunakan untuk query data list
	 * @return string json
	 */
	public function get_list() {
		$this->db->from('attribute AS atr');
		$this->db->order_by('atr.updated');

		return parent::get_list();
	}

	/**
	 * Digunakan untuk query data detail
	 * @param [in] $id string Primary key dari data yang akan diambil
	 * @return Database result object
	 */
	protected function get_detail($id) {
		$result                   = new stdClass();

		$this->db->from('attribute AS atr');
		$this->db->where('atr.id', $id);
		$t_menu = $this->db->get();
		if ($t_menu->num_rows() > 0) {
			$result = $t_menu->first_row();
		}

		return $result;
	}

	/**
	 * Form CRUD
	 * @return HTML form
	 */
	public function form() {
		$id               = $this->input->get_post('id');
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
			'attribute_model'             => ['id' => 'attribute_id']
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
				'attribute_model' => 'single'
			]);
			$validation = $this->form_validation->run();
		}

		return $validation;
	}

	public function insert() {
		// -- Load semua model yang digunakan, tampung dalam sebuah array --
		$objects = ['attribute_model'];
		$this->load->model($objects);
		parent::_insert($objects, function ($data) {
			// --- Insert Header --
			$identitas_id = $this->attribute_model->insert($data['attribute_model']);

			return $this->db->trans_status();
		});
	}

	public function update() {
		$objects = ['attribute_model'];
		$this->load->model($objects);

		parent::_update($objects, function ($data, $for_delete) {
			// -- Header --
			$identitas_id = $this->attribute_model->update($data['attribute_model']);

			return $this->db->trans_status();
		});
	}

	public function delete() {
		$objects = ['attribute_model'];
		$this->load->model($objects);
		parent::_delete($objects, function ($id, $data) {
			$this->attribute_model->delete($id, $data);
			return $this->db->trans_status();
		});
	}

	public function export($jenis_export) {
		$result = $this->get_list();
		parent::_export($result, $jenis_export, 'attribute');
	}
}
