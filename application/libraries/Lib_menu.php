<?php  if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Lib_menu {

	protected $CI;

	public function __construct() {
		//Get an Instance of CodeIgniter
		$this->CI =&get_instance();
		//load model
		$this->CI->load->model('Menu_model');
	}

	public function get_result_menu($result_arrange, $id = null, $breadcrumb = '') {
		$data                    = [];
		$val_menu                = [];
		$child                   = [];

		foreach ($result_arrange as $idx => $value) {
			//varibale berfungsi menampung breadcrumb yang diambil dari nama menu yang terdapat pada tabel menu, yang disesuaikan dengan parent dan child
			$breadcrumb .= $this->CI->Menu_model->get_nama_menu($value['id']).'/';

			//variable $key, berfungsi untuk menentukan urutan (sequence) menu
			$key        = array_search($value['id'], array_column($result_arrange, 'id'));

			//pengecekan terhadap child object
			if (isset($value['children'])) {
				//recursive untuk mengambil data child dari parent menu
				$val_ = $this->get_result_menu($value['children'], $value['id'], $breadcrumb);

				$child = $val_;
			}
				foreach ($child as $k=> $v) {
					$val_menu[$v['id']]['parent_id']    = $v['parent_id'];
					$val_menu[$v['id']]['id']           = strval($v['id']);
					$val_menu[$v['id']]['sequence']     = $v['sequence'];
					$val_menu[$v['id']]['breadcrumb']     = $v['breadcrumb'];
				}

				$val_menu[$value['id']]['parent_id']    = $id;
				$val_menu[$value['id']]['id']           = strval($value['id']);
				$val_menu[$value['id']]['sequence']     = $key;
				$val_menu[$value['id']]['breadcrumb']     = $breadcrumb;

			$breadcrumb = '';
		}

		$data = $val_menu;

		return $data;
	}

	public function generate_breadcrumb($id_menu , $detail = ''){
		$breadcrumb = $this->CI->Menu_model->get_breadcrumb($id_menu);
		$url = isset($breadcrumb['url']) ? $breadcrumb['url'] : '';
		$icon = isset($breadcrumb['icon']) ? $breadcrumb['icon'] : '';
		$breadcrumb['breadcrumb'] = isset($breadcrumb['breadcrumb']) ? $breadcrumb['breadcrumb'] : '';
		$split = preg_split('@/@', $breadcrumb['breadcrumb'], NULL, PREG_SPLIT_NO_EMPTY);
		// $split = explode('/',$breadcrumb['breadcrumb']);
		if (!empty($detail)) {
			array_push($split, $detail);
		}
		$breadcrumbs['split'] = $split;
		$breadcrumbs['url'] = $url;
		$breadcrumbs['icon'] = $icon;
		return breadcrumb($breadcrumbs);
	}
}
