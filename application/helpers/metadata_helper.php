<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Show textbox field
* @param [in]
* @return
*/
if ( ! function_exists('mt_html')) {
	function mt_html($param) {
		$CI =&get_instance();

		$result = '';
		$mt = $param;

		if ( ! is_array($mt)) {
			$t_mt = $this->CI->db->get_where('metadata', ['id', $mt]);
			if ($t_mt->num_rows() > 0) {
				$mt = $t_mt->row_array();
			}
		}

		$mt_value = isset($mt['value']) ? $mt['value'] : '';
		$mt_id = $mt['id'] . (isset($mt['index']) ? '[' . $mt['index'] . ']' : '');

		// -- Set Attribute --
		$mt_attribute = '';
		if (isset($mt['attribute']) && ! empty($mt['attribute'])) {
			$attributes = json_decode($mt['attribute']);
			foreach ($attributes as $attr => $value) {
				if ( ! empty($value))
					$mt_attribute .= ' ' . $attr . '="' . $value .'" ';
			}
		}

		switch ($mt['field_type']) {
			case 'textbox' :
				$result = '<input type="textbox" id="'.$mt_id.'" name="'.$mt_id.'" value="'.$mt_value.'" class="form-control" ' . $mt_attribute . '>';
			break;
			case 'select' :
				$options = explode('|', $mt['options']);
				$lists = [];
				foreach ($options as $value)
					$lists[$value] = $value;
				$result = form_dropdown($mt_id, $lists, $mt_value, 'id="'.$mt_id.'"');
			break;
			case 'select2' :
				$options = explode('|', $mt['options']);
				$lists = [];
				foreach ($options as $value)
					$lists[$value] = $value;
				$result = form_dropdown($mt_id, $lists, $mt_value, 'id="'.$mt_id.'" '.$mt_attribute.'');
			break;
			case 'textarea' :
				$result = form_textarea($mt_id, $mt_value, 'id="'.$mt_id.'" row="3" class="form-control" '.$mt_attribute.'');
			break;
			case 'summernote' :
				$result = form_textarea($mt_id, $mt_value, 'id="'.$mt_id.'" class="summernote" '.$mt_attribute.'');
			break;
			case 'radio' :
				$options = explode('|', $mt['options']);
				foreach ($options as $idx => $option) {
					$result .= form_radio(
						$mt_id,
						$option,
						( ! empty($mt_value) && $mt_value == $option) ? true : false,
						'id="'.$mt_id.'_'.$idx.'" '.$mt_attribute.''
					);
					$result .= form_label($option, $mt_id . '_' . $idx, ['style'=>'margin-right:10px']);

					if (isset($mt['display_mode']) && $mt['display_mode'] == 'vertical')
						$result .= '<br>';
				}
			break;
			case 'checkbox' :
				$options = explode('|', $mt['options']);
				foreach ($options as $idx => $option) {
					$result .= form_checkbox(
						$mt_id,
						$option,
						( ! empty($mt_value) && $mt_value == $option) ? true : false,
						'id="'.$mt_id.'_'.$idx.'" '.$mt_attribute.''
					);
					$result .= form_label($option, $mt_id . '_' . $idx, ['style'=>'margin-right:10px']);

					if (isset($mt['display_mode']) && $mt['display_mode'] == 'vertical')
						$result .= '<br>';
				}
			break;
			default :
				$result = 'Undefined component!';
			break;
		}

		return $result;
	}
}
