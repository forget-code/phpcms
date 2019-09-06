<?php
if(!function_exists('cache_formguid'))
{
	require 'cache.func.php';
}
class formguide
{	
	var $db;
	var $table;
	var $table_data;
	var $msg = '';

	function __construct()
	{
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'formguide';;
		$this->table_fields = DB_PRE.'formguide_fields';
		cache_formguid();
	}

	function formguide()
	{
		$this->__construct();
	}

	function get($formid)
	{
		$formid = intval($formid);
		if($formid < 1) return false;
		$result = $this->db->get_one("SELECT * FROM $this->table WHERE formid='$formid'");
		return $result;
	}

	function add($formid, $info)
	{
		global $_userid, $FORMGUIDE, $M;
		if(!$FORMGUIDE[$formid]['disabled'])
		{
			$this->msg = 'form_disabled';
			return false;
		}
		if($FORMGUIDE[$formid]['enabletime'] && ($FORMGUIDE[$formid]['starttime'] > TIME || $FORMGUIDE[$formid]['endtime'] < TIME))
		{
			return false;
		}
		$tablename = DB_PRE.'form_'.$FORMGUIDE[$formid]['tablename'];
		$info['ip'] = IP;
		if(!$M['allowmultisubmit'])
		{
			$getip = $this->db->get_one("SELECT dataid FROM $tablename WHERE IP='$info[ip]'");
			if($getip) 
			{
				$this->msg = 'the_ip_have_input';
				return false;
			}
		}
		$info['datetime'] = TIME;
		$info['userid'] = $_userid;
		$formid = $this->db->update($tablename, $info);
		unset($FORMGUIDE, $FORM);
		return $formid;
	}

	function msg()
	{
		global $LANG;
		return $LANG[$this->msg];
	}
}
?>