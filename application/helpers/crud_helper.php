<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

if (!function_exists('data_assign')) {
	function data_assign($objects) {
		$result = [];
		foreach ($objects as $object) {
			$result[$object] = set_post_value($object);
		}

		return $result;
	}
}

if (!function_exists('set_post_value')) {
	function set_post_value($object) {
		$result      = [];
		$CI          =&get_instance();
		$fields       = $CI->{strtolower($object)}->fields;
		$primary_key = $CI->input->post($CI->{strtolower($object)}->post_primary_key());
		if (is_array($primary_key)) {
			foreach ($primary_key as $idx => $value) {
				foreach ($fields as $field) {
					$post_name                     = isset($field['post_field_name']) ? $field['post_field_name'] : $field['field'];
					$post_value                    = $CI->input->post($post_name);
					$result[$idx][$field['field']] = isset($post_value[$idx]) ? $post_value[$idx] : null;
				}
			}
		} else {
			foreach ($fields as $field) {
				$post_name               = isset($field['post_field_name']) ? $field['post_field_name'] : $field['field'];
				$result[$field['field']] = $CI->input->post($post_name);
			}
		}

		return $result;
	}
}

if (!function_exists('data_format')) {
	function data_format($datas) {
		$CI     =&get_instance();
		$result = [];
		foreach ($datas as $model => $data) {
			if (!is_multi_array($data)) {
				$result[$model] = $CI->{strtolower($model)}->data_format($data);
			} else {
				foreach ($data as $idx => $value) {
					$result[$model][$idx] = $CI->{strtolower($model)}->data_format($value);
				}
			}
		}
		return $result;
	}
}

if (!function_exists('paging')) {
	function paging($custom_config = []) {
		$CI =&get_instance();
		$CI->load->library('pagination');
		$config                = [];
		$config['base_url']    = uri_string();
		$config['total_rows']  = 0;
		$config['per_page']    = config_item('public_limit_per_page');
		$config['uri_segment'] = '';
		$config['cur_page']    = '';
		$config['prefix']      = '';
		$config['suffix']      = config_item('url_suffix');
		$config['num_links']   = config_item('pagination_num_link');

		// integrate bootstrap pagination
		$config['first_link']        = 'First';
		$config['last_link']         = 'Last';
		$config['next_link']         = 'Next';
		$config['prev_link']         = 'Prev';
		$config['full_tag_open']     = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
		$config['full_tag_close']    = '</ul></nav></div>';
		$config['num_tag_open']      = '<li class="page-item">';
		$config['num_tag_close']     = '</li>';
		$config['cur_tag_open']      = '<li class="page-item active"><a class="page-link" href="#">';
		$config['cur_tag_close']     = '</a></li>';
		$config['next_tag_open']     = '<li class="page-item"><a href="#" aria-label="Next">';
		$config['next_tagl_close']   = '</a></li>';
		$config['prev_tag_open']     = '<li class="page-item">';
		$config['prev_tagl_close']   = '</li>';
		$config['first_tag_open']    = '<li class="page-item">';
		$config['first_tagl_close']  = '</li>';
		$config['last_tag_open']     = '<li class="page-item"><a href="#" aria-label="Next">';
		$config['last_tagl_close']   = '</a></li>';
		$config['use_page_numbers']  = TRUE;
		$config['attributes']        = ['class' => 'page-link'];

		if (!empty($custom_config))
			$config = array_merge($config, $custom_config);

		$config['first_url']   = $config['base_url'] . $config['suffix'];

		$CI->pagination->initialize($config);

		$data['page'] = ($config['cur_page'] - 1) * $config['per_page'];
		$data['pagination'] = $CI->pagination->create_links();
		return $data;
	}
}
if (!function_exists('selectboxarray')) {
	function selectboxarray($rowset, $match, $typechosen='') {
		$print   = '';
		$bSelect = false;
		foreach ($rowset as $field=>$value) {
			if ($typechosen == 1 || $typechosen == 2) {
				$field=$value;
			}
			$print .= "<option value='" . $field . "'";
			if (strtolower($field) == strtolower($match)) {
				$print .= ' selected';
				$bSelect = true;
			};
			$print .= '>' . $value . '</option>';
		}
		if ($bSelect == false && $typechosen == 2 && $match != '') {
			$print .= "<option value='" . $match . "' selected>" . $match . '</option>';
		}
		return $print;
	}
}

if (!function_exists('hitung_umur')) {
	function hitung_umur($tanggal_lahir) {
		list($year,$month,$day) = explode("-",$tanggal_lahir);
		$year_diff  = date("Y") - $year;
		$month_diff = date("m") - $month;
		$day_diff   = date("d") - $day;
		if ($month_diff < 0) $year_diff--;
			elseif (($month_diff==0) && ($day_diff < 0)) $year_diff--;
		return $year_diff;
	}
}