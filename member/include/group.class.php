<?php 
defined('IN_PHPCMS') or exit('Access Denied');

class group
{
	var $groupid;
	var $db;
	var $errormsg;

    function group($groupid = 0)
	{
		global $db;
		$this->db = &$db;
        $this->set_groupid($groupid);
        register_shutdown_function(array(&$this, '__destruct'));
    }

	function __destruct()
	{
	}

	function set_groupid($groupid)
	{
		$groupid = intval($groupid);
		if($groupid < 1) return FALSE;
		$this->groupid = $groupid;
		return TRUE;
	}

	function get_info()
	{
        return $this->db->get_one("SELECT * FROM ".TABLE_MEMBER_GROUP." WHERE groupid=$this->groupid limit 0,1");
	}
}
?>