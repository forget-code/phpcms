<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require_once PHPCMS_ROOT.'/member/include/member.class.php';

class member_admin extends member
{
    function member_admin($username = '')
	{
		parent::member($username);
        register_shutdown_function(array(&$this, '__destruct'));
    }

	function __destruct()
	{
	}

	function add()
	{
	}

	function edit()
	{
	}

	function view($condition)
	{
        return $this->db->get_one("SELECT * FROM ".TABLE_MEMBER." m,".TABLE_MEMBER_INFO." i,".TABLE_MEMBER_GROUP." g WHERE m.userid=i.userid AND m.groupid=g.groupid and $condition limit 0,1");
	}

	function delete($userid)
	{
		$userids = is_array($userid) ? implode(',', $userid) : intval($userid);

		$this->db->query("DELETE FROM ".TABLE_MEMBER." WHERE userid IN ($userids)");
		$this->db->query("DELETE FROM ".TABLE_MEMBER_INFO." WHERE userid IN ($userids)");
		$result = $this->db->affected_rows();

		$this->db->query("DELETE FROM ".TABLE_ADMIN." WHERE userid IN ($userids)");

		return $result;
	}

	function check($userid)
	{
		global $date;
		$userids = is_array($userid) ? implode(',', $userid) : $userid;
		$r = $this->db->get_one("SELECT * FROM ".TABLE_MEMBER_GROUP." WHERE groupid=6");
		@extract($r);
		$begindate = date('Y-m-d');
		$date->dayadd($defaultvalidday);
		$enddate = $defaultvalidday == -1 ? '0000-00-00' : $date->get_date();
		$this->db->query("UPDATE ".TABLE_MEMBER." SET groupid=6,chargetype=$chargetype,point=$defaultpoint,begindate='$begindate',enddate='$enddate' WHERE userid IN ($userids)");
		return TRUE;
	}

	function lock($userid, $val = 1)
	{
		$userids = is_array($userid) ? implode(',', $userid) : intval($userid);
		$groupid = intval($val) == 1 ? 2 : 6;
		$this->db->query("UPDATE ".TABLE_MEMBER." SET groupid=$groupid WHERE userid IN ($userids)");
		return $this->db->affected_rows();
	}

	function get_list($condition, $page, $pagesize = 30)
	{
		global $date,$LANG;

		$offset = ($page-1)*$pagesize;
        $members = array();
		$result = $this->db->query("SELECT * FROM ".TABLE_MEMBER." m,".TABLE_MEMBER_INFO." i WHERE m.userid=i.userid $condition ORDER BY m.userid DESC LIMIT $offset,$pagesize");
		while($r = $this->db->fetch_array($result))
		{
			$r['lastlogintime'] = $r['lastlogintime'] ? date('Y-m-d H:i:s', $r['lastlogintime']) : '';
			if($r['enddate'] == '0000-00-00') 
			{
				$r['validdatenum'] = '<font color="blue">'.$LANG['no_limit_time'].'</font>';
			}
			else
			{
				$r['validdatenum'] = $date->get_diff($r['enddate'],date('Y-m-d'));
				$r['validdatenum'] = $r['validdatenum'] <= 0 ? '<font color="red">'.$r['validdatenum'].'</font>'.$LANG['day'] : $r['validdatenum'];
			}
			$members[] = $r;
		}
		return $members;
	}
}
?>