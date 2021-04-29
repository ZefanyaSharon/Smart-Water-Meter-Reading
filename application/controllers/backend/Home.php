<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class Home extends MY_Controller {
	public $test;

	public function __construct() {
		parent::__construct();
		//authentication_check();
		$this->controller_name = __CLASS__;
		$this->page_title      = 'Home';
		$this->id_menu	       = '11e8ba57f13980208974313035393130';
	}

	public function index() {
		$this->view_name = 'home';

		$this->_addition_display['countVerdict'] = $this->db->count_all_results('putusan');
		parent::index();
	}
}