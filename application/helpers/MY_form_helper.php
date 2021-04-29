<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Hidden Input Field
 * Custom Add Attribute id = name
 */
if ( ! function_exists('form_hidden'))
{
	function form_hidden($name, $value = '', $recursing = FALSE)
	{
		static $form;

		if ($recursing === FALSE)
		{
			$form = "\n";
		}

		if (is_array($name))
		{
			foreach ($name as $key => $val)
			{
				form_hidden($key, $val, TRUE);
			}
			return $form;
		}

		if ( ! is_array($value))
		{
			$form .= '<input type="hidden" name="'.$name.'" value="'.form_prep($value, $name).'" id="'.$name.'" />'."\n";
		}
		else
		{
			foreach ($value as $k => $v)
			{
				$k = (is_int($k)) ? '' : $k;
				form_hidden($name.'['.$k.']', $v, TRUE);
			}
		}

		return $form;
	}
}

/* Drop Down select form table and support for autocomplete
- form_dropdown_list('kota', 'tabel_kota', 'id_kota', 'kota', array('is_delete' => 0),
					array('kota'=>'asc'), TRUE, FALSE, 'onchange="alert('test')" width="10px"', TRUE
				);
 */
if ( ! function_exists('form_dropdown_list'))
{
	function form_dropdown_list($dropdown_name, $table_name, $field_show, $field_value, $criteria = array(), $order_by = array(), $default = '', $using_blank = TRUE, $using_all = FALSE, $attributes = '', $blank_caption = '')
	{
		$CI =& get_instance();

		$CI->db->select('*');
		$CI->db->from($table_name);
		if(is_array($criteria) && !empty($criteria))
		{
			foreach($criteria as $field=>$value)
			{
				if($value != '')
					$CI->db->where($field, $value);
				else
					$CI->db->where($field);
			}
		}
		if(is_array($order_by) && !empty($order_by))
		{
			foreach($order_by as $field => $method)
			{
				$CI->db->order_by($field, $method);
			}
		}
		else
		{
			$CI->db->order_by($field_show, 'asc');
		}

		$results = $CI->db->get()->result();
		$options = array();
		if($using_blank == TRUE)
			$options[''] = $blank_caption;
		if($using_all == TRUE)
			$options['Semua'] = 'Semua';
		foreach($results as $result)
		{
			$options[$result->$field_value] = $result->$field_show;
		}

		$dropdown = form_dropdown($dropdown_name, $options, $default, $attributes);
		return $dropdown;
	}
}

/* Drop Down List Custom
Example:
$custom = array(
	'table' => 'table_name',
	'select' => 'select_name',
	'field_show' => 'field_name',
	'field_value' => 'field_id',
	'criteria' => array(
		'field_name' => 'value',
		'field_name <> ' => 'value',
		'custom criteria' => '',
	),
	'order_by' => array(
		'field_name' => 'asc',
	),
	'using_lain' => FALSE,
	'blank_caption' => 'Semua',
	'pre_options' => array(
		'custom_id' => 'Custom Label',
	),
	'post_options' => array(
		'custom_id' => 'Custom Label',
	),
);
$attributes = 'id="field_name"';
$default = set_value('ID_SUB_JENIS_PERSETUJUAN', (isset($result->ID_SUB_JENIS_PERSETUJUAN) ? $result->ID_SUB_JENIS_PERSETUJUAN : '');
form_dropdown_custom('field_name', $custom, $default, $attributes);
*/

if ( ! function_exists('form_dropdown_custom'))
{
	function form_dropdown_custom($dropdown_name, $custom=array(), $default = '', $attributes='')
	{
		//For Query to table
		$custom['table'] = isset($custom['table']) ? $custom['table'] : FALSE;
		$custom['select'] = isset($custom['select']) ? $custom['select'] : FALSE;
		$custom['field_show'] = isset($custom['field_show']) ? $custom['field_show'] : FALSE;
		$custom['field_value'] = isset($custom['field_value']) ? $custom['field_value'] : FALSE;
		$custom['criteria'] = isset($custom['criteria']) ? $custom['criteria'] : array();
		$custom['group_by'] = isset($custom['group_by']) ? $custom['group_by'] : array();
		$custom['order_by'] = isset($custom['order_by']) ? $custom['order_by'] : array();

		//Add Option for Lain-lain with value 9999
		$custom['using_lain'] = isset($custom['using_lain']) ? $custom['using_lain'] : FALSE;

		//Set Caption for empty value (blank)
		$custom['blank_caption'] = isset($custom['blank_caption']) ? $custom['blank_caption'] : FALSE;

		//Addtional Options to be put as first options
		$custom['pre_options'] = isset($custom['pre_options']) ? $custom['pre_options'] : array();
		//Addtional Options to be put as last options
		$custom['post_options'] = isset($custom['post_options']) ? $custom['post_options'] : array();


		$CI =& get_instance();
		$options = array();

		if($custom['blank_caption']) $options[''] = $custom['blank_caption'];
		if( !empty( $custom['pre_options'] ) && is_array( $custom['pre_options'] ) ) $options = $options + $custom['pre_options'] ;

		if ($custom['table']) {
			$CI->db->select('*');
			if($custom['select']) $CI->db->select($custom['select']);
			$CI->db->from($custom['table']);
			if(!empty($custom['criteria']) && is_array($custom['criteria']))
			{
				foreach($custom['criteria'] as $field=>$value)
				{
					if($value !== '')
						$CI->db->where($field, $value);
					else
						$CI->db->where($field, NULL, FALSE);
				}
			}
			else if(!empty($custom['criteria']) && !is_array($custom['criteria']))
			{
				$CI->db->where($field, NULL, FALSE);
			}

			if(!empty($custom['group_by']) && is_array($custom['group_by']))
			{
				foreach($custom['group_by'] as $field => $method)
				{
					$CI->db->group_by($field, $method);
				}
			}

			if(!empty($custom['order_by']) && is_array($custom['order_by']))
			{
				foreach($custom['order_by'] as $field => $method)
				{
					$CI->db->order_by($field, $method);
				}
			}
			else
			{
				$CI->db->order_by($custom['field_show'], 'asc');
			}

			$results = $CI->db->get()->result();
			foreach($results as $result)
			{
				$options[$result->$custom['field_value']] = $result->$custom['field_show'];
			}

		}
		if($custom['using_lain']) $options['9999'] = 'Lain-lain';
		if( !empty($custom['post_options']) && is_array ($custom['post_options']) ) $options = $options + $custom['post_options'] ;
		$dropdown = form_dropdown($dropdown_name, $options, $default, $attributes);

		return $dropdown;
	}

	if (!function_exists('form_dropdown')) {
		function form_dropdown($name = '', $options = [], $selected = [], $extra = '', $extra_option = [] , $class = '') {
			if (!is_array($selected)) {
				$selected = [$selected];
			}

			// If no selected state was submitted we will attempt to set it automatically
			if (count($selected) === 0) {
				// If the form name appears in the $_POST array we have a winner!
				if (isset($_POST[$name])) {
					$selected = [$_POST[$name]];
				}
			}

			if ($extra != '') {
				$extra = ' ' . $extra;
			}

			$multiple = (count($selected) > 1 && strpos($extra, 'multiple') === false) ? ' multiple="multiple"' : '';

			$form = '<select class="'.$class.' select2_demo_1 form-control" name="' . $name . '"' . $extra . $multiple . ">\n";

			foreach ((array)$options as $key => $val) {
				$key = (string) $key;

				if (is_array($val) && !empty($val)) {
					$form .= '<optgroup label="' . $key . '">' . "\n";

					foreach ($val as $optgroup_key => $optgroup_val) {
						$sel = (in_array($optgroup_key, $selected)) ? ' selected="selected"' : '';

						$attr_option = '';
						foreach ($extra_option as $key_opt_attribute => $opt_attributes) {
							if ($key_opt_attribute == 'data-icon') {
								foreach ($opt_attributes as $data_icon) {
									if ($data_icon == (string) $optgroup_val) {
										$attr_option .= 'data-icon="' . $data_icon . '" ';
										break;
									}
								}
							}
						}
						$form .= '<option value="' . $optgroup_key . '"' . $sel . ' ' . $attr_option . '>' . (string) $optgroup_val . "</option>\n";
					}

					$form .= '</optgroup>' . "\n";
				} else {
					$sel = (in_array($key, $selected)) ? ' selected="selected"' : '';

					$form .= '<option value="' . $key . '"' . $sel . '>' . (string) $val . "</option>\n";
				}
			}

			$form .= '</select>';

			return $form;
		}
	}

	if (!function_exists('set_option')) {
		function set_option($items, $field_label, $params = []) {
			$prefix = isset($params['prefix']) ? $params['prefix'] : '';
			$choose_text = isset($params['choose_text']) ? $params['choose_text'] : '- Pilih -';
			$field_key = isset($params['field_key']) ? $params['field_key'] : 'id';
			$field_sub = isset($params['field_sub']) ? $params['field_sub'] : 'sub';
			$optgroup_criteria = isset($params['optgroup_criteria']) ? $params['optgroup_criteria'] : [];
			$deep = isset($params['deep']) ? $params['deep'] : 1;

			if (!empty($choose_text) ){
				$option[''] = $choose_text;
			}
			foreach ($items as $item) {
				$option_next = &$option;
				if (!empty($optgroup_criteria) ) {
					foreach ($optgroup_criteria as $key => $value) {
						if ($item->$key == $value) {
							$option[$item->$field_label] = [
								$item->$field_key => $item->$field_label,
							];
							$option_next = &$option[$item->$field_label];
						} else {
							$option_next[$item->$field_key] = (!empty($prefix) ? str_repeat($prefix, $deep) . ' ' : '') . $item->$field_label;
						}
					}
				} else {
					$option_next[$item->$field_key] = (!empty($prefix) ? str_repeat($prefix,$deep) .' ': ''). $item->$field_label;
				}
				if (!empty($item->$field_sub) > 0) {
					$param_sub = $params;
					$param_sub['deep'] = $deep + 1;
					$param_sub['choose_text'] = '';
					$option_sub = set_option($item->$field_sub, $field_label, $param_sub);
					$option_next     = array_merge($option_next, $option_sub);
				}
			}
			return $option;
		}
	}

}


/* End of file MY_form_helper.php */
/* Location: ./application/helpers/MY_form_helper.php */
