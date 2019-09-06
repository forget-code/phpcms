<?php
class credit
{
	var $db;
	var $table;
	var $table_member;

	function __construct()
	{
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'ask_credit';
	}

	function credit()
	{
		$this->__construct();
	}

	function edit($id, $info)
	{
		$id = intval($id);
		if(!$id || !is_array($info)) return false;
		return $this->db->update($this->table, $info, "id=$id");
	}

	function get($userid)
	{
		$userid = intval($userid);
		$result = $this->db->get_one("SELECT * FROM $this->table WHERE userid=$userid");
		return $result;
	}

	function update($userid, $username, $credit = 0, $isadd = 0)
	{
		if($isadd)
		{
			$r = $this->db->get_one("SELECT COUNT(cid) AS num FROM $this->table WHERE userid='$userid'");
			if($r['num']==0)
			{
				$info['userid'] = $userid;
				$info['username'] = $username;
				$info['addtime'] = TIME;
				$this->db->insert($this->table, $info);
			}
			$timestamp = TIME;
			$months = date('n',$timestamp);
			$years = date('Y',$timestamp);
			$liveweek = date('w', $timestamp);
			$weeks = $liveweek*86400+date('H')*3600+date('i')*60+date('s');
			$ymdate = mktime(0,0,0,$months,1,$years);
			$credit = intval($credit);

			@extract($this->db->get_one("SELECT * FROM $this->table WHERE userid='$userid'"));
			if($timestamp-$addtime>=$weeks)
			{
				$this->db->query("UPDATE $this->table SET `preweek`=`week`, `week`='$credit' WHERE userid='$userid'");
				if(($timestamp-$addtime)>=($addtime-$ymdate))
				$this->db->query("UPDATE $this->table SET `premonth`=`month`, `month`='$credit' WHERE userid='$userid'");
			}
			else
			{
				$this->db->query("UPDATE $this->table SET `week`=`week`+$credit WHERE userid='$userid'");
				if(($timestamp-$addtime)<($addtime-$ymdate))
				$this->db->query("UPDATE $this->table SET `month`=`month`+$credit WHERE userid='$userid'");
			}
		}
		else 
		{
			$r = $this->db->get_one("SELECT COUNT(cid) AS num FROM $this->table WHERE userid='$userid'");
			if($r['num']==0)
			{
				$info['userid'] = $userid;
				$info['username'] = $username;
				$info['addtime'] = TIME;
				$this->db->insert($this->table, $info);
			}
			else
			{
				@extract($this->db->get_one("SELECT month,week FROM $this->table WHERE userid='$userid'"));
				if(($month && $credit<$week && $credit<$month) || ($week && $credit<$week && $credit<$month))
				{
					$this->db->query("UPDATE $this->table SET `month`=`month`-$credit, `week`=`week`-$credit WHERE userid='$userid'");
				}
				elseif($credit>$week)
				{
					$this->db->query("UPDATE $this->table SET `month`=0, `week`=0 WHERE userid='$userid'");
				}
			}
		}
	}
}
?>