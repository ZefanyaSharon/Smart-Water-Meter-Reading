<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$config = [

	# -- Jangan lupa berikan hak akses write pada folder "apps" -- sudo chmod 777 -R apps atau bisa lebih secure hanya diberikan pada user www
	'log_path'   => '/var/www/248putusan/logstash/apps/log/data/',

	'log_enable' => [
		'auth'  => true,
		'access' => true,
		'change' => true,
	],

	/**
	 * Logstash Configuration
	 */
	'logstash_ip'   => 'localhost',
	'logstash_port' => '8080',
	'logstash_user' => 'admin',
	'logstash_pass' => 'secret',

	/**
	 * Storage type
	 * elasticsearch | mysql (local database)
	 */
	'log_storage' => 'elasticsearch',

	/**
	 * Elasticsearch Configuration
	 */
	'es_log_ip'    => 'localhost',
	'es_log_port'  => '9200',
	'es_log_index' => 'log_index',
	'es_user'      => '',
	'es_pass'      => '',
];
