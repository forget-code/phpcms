<?php 
defined('IN_PHPCMS') or exit('Access Denied');

class movie
{
	var $channelid;
	var $movieid;
	var $db;
	var $table_movie;
	function movie($channelid)
    {
		global $db;
		$this->channelid = $channelid;
		$this->movieid = 0;
		$this->db = &$db;
		$this->table_movie = channel_table('movie', $channelid);
		register_shutdown_function(array(&$this, '__destruct'));
    }

	function __destruct()
	{
		unset($this->channelid);
		unset($this->movieid);
		unset($this->db);
		unset($this->table_movie);
	}
	function add($movie)
	{
		$content=$movie['content'];
		unset($movie['content']);
		$sql1 = $sql2 = $s = "";
		foreach($movie as $key=>$value)
		{
			$sql1 .= $s.$key;
			$sql2 .= $s."'".$value."'";
			$s = ",";
		}
		$this->db->query("INSERT INTO ".$this->table_movie." ($sql1) VALUES($sql2) ");
		if(!$this->db->affected_rows()) return FALSE;
		$movieid = $this->db->insert_id();
		if(!$movie['islink'])
		{
			$linkurl = item_url('url', $movie['catid'], $movie['ishtml'], $movie['urlruleid'], $movie['htmldir'], $movie['prefix'], $movieid, $movie['addtime'], 0);
			$this->db->query("UPDATE ".$this->table_movie." SET linkurl='$linkurl' WHERE movieid=$movieid ");
		}
		return $movieid;
	}

	function edit($movie)
	{
		$content=$movie['content'];
		unset($movie['content']);
		$movieid = $this->movieid;
		if(!$movie['islink'])
		{
			$movie['linkurl'] = item_url('url', $movie['catid'], $movie['ishtml'], $movie['urlruleid'], $movie['htmldir'], $movie['prefix'], $movieid, $movie['addtime'], 0);
		}
		$sql = $s = "";
		foreach($movie as $key=>$value)
		{
			$sql .= $s.$key."='".$value."'";
			$s = ",";
		}
		$this->db->query("UPDATE ".$this->table_movie." SET $sql WHERE movieid=$movieid ");
		return $movieid;
	}

	function delete($movieids, $file = 0, $pic = 1)
	{
		global $CHA, $pos, $MOD,$PHP_TIME;
		$movieids = is_array($movieids) ? implode(',',$movieids) : $movieids;
		$sql = $movieids ? "movieid IN($movieids)" : "status=-1";
		$result = $this->db->query("SELECT movieid,linkurl,thumb,username,catid,arrposid,ishtml,islink,urlruleid,htmldir,prefix,addtime FROM ".$this->table_movie." WHERE $sql ");
		if(!$file && $pic) require PHPCMS_ROOT.'/include/attachment.class.php';
		while($r = $this->db->fetch_array($result))
		{
			if(!$file && $r['arrposid']) $pos->delete($r['movieid'], $r['arrposid']);
			if($r['bigthumb'] && !strpos($r['bigthumb'], "://") && !$file && $pic) @unlink(PHPCMS_ROOT.'/'.$r['bigthumb']);
			if($r['thumb'] && !strpos($r['thumb'], "://") && !$file && $pic) @unlink(PHPCMS_ROOT.'/'.$r['thumb']);
			if(!$file && $pic)
			{
				$att = new attachment($r['movieid'], $this->channelid, $r['catid']);
				$att->delete();
			}
			if($r['ishtml'])
			{
				$linkurl = item_url('path', $r['catid'], $r['ishtml'], $r['urlruleid'], $r['htmldir'], $r['prefix'], $r['movieid'], $r['addtime']);
				@unlink(PHPCMS_ROOT.'/'.$linkurl);		
			}
		}
		if(!$file) $this->db->query("DELETE FROM ".$this->table_movie." WHERE $sql ");
		return TRUE;
	}
	
	function get_list($sql = 'status=3 ', $order = 'listorder DESC')
	{
		global $offset, $pagesize;
		if(empty($sql)) return FALSE;
		$offset = !empty($offset) ? intval($offset) : 0;
		$pagesize = !empty($pagesize) ? intval($pagesize) : 30;
		$TYPE = cache_read('type_'.$this->channelid.'.php');
		$result = $this->db->query("SELECT * FROM ".$this->table_movie." WHERE $sql ORDER BY $order, movieid DESC LIMIT $offset,$pagesize");
		$movies = array();
		while($r = $this->db->fetch_array($result))
		{
			$r['title'] = style($r['title'], $r['style']);
			$r['typename'] = $r['typeid'] && array_key_exists($r['typeid'], $TYPE) ? style($TYPE[$r['typeid']]['name'], $TYPE[$r['typeid']]['style']) : '';
			$r['linkurl'] = linkurl($r['linkurl']);
			$r['adddate'] = date("Y-m-d",$r['addtime']);
			$r['addtime'] = date("Y-m-d H:i:s",$r['addtime']);
			$r['checktime'] = date("Y-m-d H:i:s",$r['checktime']);
			$r['edittime'] = date("Y-m-d H:i:s",$r['edittime']);
			$movies[] = $r;
		}
		$this->db->free_result($result);
		$movies = !empty($movies) ? $movies : array();
		return $movies;
	}

	function get_one()
	{
		$r = $this->db->get_one("SELECT * FROM ".$this->table_movie." WHERE movieid=$this->movieid ");
		return $r;
	}

	function action($job = 'status', $value = 3, $movieids)
	{
		if(empty($movieids)) return FALSE;
		if(is_array($movieids))
		{
			$html_movieids = $movieids;
			$movieids = implode(',', $movieids);
		}
		else
		{
			$html_movieids = array($movieids);
		}
		$this->db->query("UPDATE ".$this->table_movie." SET $job=$value WHERE movieid IN ($movieids) ");
		if($job == 'status' && $value == 3)
		{
			global $_username,$PHP_TIME,$MOD,$MODULE;
			$CAT = $catid = '';
			$this->db->query("UPDATE ".$this->table_movie." SET checker='$_username', checktime=$PHP_TIME WHERE  movieid IN ($movieids) ");
			if(isset($MODULE['pay']))
			{
				require_once PHPCMS_ROOT.'/pay/include/pay.func.php';
				$result = $this->db->query("select movieid,title,username,catid from ".$this->table_movie." WHERE movieid IN ($movieids) ");
				while($r = $this->db->fetch_array($result))
				{
					if(!$r['username']) continue;
					$CAT = cache_read('category_'.$r['catid'].'.php');
					$point = $CAT['creditget'] ? $CAT['creditget'] : $MOD['add_point'];
					if($point) 	point_add($r['username'], $point, $r['title'].'(channelid='.$this->channelid.',movieid='.$r['movieid'].')');
				}
			}
		}
		return TRUE;
	}

	function listorder($listorder)
	{
		if(!is_array($listorder)) return FALSE;
		foreach($listorder as $id=>$value)
		{
			$this->db->query("UPDATE ".$this->table_movie." SET listorder=$value WHERE movieid=$id ");
		}
		return TRUE;
	}

	function update()
	{
		global $CATEGORY;
		foreach($CATEGORY as $k=>$v)
		{
			$r = $this->db->get_one("SELECT COUNT(*) AS number FROM ".$this->table_movie." WHERE catid=$k AND status=3 ");
			$this->db->query("UPDATE ".TABLE_CATEGORY." SET items={$r['number']} WHERE catid=$k AND channelid=$this->channelid ");
			cache_category($k);
		}
		$items = 0;
		foreach($CATEGORY as $k=>$v)
		{
			$cat = cache_read("category_$k.php");
			$items+=$cat['items'];
		}
		$this->db->query("UPDATE ".TABLE_CHANNEL." SET items=$items WHERE channelid=$this->channelid ");
		cache_channel($this->channelid);
		return TRUE;
	}
}
?>