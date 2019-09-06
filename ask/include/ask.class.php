<?php
class ask
{
	var $db;
	var $pages;
	var $number;
	var $table;
	var $table_posts;

    function __construct()
    {
		global $db;
		$this->db = &$db;
		$this->table = DB_PRE.'ask';
		$this->table_posts = DB_PRE.'ask_posts';
		$this->pay = load('pay_api.class.php', 'pay', 'api');
		$this->credit = load('credit.class.php', 'ask', 'include');
    }

	function ask()
	{
		$this->__construct();
	}

	function detail($id = 0, $fields = '*', $ismore = 0)
	{
		$id = intval($id);
		$sql = $ismore ? "SELECT $fields FROM $this->table a,$this->table_posts p WHERE a.askid=p.askid AND a.askid=$id" : "SELECT $fields FROM $this->table WHERE pid=$id";
		return $this->db->get_one($sql);
	}

	function add($info,$posts)
	{
		global $_userid, $_username, $M, $LANG;
		if(!is_array($info) || !is_array($posts)) return false;
		$this->db->insert($this->table, $info);
		$posts['askid'] = $this->db->insert_id();
		$this->db->query("UPDATE ".DB_PRE."category SET items=items+1 WHERE catid='$info[catid]'");
		if($info['reward'])
		{
			$this->credit->update($_userid, $_username, $info['reward'], 0);
			$this->pay->update_exchange('ask', 'point', '-'.$info['reward'], $LANG['reword_diff']);
		}
		if($info['anonymity'])
		{
			$this->credit->update($_userid, $_username, $M['anybody_score'], 0);
			$this->pay->update_exchange('ask', 'point', '-'.$M['anybody_score'], $LANG['anonymous_diff']);
		}
		$this->db->insert($this->table_posts, $posts);
		$this->search_api($posts['askid']);
		return $posts['askid'];
	}

	function edit($id, $info, $posts, $userid = 0)
	{
		$id = intval($id);
		if(!$id || !is_array($info) || !is_array($posts)) return false;
		if($userid) $sql = " AND userid=$userid AND status<4";
		$this->db->update($this->table, $info, "askid=$id $sql");
		$this->search_api($id);
		return $this->db->update($this->table_posts, $posts, "askid=$id $sql");
	}
	
	function point($id)
	{
		$id = intval($id);
		return $this->db->get_one("SELECT m.userid,m.username,m.point,a.status FROM ".DB_PRE."member_cache AS m, $this->table AS a WHERE m.userid=a.userid AND a.askid=$id");
	}

	function delete($id)
	{
		global $_username,$M,$LANG;
		if(is_array($id))
		{
			array_map(array(&$this, 'delete'), $id);
		}
		else
		{
			$id = intval($id);
			if($id < 1) return false;
			if($M['del_question_credit'])
			{
				$r = $this->point($id);
				if($r['status']>1)
				{
					$this->credit->update($r['userid'], $r['username'], $M['del_question_credit'], 0);
					$this->pay->update_exchange('ask', 'point', '-'.$M['del_question_credit'], "$r[username]".$LANG['ask_is_deleted'], $r['userid']);
				}
			}
			$this->db->query("DELETE FROM $this->table WHERE askid=$id");
			$this->db->query("DELETE FROM $this->table_posts WHERE askid=$id");
			$this->db->query("UPDATE ".DB_PRE."category SET items=items-1 WHERE catid='$info[catid]'");
			$this->search_api($id);
		}
		return true;
	}

	function check($id)
	{
		if(is_array($id))
		{
			array_map(array(&$this, 'check'), $id);
		}
		else
		{
			$id = intval($id);
			if($id < 1) return false;
			$this->db->query("UPDATE $this->table SET status=3 WHERE askid=$id");
		}
		return true;
	}

	function listinfo($where = '', $order = '', $page = 1, $pagesize = 50)
	{
		if($where) $where = " WHERE $where";
		if($order) $order = " ORDER BY $order";
		$page = max(intval($page), 1);
		$offset = $pagesize*($page-1);
		$limit = " LIMIT $offset, $pagesize";
		$number = cache_count("SELECT count(*) AS `count` FROM `$this->table` $where");
		$this->pages = pages($number, $page, $pagesize);
		$array = array();
		$i = 1;
		$result = $this->db->query("SELECT * FROM $this->table $where $order $limit");
		while($r = $this->db->fetch_array($result))
		{
			$r['orderid'] = $i;
			$r['url'] = ask_url($r['askid']);
			$array[] = $r;
			$i++;
		}
		$this->number = $this->db->num_rows($result);
		$this->db->free_result($result);
		return $array;
	}

	function move($id = '', $targetcatid = 0, $iscatid = 0)
	{
		if($iscatid)
		{
			if(!is_array($id)) return false;
			$ids = implode(',',$id);
			$this->db->query("UPDATE $this->table SET catid='$targetcatid' WHERE catid IN($ids)");
		}
		else
		{
			$this->db->query("UPDATE $this->table SET catid='$targetcatid' WHERE askid IN ($id)");
		}
		return true;
	}

	function getnumber($userid, $flag = 0)
	{
		$userid = intval($userid);
		$sql = '';
		if($flag) $sql = ' AND isask=1';
		$r = $this->db->get_one("SELECT count(pid) AS num FROM $this->table_posts WHERE userid='$userid' $sql");
		return $r['num'];
	}
	function status($id, $status, $userid = 0)
	{
		global $M;
		$id = intval($id);
		$status = intval($status);
		if($userid) $sql = " AND userid='$userid'";
		$this->db->query("UPDATE $this->table SET status=$status WHERE askid=$id");
		return true;
	}
	function flag($id, $flag, $userid = 0)
	{
		$id = intval($id);
		$flag = intval($flag);
		if($userid) $sql = " AND userid='$userid'";
		$this->db->query("UPDATE $this->table SET flag=$flag WHERE askid=$id");
		return true;
	}

	function check_status()
	{
		global $_userid;
		$endtime = TIME;
		$r = $this->db->get_one("SELECT count(askid) AS num FROM $this->table WHERE userid='$_userid' AND status=3 AND endtime<$endtime");
		return $r['num'];
	}

	function accept_answer($id, $pid)
	{
		global $M,$LANG;
		$pid = intval($pid);
		$this->status($id,5);
		$this->db->query("UPDATE $this->table_posts SET optimal=1,solvetime=".TIME." WHERE pid=$pid");
		$r = $this->db->get_one("SELECT userid,username FROM $this->table_posts WHERE pid=$pid");
		$this->db->query("UPDATE ".DB_PRE."member_info SET acceptcount=acceptcount+1 WHERE userid=$r[userid]");
		if($M['answer_bounty_credit'])
		{
			$this->credit->update($r['userid'], $r['username'], $M['answer_bounty_credit'], 1);
			$this->pay->update_exchange('ask', 'point', $M['answer_bounty_credit'], $LANG['accept_answer'], $r['userid']);
		}
		if($M['return_credit'])
		{
			@extract($this->db->get_one("SELECT userid,username,ischeck FROM $this->table WHERE askid=$id"));
			if($ischeck)
			{
				$this->credit->update($userid, $username, $M['return_credit'], 1);
				$this->pay->update_exchange('ask', 'point', $M['return_credit'], $LANG['return_credit'], $userid);
			}
		}
		return true;
	}

	function addscore($id, $point = 0)
	{
		global $_userid, $_username,$M;
		$id = intval($id);
		$point = intval($point);
		$this->db->query("UPDATE $this->table SET reward=reward+$point,endtime=endtime+432000 WHERE askid=$id AND userid=$_userid");
		$this->db->query("UPDATE $this->table SET flag=2 WHERE askid=$id AND flag=0 AND reward >= $M[height_score]");

		$this->credit->update($_userid,  $_username, $point, 0);
		$this->pay->update_exchange('ask', 'point', '-'.$point, $LANG['enhances_credit']);
		return true;
	}

	function search_api($askid)
	{
		global $MODULE,$CATEGORY;
		if(!isset($MODULE['search'])) return false;
		if(!is_object($this->s)) $this->s = load('search.class.php', 'search', 'include');
		$r = $this->detail($askid, 'a.title,a.status,a.searchid,p.message', 1);
		if(!$r) return false;
		$this->s->set_type('ask');
		$url = ask_url($askid);
		if($r['searchid'])
		{
			if($r['status'] == 3 || $r['status'] == 5)
			{
				$this->s->update($r['searchid'], $r['title'], $r['message'], $url);
			}
			else
			{
				$this->s->delete($r['searchid']);
			}
		}
		else
		{
			$searchid = $this->s->add($r['title'], $r['message'], $url);
			if(!$searchid) return false;
			$this->db->query("UPDATE `$this->table` SET `searchid`=$searchid WHERE `askid`=$askid");
		}
		return true;
	}
}
?>