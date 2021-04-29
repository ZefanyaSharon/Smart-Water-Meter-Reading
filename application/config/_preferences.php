<?php

$config = [
	'app_domain' => 'http://localhost', // contoh : http://putusan.mahkamahagung.go.id
	'app_email' => 'muswanto@continentum.com', // contoh : admin@putusan.mahkamahagung.go.id

	'enable_profiler' => false,

	'url_visual_svn' => 'http://localhost:8080/svn/',
	
	'user_svn' => 'test',
	
	'pass_svn' => '123456',

	// -- Document management configuration
	'document_table' => 'dokumen',
	'document_model' => 'Dokumen_model',
	'document_path' => 'docs/',
	'document_type' => 'jpg|png|jpeg|pdf|rtf',
	'document_max_size' => 20000,
	'document_history_path' => '/var/www/248putusan/doc_history/',

	// -- tingkat proses untuk penamaan folder dokumen putusan
	'tingkat_proses_file_path' => [
		'ptm'	=> 'pertama',
		'bdg'	=> 'banding',
		'k'	=> 'kasasi',
		'pk'	=> 'pk'
	],

	//path untuk simpan data indexing ke ES
	'indexing_es_file_path' => '/var/www/248putusan/logstash/apps/idx_es/data/',

	'indexing_druid_file_path' => '/var/www/248putusan/logstash/apps/idx_druid/data/',

	// path buat simpan data path dokumen
	'migrasi_dokumen_path' => '/var/www/248putusan/logstash/apps/doc_v2/data/',

	// -- path untuk simpan file text logstash converter --
	'converter_file_path' => '/var/www/248putusan/logstash/apps/converter/data/',

	'logstash_file_migration' => '/var/www/248putusan/logstash/apps/migration/data/',

	'metabaseServer'   => 'http://192.168.1.32:3000',

	'metabaseSecretKey' => '9235530931b2a7029809edc02d513f0a5045601570d331f3bf6028a9054c91d0',

	'tmp_mpdf' => '/var/www/248putusan/mpdf_tmp',

	'app_name' => 'Direktori Putusan',

	'php' => '/usr/bin/php7.2', // php path

	'cli' => '/var/www/248putusan/cli.php', // cli path

	'qpdf' => '/usr/bin/qpdf', // qpdf executeable

	'public_limit_per_page' => 10,
	'pagination_per_page' => 39,
	'pagination_num_link' => 3,
	'admin_pagination_per_page' => 50,
	'string_limit' => 250,

	'boolean' => [
		0 => 'No',
		1 => 'Yes',
	],

	'boolean_invers' => [
		0 => 'Yes',
		1 => 'No'
	],

	'is_active' => [
		0 => 'Not Active',
		1 => 'Active',
	],

	'is_publish' => [
		0 => 'Not Published',
		1 => 'Published',
	],

	'log_auth_type' => [
		0 => 'Login Failed',
		1 => 'Login Success',
		2 => 'Logout',
	],

	'category_type' => [
		'article' => 'Article',
		'event' => 'Event',
	],

	'jqgrid_limit_per_page' => '50',
	'jqgrid_limit_pages' => '50, 100, 150',

	'sub_grid_limit_per_page' => '5',
	'sub_grid_limit_pages' => '5, 10, 20',

	/* -- Date Format -- */
	'server_date_format' => 'Y-m-d',
	'server_datetime_format' => 'Y-m-d H:i:s',
	'server_datetime_nosecond_format' => 'Y-m-d H:i',
	'server_time_format' => 'H:i:s',
	'server_time_nosecond_format' => 'H:i',

	'server_display_date_format' => 'd-m-Y',
	'server_display_datetime_format' => 'd-m-Y H:i:s',
	'server_display_datetime_nosecond_format' => 'd-m-Y H:i',
	'server_display_time_format' => 'H:i:s',
	'server_display_time_nosecond_format' => 'H:i',

	'server_client_parse_validate_date_format' => 'yyyy-MM-dd',
	'server_client_parse_validate_datetime_format' => 'yyyy-MM-dd HH:mm:ss',
	'server_client_parse_validate_datetime_nosecond_format' => 'yyyy-MM-dd HH:mm',
	'server_client_parse_validate_time_format' => 'HH:mm:ss',
	'server_client_parse_validate_time_nosecond_format' => 'HH:mm',

	'client_picker_datetime_format' => 'DD-MM-YYYY H:mm:ss',
	'client_picker_date_format' => 'dd-mm-yy',
	'client_picker_time_format' => 'hh:mm:ss',
	'client_picker_time_nosecond_format' => 'hh:mm',

	'client_validate_date_format' => 'dd-MM-yyyy',
	'client_validate_datetime_format' => 'dd-MM-yyyy HH:mm:ss',
	'client_validate_datetime_nosecond_format' => 'dd-MM-yyyy HH:mm',
	'client_validate_time_format' => 'HH:mm:ss',
	'client_validate_time_nosecond_format' => 'HH:mm',

	'client_jqgrid_date_format' => 'd-m-Y',
	'client_jqgrid_datetime_format' => 'd-m-Y H:i:s',
	'client_jqgrid_datetime_nosecond_format' => 'd-m-Y H:i',
	'client_jqgrid_time_format' => 'H:i:s',
	'client_jqgrid_time_nosecond_format' => 'H:i',

	'months' => [
		1 => 'Januari',
		2 => 'Februari',
		3 => 'Maret',
		4 => 'April',
		5 => 'Mei',
		6 => 'Juni',
		7 => 'Juli',
		8 => 'Agustus',
		9 => 'September',
		10 => 'Oktober',
		11 => 'Nopember',
		12 => 'Desember'
	],

	'gender_id' => [
		'l' => 'Pria',
		'p' => 'Wanita',
	],

	'peradilan' => [
		'MAHKAMAH-AGUNG'	=> 'Mahkamah Agung',
		'UMUM'		   		=> 'Peradilan Umum',
		'AGAMA'		  		=> 'Peradilan Agama',
		'MILITER'	 		=> 'Peradilan Militer',
		'TUN'		    	=> 'Peradilan Tata Usaha Negara',
		'PENGADILAN-PAJAK'  => 'Pengadilan Pajak'
	],

	'tingkat_pengadilan' => [
		'MA|BADILAG|BADILUM|BADILMILTUN|DILMILTAMA|PT|PTA|PTM|PTTUN|PN|PA|PM|PTUN'
	],

	'tingkat_proses' => [
		'0'	=> 'Pertama',
		'1'	=> 'Banding',
		'2'	=> 'Kasasi',
		'3'	=> 'Peninjauan Kembali'
	],

	'metadata_data_type' =>	[
		'int'      => 'Integer',
		'varchar'  => 'Varchar',
		'float'    => 'Float',
		'date'     => 'Date',
		'datetime' => 'Date Time',
		'long varchar' => 'Long Varchar',
	],

	'metadata_field_type' =>	[
		'textbox'    => 'Text Box',
		'textarea'   => 'Text Area',
		'select'     => 'Select',
		'summernote' => 'Summer Note',
		'select2'    => 'Select2',
		'radio'      => 'Radio',
		'checkbox'   => 'Check Box',
	],

	'kamar' =>	[
		''         => '&#8212;',
		'PIDANA'   => 'Pidana',
		'PERDATA'  => 'Perdata',
		'TUN'      => 'Tun',
		'MILITER'  => 'Militer',
		'AGAMA'           => 'Agama',
		'KESEKRETARIATAN' => 'Kesekretariatan',
	],

	'jenis_kategori' =>	[
		''     => '&#8212;',
		'PTS'  => 'Putusan',
		'RST'  => 'Restatement',
		'RK'   => 'Rumusan Kamar',
		'YURIS'=> 'Yurisprudensi',
	],

	'tipe_worker' => [
		'MS_OFFICE' => 'MS Office',
		'ABIWORD' => 'Abiword',
		'OPEN_OFFICE' => 'Open Office',
	],
];
