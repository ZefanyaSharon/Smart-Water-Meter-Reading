<?php  if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class MY_DB_query_builder extends CI_DB_query_builder {

	protected $logstash_data_es;
	protected $logstash_data_druid;
	public $use_prepare;

	public function from($from) {
		foreach ((array) $from as $val)
		{
			if (strpos($val, ',') !== FALSE)
			{
				foreach (explode(',', $val) as $v)
				{
					$v = trim($v);
					$this->_track_aliases($v);

					if ($this->subdriver == 'ibm')
						$v = DB2_SCHEMA . '.' . $v;

					$this->qb_from[] = $v = $this->protect_identifiers($v, TRUE, NULL, FALSE);

					if ($this->qb_caching === TRUE)
					{
						$this->qb_cache_from[] = $v;
						$this->qb_cache_exists[] = 'from';
					}
				}
			}
			else
			{
				$val = trim($val);
				if ($this->subdriver == 'ibm')
					$val = DB2_SCHEMA . '.' . $val;

				// Extract any aliases that might exist. We use this information
				// in the protect_identifiers to know whether to add a table prefix
				$this->_track_aliases($val);

				$this->qb_from[] = $val = $this->protect_identifiers($val, TRUE, NULL, FALSE);

				if ($this->qb_caching === TRUE)
				{
					$this->qb_cache_from[] = $val;
					$this->qb_cache_exists[] = 'from';
				}
			}
		}

		return $this;
	}

	public function update($table = '', $set = NULL, $where = NULL, $limit = NULL) {
		$table_ori = $table;
		$table = $table;
		$CI =& get_instance();

		// -- Get current data on database --
		$old_data = '';
		$qb_where = $this->_compile_wh('qb_where');
		if ( ! in_array($table, $CI->lib_log->excludeTable)) {
			$old_data = $this->get_data($table, $qb_where);
		}

		// -- Process write to DB --
		if ( ! $this->use_prepare)
			$return = parent::update($table, $set, $where, $limit);
		else
			$return = self::update_prepare($table, $set, $where, $limit);

		// -- Insert to queue --
		if ( ! empty($old_data) && $table != 'queue') {
			$new_data = $this->get_data($table, $qb_where);
			$CI->lib_log->pushLogChangeToQueue('update', $table, $old_data, $new_data);
		}

		// -- Logstash druid --
		$created = isset($old_data['created']) ? $old_data['created'] : date('Y-m-d H:i:s');
		$set['id'] = $old_data['id'];
		$this->set_druid_logstash_data('U', $table_ori, $set['id'], $created);

		// -- Logstash ES --
		$this->set_es_logstash_data('U', $table_ori, $set);

		$this->use_prepare = false;

		return $return;
	}

	private function update_prepare($table = '', $set = null, $where = null, $limit = null) {
		if ($set !== NULL)
			$this->set($set, '', false);

		if ($where !== NULL)
			$this->where($where);

		if ( ! empty($limit))
			$this->limit($limit);

		if ($table !== '')
			$this->qb_from = array($this->protect_identifiers($table, TRUE, NULL, FALSE));

		$set_value = [];
		foreach ($this->qb_set as $key => $val)
		{
			$set_str[] = '"' . $key.'" = :' . str_replace('"', '', $key);
			$set_value[$key] = $val;
		}

		$sql_string = 'UPDATE ' . $this->qb_from[0] . ' SET ' . implode(', ', $set_str)
			. $this->_compile_wh('qb_where')
			. ($this->qb_limit !== FALSE ? ' LIMIT '.$this->qb_limit : '');

		$sql = $this->conn_id->prepare($sql_string);
		$this->_reset_write();

		if ($this->save_queries === TRUE)
			$this->queries[] = $sql_string . PHP_EOL . var_export($set_value, true);

		$time_start = microtime(TRUE);

		$result = $sql->execute($set_value);

		$time_end = microtime(TRUE);

		$this->benchmark += $time_end - $time_start;

		if ($this->save_queries === TRUE)
			$this->query_times[] = $time_end - $time_start;

		// Increment the query counter
		$this->query_count++;

		if ($result === false) {
			log_message('error', 'Query error: ' . var_export($sql->errorInfo(), true) . ' - Query: ' . $sql_string . ' - Value: ' . var_export($set_value, true));
		}
		return $result;
	}

	public function delete($table = '', $where = '', $limit = NULL, $reset_data = TRUE) {
		$CI =& get_instance();
		$table_ori = $table;
		if ( ! is_array($table)) {
			$table = $table;
		}

		// -- Get current data on database --
		$old_data = '';
		$qb_where = $this->_compile_wh('qb_where');
		if ( ! in_array($table, $CI->lib_log->excludeTable)) {
			$old_data = $this->get_data($table, $qb_where);
		}

		$return = parent::delete($table, $where, $limit, $reset_data);

		// -- Logstash druid --
		$created = isset($old_data['created']) ? $old_data['created'] : date('Y-m-d H:i:s');
		$id = isset($old_data['id']) ? $old_data['id'] : '';
		$this->set_druid_logstash_data('D', $table_ori, $id, $created);

		// -- Logstash ES --
		$this->set_es_logstash_data('D', $table_ori, $old_data);

		return $return;
	}

	public function join($table, $cond, $type = '', $escape = NULL) {
		if ($this->subdriver == 'ibm')
			$table = DB2_SCHEMA . '.' . $table;
		return parent::join($table, $cond, $type, $escape);
	}

	public function insert($table = '', $set = NULL, $escape = NULL) {
		$table_ori = $table;
		$table = $table;

		if ( ! $this->use_prepare)
			$return = parent::insert($table, $set, $escape);
		else
			$return = self::insert_prepare($table, $set, $escape);

		// -- Logstash druid --
		$created = isset($set['created']) ? $set['created'] : date('Y-m-d H:i:s');
		//$this->set_druid_logstash_data('A', $table_ori, $set['id'], $created);

		// -- Logstash ES --
		//$this->set_es_logstash_data('A', $table_ori, $set);

		$this->use_prepare = false;

		return $return;
	}

	private function insert_prepare($table = '', $set = null, $escape = null) {
		$sql = '';

		if ($set !== NULL)
			$this->set($set, '', false);

		if ($table !== '')
			$this->qb_from = array($this->protect_identifiers($table, TRUE, NULL, FALSE));

		$set_value = [];
		foreach ($this->qb_set as $key => $val)
		{
			$set_field[] = '"' . $key . '"';
			$set_str[] = ':' . $key;
			$set_value[$key] = $val;
		}

		$sql_string = 'INSERT INTO '.$this->qb_from[0].' (' .implode(', ', $set_field). ') VALUES (' . implode(', ', $set_str) . ')';

		$sql = $this->conn_id->prepare($sql_string);

		if ($this->save_queries === TRUE)
			$this->queries[] = $sql_string . PHP_EOL . var_export($set_value, true);

		$time_start = microtime(TRUE);

		$result = $sql->execute($set_value);
		$this->_reset_write();

		$time_end = microtime(TRUE);

		$this->benchmark += $time_end - $time_start;

		if ($this->save_queries === TRUE)
			$this->query_times[] = $time_end - $time_start;

		// Increment the query counter
		$this->query_count++;

		if ($result === false) {
			log_message('error', 'Query error: '.var_export($sql->errorInfo(), true).' - Query: '.$sql_string . ' - Value: ' . var_export($set_value, true));
		}
		return $result;
	}

	public function get_data($table, $criteria) {
		/**
		 * Jika ada perubahan pada field criteria (where) maka return nya akan kosong
		 * Contoh : UPDATE `rup_penelitian` SET IS_PENELITIAN_AKHIR = 0 WHERE IS_PENELITIAN_AKHIR =  1 AND `ID_RUP_BARANG` =  '132201508070004'
		 * Field IS_PENELITIAN_AKHIR diubah tapi digunakan juga sebagai criteria pencarian
		 * Maka akan terjadi error karena current_data tidak ditemukan, sehingga log_verified tidak bisa membandingkan antara old_data dengan current_data
		 */

		// if ( ! empty($qb_where)) {
		// 	$criteria = $this->_compile_wh('qb_where');
		// }

		// -- Gegara DB2 jadi harus kek gini kan.. rempong --
		$table = $table;

		// -- Query data --
		$result   = $this->query('SELECT * FROM ' . $table . ' ' . $criteria)->row_array();
		return $result;
	}

	public function list_fields($table) {
		$table = explode('.', $table);
		return $this->query("SELECT NAME, POS, MTYPE, PRTYPE, LEN FROM INFORMATION_SCHEMA.INNODB_SYS_COLUMNS WHERE NAME = '".end($table)."'");
	}

	public function _compile_select($select_override = FALSE) {
		return parent::_compile_select($select_override);
	}

	public function _reset_select() {
		parent::_reset_select();
	}

	public function get_count($table = '', $reselect_count = FALSE)
	{
		if ($table != '')
		{
			$this->_reset_select();
			$this->_track_aliases($table);
			$this->from($table);
		}

		$qb_orderby = [];
		if ($this->qb_orderby) {
			$qb_orderby = $this->qb_orderby;
			$this->qb_orderby = [];
		}

		$sql = $this->_compile_select($this->_count_string . $this->protect_identifiers('numrows'));
		if(strpos($sql, 'GROUP BY') || strpos($sql, 'HAVING') && $reselect_count == TRUE)
		{
			$sql_reselect = $this->_compile_select();

			$symbol_removes = array("\n", "\r\n", "\r");
			$sql_reselect = str_replace($symbol_removes, ' ', $sql_reselect);

			$from_word = ' FROM ';
			$from_pos = $this->get_ipos_outside_bracket($sql_reselect, $from_word);
			$query_after_from = substr($sql_reselect, $from_pos + strlen($from_word));

			$query_before_from = substr($sql_reselect, 0, $from_pos);
			$select_query = str_replace(' *', ' 1', $query_before_from);

			$sql_reselect = 'SELECT COUNT(*) numrows FROM ('.$select_query.' FROM '.$query_after_from.') t1';
		}

		$query = $this->query($sql);
		$total_row = $query->num_rows();
		if ($total_row == 0)
		{
			return 0;
		}
		else if($total_row > 1)
		{
			return $total_row;
		}
		else if((strpos($sql, 'GROUP BY') || strpos($sql, 'HAVING')) && $reselect_count == TRUE)
		{
			// jika ada data menggunakan group by dan muncul 1 record contoh: overstaying_rekap group by id_upt (akan muncul 1 record jika di upt). Untuk sementara hardcode dengan parameter reselect_count
			$query = $this->query($sql);
			return $query->num_rows();
		}

		$row = $query->row();

		$this->qb_orderby = $qb_orderby;

		return (int) $row->numrows;
	}

	protected function get_ipos_outside_bracket($haystack, $needle, $bracket_1 = '(', $bracket_2 = ')', $outside = 0)
    {
        $strs = str_split($haystack);

        $deep_count = 0;
        $deep_counter = 0;
        $new_text = '';
        $is_write_text = TRUE;
        foreach ($strs as $str_idx=>$str)
        {
            if ($str == $bracket_1)
            {
                if ($deep_counter >= $outside)
                    $is_write_text = FALSE;
                $deep_counter++;

                if ($deep_counter > $deep_count)
                    $deep_count = $deep_counter;
            }
            if ($is_write_text == TRUE)
            {
                $new_text .= $str;
                if (strtolower(substr($new_text, -(strlen($needle)))) == strtolower($needle))
                    return $str_idx + 1 - strlen($needle);
            }
            if ($str == $bracket_2)
            {
                $deep_counter--;
                if ($deep_counter == $outside)
                    $is_write_text = TRUE;
            }
        }

        return FALSE;
	}

	protected function set_druid_logstash_data($action, $table, $id, $created) {
		if (in_array($table, ['putusan', 'putusan_identitas', 'putusan_identitas_hukuman', 'putusan_pejabat'])) {
			$this->logstash_data_druid[$id] = [
				'id' => $id,
				'table' => $table,
				'action' => $action,
				'created' => $created
			];
		}
	}

	protected function set_es_logstash_data($action, $table, $data) {
		if (in_array($table, ['putusan', 'rumusan_kamar', 'restatement', 'yurisprudensi', 'peraturan'])) {
			$id = $data['id'];
			$jenis = $table;
		}
		elseif (in_array($table, ['putusan_identitas', 'putusan_pejabat'])) {
			$id = $data['id_putusan'];
			$jenis = 'putusan';
		}
		elseif (in_array($table, ['putusan_identitas_hukuman'])) {
			$this->select("put_iden.id_putusan");
			$this->from("$table as $table");
			$this->join("putusan_identitas AS put_iden", "put_iden.id = $table.id_putusan_identitas", "LEFT");
			$this->where("$table.id_putusan_identitas", $data['id_putusan_identitas']);
			$result = $this->get()->first_row();

			$id = $result->id_putusan;
			$jenis = 'putusan';
		}
		elseif (in_array($table, ['rumusan_kamar_putusan'])) {
			$id = $data['id_rumusan_kamar'];
			$jenis = 'rumusan_kamar';
		}
		elseif (in_array($table, ['restatement_author','restatement_putusan'])) {
			$id = $data['id_restatement'];
			$jenis = 'restatement';
		}
		elseif (in_array($table, ['yurisprudensi_peraturan','yurisprudensi_putusan'])) {
			$id = $data['id_yurisprudensi'];
			$jenis = 'yurisprudensi';
		}

		if (isset($jenis)) {
			$this->logstash_data_es[$id] = [
				'id' => $id,
				'jenis'	 => $jenis,
				'action' => $action
			];
		}
	}

	public function get_logstash_data($type) {
		return $this->{'logstash_data_' . $type};
	}

	// public function where($key, $value = NULL, $escape = NULL)
	// {
	// 	$key = DB2_SCHEMA . '.' . $key;
	// 	return $this->_wh('qb_where', $key, $value, 'AND ', $escape);
	// }

	// public function order_by($orderby, $direction = '', $escape = NULL)
	// {
	// 	$orderby = DB2_SCHEMA . '.' . $orderby;
	// 	return parent::order_by($orderby, $direction, $escape);
	// }
}

// END MY_Input class

/* End of file MY_Input.php */
/* Location: ./appication/core/MY_Input.php */
