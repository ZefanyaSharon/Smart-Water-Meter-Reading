<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Menu_model extends MY_Model {
	public $table_name = 'menu';

	public function __construct() {
		$this->validation_fields = [
			['field' => 'id', 'label' => 'Primary Key', 'rules' => 'trim'],
			['field' => 'nama', 'label' => 'Nama', 'rules' => 'trim|required'],
			['field' => 'parent_id', 'label' => 'Parent Id', 'rules' => 'trim'],
			['field' => 'sequence', 'label' => 'Sequence', 'rules' => 'trim'],
			['field' => 'url', 'label' => 'URL', 'rules' => 'trim'],
			['field' => 'id_icon', 'label' => 'ICON', 'rules' => 'trim'],
		];
		parent::__construct();
	}

	/**
	 * Fungsi yang digunakan untuk mengatur formating data yang akan disimpan dalam database
	 * @param [in] $data Array Data yang akan diproses
	 * @return Array
	 */
	public function data_format($data) {
		// $data['nama']   = strtoupper($data['nama']);
		$data['parent_id']   = !empty($data['parent_id']) ? $data['parent_id'] : null;
		return parent::data_format($data);
	}

	public function get_menu($parent_id = null) {
		$results    = [];

		$this->db->order_by('mnu.sequence', 'asc');
		if ($parent_id != null) {
			$this->db->where('mnu.parent_id', $parent_id);
		} else {
			$this->db->where('mnu.parent_id IS NULL', null);
		}
		$this->db->select('mnu.id, mnu.nama AS name, mnu.parent_id, mnu.sequence, mnu.url, mnu.breadcrumb, , icon.nama AS nama_icon');
		$this->db->from('menu AS mnu');
		$this->db->join('icon AS icon', 'icon.id = mnu.id_icon', 'LEFT');

		$menu_table = $this->db->get();
		if ($menu_table->num_rows() > 0) {
			$menus = $menu_table->result();
			foreach ($menus as $menu) {
				$menu->childs = $this->get_menu($menu->id);
				$results[]    = $menu;
			}
		}

		return $results;
	}

	public function get_nama_menu($id_menu) {
		$result    = '';

		$this->db->select('mnu.nama AS nama_menu');
		$this->db->from('menu AS mnu');
		$this->db->where('mnu.id', $id_menu);

		$menu_table = $this->db->get();
		if ($menu_table->num_rows() > 0) {
			$nama_menu = $menu_table->result();
			foreach ($nama_menu as $key_nama => $val) {
				$result = $val->nama_menu;
			}
		}
		return $result;
	}

	public function get_breadcrumb($id_menu) {
		$result    = [];
		$this->db->select('mnu.breadcrumb AS breadcrumb, mnu.url AS url, mnu.parent_id AS parent, icon.nama AS nama_icon');
		$this->db->from('menu AS mnu');
		$this->db->join('icon AS icon', 'icon.id = mnu.id_icon', 'LEFT');
		$this->db->where('mnu.id', $id_menu);

		$menu_table = $this->db->get();
		if ($menu_table->num_rows() > 0) {
			$breadcrumb = $menu_table->result();
			foreach ($breadcrumb as $key_nama => $val) {
				$result['breadcrumb'] = $val->breadcrumb;
				$url = $this->get_url($id_menu);
				$result['url'] = $url;
				$result['icon'] = $val->nama_icon;
			}
		}
		return $result;
	}

	public function get_menu_bottom_to_top($menu_id = null) {
		$results    = [];
		$this->db->order_by('mnu.sequence', 'asc');
		if ($menu_id != null) {
			$this->db->where('mnu.id', $menu_id);
		} else {
			$this->db->where('mnu.id IS NULL', null);
		}
		$this->db->select('mnu.id, mnu.nama AS name, mnu.parent_id, mnu.sequence, mnu.url, mnu.breadcrumb, , icon.nama AS nama_icon');
		$this->db->from('menu AS mnu');
		$this->db->join('icon AS icon', 'icon.id = mnu.id_icon', 'LEFT');

		$menu_table = $this->db->get();
		if ($menu_table->num_rows() > 0) {
			$menus = $menu_table->result();
			foreach ($menus as $menu) {
				$menu->parent = $this->get_menu_bottom_to_top($menu->parent_id);
				$results[]    = $menu;
			}
		}

		return $results;
	}

	public function get_url($menu_id = null, $parent = [], &$results = []) {
		if ($menu_id != null) {
			$parent = $this->get_menu_bottom_to_top($menu_id);
		}
		foreach ($parent as $url_key => $url_val) {
			if(!empty($url_val->parent)) { // <-- else if statement simplified
				$this->get_url('', $url_val->parent, $results);
				$results[$url_val->name] = $url_val->url;
			} else {
				$results[$url_val->name] = $url_val->url;
			}
		}
		return $results;
	}
}
