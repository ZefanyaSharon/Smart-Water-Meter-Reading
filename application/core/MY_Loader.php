<?php  if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
/**
 * MY_Loader
 * Extends the base CI_Loader class so we we can override the database()
 * load method
 * @author Calvin Lai <calvin@row27.com>
 * @author Simon Emms <simon@simonemms.com>
 */
class MY_Loader extends CI_Loader {
	/**
	 * Database Loader
	 *
	 * @access	public
	 * @param	string	the DB credentials
	 * @param	bool	whether to return the DB object
	 * @param	bool	whether to enable active record (this allows us to override the config setting)
	 * @return	object
	 */
	public function database($params = '', $return = false, $query_builder = null) {
		// Grab the super object
		$CI =& get_instance();

		// Do we even need to load the database class?
		if ($return === false && $query_builder === null && isset($CI->db) && is_object($CI->db) && !empty($CI->db->conn_id)) {
			return false;
		}

		$prefix = config_item('subclass_prefix');
		$db_extends = APPPATH . 'core/' . $prefix . 'DB.php';
		if (file_exists($db_extends))  {
			require_once $db_extends;
		} else {
			require_once BASEPATH . 'database/DB.php';
		}

		// Load the DB class
		$db =& DB($params, $query_builder);

		$my_driver      = config_item('subclass_prefix') . 'DB_' . $db->dbdriver . '_driver';
		$my_driver_file = APPPATH . 'core/' . $my_driver . '.php';

		if (file_exists($my_driver_file)) {
			require_once $my_driver_file;
			$db_obj = new $my_driver(get_object_vars($db));
			$db =& $db_obj;
		}

		if ($db->dbdriver == 'pdo') {
			$db->conn_id->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
		}

		if ($return === true) {
			return $db;
		}

		// Initialize the db variable.  Needed to prevent
		// reference errors with some configurations
		$CI->db = '';
		$CI->db = $db;
		// return $this;
	}
}
