<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Upload extends CI_Upload {

	public $_file_name_override = '';

	public function __construct($config = []) {
		parent::__construct($config);
	}

	public function do_upload($field = 'userfile') {
		$upload = parent::do_upload($field);
		// if ($upload === true) {
		// 	rename($this->upload_path.$this->file_name, $this->upload_path.$this->_file_name_override);
		// }
		return $upload;
	}
}

// END MY_Input class

/* End of file MY_Input.php */
/* Location: ./appication/core/MY_Input.php */