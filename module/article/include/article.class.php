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
		$this->db->query("INSERT INTO ".$this->table_article_data." (articleid,content) VALUES ('$articleid','$content') ");
		return $articleid;
	}

	function edit($article)
	{
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
		$this->db->query("UPDATE ".$this->table_article_data." SET content='$content' WHERE articleid=$articleid ");
		return TRUE;
	}

	function delete($articleids, $file = 0, $pic = 1)//File为1时仅删除文件 文章编辑时有用 $pic=1时删除内容图片和缩略图 频道移动时有用
	{
		global $CHA, $pos, $MOD;
		$articleids = is_array($articleids) ? implode(',',$articleids) : $articleids;
		$sql = $articleids ? "articleid IN($articleids)" : "status=-1";//当articleids为空时，表示清空回收站
		$result = $this->db->query("SELECT articleid,linkurl,thumb,username,paginationtype,maxcharperpage,catid,arrposid,ishtml,islink,urlruleid,htmldir,prefix,addtime FROM ".$this->table_article." WHERE $sql ");
		while($r = $this->db->fetch_array($result))
		{
			if($MOD['add_point'] && $r['username']) $this->db->query("update ".TABLE_MEMBER." set point=point-$MOD[add_point] where username='$r[username]'");
			if(!$file && $r['arrposid']) $pos->delete($r['articleid'], $r['arrposid']);
			if($r['islink'])
			{
				$this->db->query("DELETE FROM ".$this->table_article_data." WHERE articleid=$r[articleid] ");
				continue;
			}
			if($r['thumb'] && !strpos($r['thumb'], "://") && !$file && $pic) @unlink(PHPCMS_ROOT.'/'.$r['thumb']);
			$content = $this->db->get_one("SELECT content FROM ".$this->table_article_data." WHERE articleid=$r[articleid] ");
			if(!$file && $pic)
			{
				preg_match_all("/<img[^>]*src=\"([^\"]+)\"/", $content['content'], $m);//删除文章中的图片
				foreach($m[1] as $v)
				{
					if(!strpos($v, "://")) @unlink(PHPCMS_ROOT.$v); //文章中的图片已经带/
				}
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
						for($i = 0; $i < $pagenumber; $i++)
						{
							$page = $i+1;
							$linkurl = item_url('path', $r['catid'], $r['ishtml'], $r['urlruleid'], $r['htmldir'], $r['prefix'], $r['articleid'], $r['addtime'], $page);
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
			if(!$file) $this->db->query("DELETE FROM ".$this->table_article_data." WHERE articleid=$r[articleid] ");
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
		$r = $this->db->get_one("SELECT * FROM ".$this->table_article." a, ".$this->table_article_data." d WHERE a.articleid=$this->articleid AND a.articleid=d.articleid ");
		return $r;
	}

	function action($job = 'status', $value = 3, $articleids)
	{
		if(empty($articleids)) return FALSE;
		$articleids = is_array($articleids) ? implode(',',$articleids) : $articleids;
		$this->db->query("UPDATE ".$this->table_article." SET $job=$value WHERE articleid IN ($articleids) ");
		if($job == 'status' && $value == 3)
		{
			global $_username,$PHP_TIME,$MOD;
			$this->db->query("UPDATE ".$this->table_article." SET checker='$_username', checktime=$PHP_TIME WHERE  articleid IN ($articleids) ");
			foreach($articleids as $articleid)
			{
				createhtml('show');
			}
			if($MOD['add_point'])
			{
				$result = $this->db->query("select username from ".$this->table_article." WHERE articleid IN ($articleids) ");
				while($r = $this->db->fetch_array($result))
				{
					if(!$r['username']) continue;
					$this->db->query("update ".TABLE_MEMBER." set point=point+$MOD[add_point] where username='$r[username]'");
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