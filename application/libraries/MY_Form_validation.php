<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

	public function __construct()
	{
		$this->CI =& get_instance();
		parent::__construct();
	}

	public function set_rules_multiple($models) {
		foreach ($models as $model => $type) {
			$rule_setting_array = [];
			if ($type == 'single') {
				foreach ($this->CI->{strtolower($model)}->validation_fields as $idx => $properties) {
					$field_setting['field'] = isset($properties['post_field_name']) ? $properties['post_field_name'] : $properties['field'];
					$field_setting['label'] = $properties['label'];
					$field_setting['rules'] = $properties['rules'];
					$rule_setting_array[] = $field_setting;
				}
				$this->set_rules($rule_setting_array);
			}
			else { // -- Multiple --
				$primary_key = $this->CI->{strtolower($model)}->post_primary_key();
				$post_id = $this->CI->input->post($primary_key);
				foreach ($post_id as $idx => $value) {
					foreach ($this->CI->{strtolower($model)}->validation_fields as $properties) {
						if ( ! $this->row_empty($this->CI->{strtolower($model)}->validation_fields, $idx))
						{
							$field_name = isset($properties['post_field_name']) ? $properties['post_field_name'] : $properties['field'];
							$field_setting['field'] = $field_name.'['.$idx.']';
							$field_setting['label'] = $properties['label'].' '.($idx + 1);
							$field_setting['rules'] = $properties['rules'];
							$rule_setting_array[] = $field_setting;
						}
					}
					if ( ! empty($rule_setting_array)) {
						$this->set_rules($rule_setting_array);
					}
				}
			}
		}
	}

	/**
	 * Jika row detail semuanya kosong maka dianggap tidak ada (insert multiple)
	 * @param [in] Array   $fields Variable $this->$model->fields
	 * @param [in] integer $index  Array post address
	 * @return Boolean
	 */
	protected function row_empty($fields = [], $index = '') {
		$row_empty = TRUE;
		foreach ($fields as $properties) {
			$field_name = isset($properties['post_field_name']) ? $properties['post_field_name'] : $properties['field'];
			$data = $this->CI->input->post($field_name);
			if (isset($data[$index]) && $data[$index] <> '')
				$row_empty = FALSE;
		}
		return $row_empty;
	}

	/* Valid Date (ISO format)
	 *
	 * @access    public
	 * @param    string
	 * @return    bool
	 */
	public function valid_date($str)
	{
		if ( preg_match("/([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})/", $str) )
		{
			$arr = explode("/", $str);    // splitting the array
			$dd = $arr[0];              // third element is days
			$mm = $arr[1];              // second element is month
			$yyyy = $arr[2];            // first element of the array is year
			return ( checkdate($mm, $dd, $yyyy) );
		}
		else
		{
			$this->set_message('valid_date', "Data '".$str."' in %s is not valid. format date dd/mm/yyyy ex: 31/12/2013.");
			return FALSE;
		}
	}


	public function valid_date_time($str)
	{
		$date = DateTime::createFromFormat('d/m/Y H:i:s', $str);
		if (!$date)
		{
			$this->set_message('valid_date_time', "Data '".$str."' in %s is not valid. format datetime dd/mm/yyyy H:i:s ex: 31/12/2013 22:55:60.");
			return FALSE;
		}

		return TRUE;
	}

	/* Not Matches value
	 *
	 * @access    public
	 * @param    string
	 * @return    boolean
	 */
	public function not_matches($str, $field)
	{
		if ( ! isset($_POST[$field]))
		{
			return TRUE;
		}

		$field = $_POST[$field];

		return ($str == $field) ? FALSE : TRUE;
	}

	public function valid_url($str){
		return filter_var($str, FILTER_VALIDATE_URL);
	}

	/* Real URL
	 *
	 * @access    public
	 * @param    string
	 * @return    string
	 */
	public function real_url($str){
		return @fsockopen("$str", 80, $errno, $errstr, 30);
	}

	/* Numeric Coma for Accountant format
	- formatt 1,000.00
	*/
	public function numeric_comma($str)
	{
		if($str != '')
		{
			//return (bool)  preg_match('/^[0-9,]+$/', $str);
			//return (bool) preg_match('/^[\-+]?[0-9,]+\.[0-9]+$/', $str);// decimal only
			return (bool) preg_match('/^[\-+]?[0-9,.]+$/', $str);
		}
		else
			return TRUE;
	}

	/* Check is Existing Data and Create New if not exists [for update]
	- example user for username unique and compare with user id
	- for call is_exists_new['$table_name, $field, $field_ref, $value_ref']
	*/
	public function is_exists_new($str, $attribute)
	{
		$temp = explode(',', $attribute);
		if(count($temp) == 4)
		{
			$table_name = trim($temp[0]);
			$field = trim($temp[1]);
			$field_ref = trim($temp[2]);
			$value_ref = trim($temp[3]);

			$result = $this->CI->db->get_where($table_name, array($field => $str));
			if($result->num_rows())
			{
				$data = $result->row();
				if(!empty($field_ref) && !empty($value_ref))
				{
					if($data->$field_ref == $value_ref)
					{
						return TRUE;
					}
					else
					{
						$this->set_message('is_exists_new', "Data '".$str."' in %s field not found.");
						return FALSE;
					}
				}
				else
				{
					$this->set_message('is_exists_new', "Data '".$str."' in %s field not found.");
					return FALSE;
				}
			}
			else
			{
				return TRUE;
			}
		}
		else
		{
			$this->set_message('is_exists_new', "Data '".$str."' in %s variable not found.");
			return FALSE;
		}
	}

	/* Check is Existing Data
	- for check existing data only
	*/
	public function is_exists($str, $table_field_name)
	{
		if($str == '')
			return TRUE;
		$temp = explode('.', $table_field_name);
		if(count($temp) == 2)
		{
			$table_name = trim($temp[0]);
			$field_name = trim($temp[1]);

			$result = $this->CI->db->get_where($table_name, array($field_name => $str));
			if($result->num_rows())
			{
				return TRUE;
			}
			else
			{
				$this->set_message('is_exists', "Data '".$str."' in %s field not found.");
				return FALSE;
			}
		}
		else
		{
			$this->set_message('is_exists', "Data '".$str."' in %s variable not found.");
			return FALSE;
		}
	}

	public function integer($str)
	{
		if($str == '')
			return TRUE;
		return parent::integer($str);
	}

	public function is_unique_deleted($str, $field)
	{
		list($table, $field)=explode('.', $field);
		$query = $this->CI->db->limit(1)->get_where($table, array($field => $str, 'IS_DELETED' => '0'));
		if($query->num_rows() === 0)
		{
			return  TRUE;
		}
		else
		{
			$this->set_message('is_unique_deleted', "This data in %s field was exist.");
			return FALSE;
		}
	}

	public function is_exists_new_deleted($str, $attribute)
	{
		$temp = explode(',', $attribute);
		if(count($temp) == 4)
		{
			$table_name = trim($temp[0]);
			$field = trim($temp[1]);
			$field_ref = trim($temp[2]);
			$value_ref = trim($temp[3]);

			$result = $this->CI->db->get_where($table_name, array($field => $str, 'IS_DELETED' => '0'));
			if($result->num_rows())
			{
				$data = $result->row();
				if(!empty($field_ref) && !empty($value_ref))
				{
					if($data->$field_ref == $value_ref)
					{
						return TRUE;
					}
					else
					{
						$this->set_message('is_exists_new_deleted', "Data '".$str."' in %s field not found.");
						return FALSE;
					}
				}
				else
				{
					$this->set_message('is_exists_new_deleted', "Data '".$str."' in %s field not found.");
					return FALSE;
				}
			}
			else
			{
				return TRUE;
			}
		}
		else
		{
			$this->set_message('is_exists_new_deleted', "Data '".$str."' in %s variable not found.");
			return FALSE;
		}
	}

	public function check_double_selected($str)
	{
		$bDouble = FALSE;
		$temp = explode('|', $str);
		foreach($temp as $index=>$value)
		{
			unset($temp[$index]);
			if(count($temp))
			{
				if (in_array($value, $temp))
				{
					$bDouble = TRUE;
					break;
				}
			}
		}
		if($bDouble == TRUE)
		{
			$this->set_message('check_double_selected', "%s field can't double selected.");
			return FALSE;
		}
		else
			return TRUE;

	}

	public function set_checkbox($field = '', $value = '', $default = FALSE)
	{
		if ( ! isset($this->_field_data[$field]) OR ! isset($this->_field_data[$field]['postdata']))
		{
			if ($default === TRUE AND count($this->_field_data) === 0)
			{
				return ' checked="checked"';
			}
			return '';
		}

		$field = $this->_field_data[$field]['postdata'];

		if (is_array($field))
		{
			if ( ! in_array($value, $field))
			{
				return '';
			}
		}
		else
		{
			// if (($field == '' OR $value == '') OR ($field != $value))
			if (($field === '' OR $value === '') OR ($field != $value)) // karena jika 0 harusnya tidak masuk sebagai kondisi empty
			{
				return '';
			}
		}

		return ' checked="checked"';
	}
}

/* End of file MY_Form_validation.php */
/* Location: ./application/libraries/MY_Form_validation.php */