<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Symfony\Component\Filesystem\Filesystem;

if ( ! function_exists('check_login'))
{
	function check_login()
	{
		$CI =& get_instance();

		if(!$CI->session->userdata('userId'))
		{
			$CI->session->set_flashdata('message_alert', 'Maaf, Anda perlu login untuk mengakses halaman ini.');
			redirect('Welcome');
		}
	}
}

if ( ! function_exists('check_delete_permissions'))
{
	function check_delete_permissions($id_menu = '')
    {
		$CI =& get_instance();

		$userId = $CI->session->userdata('userId');
		$return =  FALSE;
		if($CI->session->userdata('userIsDelete') === TRUE)
			$return = $CI->session->userdata('userIsDelete');
		else
		{
			$CI->db->select('HAK_DELETE');
			$CI->db->from('hak_akses');
			$CI->db->where('ID_MENU', $id_menu);
			$CI->db->where('ID_ROLE', $userId);

			$result = $CI->db->get();
			$result = $result->result_array();
			if(count($result))
			{
				$return = $result[0]['HAK_DELETE'] === "1";
			}
			$CI->session->set_userdata('userIsDelete', $return);
		}

		return $return;
	}
}


if ( ! function_exists('access_denied'))
{
	function access_denied()
	{
		$CI =& get_instance();

		$CI->session->set_flashdata('message_alert', 'Mohon maaf anda tidak berhak mengakses halaman ini.');
		redirect('Welcome');
	}
}


/* Convert Date from 31/12/2013 to 2013-12-31 or in reverse 2013-12-31 to 31/12/2013
- use for save to database or display
*/
if ( ! function_exists('convert_date'))
{
	function convert_date($date_format='d/m/Y', $date='', $date_format_result='Y-m-d')
	{
		if($date == '0000-00-00')
			$date = '';

		$result = '';
		if (!empty($date))
		{
			$date_new = DateTime::createFromFormat($date_format, $date);
			if ($date_new)
				$result = $date_new->format($date_format_result);
		}

		return $result;
	}
}

/* Convert Date Time from 31/12/2013 22:55:10 to 2013-12-31 22:55:10 or in reverse 2013-12-31 22:55:10 to 31/12/2013 22:55:10
- use for save to database or display
*/
if ( ! function_exists('convert_date_time'))
{
	function convert_date_time($date_time_format='d/m/Y H:i:s', $date_time, $date_time_format_result='Y-m-d H:i:s')
	{
		if($date_time == '0000-00-00 00:00:00')
			$date_time = '';

		$result = $date_time;
		if (!empty($date_time))
		{
			$date_new = DateTime::createFromFormat($date_time_format, $date_time);
			$result = $date_new->format($date_time_format_result);
		}

		return $result;
	}
}

/* Convert Date Indonesia 2013-12-31 to 30 Desember 2013
- use for save to database or display
*/
if ( ! function_exists('convert_date_text'))
{
	function convert_date_text($date)
	{
		$CI =& get_instance();

		$result = $date;

		$temp = explode ('-', $date);
		if(count($temp) == 3)
		{
			$months = $CI->config->item('months');
			$month = intval($temp[1]);
			$bulan = (isset($months[$month]) ? $months[$month] : '');

			$result = $temp[2].' '.$bulan.' '.$temp[0];
		}

		return $result;
	}
}

/* Convert number 1,000 to 1000
- use for save to database
*/
if ( ! function_exists('convert_number'))
{
	function convert_number($number_string)
	{
		$result = str_replace(',', '', $number_string);

		return $result;
	}
}

/* Normalize line endings */
if ( ! function_exists('normalize'))
{
	function normalize($s) {
		// Convert all line-endings to UNIX format
		$s = str_replace("\r\n", "\n", $s);
		$s = str_replace("\r", "\n", $s);
		// Don't allow out-of-control blank lines
		$s = preg_replace("/\n{2,}/", "\n\n", $s);

		return $s;
	}
}

if ( ! function_exists('generate_id'))
{
	function generate_id($model = '',$prefix_id = '', $length_sequence_id = '4')
	{
		/* Cara Pakai
			echo generate_id($this->model_name,'501',5);
		*/
		$CI =& get_instance();
		$CI->load->model($model);
		$field_id = $CI->$model->field_id;
		$CI->db->select_max($field_id);
		$CI->db->from($CI->$model->table_name);
		if(!empty($prefix_id))
			$CI->db->where("LEFT(`".$CI->$model->field_id."`, LENGTH(`".$CI->$model->field_id."`) - ".$length_sequence_id.") = '".$prefix_id."'");

		$sql = $CI->db->get();
		$sequence_no = 1;
		if($sql !== FALSE){
			$result = $sql->row_array();
			if(isset($result[$CI->$model->field_id]) && !empty($result[$CI->$model->field_id]))
			{
				$sequence_no = substr($result[$CI->$model->field_id], (strlen($result[$CI->$model->field_id]) - $length_sequence_id), $length_sequence_id);
				if(is_numeric($sequence_no))
				{
					$sequence_no = $sequence_no + 1;
				}
			}
		}

		$sequence_no = sprintf("%0".$length_sequence_id."s",$sequence_no);

		return $prefix_id.$sequence_no;
	}
}

if ( ! function_exists('generate_id_old'))
{
	function generate_id_old($table_name, $field_id, $prefix_id = '', $length_sequence_id = 4)
	{
		/* Cara Pakai
			echo generate_id_old($this->model_name,'501',5);
		*/
		$CI =& get_instance();
		$CI->db->select_max($field_id);
		$CI->db->from($table_name);
		if(!empty($prefix_id))
			$CI->db->where("LEFT(`".$field_id."`, LENGTH(`".$field_id."`) - ".$length_sequence_id.") = '".$prefix_id."'");

		$sql = $CI->db->get();
		$sequence_no = 1;
		if($sql !== FALSE){
			$result = $sql->row_array();
			if(isset($result[$field_id]) && !empty($result[$field_id]))
			{
				$sequence_no = substr($result[$field_id], (strlen($result[$field_id]) - $length_sequence_id), $length_sequence_id);
				if(is_numeric($sequence_no))
				{
					$sequence_no = $sequence_no + 1;
				}
			}
		}

		$sequence_no = sprintf("%0".$length_sequence_id."s",$sequence_no);

		return $prefix_id.$sequence_no;
	}
}

/* Generate PIN */
if ( ! function_exists('pinGenerator'))
{
	function pinGenerator($table='upt')
	{
		$CI =& get_instance();
		$CI->load->helper('string');

		$pin = random_string('alnum', 10);
		$query = $CI->db->get_where($table, array('PIN' => $pin));
		if($query->num_rows()){
			pinGenerator($table);
		} else {
			return $pin;
		}
	}
}

/* Generate Romawi from Number */
if ( ! function_exists('romawiFromNumber'))
{
	function romawiFromNumber($num)
	{
		$n = intval($num);
		$res = '';

		$value_str = substr($num, strlen($n));

		/*** roman_numerals array  ***/
		$roman_numerals = array(
			'M'  => 1000,
			'CM' => 900,
			'D'  => 500,
			'CD' => 400,
			'C'  => 100,
			'XC' => 90,
			'L'  => 50,
			'XL' => 40,
			'X'  => 10,
			'IX' => 9,
			'V'  => 5,
			'IV' => 4,
			'I'  => 1
		);

		foreach ($roman_numerals as $roman => $number)
		{
			/*** divide to get  matches ***/
			$matches = intval($n / $number);

			/*** assign the roman char * $matches ***/
			$res .= str_repeat($roman, $matches);

			/*** substract from the number ***/
			$n = $n % $number;
		}

		/*** return the res ***/
		return $res.$value_str;
	}
}

/* Generate Number from Romawi */
if ( ! function_exists('numberFromRomawi'))
{
	function numberFromRomawi($roman)
	{
		$romans = array(
			'M' => 1000,
			'CM'=> 900,
			'D'	=> 500,
			'CD'=> 400,
			'C' => 100,
			'XC'=> 90,
			'L' => 50,
			'XL'=> 40,
			'X' => 10,
			'IX'=> 9,
			'V' => 5,
			'IV'=> 4,
			'I' => 1
		);

		$result = 0;

		$suffix = '';
		$roman_last = substr($roman, -1);
		if (strtolower($roman_last) == 'a')
		{
			$roman = substr($roman, 0, -1);
			$suffix = 'a';
		}

		foreach ($romans as $key => $value)
		{
			while (strpos($roman, $key) === 0)
			{
				$result += $value;
				$roman = substr($roman, strlen($key));
			}
		}

		return $result.$suffix;
	}
}

/* convert empty value html for table */
if ( ! function_exists('convert_empty_html'))
{
	function convert_empty_html($string='')
	{
		return $string = ($string !='' ? $string : '&nbsp;');
	}
}

/* angka terbilang */
if ( ! function_exists('angka_terbilang'))
{
	function angka_terbilang($x)
	{
	  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	  if ($x < 12)
		return " " . $abil[$x];
	  elseif ($x < 20)
		return angka_terbilang($x - 10) . "belas";
	  elseif ($x < 100)
		return angka_terbilang($x / 10) . " puluh" . angka_terbilang($x % 10);
	  elseif ($x < 200)
		return " seratus" . angka_terbilang($x - 100);
	  elseif ($x < 1000)
		return angka_terbilang($x / 100) . " ratus" . angka_terbilang($x % 100);
	  elseif ($x < 2000)
		return " seribu" . angka_terbilang($x - 1000);
	  elseif ($x < 1000000)
		return angka_terbilang($x / 1000) . " ribu" . angka_terbilang($x % 1000);
	  elseif ($x < 1000000000)
		return angka_terbilang($x / 1000000) . " juta" . angka_terbilang($x % 1000000);
	}
}

/* hari by tanggal */
if ( ! function_exists('hari_dari_tanggal'))
{
	function hari_dari_tanggal($tanggal)
	{
		$day = convert_date('Y-m-d', $tanggal, 'l');
		$days = config_item('days');

		$tanggal = (isset($days[$day]) ? $days[$day] : $tanggal);

	  return $tanggal;
	}
}

if ( ! function_exists('favicon'))
{
	function favicon()
	{

		$favicon = '<link rel="shortcut icon" href="'.site_url('/public/images/favicon.ico').'">';
		return $favicon;
	}
}

if ( ! function_exists('clean_up_url'))
{
	function clean_up_url($url)
	{
		return preg_replace('~((?<!:)/(?=/)|\\|.+)~', '', $url);
	}
}

if ( ! function_exists('human_array_concat'))
{
	function human_array_concat($array)
	{
		$caption = '';

		if (count($array) > 1)
		{
			$caption_2 = end($array);
			$caption_1 = array_pop($array);
			$caption = implode(', ', $array).' dan '.$caption_2;
		}
		elseif (count($array) == 1)
		{
			$caption = $array[0];
		}

		return $caption;
	}
}

if ( ! function_exists('number_format_decimal'))
{
	function number_format_decimal($value)
	{
		return str_replace('.00','',number_format($value, 2));
	}
}

if (! function_exists('compact_string'))
{
	function compact_string($string)
	{
		$string = trim(preg_replace('/\s\s+/', '', $string));
		return $string;
	}
}

if (! function_exists('get_image'))
{
	function get_image($file)
	{
		if (file_exists($file))
			return site_url($file);
		else
			return site_url('public/images/biometric/default.jpg');
	}
}

if (! function_exists('formatNumber'))
{
	function formatNumber( $number, $decimals=2, $dec_point=".", $thousands_sep=",")
	{
		$nachkomma = abs($number - floor($number));
		$strnachkomma = number_format($nachkomma , $decimals, ".", "");

		for ($i = 1; $i <= $decimals; $i++) {
			if (substr($strnachkomma, ($i * -1), 1) != "0") {
				break;
			}
		}

		return number_format($number, ($decimals - $i +1), $dec_point, $thousands_sep);
	}
}

if (! function_exists('number_to_text'))
{
	function number_to_text($angka)
	{
		$teks = '';
		/**
		 *  Logi saat ini dengan nilai Maksimal 9999
		 */
		if($angka < 10000)
		{
			$pangjang_satuan = array(
					3 => 'ratus',
					4 => 'ribu'
					);
			$angka = intval($angka);
			$length = strlen($angka);
			$lenght_satuan = ($length-2);

			$DuaAngkaTerakhir = substr($angka, ($lenght_satuan), 2);
			if ($length >= 3)
			{
				$teks = angka_to_teks($angka);
				if($teks == '')
				{
					$pembagi_satuan = 1;
					for($iSatuan=1; $iSatuan < $length; $iSatuan++){
						$pembagi_satuan .= 0;
					}
					$pembagi_satuan = intval($pembagi_satuan);

					$angka_satuan = floor($angka / $pembagi_satuan);
					if( $angka_satuan > 1)
					{
						$teks .= ' '.angka_to_teks($angka_satuan);
						$teks .= ' '.$pangjang_satuan[$length];
					}
					else
					{
						$teks .= ' '.angka_to_teks($pembagi_satuan);
					}
					$sisa_bagi = ($angka % $pembagi_satuan);
					$length_sisa = strlen($sisa_bagi);
					if ($sisa_bagi > 0 && isset($pangjang_satuan[$length_sisa]))
					{
						$teks .= ' '.number_to_text($sisa_bagi);
					}
					else
					{

						$teksDuaAngkaTerakhir = dua_angka_terakhir($DuaAngkaTerakhir);
						$teks .= ' '.$teksDuaAngkaTerakhir;
					}
				}
			}
			else
			{
				$teksDuaAngkaTerakhir = dua_angka_terakhir($DuaAngkaTerakhir);
				$teks .= ' '.$teksDuaAngkaTerakhir;
			}
		}

		$teks = strtolower(trim($teks));
		return $teks;
	}
}

if (! function_exists('dua_angka_terakhir'))
{
	function dua_angka_terakhir($DuaAngkaTerakhir)
	{
		$teks = angka_to_teks($DuaAngkaTerakhir);
		if ($teks == '')
		{
			if ($DuaAngkaTerakhir >= 20)
			{
				for($i2=0; $i2<strlen($DuaAngkaTerakhir); $i2++)
				{
					$duaAkhir = substr($DuaAngkaTerakhir, ($i2), 1);
					$angka_to_teks = angka_to_teks($duaAkhir);
					if ($angka_to_teks != '')
					{
						$teks .= ' '.$angka_to_teks;
						if($i2 == 0)
							$teks .= ' Puluh';
					}
				}
			}
			else if($DuaAngkaTerakhir > 11 && $DuaAngkaTerakhir < 20)
			{
				$satuAkhir = substr($DuaAngkaTerakhir, 1, 1);
				$angka_to_teks = angka_to_teks($satuAkhir);
				if ($angka_to_teks != '')
				{
					$teks .= ' '.$angka_to_teks.' Belas';
				}
			}
			else
			{
				$satuAngka = intval($DuaAngkaTerakhir);
				$angka_to_teks = angka_to_teks($satuAngka);
				if ($angka_to_teks != '')
				{
					$teks .= ' '.$angka_to_teks;
				}
			}
		}

		$teks = trim($teks);
		return $teks;
	}
}

if (! function_exists('angka_to_teks'))
{
	function angka_to_teks($angka)
	{
		$angka_to_teks = array(
				1 => 'Satu',
				2	=> 'Dua',
				3	=> 'Tiga',
				4	=> 'Empat',
				5	=> 'Lima',
				6	=> 'Enam',
				7 	=> 'Tujuh',
				8	=> 'Delapan',
				9	=> 'Sembilan',
				10 => 'Sepuluh',
				11 => 'Sebelas',
				100 => 'Seratus',
				1000 => 'Seribu');

		$teks = (isset($angka_to_teks[$angka]) ? $angka_to_teks[$angka] : '');

		return $teks;
	}
}

if (! function_exists('html_entity_decode_data_result'))
{
	function html_entity_decode_data_result($data)
	{
		if(empty($data))
			return $data;

		if(is_array($data) || is_object($data))
		{
			foreach($data as $index=>$value)
			{
				if(is_array($value))
				{
					if(is_array($data))
						$data[$index] = html_entity_decode_data_result($value);
					else if(is_object($data))
						$data->$index = html_entity_decode_data_result($value);
				}
				else if(is_object($value))
				{
					if(is_array($data))
						$data[$index] = html_entity_decode_data_result($value);
					else if(is_object($data))
						$data->$index = html_entity_decode_data_result($value);
				}
				else
				{
					if(is_array($data))
					{
						$data[$index] = html_entity_decode($value, ENT_QUOTES);
					}
					else if(is_object($data))
					{
						$data->$index = html_entity_decode($value, ENT_QUOTES);
					}
				}
			}
		}
		else
		{
			$data = html_entity_decode($data);
		}

		return $data;
	}
}

if (! function_exists('convert_number_decimal_format'))
{
	function convert_number_decimal_format($number, $percision=2)
	{
		$zero = '';
		for($i=0; $i<$percision; $i++)
			$zero .='0';

		return str_replace('.'.$zero, '', number_format($number, $percision));
	}
}

if (! function_exists('format_from_id'))
{
	function format_from_id($id)
	{
		$CI =& get_instance();

		$res = $CI->db->get_where('daftar_referensi',array('ID_LOOKUP'=>$id))->row();
		if(!empty($res)){
			$data = $res->DESKRIPSI;
			return $data;
		}

		//jika kosong cari di table propinsi
		$res = $CI->db->get_where('propinsi',array('ID_PROPINSI'=>$id))->row();
		if(!empty($res)){
			$data = $res->DESKRIPSI;
			return $data;
		}

		//jika kosong cari di table dati2
		$res = $CI->db->get_where('dati2',array('ID_DATI2'=>$id))->row();
		if(!empty($res)){
			$data = $res->DESKRIPSI;
			return $data;
		}

		//jika kosong cari di table daftar_negara
		$res = $CI->db->get_where('daftar_negara',array('ID_NEGARA'=>$id))->row();
		if(!empty($res)){
			$data = $res->NAMA_NEGARA;
			return $data;
		}


		//jika kosong cari di table pekerjaan
		$res = $CI->db->get_where('pekerjaan',array('ID_PEKERJAAN'=>$id))->row();
		if(!empty($res)){
			$data = $res->DESKRIPSI;
			return $data;
		}

		//jika kosong cari di table UPT
		$res = $CI->db->get_where('upt',array('ID_UPT'=>$id))->row();
		if(!empty($res)){
			$data = $res->URAIAN;
			return $data;
		}

		return $id;
	}
}

if (! function_exists('propinsi'))
{
	function propinsi($id)
	{
		$CI =& get_instance();

		$res = $CI->db->get_where('propinsi',array('ID_PROPINSI'=>$id))->row();
		if(!empty($res)){
			$data = $res->DESKRIPSI;
			return $data;
		}

		return $id;
	}
}

if (! function_exists('kota'))
{
	function kota($id)
	{
		$CI =& get_instance();

		$res = $CI->db->get_where('dati2',array('ID_DATI2'=>$id))->row();
		if(!empty($res)){
			$data = $res->DESKRIPSI;
			return $data;
		}

		return $id;
	}
}

if (! function_exists('negara'))
{
	function negara($id)
	{
		$CI =& get_instance();

		$res = $CI->db->get_where('daftar_negara',array('ID_NEGARA'=>$id))->row();
		if(!empty($res)){
			$data = $res->NAMA_NEGARA;
			return $data;
		}

		return $id;
	}
}

if (! function_exists('pekerjaan'))
{
	function pekerjaan($id)
	{
		$CI =& get_instance();

		$res = $CI->db->get_where('pekerjaan',array('ID_PEKERJAAN'=>$id))->row();
		if(!empty($res)){
			$data = $res->DESKRIPSI;
			return $data;
		}

		return $id;
	}
}

if (! function_exists('ya_tidak'))
{
	function ya_tidak($data)
	{

		if($data=='0'){
			$data='Tidak';
		}else{
			$data='Ya';
		}

		return $data;
	}
}

if (! function_exists('sudah_belum'))
{
	function sudah_belum($data)
	{
		if($data=='0'){
			$data='Belum';
		}else{
			$data='Sudah';
		}

		return $data;
	}
}

if (! function_exists('assign_not_assign'))
{
	function assign_not_assign($data)
	{
		if($data=='0'){
			$data='Assign';
		}else{
			$data='Not Assign';
		}

		return $data;
	}
}

if (! function_exists('leading_zeros'))
{
	function leading_zeros($value, $places)
	{
		$leading ="";
		if(is_numeric($value)){
			for($x = 1; $x <= $places; $x++){
				$ceiling = pow(10, $x);

				if($value < $ceiling){
					$zeros = $places - $x;
					for($y = 1; $y <= $zeros; $y++)
					{
						$leading .= "0";
					}
					$x = $places + 1;
				}
			}
			$output = $leading.$value;
		}
		else{
			$output = $value;
		}
		return $output;
	}
}

if ( ! function_exists('is_multi_array'))
{
	function is_multi_array($arr) {
		rsort( $arr );
		return isset($arr[0]) && is_array($arr[0]);
	}
}

if (!function_exists('set_message')) {
	function set_message($type, $message) {
		$CI        =&get_instance();
		$CI->session->set_flashdata('system_message', ['type'=>$type, 'message'=>$message]);
	}
}

if (!function_exists('get_message')) {
	function get_message() {
		$CI        =&get_instance();
		return $CI->session->flashdata('system_message');
	}
}

if (!function_exists('convert_filesize')) {
	function convert_filesize($file_size) {
		if ($file_size > 1048576) {
			return number_format($file_size / 1048576, 2, ',', '.') . ' MB';
		} elseif ($file_size > 1024) {
			return number_format($file_size / 1024, 2, ',', '.') . ' KB';
		} else {
			return number_format($file_size / 1024, 2, ',', '.') . ' Byte';
		}
	}
}

/**
 * @brief Delete semua array jika memenuhi kondisi dari $rejectCallback
 * @details
 * Cara penggunaan :
 * the case is reject/delete when value of this array is bigger than 3
 * $array = [1, 2, 3, 4, 5];
 * $array = array_reject($array, function ($value) {
 * 		return $value > 3
 * });
 * // result -> $array[1, 2, 3]
 * Ref : https://stackoverflow.com/questions/7225070/php-array-delete-by-value-not-key
 * @param[in] $arrayToFilter 	array 		Variable array yang akan difilter
 * @param[in] $rejectCallback callable 	Callback function, delete semua array yang memenuhi kondisi fungsi ini, parameternya $value dan $key dari array yang sedang diproses
 */
if ( ! function_exists('array_reject')) {
	function array_reject(array &$arrayToFilter, callable $rejectCallback) {
		$filteredArray = [];
		foreach ($arrayToFilter as $key => $value) {
			if ( ! $rejectCallback($value, $key)) {
				$filteredArray[$key] = $value;
			}
		}

		return $filteredArray;
	}
}

/**
 * @brief Filter semua array jika memenuhi kondisi $filterCallback
 * @details
 * Cara penggunaan :
 * the case is return only when value of this array is bigger than 3
 * $array = [1, 2, 3, 4, 5];
 * $array = array_pass($array, function ($value) {
 * 		return $value > 3
 * });
 * // result -> $array[4, 5]
 * @param[in] $arrayToFilter 	array 		Variable array yang akan difilter
 * @param[in] $filterCallback callable 	Callback function, return semua array yang memenuhi kondisi fungsi ini, parameternya $value dan $key dari array yang sedang diproses
 */
if ( ! function_exists('array_pass')) {
	function array_pass(array &$arrayToFilter, callable $filterCallback) {
		$filteredArray = [];
		foreach ($arrayToFilter as $key => $value) {
			if ($filterCallback($value, $key)) {
				$filteredArray[$key] = $value;
			}
		}

		return $filteredArray;
	}
}

/**
 * @brief download file pdf dan zip
 * params(FileDownload) ->merupakan path dari file pdf yg akan di download
 * params(file_name) ->nama file yang akan terdownload
 * params(type) -> type file yang akan di download , ex:pdf , zip
 */
if ( !function_exists('download_file')) {
	function download_file($FileDownload, $file_name, $type, $qrfile = NULL) {
		$CI =&get_instance();
		if(file_exists($FileDownload)==TRUE) {
			$CI->load->library('Maskpdf');
			$pdf = new Maskpdf();
			$pagecount = $pdf->setSourceFile($FileDownload);
			for($i=1;$i<=$pagecount;$i++){
				$tplidx = $pdf->importPage($i);
				$pdf->addPage();
				$pdf->useTemplate($tplidx, 10, 0, 180);
				$pdf->Image($qrfile,3,7,18);

				$fileSystem = new Filesystem();
				if ($fileSystem->exists($qrfile))
					$fileSystem->remove($qrfile);
			}
			if ($type == 'zip'){
				$cPdf = $pdf->Output($file_name, 'S');
				$nPos = strrpos($file_name, '.');
				$FileNameWithoutExt = substr($file_name, 0, $nPos);
				$tmp_file=tempnam(sys_get_temp_dir(),'zip');
				$CI->load->library('zip');
				$CI->zip->add_data($file_name, $cPdf);
				$CI->zip->archive($tmp_file);
				$CI->zip->download($FileNameWithoutExt.'.zip');
			} else {
					$pdf->Output($file_name, 'D');
			}
		}
	}
}

/**
 * @brief Untuk melimit string
 * params(string)
 * params(bp)
 */
if ( !function_exists('string_limit')) {

	function string_limit($string, $bp) {
		$CI =&get_instance();
		$string = strip_tags($string);
		if (strlen($string) > config_item('string_limit')) {

			// truncate string
			$stringCut = substr($string, 0, config_item('string_limit'));
			$endPoint  = strrpos($stringCut, ' ');

			//if the string doesn't contain any space then it will cut without word basis.
			$string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
			$string .= $bp ;
		}
		return $string;
	}
}

/**
 * untuk menghilangkan html character
 * params(string)
 */
if ( !function_exists('remove_html')) {
	function remove_html($content) {
		$content = strip_tags($content);
		$content = utf8_encode($content);
		$content = str_replace('&nbsp;', ' ', $content);
		$content = preg_replace("/[^a-zA-Z0-9\/\/\/:-?~!#$%^&*()@<>.,\'\"\=+ ]+/", '', $content);
		return $content;
	}
}

if (!function_exists('kategori_public')) {
	function kategori_public($id_kategori, $site = 'direktori/kategori') {
		$CI =&get_instance();
		$CI->load->model('Kategori_model');
		$list_nama_path = $CI->Kategori_model->get_nama_by_path($id_kategori);
		$nama_result = '';
		foreach ($list_nama_path as $kategori) {
			if($kategori['jenis_kategori'] == 'PTS') {
				$nama_result .= ' <i class="fa fa-angle-double-right"></i> <a style="font-size: 12px;" href="'.site_url($site.'/jenis/' . $kategori['url_name']).'"> '.$kategori['nama_kategori'].' </a>';
			} elseif ($kategori['jenis_kategori'] == 'RK') {
				$nama_result .= '<i class="fa fa-angle-double-right"></i> <a style="font-size: 12px;" href="'.site_url('rumusan_kamar/kamar/kategori/' . $kategori['url_name']).'"> '.$kategori['nama_kategori'].' </a>';
			} elseif ($kategori['jenis_kategori'] == 'RST') {
				$nama_result .= ' <i class="fa fa-angle-double-right"></i> <a style="font-size: 12px;" href="'.site_url('restatement/kategori/jenis/' . $kategori['url_name']).'"> '.$kategori['nama_kategori'].' </a>';
			} else {
				$nama_result .= '<i class="fa fa-angle-double-right"></i> <a style="font-size: 12px;" href="'.site_url('yurisprudensi/bidang/kategori/' . $kategori['url_name']).'"> '.$kategori['nama_kategori'].' </a>';
			}
		}

		return $nama_result;

	}
}

if ( ! function_exists('bgcli')) {
	function bgcli($cmd) {
		if (substr(php_uname(), 0, 7) == 'Windows') {
			pclose(popen('start /B ' . $cmd, 'r')); // -- Silent mode --
			// pclose(popen("start ". $cmd, "r")); // -- Tampil CMD nya --
		} else {
			exec($cmd . ' > /dev/null &');  // -- Ini buat di linux --
		}
	}
}

if ( ! function_exists('is_file_locked')) {
	function is_file_locked($dir, $file) {
		if (substr(php_uname(), 0, 7) == 'Windows') {
			$result = exec(config_item('lsof') . ' ' . $dir . $file);
			if ($result == 'No locking processes found.') {
				return false;
			} else {
				return true;
			}
		} else {
			$result = exec('lsof +d ' . $dir . ' | grep -c -i ' . $file);  // -- Ini buat di linux --
			if ($result == 0) {
				return false;
			} else {
				return true;
			}
		}
	}
}

if(!function_exists('get_extension_by_mime')) {

    function get_extension_by_mime($filename, $flip = false) {

        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
			'doc' => 'application/msword',
			'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'rtf' => 'application/rtf',
			'xls' => 'application/vnd.ms-excel',
			'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
			'ppt' => 'application/vnd.ms-powerpoint',
			'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
		);

		$extension = 'dat';

		$mime_types = array_flip($mime_types);
		if (file_exists($filename)) {
			$mime = mime_content_type($filename);
			if (array_key_exists($mime, $mime_types)) {
				$extension = $mime_types[$mime];
			} else {
				$extension = pathinfo($filename, PATHINFO_EXTENSION);
			}
		}

		return $extension;
    }
}

if ( ! function_exists('attr')) {
	/**
	 * Fungsi yang digunakan untuk menampilkan label dari table attribute
	 * Contoh : echo attr('identitas_negara', 'INDONESIA', $mapping);
	 *
	 * @param string $key
	 * @param string $value
	 * @param array $mapping	Parameter output sebagai variable yang menampung data array
	 * @return string
	 */
	function attr($key, $value, &$mapping) {
		$CI =&get_instance();

		if ( ! isset($mapping[$key][$value])) {
			$CI->db->select('key, value, label');
			$CI->db->where('key', $key);
			$t_attrs = $CI->db->get('attribute');
			if ($t_attrs->num_rows() > 0) {
				$attrs = $t_attrs->result();
				foreach ($attrs as $attr) {
					$mapping[$attr->key][$attr->value] = $attr->label;
				}
			}
		}

		return isset($mapping[$key][$value]) ? $mapping[$key][$value] : '';
	}
}




/* End of file utility_helper.php */
/* Location: ./application/helpers/utility_helper.php */
