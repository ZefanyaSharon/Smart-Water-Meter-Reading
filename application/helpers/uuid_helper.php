<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('uuid_generate_v1')) {
	function uuid_generate_v1() {
		$CI =& get_instance();
		$CI->load->library('not/uuid');
		$uuid = $CI->uuid->generate(1, 101, date('Hisu'));
		return $uuid;
	}
}

// -- Biar lebih simple nama function nya dipendekin --
if ( ! function_exists('guid')) {
	function guid($sufix = '') {
		$uuid = uuid_generate_v1();
		$uuid = substr($uuid,  14, 4).
				substr($uuid,  9,4).
				substr($uuid,  0, 8).
				substr($uuid,  19,4).
				substr($uuid, 24);
		$uuid = ( ! empty($sufix) ? $uuid.$sufix : $uuid);

		return $uuid;
	}
}
