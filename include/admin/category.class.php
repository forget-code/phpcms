<?php
class category
{
	var $module;
	var $db;
	var $table;
	var $category;
	var $menu;
	var $u;

	function __construct($module = 'phpcms')
	{
		global $db, $CATEGORY;
		$this->db = &$db;
		$this->table = DB_PRE.'category';
		$this->category = $CATEGORY;
		$this->module = $module;
		$this->menu = load('menu.class.php');
		$this->u = load('url.class.php');
	}

	function category($module = 'phpcms')
	{
		$this->__construct($module);
	}

	function get($catid)
	{
		$data = $this->db->get_one("SELECT * FROM `$this->table` WHERE `catid`=$catid");
		if(!$data) return false;
		if($data['setting'])
		{
			$setting = $data['setting'];
			eval("\$setting = $setting;");
			unset($data['setting']);
			if(is_array($setting)) $data = array_merge($data, $setting);
		}
		return $data;
	}

	function add($category, $setting = array())
	{
		if(!is_array($category)) return FALSE;
		$category['module'] = $this->module;
		$this->db->insert($this->table, $category);
		$catid = $this->db->insert_id();
		if($category['parentid'])
		{
			$category['arrparentid'] = $this->category[$category['parentid']]['arrparentid'].','.$category['parentid'];
			$category['parentdir'] = $this->category[$category['parentid']]['parentdir'].$this->category[$category['parentid']]['catdir'].'/';
			$parentids = explode(',', $category['arrparentid']);
			foreach($parentids as $parentid)
			{
				if($parentid)
				{
					$arrchildid = $this->category[$parentid]['arrchildid'].','.$catid;
					$this->db->query("UPDATE `$this->table` SET child=1,arrchildid='$arrchildid' WHERE catid='$parentid'");
				}
			}
		}
		else
		{
			$category['arrparentid'] = '0';
			$category['parentdir'] = '';
		}
		$arrparentid = $category['arrparentid'];
		$parentdir = $category['parentdir'];
		$this->db->query("UPDATE `$this->table` SET `arrchildid`='$catid',`listorder`=$catid,`arrparentid`='$arrparentid',`parentdir`='$parentdir' WHERE catid=$catid");
		if($setting) setting_set($this->table, "catid=$catid", $setting);
		if($this->module == 'phpcms' && $category['type'] < 2)
		{
			$parentid = $category['parentid'];
			$this->menu->update('catid_'.$catid, array('parentid'=>$this->menu->menuid('catid_'.$parentid), 'name'=>$category['catname'], 'url'=>'?mod=phpcms&file=content&action=manage&catid='.$catid));
			if($parentid) $this->menu->update('catid_'.$parentid, array('url'=>''));
		}
		if($category['type'] < 2) $this->url($catid);
		$this->repair();
		return $catid;
	}

	function edit($catid, $category, $setting = array())
	{
		$parentid = $category['parentid'];
		$oldparentid = $this->category[$catid]['parentid'];
		if($parentid != $oldparentid)
		{
			$this->move($catid, $parentid, $oldparentid);
		}

		$category['module'] = $this->module;
		$this->db->update($this->table, $category, "catid=$catid");
		if($setting) setting_set($this->table, "catid=$catid", $setting);
		if($this->module == 'phpcms' && $category['type'] < 2)
		{
            $url = $this->category[$catid]['child'] ? '' : '?mod=phpcms&file=content&action=manage&catid='.$catid;
			$this->menu->update('catid_'.$catid, array('parentid'=>$this->menu->menuid('catid_'.$parentid), 'name'=>$category['catname'], 'url'=>$url));
            if($parentid) $this->menu->update('catid_'.$parentid, array('url'=>''));
		}
		if($category['type'] < 2) $this->url($catid);
		$this->repair();
		$this->cache();
		return true;
	}

	function link($catid, $category)
	{
		$this->db->update($this->table, $category, "catid=$catid");
		$this->cache();
		return true;
	}

	function page($catid, $category)
	{
		$this->db->update($this->table, $category, "catid=$catid");
		$this->cache();
		return true;
	}

	function delete($catid)
	{
		global $MODEL,$MODULE;
		if(!array_key_exists($catid, $this->category)) return false;
		@set_time_limit(600);
		$arrparentid = $this->category[$catid]['arrparentid'];
		$arrchildid = $this->category[$catid]['arrchildid'];
		$catids = explode(',', $arrchildid);
		if($this->category[$catid]['type'] == 0)
		{
			if(isset($MODULE['search']) || isset($MODULE['comment']))
			{
				$sids = array();
				$result = $this->db->query("SELECT contentid,searchid FROM ".DB_PRE."content WHERE catid IN($arrchildid)");
				while($r = $this->db->fetch_array($result))
				{
					if(isset($MODULE['comment']))
					{
						$keyid = 'phpcms-content-title-'.$r['contentid'];
						$this->db->query("DELETE FROM ".DB_PRE."comment WHERE keyid='$keyid'");
					}
					$sids[] = $r['searchid'];
				}
				if(isset($MODULE['search']) && $sids)
				{
					$this->search = load('search.class.php', 'search', 'include');
					foreach($sids as $searchid)
					{
						$this->search->delete($searchid, 'searchid');
					}
				}
			}
			if(isset($MODULE['digg']))
            {
                $data = $this->db->select("SELECT `contentid` FROM `".DB_PRE."content` WHERE `catid` IN($arrchildid)", 'contentid');
                if($data)
				{
					$contentids = implode(',', array_keys($data));
					$this->db->query("DELETE `".DB_PRE."digg`,`".DB_PRE."digg_log` FROM `".DB_PRE."digg`,`".DB_PRE."digg_log` WHERE `".DB_PRE."digg`.contentid=`".DB_PRE."digg_log`.contentid AND `".DB_PRE."digg`.contentid IN($contentids)");
				}
            }
			foreach($catids as $id)
			{
				$modelid = $this->category[$id]['modelid'];
				if($this->category[$id]['type']) continue;
				$tablename = $MODEL[$modelid]['tablename'];
				if($tablename && $this->db->table_exists(DB_PRE.'c_'.$tablename))
				{
					$this->db->query("DELETE `".DB_PRE."content`,`".DB_PRE."c_$tablename` FROM `".DB_PRE."content`,`".DB_PRE."c_$tablename` WHERE `".DB_PRE."content`.contentid=`".DB_PRE."c_$tablename`.contentid AND `".DB_PRE."content`.catid='$id'");
				}
				if($this->module == 'phpcms' && $this->category[$id]['type'] < 2) $this->menu->update('catid_'.$id);
				unset($this->category[$id]);
			}
		}
		else
		{
			$this->menu->update('catid_'.$catid);
		}
		$this->db->query("DELETE FROM `$this->table` WHERE `catid` IN($arrchildid)");
		if($arrparentid)
		{
			$arrparentids = explode(',', $arrparentid);
			foreach($arrparentids as $id)
			{
				if($id == 0) continue;
				$arrchildid = $this->get_arrchildid($id);
				$child = is_numeric($arrchildid) ? 0 : 1;
				$this->db->query("UPDATE `$this->table` SET `arrchildid`='$arrchildid', `child`='$child' WHERE `catid`='$id'");
				if($this->module == 'phpcms' && $this->category[$id]['type'] < 2) $this->menu->update('catid_'.$id, array('isfolder'=>$child));
			}
		}
		$this->cache();
		return true;
	}

	function listorder($listorder)
	{
		if(!is_array($listorder)) return FALSE;
		foreach($listorder as $catid=>$value)
		{
			$value = intval($value);
			$this->db->query("UPDATE `$this->table` SET listorder=$value WHERE catid=$catid");
		}
		$this->cache();
		return TRUE;
	}

	function recycle($catid)
	{
		$modelid = $this->category[$catid]['modelid'];
		$m = cache_read('model_'.$modelid.'.php');
		$this->db->query("DELETE FROM `".DB_PRE."content` ,`".DB_PRE."c_".$m['tablename']."` USING `".DB_PRE."content`,`".DB_PRE."c_".$m['tablename']."` WHERE `".DB_PRE."content`.catid='$catid' AND `".DB_PRE."content`.contentid=`".DB_PRE."c_".$m['tablename']."`.contentid");
		return TRUE;
	}

	function listinfo($parentid = -1)
	{
		$categorys = array();
		$where = $parentid > -1 ? " AND parentid='$parentid'" : '';
		$result = $this->db->query("SELECT `catid` FROM `$this->table` WHERE `module`='$this->module' $where ORDER BY `listorder`,`catid`");
		while($r = $this->db->fetch_array($result))
		{
			$categorys[$r['catid']] = $this->get($r['catid']);
		}
		$this->db->free_result($result);
		return $categorys;
	}

	function repair()
	{
		@set_time_limit(600);
		if(is_array($this->category))
		{
			foreach($this->category as $catid => $cat)
			{
				if($catid == 0) continue;
				$arrparentid = $this->get_arrparentid($catid);
				$parentdir = $this->get_parentdir($catid);
				$arrchildid = $this->get_arrchildid($catid);
				$child = is_numeric($arrchildid) ? 0 : 1;
				$this->db->query("UPDATE `$this->table` SET arrparentid='$arrparentid',parentdir='$parentdir',arrchildid='$arrchildid',child='$child' WHERE catid=$catid");
				if($cat['module']=='phpcms') $this->url($catid);
			}
		}
		$this->cache();
		return TRUE;
	}

	function join($sourcecatid, $targetcatid)
	{
		$arrchildid = $this->category[$sourcecatid]['arrchildid'];
		$arrparentid = $this->category[$sourcecatid]['arrparentid'];

		$this->db->query("DELETE FROM `$this->table` WHERE `catid` IN ($arrchildid)");

		$this->db->query("UPDATE ".DB_PRE."content set catid='$targetcatid' WHERE catid IN ($arrchildid)");

		$catids = explode(',', $arrchildid);
		foreach($catids as $id)
		{
			$this->db->query("DELETE FROM ".DB_PRE."menu WHERE keyid='catid_$id' LIMIT 1");
			unset($this->category[$id]);
		}

		if($arrparentid)
		{
			$arrparentids = explode(',', $arrparentid);
			foreach($arrparentids as $id)
			{
				if($id == 0) continue;
				$arrchildid = $this->get_arrchildid($id);
				$child = is_numeric($arrchildid) ? 0 : 1;
				$this->db->query("UPDATE `$this->table` SET arrchildid='$arrchildid',child=$child WHERE catid='$id'");
			}
		}

		$this->cache();
		return true;
	}

	function get_arrparentid($catid, $arrparentid = '', $n = 1)
	{
		if($n > 5 || !is_array($this->category) || !isset($this->category[$catid])) return false;
		$parentid = $this->category[$catid]['parentid'];
		$arrparentid = $arrparentid ? $parentid.','.$arrparentid : $parentid;
		if($parentid)
		{
			$arrparentid = $this->get_arrparentid($parentid, $arrparentid, ++$n);
		}
		else
		{
			$this->category[$catid]['arrparentid'] = $arrparentid;
		}
		return $arrparentid;
	}

	function get_arrchildid($catid)
	{
		$arrchildid = $catid;
		if(is_array($this->category))
		{
			foreach($this->category as $id => $cat)
			{
				if($cat['parentid'] && $id != $catid)
				{
					$arrparentids = explode(',', $cat['arrparentid']);
					if(in_array($catid, $arrparentids)) $arrchildid .= ','.$id;
				}
			}
		}
		return $arrchildid;
	}

	function get_parentdir($catid)
	{
		if($this->category[$catid]['parentid']==0) return '';
		$arrparentid = $this->category[$catid]['arrparentid'];
		$arrparentid = explode(',', $arrparentid);
		$arrcatdir = array();
		foreach($arrparentid as $id)
		{
			if($id==0) continue;
			$arrcatdir[] = $this->category[$id]['catdir'];
		}
		return implode('/', $arrcatdir).'/';
	}

	function move($catid, $parentid, $oldparentid)
	{
		$arrchildid = $this->category[$catid]['arrchildid'];
		$oldarrparentid = $this->category[$catid]['arrparentid'];
		$oldparentdir = $this->category[$catid]['parentdir'];
		$child = $this->category[$catid]['child'];
		$oldarrparentids = explode(',', $this->category[$catid]['arrparentid']);
		$arrchildids = explode(',', $this->category[$catid]['arrchildid']);
		if(in_array($parentid, $arrchildids)) return FALSE;
		$this->category[$catid]['parentid'] = $parentid;
		if($child)
		{
			foreach($arrchildids as $cid)
			{
				if($cid==$catid) continue;
				$newarrparentid = $this->get_arrparentid($cid);
				$this->category[$cid]['arrparentid'] = $newarrparentid;
				$newparentdir = $this->get_parentdir($cid);
				$this->db->query("UPDATE `$this->table` SET arrparentid='$newarrparentid',parentdir='$newparentdir' WHERE catid='$cid'");
			}
		}
		if($parentid)
		{
			$arrparentid = $this->category[$parentid]['arrparentid'].",".$parentid;
			$this->category[$catid]['arrparentid'] = $arrparentid;
			$parentdir = $this->category[$parentid]['parentdir'].$r['catdir']."/";
			$arrparentids = explode(",", $arrparentid);
			foreach($arrparentids as $pid)
			{
				if($pid==0) continue;
				$newarrchildid = $this->get_arrchildid($pid);
				$this->db->query("UPDATE `$this->table` SET arrchildid='$newarrchildid',child=1 WHERE catid=$pid");
			}
		}
		else
		{
			$arrparentid = 0;
			$parentdir = '/';
			$this->category[$catid]['arrparentid'] = $arrparentid;
		}
		$this->db->query("UPDATE `$this->table` SET arrparentid='$arrparentid',parentdir='$parentdir' WHERE catid=$catid");
		if($oldparentid)
		{
			foreach($oldarrparentids as $pid)
			{
				if($pid==0) continue;
				$oldarrchildid = $this->get_arrchildid($pid);
				$child = is_numeric($oldarrchildid) ? 0 : 1;
				$this->db->query("UPDATE `$this->table` SET arrchildid='$oldarrchildid' ,child=$child WHERE catid=$pid");
			}
		}
		return TRUE;
	}

	function depth($catid)
	{
		return (substr_count($this->category[$catid]['arrparentid'], ',') + 1);
	}

	function url($catid, $is_update = 1)
	{
		global $MODEL;
		$data = $this->get($catid);
		if(!$data) return false;
		$this->u->CATEGORY[$catid] = $data;
		if($this->category[$catid]['type'] == 2) return false;
		cache_write('category_'.$catid.'.php', $data);
		if($MODEL[$this->category[$catid]['modelid']]['ishtml'])
		{
			if(!preg_match('/:\/\//',$data['url']))
			{
				$url = $this->u->category($catid);
			}
			else
			{
				$url = $data['url'];
			}
		}
		else
		{
			$url = $this->u->category($catid);
		}
		$url = preg_replace('/index\.[a-z]{3,5}$/', '', $url);
		if($is_update)
		{
			$categorys_c = array();
			$result = $this->db->query("SELECT * FROM `$this->table` WHERE `module`='$this->module'");
			while($r = $this->db->fetch_array($result))
			{
				$categorys_c[$r['catid']] = $r;
			}
			if(!$categorys_c[$catid]['parentid'])
			{
				$this->db->query("UPDATE `$this->table` SET url='$url' WHERE catid=$catid");
				$arrchildid = $data['arrchildid'];
				$arrchild = explode(',',$arrchildid);
				foreach($arrchild AS $k)
				{
					$parentdir = $second_domain = '';
					if($categorys_c[$k]['modelid'])
					{
						if($k == $catid || !$MODEL[$categorys_c[$k]['modelid']]['ishtml'] || $categorys_c[$k]['type'] == 2) continue;
					}
					else
					{
						$child_array_data = $this->get($k);
						if($k == $catid || !$child_array_data['ishtml'] || $categorys_c[$k]['type'] == 2) continue;	
					}
					$arrparentid = $categorys_c[$k]['arrparentid'];
					$arrparentid = explode(',',$arrparentid);
					array_shift($arrparentid);
					if(preg_match('/:\/\//',$categorys_c[$arrparentid[0]]['url']))
					{
						$second_domain = $categorys_c[$arrparentid[0]]['url'];
						array_shift($arrparentid);
					}
					foreach($arrparentid AS $p)
					{
						$parentdir .= $categorys_c[$p]['catdir'].'/';
					}
					$caturl = $second_domain.'/'.$parentdir.$categorys_c[$k]['catdir'].'/';
					$this->db->query("UPDATE `$this->table` SET url='$caturl' WHERE catid=$k");
				}
			}
			else
			{
				$this->db->query("UPDATE `$this->table` SET url='$url' WHERE catid=$catid");
			}
			unset($url);
		}
		
		return $url;
	}

	function count($catid, $status = null)
	{
        if(!isset($this->category[$catid])) return false;
		$where = '';
		$where .= $this->category[$catid]['child'] ? "AND `catid` IN(".$this->category[$catid]['arrchildid'].") " : "AND `catid`=$catid ";
        $where .= $status == null ? '' : "AND status='$status' ";
		if($where) $where = ' WHERE '.substr($where, 3);
		return cache_count("SELECT COUNT(*) AS `count` FROM `".DB_PRE."content` $where");
	}

	function cache()
	{
		@set_time_limit(600);
		cache_category();
		cache_common();
	}
}
?>