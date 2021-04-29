<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_model extends CI_Model {

	public $fields = [];

	public $validation_fields = [];

	public $calculated_fields = [];

	public $table_name;

	public $response_data = '';

	public function __construct() {
		$this->merge_fields();
		parent::__construct();
	}

	public function data_format($data) {
		return $data;
	}

	public function insert($data) {
		if (empty($data['id'])) {
			$data['id']         = guid();
		}
		$data['created']    = date('Y-m-d H:i:s');
		$data['created_by'] = $this->session->userdata('user_id');
		$data['updated']    = date('Y-m-d H:i:s');
		$this->db->insert($this->table_name, $data);

		// -- Insert to System Log (optional, because this's insert broh..) --

		// -- Insert Reindex Queue --

		// -- Return Primary Key --
		return $data['id'];
	}

	public function update($data) {
		$data['updated']    = date('Y-m-d H:i:s');
		$data['updated_by'] = $this->session->userdata('user_id');
		$this->db->where('id_pengadilan', $data['id']);
		$this->db->update($this->table_name, $data);

		// -- Insert to System Log Change --

		// -- Insert Reindex Queue --

		// -- Return Primary Key --
		return $data['id'];
	}

	/**
	 * Digunakan untuk menghapus record dalam database
	 * @param [in] $primary_key ID Primary Key dari table
	 * @return void
	 */
	public function delete($primary_key, $data = []) {
		$this->db->delete($this->table_name, ['id' => $primary_key]);
		// -- Return Primary Key --
		return $primary_key;
	}

	public function merge_fields() {
		$this->fields = array_merge($this->validation_fields, $this->calculated_fields);
	}

	/**
	 *  @brief Fungsi ini untuk menghapus field pada metadata
	 *
	 *  @param [in] $fields_name Nama field yang akan dihapus
	 *  @return Field yang dihapus (jika menghapus sekaligus banyak, maka yang direturn field yang terakhir dihapus)
	 *
	 *  @details Menghapus field bisa per field atau multi field. Jika ingin menghapus sekaligus banyak, maka field tersebut
	 *  harus dimasukan kedalam format array
	 */
	public function remove_fields($fields_name) {
		if (!is_array($fields_name)) {
			$fields_name = [$fields_name];
		}

		foreach ($fields_name as $_field_name) {
			$fields = $this->fields;
			foreach ($fields as $_index => $_fields) {
				if ($_fields['field'] == $_field_name) {
					unset($this->validation_fields[$_index]);
					break;
				}
			}
		}
		$this->merge_fields();

		return $this->fields;
	}

	/**
	 *  @brief Fungsi untuk menambahkan metadata
	 *
	 *  @param [in] $field Nama field yang akan ditambahkan
	 *  @param [in] $label Nama Label/ Caption
	 *  @param [in] $rules Validation Rules (Standard CodeiIgniter)
	 *
	 *  @details fungsi ini untuk menambahkan field tambahan yang belum di define
	 */
	public function add_fields($field, $label, $rules) {
		/**
		 * get field @ref get_fields($field)
		 */
		if (count($this->get_fields($field)) == 0) {
			$this->fields[] = ['field' => $field, 'label' => $label, 'rules' => $rules];
		} else {
			/**
			 *  set label @ref modify_label_fields($field, $label)
			 */
			$this->modify_label_fields($field, $label);

			/**
			 *  set rules @ref modify_rules_fields($field, $rules)
			 */
			$this->modify_rules_fields($field, $rules);
		}
	}

	public function modify_label_fields($field, $caption) {
		/**
		 *  set change label @ref _set_property_fields('label', $field, $caption)
		 */
		return $this->_set_property_fields('label', $field, $caption);
	}

	public function modify_rules_fields($field, $rules) {
		/**
		 *  set change rule @ref _set_property_fields('label', $field, $rules)
		 */
		return $this->_set_property_fields('rules', $field, $rules);
	}

	protected function _set_property_fields($property, $field, $value) {
		$is_found = false;
		foreach ($this->validation_fields as $_index=>$_fields) {
			if ($_fields['field'] == $field) {
				$this->validation_fields[$_index][$property] = $value;
				$is_found                                    = true;
				$this->merge_fields();
				break;
			}
		}

		return $this;
	}

	public function remove_rule_fields($field, $rule) {
		$result = false;

		/**
		 *  get field @ref get_fields($field)
		 */
		$configurations = $this->get_fields($field);
		if (count($configurations) > 0) {
			$rules = str_replace(['|' . $rule, $rule . '|', $rule], '', $configurations[0]['rules']);
			/**
			 *  Remove and restructure validation @ref modify_rules_fields($field, $rules)
			 */
			$result = $this->modify_rules_fields($field, $rules);
		}
		return $result;
	}

	/**
	 *  @brief Fungsi ini untuk menampilkan metadata per field
	 *
	 *  @param [in] $fields_name         Nama field yang akan di panggil
	 *  @param [in] $not_exception_field Penentuan logic status pengecekan nama field
	 *
	 *  @return Metadata field yang di panggil
	 *
	 *  @details Fungsi ini sebagai pengecekan field yang dipanggil apakah terdaftar atau tidak,
	 *  jika terdaftar maka akan di return metadata field tersebut
	 */
	public function get_fields($fields_name = null, $not_exception_field = true) {
		$results = [];

		if ($fields_name != null) {
			if (!is_array($fields_name)) {
				$fields_name = [$fields_name];
			}

			foreach ($fields_name as $_field_name) {
				$fields   = [];
				$is_found = false;
				foreach ($this->fields as $_index=>$_field) {
					if ($_field['field'] == $_field_name) {
						$fields   = $_field;
						$is_found = true;
						break;
					}
				}

				if ($is_found == $not_exception_field) {
					$results[] = $fields;
				}
			}
		} else {
			$results = $this->fields;
		}

		return $results;
	}

	/**
	 * Menambahkan variable post_field_name pada @var $this->fields.
	 * Dikarenakan nama variable yang di POST tidak boleh ada yang sama.
	 * Jika nama POST sama maka akan timbul error pada saat menjalankan fungsi $this->form_validation->run();
	 * Contoh parameter $post_field_name :
	 * return [
			'User_model' => ['id' => 'user_id'],
			'User_mata_kuliah_model' => [
				'id' => 'user_mata_kuliah_id',
				'keterangan' => 'keterangan_matkul'
			]
		];
	 * @param [in] Array $post_field_name
	 * @return void
	 */
	public function post_field_name($post_field_name) {
		foreach ($this->validation_fields as $idx => $properties) {
			if (isset($post_field_name[$properties['field']])) {
				$this->validation_fields[$idx]['post_field_name'] = $post_field_name[$properties['field']];
			}
		}
		$this->merge_fields();

	}

	/**
	 * Untuk mendapatkan field primary key yang di POST dari client
	 * @return String
	 */
	public function post_primary_key() {
		$primary = current($this->fields);
		return isset($primary['post_field_name']) && !empty($primary['post_field_name']) ? $primary['post_field_name'] : $primary['field'];
	}

	public function get($id = '') {
		$this->response_data = '';
		$data                = '';
		if (!empty($id)) {
			$this->db->where('id', $id);
		}
		$t_data = $this->db->get($this->table_name . ' AS ' . $this->table_name);
		if ($t_data->num_rows() > 0) {
			$this->response_data = $t_data->result();
		}
		return $this;
	}

	/**
	 * toDropdownArray digunakan untuk mengkonversi response data query ke dalam bentuk array
	 * yang akan digunakan untuk komponen HTML input dropdown
	 *
	 * @param mixed $value Value dropdown
	 * @param mixed $label Label dropdown
	 * @return void Array
	 */
	public function toDropdownArray($value, $label) {
		$list = [];
		if (!empty($this->response_data)) {
			if (is_array($this->response_data)) {
				foreach ($this->response_data as $idx => $response_data) {
					$list[$response_data->$value] = $response_data->$label;
				}
			}
		}

		return $list;
	}
}
