<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class Lib_log {
	protected $CI;
	protected $storage;
	protected $logstashIP;
	protected $logstashPort;

	/**
	 * Variable penampung table yang perubahannya tidak di log
	 *
	 * @var array
	 */
	public $excludeTable;

	public function __construct() {
		$this->CI =&get_instance();
		$this->CI->load->helper('file');
		$this->CI->config->load('log');

		$this->storage      = config_item('log_storage');
		$this->logstashIP   = config_item('logstash_ip');
		$this->logstashPort = config_item('logstash_port');
		$this->logPath      = config_item('log_path');

		$this->excludeTable = ['queue']; // table berikut tidak boleh diexclude : putusan, putusan_identitas, putusan_hukuman, hakim
	}

	public function pushLogAuth($data) {
		$username         = isset($data['username']) ? $data['username'] : null;
		$user_id          = isset($data['user_id']) ? $data['user_id'] : null;
		$notes            = isset($data['notes']) ? $data['notes'] : null;
		$action_status    = isset($data['action_status']) ? $data['action_status'] : null;

		return self::writeToFile([
			'id'            => guid(),
			'action_type'   => 'Auth',
			'created_at'    => date('Y-m-d H:i:s'),
			'username'      => $username,
			'user_id'       => $user_id,
			'ip'            => $_SERVER['REMOTE_ADDR'],
			'user_agent'    => $_SERVER['HTTP_USER_AGENT'],
			'url'           => $_SERVER['REQUEST_URI'],
			'action_status' => $action_status,
			'notes'         => self::setNotes($notes),
		]);
	}

	public function pushLogAccess() {
		$username      = isset($data['username']) ? $data['username'] : null;
		$user_id       = isset($data['user_id']) ? $data['user_id'] : null;
		$notes         = isset($data['notes']) ? $data['notes'] : null;
		$action_status = isset($data['action_status']) ? $data['action_status'] : null;

		return self::writeToFile([
			'id'            => guid(),
			'action_type'   => 'Access',
			'created_at'    => date('Y-m-d H:i:s'),
			'username'      => $username,
			'user_id'       => $user_id,
			'ip'            => $_SERVER['REMOTE_ADDR'],
			'user_agent'    => $_SERVER['HTTP_USER_AGENT'],
			'url'           => $_SERVER['REQUEST_URI'],
			'action_status' => $action_status,
			'notes'         => self::setNotes($notes),
		]);
	}

	/**
	 * Push Log Change to file
	 *
	 * @return void
	 */
	public function pushLogChange() {

	}

	/**
	 * Push Log Change to table queue
	 *
	 * @param string $mode
	 * @param string $table
	 * @param array $old_data
	 * @param array $new_data
	 * @return void
	 */
	public function pushLogChangeToQueue($mode, $table, $old_data = [], $new_data = []) {
		// -- Clearing data --
		if ( ! empty($old_data) && ! empty($new_data)) {
			unset($old_data['created'], $old_data['created_by'], $old_data['updated'], $old_data['updated_by']);
			unset($new_data['created'], $new_data['created_by'], $new_data['updated'], $new_data['updated_by']);
		}

		// -- Check change or not --
		$old_data_changed = [];
		$new_data_changed = [];
		if ($mode == 'update') {
			// -- Get fields from table --
			$fields = $this->CI->db->list_fields($table)->result();

			// -- Compare data --
			foreach ($fields as $field) {
				// -- If not changed, unset it --
				if ((isset($old_data[$field->NAME]) && isset($new_data[$field->NAME])) &&
					($old_data[$field->NAME] != $new_data[$field->NAME])
				) {
					$old_data_changed[$field->NAME] = utf8_encode($old_data[$field->NAME]);
					$new_data_changed[$field->NAME] = utf8_encode($new_data[$field->NAME]);
				}
			}
		}

		// -- Compare data and insert to table queue --
		if ($mode == 'insert' || ( ! empty($old_data_changed) && ! empty($new_data_changed)) ) {
			$queue = [];
			$queue['id'] = guid();
			$queue['metadata'] = json_encode([
				'old_data' => $old_data_changed,
				'new_data' => $new_data_changed,
			]);
			$queue['type'] = 'change_log';
			$queue['ref_id'] = $old_data['id'];
			$queue['table'] = $table;
			$queue['is_sukses'] = 0;
			$queue['created'] = date('Y-m-d H:i:s');
			$queue['updated'] = date('Y-m-d H:i:s');

			$this->CI->db->insert('queue', $queue);
		}
	}

	private function writeToFile($data) {
		$fileSystem = new Filesystem();
		$fileSystem->dumpFile($this->logPath . '/' . $data['action_type'] . '_' . date('Y_m_d_H_i_s') . '_' . guid() . '.txt', json_encode($data) . PHP_EOL);
	}

	private function setNotes($notes) : string {
		$result = json_encode($notes);
		return $result;
	}

	public function testBulkLog($count = 10) {
		$data = [
			'random1' => guid(),
			'random2' => guid()
		];
		for ($i = 0; $i < $count; $i++) {
			write_file($this->logPath . '/' . 'test_' . date('Y_m_d_H_i_s') . '_' . guid() . '.txt', json_encode($data));
		}

		return $i;
	}
}
