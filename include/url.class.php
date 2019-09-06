<?php 
class url
{
	var $db;
	var $URLRULE;
	var $PHPCMS;
	var $CATEGORY;

	function url()
	{
		global $db, $CATEGORY, $MODEL, $URLRULE, $PHPCMS;
		$this->db = &$db;
		$this->URLRULE = $URLRULE;
		$this->PHPCMS = $PHPCMS;
		$this->CATEGORY = $CATEGORY;
		$this->MODEL = $MODEL;
	}

	function index()
	{
		return 'index.'.$this->PHPCMS['fileext'];
	}

	function category($catid, $page = 0, $isurls = 0)
	{
		if(!isset($this->CATEGORY[$catid])) return false;
        $C = cache_read('category_'.$catid.'.php', '', 1);
		if($C['type'] == 0)
		{
			$modelid = $C['modelid'];
			$urlruleid = $this->MODEL[$modelid]['category_urlruleid'];
		}
		elseif($C['type'] == 1)
		{
			$urlruleid = $C['category_urlruleid'];
		}
		elseif($C['type'] == 2)
		{
			return $C['url'];
		}
		if(is_numeric($page)) $page = intval($page);
		$arrparentids = explode(',',$C['arrparentid']);
		$arrparentid = $arrparentids[1];
		if($isurls && preg_match('/:\/\//',$this->CATEGORY[$arrparentid]['url']))
		{
			$parentdir = $this->CATEGORY[$arrparentid]['catdir'];
			$parentdir = substr($C['parentdir'],strlen($parentdir));
			$categorydir = $parentdir.$C['catdir'];

			$catdir = $C['catdir'];
			$fileext = $this->PHPCMS['fileext'];
			$urlrules = explode('|', $this->URLRULE[$urlruleid]);
			$urlrule = $page === 0 ? $urlrules[0] : $urlrules[1];
			eval("\$url = \"$urlrule\";");
			$url = $this->CATEGORY[$arrparentid]['url'].$url;
		}
		else
		{
			$categorydir = $C['parentdir'].$C['catdir'];
			$catdir = $C['catdir'];
			$fileext = $this->PHPCMS['fileext'];
			$urlrules = explode('|', $this->URLRULE[$urlruleid]);
			$urlrule = $page === 0 ? $urlrules[0] : $urlrules[1];
			eval("\$url = \"$urlrule\";");
		}		
		return $url;
	}

	function show($contentid, $page = 0, $catid = 0, $time = 0, $prefix = '')
	{
		global $PHPCMS;
		if($catid == 0 || $time == 0 || $prefix == '')
		{
			$r = $this->db->get_one("SELECT `catid`,`inputtime`,`prefix` FROM `".DB_PRE."content` WHERE `contentid`='$contentid'");
			$catid = $r['catid'];
			$time = $r['inputtime'];
			if(!$prefix) $prefix = $r['prefix'];
		}
		if(!isset($this->CATEGORY[$catid])) return false;
        $C = cache_read('category_'.$catid.'.php', '', 1);
		$categorydir = $C['parentdir'].$C['catdir'];
		$catdir = $C['catdir'];
		$fileext = $this->PHPCMS['fileext'];
		$year = date('Y', $time);
		$month = date('m', $time);
		$day = date('d', $time);
		$modelid = $C['modelid'];
		$urlruleid = $this->MODEL[$modelid]['show_urlruleid'];
		$urlrules = explode('|', $this->URLRULE[$urlruleid]);
		$urlrule = $page < 2 ? $urlrules[0] : $urlrules[1];
		if($this->MODEL[$modelid]['ishtml'])
		{
			if($prefix)
			{
				$contentid = $prefix;
			}
			elseif($PHPCMS['enable_urlencode'])
			{
				$contentid = hash_string($contentid);
			}
		}
		eval("\$url = \"$urlrule\";");
		return $url;
	}

	function show_pages($page, $pagenumber, $pageurls)
	{
		$pages = '';
		for($i=1; $i<=$pagenumber; $i++)
		{
			$pages .= $page == $i ? '<span>'.$i.'</span>' : '<a href="'.$pageurls[$i].'">'.$i.'</a>';        
		}
		$prepage = max($page-1, 1);
		$nextpage = min($page+1, $pagenumber);
		return '<a href="'.$pageurls[$prepage].'">上一页</a>'.$pages.'<a href="'.$pageurls[$nextpage].'">下一页</a>';
	}

	function update($contentid,$urls)
	{
		$this->db->query("UPDATE `".DB_PRE."content` SET url='$urls' WHERE `contentid`='$contentid'");
	}
}
?>