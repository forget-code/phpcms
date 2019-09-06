<?php
class guestbook
{
	var $db;
	var $table;
	var $M;

	function __construct()
    {
		global $db,$M;
		$this->db = &$db;
		$this->table = DB_PRE.'guestbook';
		$this->M = $M;
    }

	function guestbook()
	{
		$this->__construct();
	}

	function listinfo($condition, $page = 1, $pagesize = 10)
	{
		$number = cache_count("SELECT count(*) AS `count` FROM $this->table where 1 $condition");
		$this->pages = pages($number, $page, $pagesize);
		$offset = $page ? ($page-1)*$pagesize : 0;
		$sql = $this->db->query("SELECT * from $this->table where 1 $condition ORDER by addtime DESC LIMIT $offset,$pagesize");
		$key = array();
		while($r = $this->db->fetch_array($sql))
		{
			$r['head'] = $r['head']<10 ? "0".$r['head'] : $r['head'];
			$r['addtime'] = date("Y-m-d H:i:s",$r['addtime']);
			$r['replytime'] = date("Y-m-d H:i:s",$r['replytime']);
			$r['gender'] = $r['gender'] ? $LANG['male']: $LANG['female'];
			if($sear == 'all')
			{
				$r['content'] = substr($r['content'],0,40);
				$r['reply'] = substr($r['reply'],0,40);
			}
			$r['gip'] = guestbook::realm($r['ip']);
			$key[] = $r;
		}
		$this->db->free_result($sql);
		return $key;
	}

	function add($guestbook)
	{
		return $this->db->insert($this->table, $guestbook);
	}

	function delete($gid)
	{
		$gids=is_array($gid) ? implode(',',$gid) : $gid;
		return $this->db->query("DELETE FROM $this->table WHERE gid IN ($gids)");
	}

	function getone($gid)
	{
		$guestbook = $this->db->get_one("SELECT * FROM  $this->table WHERE gid='$gid'");
		$guestbook['addtime'] = date("Y-m-d H:i:s",$guestbook['addtime']);
		$guestbook['replytime'] = date("Y-m-d H:i:s",$guestbook['replytime']);
		$guestbook['head'] = $guestbook['head']<10 ? "0".$guestbook['head'] : $guestbook['head'];
		$guestbook['country'] = guestbook::realm($guestbook['ip']);
		return $guestbook;
	}

	function pass($gid,$passed)
	{
		$gids=is_array($gid) ? implode(',',$gid) : $gid;
		return $this->db->query("UPDATE $this->table SET passed=$passed WHERE gid IN ($gids)");

	}

	function reply($gid,$reply,$passed,$hidden,$_username)
	{
		return $this->db->query("UPDATE $this->table SET reply='$reply',passed='$passed',hidden='$hidden',replyer='$_username',replytime='".TIME."' WHERE gid=$gid");
	}

	function realm($ip)
	{
		require_once PHPCMS_ROOT."include/ip_area.class.php";
		$getip = new ip_area;
		$gip = $getip->get($ip);
		return $gip;
	}

	function get_face()
	{
		$face = $t = '';
		$face .= '<ul>';
		foreach(glob(PHPCMS_ROOT.'images/face/*.gif') AS $i)
		{
			$headname = basename($i, ".gif");
			$headpath = basename($i);
			if($headname=='01')
			{
				$t = 'checked';
			}
			else
			{
				$t = '';
			}
			$face .= '<li><img src="images/face/'.$headpath.'"><p><input type="radio" value="'.$headname.'" name="guestbook[head]" '.$t.'></p></li>';
		}
		$face .= '</ul>';
		return $face;
	}
}
?>