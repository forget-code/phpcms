<?php
class url
{
	var $db;
	var $URLRULE;
	var $PHPCMS;
	var $TYPE;

	function url()
	{
		global $db, $TYPE, $URLRULE, $PHPCMS, $M;
		$this->db = &$db;
		$this->URLRULE = $URLRULE;
		$this->PHPCMS = $PHPCMS;
		$this->TYPE = $TYPE;
		$this->M = $M;
	}

	function index()
	{
		return 'index.'.$this->PHPCMS['fileext'];
	}

	function type($typeid, $page = 0)
	{
        $type = cache_read('type.php');
		$typedir = $type[$typeid]['typedir'];
		$fileext = $this->PHPCMS['fileext'];
		$urlruleid = $this->M['type_urlruleid'];
		$urlrules = explode('|', $this->URLRULE[$urlruleid]);
		$urlrule = $page == 0 ? $urlrules[0] : $urlrules[1];
		eval("\$url = \"$urlrule\";");
		return $url;
	}

	function show($specialid, $filename = '', $typeid = 0)
	{
		if($filename == '')
		{
			$r = $this->db->get_one("SELECT `typeid`,`filename` FROM `".DB_PRE."special` WHERE `specialid`='$specialid'");
			$typeid = $r['typeid'];
			$filename = $r['filename'];
		}
		if(!isset($this->TYPE[$typeid])) return false;
		$typedir = $this->TYPE[$typeid]['typedir'];
		$fileext = $this->PHPCMS['fileext'];
		$urlruleid = $this->M['show_urlruleid'];
		$urlrule = $this->URLRULE[$urlruleid];
		eval("\$url = \"$urlrule\";");
		return $url;
	}
}
?>