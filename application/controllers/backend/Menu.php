<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends MY_Controller {
	public function __construct() {
		parent::__construct();
		authentication_check();
		$this->controller_name = __CLASS__;
		$this->page_title      = 'Management Menu';
		$this->load->model('menu_model');
		$this->load->library('Lib_menu');
		$this->load->library('not/Acl');
		$this->id_menu   = '1';
		$this->sUsername = $this->session->userdata('username');
		$this->aco_name  = 'content';

		$this->data_list =
			[
				['label' => 'ID', 'field' => 'id'],
				['label' => 'Nama Menu', 'field' => 'nama'],
				['label' => 'Parent', 'field' => 'nama_parent'],
				['label' => 'Sequence', 'field' => 'sequence'],
				['label' => 'URL', 'field' => 'url'],
				['label' => 'Icon', 'field' => 'nama_icon']
			];
	}

	public function index() {
		authorization_check($this->aco_name, 'view');
		$this->_addition_display = [];
		parent::index();
	}

	/**
	 * Digunakan untuk query data list
	 * @return string json
	 */
	public function get_list() {
		$this->db->select('mnu.*, icon.nama AS nama_icon, mnu_parent.nama AS nama_parent');
		$this->db->from('menu AS mnu');
		$this->db->join('icon AS icon', 'icon.id = mnu.id_icon', 'LEFT');
		$this->db->join('menu AS mnu_parent', 'mnu_parent.id = mnu.parent_id', 'LEFT');

		return parent::get_list();
	}

	/**
	 * Digunakan untuk query data detail
	 * @param [in] $id string Primary key dari data yang akan diambil
	 * @return Database result object
	 */
	protected function get_detail($id) {
		$result                   = new stdClass();

		$this->db->select('mnu.*, icon.nama AS nama_icon, icon.group AS group_icon, mnu_parent.nama AS nama_parent');
		$this->db->from('menu AS mnu');
		$this->db->join('icon AS icon', 'icon.id = mnu.id_icon', 'LEFT');
		$this->db->join('menu AS mnu_parent', 'mnu_parent.id = mnu.parent_id', 'LEFT');
		$this->db->where('mnu.id', $id);
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
		$id = $this->input->get_post('id');

		$list_icons = ['' => ''];
		$icons      = $this->db->get('icon')->result();
		foreach ($icons as $index => $value) {
			$list_icons[$value->group][$value->id] = $value->nama;
		}

		$this->_addition_display['icons_option'] = $list_icons;

		$list_parent = ['' => ''];
		$parents     = $this->db->get('menu')->result();
		foreach ($parents as $index => $value) {
			$list_parent[$value->id] = $value->nama;
		}

		$this->_addition_display['parents_option'] = $list_parent;

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
			'menu_model'             => ['id' => 'menu_id']
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
				'menu_model' => 'single'
			]);
			$validation = $this->form_validation->run();
		}

		// -- Let's check .... --
		return $validation;
		// return TRUE; // -- You can by pass validation here ..
	}

	public function insert() {
		authorization_check($this->aco_name, 'insert');
		// -- Load semua model yang digunakan, tampung dalam sebuah array --
		$objects = ['menu_model'];
		$this->load->model($objects);
		parent::_insert($objects, function ($data) {
			// -- Using Custom Mode --
			// --- Insert Header --
			$menu_id = $this->menu_model->insert($data['menu_model']);

			return $this->db->trans_status();

			// -- Using Library Mode --
			// $this->load->library('Lib_user');
			// $this->lib_user->insert($data);
			// return $this->db->trans_status();
		});
	}

	public function update() {
		authorization_check($this->aco_name, 'update');
		$objects = ['menu_model'];
		$this->load->model($objects);

		parent::_update($objects, function ($data, $for_delete) {
			// -- Header --
			$menu_id = $this->menu_model->update($data['menu_model']);

			return $this->db->trans_status();
		});
	}

	public function delete() {
		authorization_check($this->aco_name, 'delete');
		$objects = ['menu_model'];
		$this->load->model($objects);
		parent::_delete($objects, function ($id, $data) {
			$this->menu_model->delete($id, $data);
			return $this->db->trans_status();
		});
	}

	public function export($jenis_export) {
		$this->data_list =
			[
				['label' => 'ID', 'field' => 'id'],
				['label' => 'Nama Menu', 'field' => 'nama'],
				['label' => 'Parent', 'field' => 'nama_parent'],
				['label' => 'Sequence', 'field' => 'sequence'],
				['label' => 'URL', 'field' => 'url'],
				['label' => 'Icon', 'field' => 'nama_icon']
			];
		$result = $this->get_list();
		parent::_export($result, $jenis_export, 'menu');
	}

	public function menu_arrange() {
		$data      = [];
		$this->load->model('menu_model');
		$data['form_action']      = 'backend/' . $this->controller_name . '/update_menu_arrange';
		$data['form_attributes']  = [
			'id'     => 'form_menu_arrange',
			'name'   => 'form_menu_arrange',
			'method' => 'POST',
		];
		$data['menu']             = $this->menu_model->get_menu();

		$content   = '';
		$content   = $this->load->view($this->layout . '/' . $this->controller_name . '/list_arrange', $data, true);
		$this->_load_layout($content);
	}

	public function update_menu_arrange() {
		$result             = new stdClass();
		$result->response   = true;
		$result->message    = '';

		//variable $result_arrange menampung hasil perubahan json menjadi array
		$result_arrange = json_decode($_POST['json'], true);

		//variable $result_menu menampung hasil get data menu yang akan di update kedalam table database
		$result_menu = $this->lib_menu->get_result_menu($result_arrange);

		foreach ($result_menu as $key => $value) {
			$id_menu = $this->menu_model->update($value);
		}

		parent::result_json($result);
	}
}
