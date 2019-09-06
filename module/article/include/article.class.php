<?php 
defined('IN_PHPCMS') or exit('Access Denied');

class article
{
	var $channelid;
	var $articleid;
	var $db;
	var $table_article;
	var $table_article_data;

	function article($channelid)
    {
		global $db;
		$this->channelid = $channelid;
		$this->articleid = 0;
		$this->db = &$db;
		$this->table_article = channel_table('article', $channelid);
		$this->table_article_data = channel_table('article_data', $channelid);
		register_shutdown_function(array(&$this, '__destruct'));
    }

	function __destruct()
	{
		unset($this->channelid);
		unset($this->articleid);
		unset($this->db);
		unset($this->table_article);
		unset($this->table_article_data);
	}
	function add($article)
	{
		global $MOD;
		$content=$article['content'];
		unset($article['content']);
		$sql1 = $sql2 = $s = "";
		foreach($article as $key=>$value)
		{
			$sql1 .= $s.$key;
			$sql2 .= $s."'".$value."'";
			$s = ",";
		}
		$this->db->query("INSERT INTO ".$this->table_article." ($sql1) VALUES($sql2) ");
		if(!$this->db->affected_rows()) return FALSE;
		$articleid = $this->db->insert_id();
		if(!$article['islink'])
		{
			$linkurl = item_url('url', $article['catid'], $article['ishtml'], $article['urlruleid'], $article['htmldir'], $article['prefix'], $articleid, $article['addtime'], 0);
			$this->db->query("UPDATE ".$this->table_article." SET linkurl='$linkurl' WHERE articleid=$articleid ");
		}
		if($MOD['storage_mode'] < 3) $this->db->query("INSERT INTO ".$this->table_article_data." (articleid,content) VALUES ('$articleid','$content') ");
		if($MOD['storage_mode'] > 1) txt_update($this->channelid, $articleid, $content);
		if($MOD['storage_mode'] == 3) $this->db->query("INSERT INTO ".$this->table_article_data." (articleid) VALUES ('$articleid') ");
		return $articleid;
	}

	function edit($article)
	{
		global $MOD;
		$content=$article['content'];
		unset($article['content']);
		$articleid = $this->articleid;
		if(!$article['islink'])
		{
			$article['linkurl'] = item_url('url', $article['catid'], $article['ishtml'], $article['urlruleid'], $article['htmldir'], $article['prefix'], $articleid, $article['addtime'], 0);
		}
		$sql = $s = "";
		foreach($article as $key=>$value)
		{
			$sql .= $s.$key."='".$value."'";
			$s = ",";
		}
		$this->db->query("UPDATE ".$this->table_article." SET $sql WHERE articleid=$articleid ");
		if($MOD['storage_mode'] < 3) $this->db->query("UPDATE ".$this->table_article_data." SET content='$content' WHERE articleid=$articleid ");
		if($MOD['storage_mode'] > 1) txt_update($this->channelid, $this->articleid, $content);
		return TRUE;
	}

	function delete($articleids, $file = 0, $pic = 1)
	{
		global $CHA, $pos, $MOD;
		$articleids = is_array($articleids) ? implode(',',$articleids) : $articleids;
		$sql = $articleids ? "articleid IN($articleids)" : "status=-1";
		$result = $this->db->query("SELECT articleid,linkurl,thumb,username,paginationtype,maxcharperpage,catid,arrposid,ishtml,islink,urlruleid,htmldir,prefix,addtime FROM ".$this->table_article." WHERE $sql ");
		if(!$file && $pic) require PHPCMS_ROOT.'/include/attachment.class.php';
		while($r = $this->db->fetch_array($result))
		{
			if(!$file && $r['arrposid']) $pos->delete($r['articleid'], $r['arrposid']);
			if(!$file && $r['islink'])
			{
				$this->db->query("DELETE FROM ".$this->table_article_data." WHERE articleid=$r[articleid] ");
				continue;
			}
			if($r['thumb'] && !strpos($r['thumb'], "://") && !$file && $pic) @unlink(PHPCMS_ROOT.'/'.$r['thumb']);
			$content = $this->db->get_one("SELECT content FROM ".$this->table_article_data." WHERE articleid=$r[articleid] ");
			if(!$file && $pic)
			{
				$att = new attachment($r['articleid'], $this->channelid, $r['catid']);
				$att->delete();
			}
			if($r['ishtml'])
			{
				if($r['paginationtype'])
				{
					if($r['paginationtype']==1)
					{
						$charnumber = strlen($content['content']);
						$pagenumber = ceil($charnumber/$r['maxcharperpage']);
					}
					elseif($r['paginationtype']==2)
					{
						$pagenumber = count(explode('[next]',$content['content']));
					}
					if($pagenumber > 1)
					{
						for($i = 0; $i <= $pagenumber; $i++)
						{
							$linkurl = item_url('path', $r['catid'], $r['ishtml'], $r['urlruleid'], $r['htmldir'], $r['prefix'], $r['articleid'], $r['addtime'], $i);
							@unlink(PHPCMS_ROOT.'/'.$linkurl);
						}
					}
				}
				else
				{
					$linkurl = item_url('path', $r['catid'], $r['ishtml'], $r['urlruleid'], $r['htmldir'], $r['prefix'], $r['articleid'], $r['addtime']);
					@unlink(PHPCMS_ROOT.'/'.$linkurl);
				}
			}
			if(!$file)
			{
				$this->db->query("DELETE FROM ".$this->table_article_data." WHERE articleid=$r[articleid] ");
				if($MOD['storage_mode'] > 1) txt_delete($this->channelid, $this->articleid);
			}
		}
		if(!$file) $this->db->query("DELETE FROM ".$this->table_article." WHERE $sql ");
		return TRUE;
	}
	
	function get_list($sql = 'status=3 ', $order = 'listorder DESC')
	{
		global $offset, $pagesize;
		if(empty($sql)) return FALSE;
		$offset = !empty($offset) ? intval($offset) : 0;
		$pagesize = !empty($pagesize) ? intval($pagesize) : 30;
		$TYPE = cache_read('type_'.$this->channelid.'.php');
		$result = $this->db->query("SELECT * FROM ".$this->table_article." WHERE $sql ORDER BY $order, articleid DESC LIMIT $offset,$pagesize");
		$articles = array();
		while($r = $this->db->fetch_array($result))
		{
			$r['title'] = style($r['title'], $r['style']);
			$r['typename'] = $r['typeid'] && array_key_exists($r['typeid'], $TYPE) ? style($TYPE[$r['typeid']]['name'], $TYPE[$r['typeid']]['style']) : '';
			$r['linkurl'] = linkurl($r['linkurl']);
			$r['adddate'] = date("Y-m-d",$r['addtime']);
			$r['addtime'] = date("Y-m-d H:i:s",$r['addtime']);
			$r['checktime'] = date("Y-m-d H:i:s",$r['checktime']);
			$r['edittime'] = date("Y-m-d H:i:s",$r['edittime']);
			$articles[] = $r;
		}
		$this->db->free_result($result);
		$articles = !empty($articles) ? $articles : array();
		return $articles;
	}

	function get_one()
	{
		global $MOD;
		if($MOD['storage_mode'] > 1)
		{
			$r = $this->db->get_one("SELECT * FROM ".$this->table_article." WHERE articleid=$this->articleid ");
			$r['content'] = txt_read($this->channelid, $this->articleid);
		}
		else
		{
			$r = $this->db->get_one("SELECT * FROM ".$this->table_article." a, ".$this->table_article_data." d WHERE a.articleid=$this->articleid AND a.articleid=d.articleid ");
		}
		return $r;
	}

	function action($job = 'status', $value = 3, $articleids)
	{
		if(empty($articleids)) return FALSE;
		if(is_array($articleids))
		{
			$html_articleids = $articleids;
			$articleids = implode(',', $articleids);
		}
		else
		{
			$html_articleids = array($articleids);
		}
		$this->db->query("UPDATE ".$this->table_article." SET $job=$value WHERE articleid IN ($articleids) ");
		if($job == 'status' && $value == 3)
		{
			global $_username,$PHP_TIME,$MOD,$MODULE;
			$this->db->query("UPDATE ".$this->table_article." SET checker='$_username', checktime=$PHP_TIME WHERE articleid IN ($articleids) ");
			if(isset($MODULE['pay']))
			{
				require_once PHPCMS_ROOT.'/pay/include/pay.func.php';
				$result = $this->db->query("select articleid,title,username,catid from ".$this->table_article." WHERE articleid IN ($articleids) ");
				while($r = $this->db->fetch_array($result))
				{
					if(!$r['username']) continue;
					$CAT = cache_read('category_'.$r['catid'].'.php');
					$point = $CAT['creditget'] ? $CAT['creditget'] : $MOD['add_point'];
					if($point) 	point_add($r['username'], $point, $r['title'].'(channelid='.$this->channelid.',articleid='.$r['articleid'].')');
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
			$this->db->query("UPDATE ".$this->table_article." SET listorder=$value WHERE articleid=$id ");
		}
		return TRUE;
	}

	function update()
	{
		global $CATEGORY;
		foreach($CATEGORY as $k=>$v)
		{
			$r = $this->db->get_one("SELECT COUNT(*) AS number FROM ".$this->table_article." WHERE catid=$k AND status=3 ");
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