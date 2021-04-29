<?php  if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
include 'acl/gacl.class.php';
include 'acl/gacl_api.class.php';
class Acl {
	public $CI;
	public $_acl;
	public $_defaultAroSection='';
	public $_defaultAroGroup  = '';

	protected $mariaDB;

	/**
	 * Constructor
	 *
	 * Loads the calendar language file and sets the default time reference
	 *
	 * @access	public
	 */
	public function __construct($config = []) {
		$this->CI =&get_instance();

		// -- Connect to MariaDB --
		$this->mariaDB = $this->CI->load->database('gacl', TRUE);
		// $this->mariaDB = $mariaDB;

		// $configdb =$this->mariaDB;
		$configdb =$this->mariaDB;

		$this->CI->config->load('acl');
		$configacl=$this->CI->config->item('acl');

		$this->_defaultAroGroup  =$configacl['default_aro_group'];
		$this->_defaultAroSection=$configacl['default_aro_section'];
		$this->_defaultAcoSection=$configacl['default_aco_section'];
		$this->_defaultAxoSection=$configacl['default_axo_section'];

		$gacl_options['debug']                   = $configacl['debug'];
		$gacl_options['db_type']                 = $configdb->dbdriver;
		$gacl_options['db_host']                 = $configdb->hostname;
		$gacl_options['db_port']                 = $configdb->port;
		$gacl_options['db_user']                 = $configdb->username;
		$gacl_options['db_password']             = $configdb->password;
		$gacl_options['db_name']                 = $configdb->database;
		$gacl_options['db_table_prefix']         = 'gacl_';
		$gacl_options['caching']                 = '';
		$gacl_options['force_cache_expire']      = 1;
		$gacl_options['cache_dir']               = '/tmp/phpgacl_cache';
		$gacl_options['cache_expire_time']       = 600;
		$gacl_options['items_per_page']          = 100;
		$gacl_options['max_select_box_items']    = 100;
		$gacl_options['max_search_return_items'] = 200;
		$gacl_options['smarty_dir']              = 'smarty/libs';
		$gacl_options['smarty_template_dir']     = 'templates';
		$gacl_options['smarty_compile_dir']      = 'templates_c';

		$this->_acl = new gacl_api($gacl_options);
	}

	public function getUsers() {
		$aResult = $this->_acl->get_objects($this->_defaultAroGroup, $return_hidden = 1, $object_type = 'aro');
		return $aResult[$this->_defaultAroGroup];
	}

	public function addUser($username, $groupValue=null, $section=null) {
		$section=($section == null) ? $this->_defaultAroSection : $section;
		$result = $this->_acl->add_object($section, $username, $username, 0, 0, 'aro');

		$aroGroupId = $this->_acl->get_group_id($this->_defaultAroGroup, $this->_defaultAroGroup, 'aro');
		$this->_acl->add_group_object($aroGroupId, $section, $username, 'aro');

		if (!empty($groupValue)) {
			//$aroGroupId = null;
			$aroGroupId = $this->_acl->get_group_id($groupValue, $groupValue, 'aro');
			$this->_acl->add_group_object($aroGroupId, $section, $username, 'aro');
		}
	}

	public function deleteUser($username, $section=null) {
		$section=($section == null) ? $this->_defaultAroSection : $section;

		$groups=$this->getUserGroupIds($username);
		foreach ($groups as $groupValue=>$groupName) {
			$this->removeUserFromGroup($username, $groupValue);
		}
		$id = $this->_acl->get_object_id($section, $username, 'aro');
		return $this->_acl->del_object($id, 'aro', true);
	}

	public function getUserGroupIds($username, $section=null) {
		$return =[];
		$section=($section == null) ? $this->_defaultAroSection : $section;
		$id     = $this->_acl->get_object_id($section, $username, 'aro');

		$aReturn = $this->_acl->get_object_groups($id, $object_type = 'ARO');

		for ($i=0; $i < count($aReturn); $i++) {
			$aTmp            = $this->_acl->get_group_data($aReturn[$i], 'ARO');
			$return[$aTmp[2]]=$aTmp[3];
		}
		return $return;
	}

	public function addUserToGroup($username, $groupValue, $section=null) {
		$section    =($section == null) ? $this->_defaultAroSection : $section;
		$aroGroupId = $this->_acl->get_group_id($groupValue, $groupValue, 'aro');
		return $this->_acl->add_group_object($aroGroupId, $section, $username, 'aro');
	}

	/**
	 * removeUserFromGroup()
	 *
	 * Removes an Object from a group.
	 *
	 * @return bool Returns TRUE if successful, FALSE otherwise
	 *
	 * @param string username
	 * @param string groupValue
	 */
	public function getGroupObjects($groupValue, $groupType, $section='') {
		switch ($groupType) {
			case 'aco':
				$section=$this->_defaultAcoSection;
				break;
			case 'aro':
				$section=$this->_defaultAroSection;
				break;
			case 'axo':
				$section=$this->_defaultAxoSection;
				break;
		}
		$groupId = $this->_acl->get_group_id($groupValue, $section, $groupType);
		return  $this->_acl->get_group_objects($groupId, $groupType);
	}

	public function removeUserFromGroup($username, $groupValue, $section=null) {
		$section    =($section == null) ? $this->_defaultAroSection : $section;
		$aroGroupId = $this->_acl->get_group_id($this->_defaultAroGroup, $this->_defaultAroGroup, 'aro');
		$this->_acl->del_group_object($aroGroupId, $section, $username, 'aro');

		if (!empty($groupValue)) {
			//$aroGroupId = null;
			$aroGroupId = $this->_acl->get_group_id($groupValue, $groupValue, 'aro');
			return $this->_acl->del_group_object($aroGroupId, $section, $username, 'aro');
		}
	}

	public function getGroups() {
		return $this->_acl->get_object(null, 1, $group_type='ARO');
	}

	public function checkAcl($acoSectionValue=null, $acoValue, $aroSectionValue=null, $aroValue, $axoSectionValue=null, $axoValue) {
		$aroSectionValue=($aroSectionValue == null) ? $this->_defaultAroSection : $aroSectionValue;
		$acoSectionValue=($acoSectionValue == null) ? $this->_defaultAcoSection : $acoSectionValue;
		$axoSectionValue=($axoSectionValue == null) ? $this->_defaultAxoSection : $axoSectionValue;
		return $this->_acl->acl_check($acoSectionValue, $acoValue, $aroSectionValue, $aroValue, $axoSectionValue, $axoValue); //, $root_aro_group=NULL, $root_axo_group=NULL)
	}

	public function checkAclDefault($acoValue, $aroValue, $axoValue) {
		$aroSectionValue=$this->_defaultAroSection;
		$acoSectionValue=$this->_defaultAcoSection;
		$axoSectionValue=$this->_defaultAxoSection;

		return  $this->_acl->acl_check($acoSectionValue, $acoValue, $aroSectionValue, $aroValue, $axoSectionValue, $axoValue);
	}

	public function checkAclRedirect($acoSectionValue=null, $acoValue, $aroSectionValue=null, $aroValue, $axoSectionValue=null, $axoValue) {
		$aroSectionValue=(isnull($aroSectionValue)) ? $this->_defaultAroSection : $aroSectionValue;
		$acoSectionValue=(isnull($acoSectionValue)) ? $this->_defaultAcoSection : $acoSectionValue;
		$axoSectionValue=(isnull($axoSectionValue)) ? $this->_defaultAxoSection : $axoSectionValue;
		$granted        =$this->checkAclDefault($acoSectionValue, $acoValue, $aroSectionValue, $aroValue, $axoSectionValue, $axoValue);
		if (!$granted) {
			$this->aclRedirect('not_valid');
		} else {
			return $granted;
		}
	}

	public function checkAclDefaultRedirect($acoValue, $aroValue, $axoValue) {
		$granted=$this->checkAclDefault($acoValue, $aroValue, $axoValue);
		if (!$granted) {
			$this->aclRedirect('not_valid');
		} else {
			return $granted;
		}
	}

	public function searchAcl($acoSectionValue=false, $acoValue=false, $aroSectionValue=false, $aroValue=false, $aro_group_name=false, $axoSectionValue=false, $axoValue=false, $axo_group_name=false, $return_value=false) {
		return $this->_acl->search_acl($acoSectionValue, $acoValue, $aroSectionValue, $aroValue, $aro_group_name, $axoSectionValue, $axoValue, $axo_group_name, $return_value);
	}

	public function searchAclDefault($acoValue=false, $aroValue=false, $aro_group_name=false, $axoValue=false, $axo_group_name=false, $return_value=false) {
		$aroSectionValue=$this->_defaultAroSection;
		$acoSectionValue=$this->_defaultAcoSection;
		$axoSectionValue=$this->_defaultAxoSection;
		return $this->_acl->search_acl($acoSectionValue, $acoValue, $aroSectionValue, $aroValue, $aro_group_name, $axoSectionValue, $axoValue, $axo_group_name, $return_value);
	}

	public function deleteAcl($acl_id) {
		return $this->_acl->del_acl($acl_id);
	}

	public function getAcl($aclId) {
		return $this->_acl->get_acl($aclId);
	}

	public function aclRedirect($go_topage='') {
		$this->CI->load->helper('url');
		if ($go_topage == '') {
			redirect('main/index');
		} elseif ($go_topage == 'not_valid') {
			redirect('main/index/2');
		} else {
			redirect($go_topage);
		}
	}

	public function aclAroAccess($aroSectionValue, $aroValue) {
		$aro_groups = $this->aroGroups($aroSectionValue, $aroValue);
		$result     = [];
		$this->mariaDB->select('a.id, a.allow, a.return_value, ax.value AS axo_value, ac.value AS aco_value');
		$this->mariaDB->from('gacl_acl AS a');
		$this->mariaDB->join('gacl_aco_map AS ac', 'ac.acl_id = a.id', 'LEFT');
		$this->mariaDB->join('gacl_aro_map AS ar', 'ar.acl_id = a.id', 'LEFT');
		$this->mariaDB->join('gacl_axo_map AS ax', 'ax.acl_id = a.id', 'LEFT');
		$this->mariaDB->join('gacl_aro_groups_map AS arg', 'arg.acl_id = a.id', 'LEFT');
		$this->mariaDB->join('gacl_aro_groups AS rg', 'rg.id = arg.group_id', 'LEFT');
		$this->mariaDB->join('gacl_axo_groups_map AS axg', 'axg.acl_id = a.id', 'LEFT');
		$this->mariaDB->join('gacl_axo_groups AS xg', 'xg.id = axg.group_id', 'LEFT');
		$this->mariaDB->where('a.enabled', 1);
		$this->mariaDB->where('a.allow', 1);
		if (empty($aro_groups)) {
			$this->mariaDB->where('(ar.section_value = \'' . $aroSectionValue . '\' AND ar.value = \'' . $aroValue . '\')', null, false);
		} else {
			$this->mariaDB->where('((ar.section_value = \'' . $aroSectionValue . '\' AND ar.value = \'' . $aroValue . '\') OR rg.id IN (' . $aro_groups . '))', null, false);
		}
		$query_order = '(CASE WHEN ar.value IS NULL THEN 0 ELSE 1 END) DESC,(rg.rgt-rg.lft) ASC,(CASE WHEN ax.value IS NULL THEN 0 ELSE 1 END) DESC,(xg.rgt-xg.lft) ASC,a.updated_date DESC';
		$this->mariaDB->order_by($query_order, false);
		$acl_query = $this->mariaDB->get();
		if ($acl_query->num_rows() > 0) {
			$result = $acl_query->result();
		}
		return $result;
	}

	public function aroGroups($aroSectionValue, $aroValue) {
		$sql_aro_group_ids = [];
		$query_select      = 'DISTINCT g2.id';
		$this->mariaDB->select($query_select, false);
		$this->mariaDB->from('gacl_aro AS o, gacl_groups_aro_map AS gm, gacl_aro_groups AS g1, gacl_aro_groups AS g2');
		$this->mariaDB->where('(o.section_value = \'' . $aroSectionValue . '\' AND o.value = \'' . $aroValue . '\')', null, false);
		$this->mariaDB->where('gm.aro_id = o.id');
		$this->mariaDB->where('g1.id = gm.group_id');
		$this->mariaDB->where('(g2.lft <= g1.lft AND g2.rgt >= g1.rgt)', null, false);
		$aro_group_query = $this->mariaDB->get();
		if ($aro_group_query->num_rows() > 0) {
			$result_aro_group  = $aro_group_query->result();
			foreach ($result_aro_group as $aro) {
				$aro_arr[] = $aro->id;
			}

			$sql_aro_group_ids = implode(',', $aro_arr);
		}
		return $sql_aro_group_ids;
	}

	/*
	function getAxo($acoSectionValue=NULL, $acoValue, $aroSectionValue=NULL, $aroValue, $axoSectionValue=NULL, $axoValue=NULL){
		$axos=array();
		$res= $this->searchAcl($acoSectionValue, $acoValue, $aroSectionValue, $aroValue, FALSE, $axoSectionValue, $axoValue, FALSE, FALSE);

			foreach($res as $acl){
				$axo=$acl['axo'][$axoSectionValue];
				$axo=array_flip($axo);
				$axos=array_merge($axos,$axo);
			}

		return $axos;
	}
	function getAxoDefault($acoValue, $aroValue=FALSE, $axoValue=FALSE){
		$axos=array();
		$axo=array();
		$aroSectionValue=$this->_defaultAroSection;
		$acoSectionValue=$this->_defaultAcoSection;
		$axoSectionValue=$this->_defaultAxoSection;
		$res= $this->searchAcl($acoSectionValue, $acoValue, $aroSectionValue, $aroValue, FALSE, $axoSectionValue, $axoValue, FALSE, FALSE);

		foreach($res as $key){
			$acl=$this->getAcl($key);
			$axo=$acl['axo'][$axoSectionValue];
			$axo=array_flip($axo);
			$axos=array_merge($axos,$axo);

		}
		var_dump($res);echo $axoSectionValue;

		return $axos;
	}
	*/
}
