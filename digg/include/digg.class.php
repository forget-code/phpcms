<?php
class digg
{
	var $db;
	var $table;
	var $table_log;
	var $table_content;
	var $userid;
	var $username;

    function __construct()
    {
		global $db, $_userid, $_username;
		$this->db = &$db;
		$this->table = DB_PRE.'digg';
		$this->table_log = DB_PRE.'digg_log';
		$this->table_content = DB_PRE.'content';
		$this->userid = $_userid;
		$this->username = $_username;
    }

	function digg()
	{
		$this->__construct();
	}

	function get($contentid, $fields = 'supports,againsts')
	{
		$contentid = intval($contentid);
		return $this->db->get_one("SELECT $fields FROM `$this->table` WHERE `contentid`=$contentid");
	}

	function update($contentid, $flag = 1)
	{
		$contentid = intval($contentid);
        $flag = $flag == 1 ? 1 : 0;
		if($this->is_done($contentid) || !$this->content_exists($contentid)) return false;
		$r = $this->get($contentid, '*');
		if($r)
		{
			if($flag)
			{
				$supports = $data = $r['supports'] + 1;
				$supports_day = (date('Ymd', $r['updatetime']) == date('Ymd', TIME)) ? ($r['supports_day'] + 1) : 1;
				$supports_week = (date('YW', $r['updatetime']) == date('YW', TIME)) ? ($r['supports_week'] + 1) : 1;
				$supports_month = (date('Ym', $r['updatetime']) == date('Ym', TIME)) ? ($r['supports_month'] + 1) : 1;
				$sql_update = "`supports`=$supports,`supports_day`=$supports_day,`supports_week`=$supports_week,`supports_month`=$supports_month";
			}
			else
			{
				$againsts = $data = $r['againsts'] + 1;
				$againsts_day = (date('Ymd', $r['updatetime']) == date('Ymd', TIME)) ? ($r['againsts_day'] + 1) : 1;
				$againsts_week = (date('YW', $r['updatetime']) == date('YW', TIME)) ? ($r['againsts_week'] + 1) : 1;
				$againsts_month = (date('Ym', $r['updatetime']) == date('Ym', TIME)) ? ($r['againsts_month'] + 1) : 1;
				$sql_update = "`againsts`=$againsts,`againsts_day`=$againsts_day,`againsts_week`=$againsts_week,`againsts_month`=$againsts_month";
			}
	        $this->db->query("UPDATE `$this->table` SET $sql_update, `updatetime`=".TIME." WHERE `contentid`=$contentid");
		}
		else
		{
			if($flag)
			{
				$this->db->query("INSERT INTO `$this->table`(`contentid` , `supports` , `againsts` , `supports_day` , `againsts_day` , `supports_week` , `againsts_week` , `supports_month` , `againsts_month` , `updatetime` ) VALUES ('$contentid', '1', '0', '1', '0', '1', '0', '1', '0', '".TIME."')");
			}
			else
			{
				$this->db->query("INSERT INTO `$this->table`(`contentid` , `supports` , `againsts` , `supports_day` , `againsts_day` , `supports_week` , `againsts_week` , `supports_month` , `againsts_month` , `updatetime` ) VALUES ('$contentid', '0', '1', '0', '1', '0', '1', '0', '1', '".TIME."')");
			}
			$data = 1;
		}
		$this->db->query("INSERT INTO `$this->table_log`(`contentid` , `flag` , `userid` , `username` , `ip` , `time` ) VALUES ('$contentid', '$flag', '$this->userid', '$this->username', '".IP."', '".TIME."')");
		return $data;
	}

	function is_done($contentid)
	{
		$contentid = intval($contentid);
		$where = $this->userid ? "`userid`=$this->userid AND `contentid`=$contentid" : "`ip`='".IP."' AND `contentid`=$contentid";
		return $this->db->get_one("SELECT `flag` FROM `$this->table_log` WHERE $where");
	}

    function content_exists($contentid)
    {
		$contentid = intval($contentid);
		return $this->db->get_one("SELECT `status` FROM `$this->table_content` WHERE `contentid`=$contentid AND `status`=99");
    }

	function delete($contentid)
	{
		$contentids = is_array($contentid) ? implodeids($contentid) : intval($contentid);
		if(!$contentids) return false;
        $this->db->query("DELETE FROM `$this->table` WHERE `contentid` IN($contentids)");
        $this->db->query("DELETE FROM `$this->table_log` WHERE `contentid` IN($contentids)");
	}
}
?>