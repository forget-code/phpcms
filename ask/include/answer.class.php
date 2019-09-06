<?php
class answer
{
	var $db;
	var $pages;
	var $number;
	var $table;
	var $table_posts;

	function __construct()
	{
		global $db,$member;
		$this->db = &$db;
		$this->member = &$member;
		$this->table = DB_PRE.'ask';
		$this->table_posts = DB_PRE.'ask_posts';
		$this->pay = load('pay_api.class.php', 'pay', 'api');
		$this->credit = load('credit.class.php', 'ask', 'include');
	}

	function answer()
	{
		$this->__construct();
	}

	function show($id = 0)
	{
		global $M,$LANG;
		$id = intval($id);
		$array = array();
		$result = $this->db->query("SELECT * FROM $this->table_posts WHERE askid=$id AND status>2");
		while($r = $this->db->fetch_array($result))
		{
			if($r['isask']) {
				$arr = $this->db->get_one("SELECT * FROM $this->table WHERE askid=$id");
				$r['title'] = $arr['title'];
				$r['reward'] = $arr['reward'];
				$r['status'] = $arr['status'];
				$r['answercount'] = $arr['answercount'];
				$r['flag'] = $arr['flag'];
				$r['endtime'] = $arr['endtime'];
				$r['catid'] = $arr['catid'];
				$r['anonymity'] = $arr['anonymity'];
				if((TIME>$r['endtime']) && !$arr['ischeck'])
				{
					$this->db->query("UPDATE $this->table SET ischeck=1 WHERE askid=$id");
					$this->db->query("UPDATE $this->table SET flag=1 WHERE askid=$id AND answercount>1");
					$this->db->query("UPDATE $this->table_posts SET candidate=1 WHERE askid=$id");
					$this->credit->update($arr['userid'], $arr['username'], $M['del_day15_credit'], 0);
					$this->pay->update_exchange('ask', 'point', '-'.$M['del_day15_credit'], $LANG['ask_15days_no_deal_with'], $arr['userid']);
				}
			}
			$userids[] = $r['userid'];
			$array[] = $r;
		}
		if($userids)
		{
			$userids = implodeids($userids);
			$data = $this->member->listinfo(" AND m.userid IN ($userids)");
			foreach($data AS $r)
			{
				$userinfo[$r['userid']]['actortype'] = $r['actortype'];
				$userinfo[$r['userid']]['point'] = $r['point'];
			}
			foreach($array AS $arr)
			{
				$arr['actortype'] = $userinfo[$arr['userid']]['actortype'];
				$arr['point'] = $userinfo[$arr['userid']]['point'];
				$_array[] = $arr;
			}
			return $_array;
		}
		else
		{
			return $array;
		}
	}

	function get($id = 0, $fields = '*', $ismore = 0)
	{
		$id = intval($id);
		$sql = $ismore ? "SELECT $fields FROM $this->table a,$this->table_posts p WHERE a.askid=p.askid AND p.pid=$id" : "SELECT $fields FROM $this->table WHERE pid=$id";
		return $this->db->get_one($sql);
	}

	function add($id,$posts)
	{
		global $_point,$_userid,$_username,$M,$LANG;
		$id = intval($id);
		if(!$id || !is_array($posts)) return false;
		$posts['askid'] = $id;
		$r = $this->db->get_one("SELECT pid FROM $this->table_posts WHERE askid=$id AND userid='$_userid' LIMIT 1");
		if($r) return false;
		$this->db->insert($this->table_posts, $posts);
		$this->db->query("UPDATE ".DB_PRE."member_info SET answercount=answercount+1 WHERE userid='$_userid'");
		if($M['answer_give_credit'])
		{
			@extract($this->db->get_one("SELECT count(pid) AS num FROM $this->table_posts WHERE userid='$_userid' AND isask=0"));
			$maxnum = floor($M['answer_max_credit']/$M['answer_give_credit']);
			if($num<=$maxnum)
			{
				$this->credit->update($_userid, $_username, $M['answer_give_credit'], 1);
				$this->pay->update_exchange('ask', 'point', $M['answer_give_credit'], $LANG['reply_reward']);
			}
		}
		return $this->db->query("UPDATE $this->table SET answercount=answercount+1 WHERE askid=$id");
	}

	function edit($id, $posts, $userid)
	{
		$id = intval($id);
		$userid = intval($userid);
		if(!$id || !is_array($posts)) return false;
		if($userid) $sql = " AND userid=$userid";
		return $this->db->update($this->table_posts, $posts, "pid=$id $sql");
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
			if($M['del_answer_credit'])
			{
				$r = $this->point($id);
				if($r['status']>1)
				{
					$this->credit->update($r['userid'], $r['username'], $M['del_answer_credit'], 0);
					$this->pay->update_exchange('ask', 'point', '-'.$M['del_answer_credit'], "$r[username]".$LANG['reply_is_deleted'], $r['userid']);
				}
			}
			$this->db->query("DELETE FROM $this->table_posts WHERE pid='$id'");
		}
		return true;
	}

	function point($id)
	{
		$id = intval($id);
		return $this->db->get_one("SELECT m.userid,m.username,m.point,p.status FROM ".DB_PRE."member_cache AS m, $this->table_posts AS p WHERE m.userid=p.userid AND p.pid=$id");
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
			$this->db->query("UPDATE $this->table_posts SET status=3 WHERE pid=$id");
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
		$r = $this->db->get_one("SELECT count(*) as number FROM $this->table_posts $where");
		$number = $r['number'];
		$this->pages = pages($number, $page, $pagesize);
		$array = array();
		$i = 1;
		$result = $this->db->query("SELECT * FROM $this->table_posts $where $order $limit");
		while($r = $this->db->fetch_array($result))
		{
			$r['orderid'] = $i;
			$array[] = $r;
			$i++;
		}
		$this->number = $this->db->num_rows($result);
		$this->db->free_result($result);
		return $array;
	}

	function vote($id,$pid)
	{
		global $_userid, $_username, $M, $LANG;
		$id = intval($id);
		$pid = intval($pid);
		$userid = intval($_userid);
		if(!$id || !$pid || !$userid) return false;
		$r = $this->db->get_one("SELECT count(voteid) AS num FROM ".DB_PRE."ask_vote WHERE askid=$id AND userid=$userid");
		if($r['num']>0) return false;
		$this->db->query("UPDATE $this->table_posts SET votecount=votecount+1 WHERE pid=$pid");
		if($M['vote_give_credit'])
		{
			$maxnum = floor($M['vote_max_credit']/$M['vote_give_credit']);
			if($r['num']<=$maxnum)
			{
				$this->credit->update($_userid, $_username, $M['vote_give_credit'], 1);
				$this->pay->update_exchange('ask', 'point', $M['vote_give_credit'], $LANG['votes_the_reward_integral']);
			}
		}
		$posts['askid'] = $id;
		$posts['pid'] = $pid;
		$posts['userid'] = $userid;
		$posts['addtime'] = TIME;
		return $this->db->insert(DB_PRE.'ask_vote', $posts);
	}

	function exchange($askid,$ids, $flag = 0, $isvote = 0, $userid = 0)
	{
		$askid = intval($askid);
		$userid = intval($userid);
		if(!is_array($ids)) return false;
		if($isvote)
		{
			foreach($ids AS $id)
			{
				$this->db->query("UPDATE $this->table_posts SET candidate=1 WHERE pid=$id AND askid=$askid");
			}
		}
		$sql = '';
		if($userid) $sql = "AND userid=$userid";
		$this->db->query("UPDATE $this->table SET flag=$flag WHERE askid=$askid $sql");
		return true;
	}

	function hits($id)
	{
		$id = intval($id);
		$this->db->query("UPDATE $this->table SET hits=hits+1 WHERE askid=$id");
		return true;
	}

	function vote_result($id)
	{
		$id = intval($id);
		@extract($this->db->get_one("SELECT sum(votecount) AS totalnum FROM $this->table_posts WHERE askid=$id AND candidate=1 AND status=3"));
		if($totalnum==0) $totalnum = 1;
		$result = $this->db->query("SELECT * FROM $this->table_posts WHERE askid=$id AND candidate=1");
		while($r = $this->db->fetch_array($result))
		{
			$r['width'] =round(($r['votecount']/$totalnum)*100,1)."%";
			$array[] = $r;
		}
		$this->db->free_result($result);
		return $array;
	}
}
?>