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

	function category($catid, $page = 0, $isurls = 0, $type = 3)
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
		$domain_dir = $domain_url = '';
		if(preg_match('/:\/\//', $C['url']) && (substr_count($C['url'], '/')<4))
		{
			$url_a[0] = $C['parentdir'].$C['catdir'].'/index.'.$this->PHPCMS['fileext'];
			$url_a[1] = $C['url'];
			return $type<3 ? $url_a[$type] : $url_a;
		}
		else
		{
			$count = count($arrparentids)-1;
			for($i=$count; $i>=0; $i--)
			{
				if(preg_match('/:\/\//', $this->CATEGORY[$arrparentids[$i]]['url']) && (substr_count($this->CATEGORY[$arrparentids[$i]]['url'], '/')<4))
				{
					$domain_dir = $this->CATEGORY[$arrparentids[$i]]['parentdir'].$this->CATEGORY[$arrparentids[$i]]['catdir'].'/';
					$domain_url = $this->CATEGORY[$arrparentids[$i]]['url'];
					break;
				}
			}
		}
		$categorydir = $C['parentdir'].$C['catdir'];
		$catdir = $C['catdir'];
		$fileext = $this->PHPCMS['fileext'];
		$urlrules = explode('|', $this->URLRULE[$urlruleid]);
		$urlrule = $page === 0 ? $urlrules[0] : $urlrules[1];
		eval("\$url = \"$urlrule\";");	
		if($C['type']==0 && $this->MODEL[$modelid]['ishtml'] && $domain_dir)
		{
			if(strpos($url, $domain_dir)===false)
			{
				$url_a[0] = $domain_dir.$url;
			}
			else
			{
				$url_a[0] = $url;
			}
			$url_a[1] = str_replace($domain_dir, $domain_url.'/', $url_a[0]);
		}
		else
		{
			$url_a[0] = $url_a[1] = $url;
		}
		return $type<3 ? $url_a[$type] : $url_a;
	}

	function show($contentid, $page = 0, $catid = 0, $time = 0, $prefix = '')
	{
		global $PHPCMS;
		if($catid == 0 || $time == 0 || $prefix == '')
		{
			$r = $this->db->get_one("SELECT * FROM `".DB_PRE."content` WHERE `contentid`='$contentid'");
			if($r['isupgrade'] && !empty($r['url']))
			{
				if($page>1)
				{
					$base_name = basename($r['url']);
					$fileext = fileext($base_name);
					$url_a[0] = $url_a[1] = preg_replace('/.'.$fileext.'$/','_'.$page.'.'.$fileext,$r['url']);
					return $url_a;
				}
				else
				{
					$url_a[0] = $url_a[1] = $r['url'];
					return $url_a;
				}
			}
			$catid = $r['catid'];
			$time = $r['inputtime'];
			if(!$prefix) $prefix = $r['prefix'];
		}
		if(!isset($this->CATEGORY[$catid])) return false;
        $C = cache_read('category_'.$catid.'.php', '', 1);
		$tag = 0;
		if(preg_match('/:\/\//',$C['url']))
		{
			$tag = 1;
			$arr_url = preg_split('/\//', $C['url']);
			$domain = 'http://'.$arr_url[2];
			$domain1 = 'http://'.$arr_url[2].'/';
			$info = $this->db->get_one("SELECT * FROM `".DB_PRE."category` WHERE `url` IN ('$domain', '$domain1') LIMIT 1");
			$crootdir = $info['parentdir'].$info['catdir'].'/';
		}
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
		if($tag)
		{
			if(!(strpos($url, $crootdir)===0))
			{
				$url = $crootdir.$url;
			}
			$url_a[0] = $url;
			$url_a[1] = $domain1.str_replace($crootdir, '', $url);
		}
		else
		{
			$url_a[0] = $url_a[1] = $url;
		}
		return $url_a;
	}

	function show_pages($page, $pagenumber, $pageurls)
	{
		$pages = '';
		for($i=1; $i<=$pagenumber; $i++)
		{
			$pages .= $page == $i ? '<span>'.$i.'</span>' : '<a href="'.$pageurls[$i][1].'">'.$i.'</a>';        
		}
		$prepage = max($page-1, 1);
		$nextpage = min($page+1, $pagenumber);
		return '<a href="'.$pageurls[$prepage][1].'">上一页</a>'.$pages.'<a href="'.$pageurls[$nextpage][1].'">下一页</a>';
	}

	function update($contentid,$url)
	{
		if(!$this->db->get_one("SELECT contentid FROM `".DB_PRE."content` WHERE `contentid`='$contentid' AND `url`='$url'"))
		{
			return $this->db->query("UPDATE `".DB_PRE."content` SET url='$url' WHERE `contentid`='$contentid'");
		}
		return true;
	}
}
?>