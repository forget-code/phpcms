<?php 
class html
{
	var $url;

    function __construct()
    {
		$this->url = load('url.class.php');
		if(!defined('CREATEHTML')) define('CREATEHTML', 1);
    }

	function html()
	{
		$this->__construct();
	}

	function index()
	{
		global $PHPCMS;
		if(!$PHPCMS['ishtml']) return true;
		extract($GLOBALS, EXTR_SKIP);
		$head['title'] = $PHPCMS['sitename'].'-'.$PHPCMS['meta_title'];
		$head['keywords'] = $PHPCMS['meta_keywords'];
		$head['description'] = $PHPCMS['meta_description'];
		$subcats = subcat('phpcms', 0, 0);
		$catid = 0;
		ob_start();
		include template('phpcms', 'index');
		$file = PHPCMS_ROOT.$this->url->index();
		return createhtml($file);
	}

	function category($catid, $page = 0)
	{
		extract($GLOBALS, EXTR_SKIP);
		$C = cache_read("category_$catid.php", '', 1);
		if(!$C || $C['type'] > 1) return false;
		extract($C);
		if($type == 0 && !isset($ishtml))
		{
			$ishtml = $MODEL[$modelid]['ishtml'];
		}
		if(!$ishtml) return false;
		$catlist = submodelcat($C['modelid']);
		$arrparentid = explode(',', $CATEGORY[$catid]['arrparentid']);
		$parentid = $arrparentid[1];

        $head['title'] = $catname.'-'.($meta_title ? $meta_title : $PHPCMS['sitename']);
		$head['keywords'] = $meta_keywords;
		$head['description'] = $meta_description;
		$curpage = $page;
		if($type == 0)
		{	
			if($child==1)
			{
				$arrchildid = subcat('phpcms',$catid);
				$template = $template_category;
			}
			else
			{
				if($page == 0) $page = 1;
				$template = $template_list;
			}
		}
		$file_a = $this->url->category($catid, $curpage);
		$file = PHPCMS_ROOT.$file_a[0];
		ob_start();
		include template('phpcms', $template);
		return createhtml($file);
	}

	function show($contentid, $is_update_related = 0)
	{
		global $MODEL,$CATEGORY;
		extract($GLOBALS, EXTR_SKIP);
		if(!is_a($c, 'content'))
		{
			if(!class_exists('content'))
			{
				require 'admin/content.class.php';
			}
			$c = new content();
		}
		$r = $c->get($contentid);
		if(!$r) return false;
		if(isset($r['paginationtype']))
		{
			$paginationtype = $r['paginationtype'];
			$maxcharperpage = $r['maxcharperpage'];
		}
		if($r['catid']) $catid = $r['catid'];
		$CA = cache_read('category_'.$catid.'.php','',1);

		if((!isset($CA['content_ishtml']) && !$MODEL[$CATEGORY[$catid]['modelid']]['ishtml']) || (isset($CA['content_ishtml']) && !$CA['content_ishtml'])) return false;
		
		if($is_update_related)
		{
			$this->index();
			$pages = intval($PHPCMS['autoupdatelist']);
			$catids = explode(',', $CATEGORY[$r['catid']]['arrparentid']);
			$catids[] = $r['catid'];
			foreach($catids as $cid)
			{
				if($cid == 0) continue;
				for($i=0; $i<=$pages; $i++)
				{
					if($CATEGORY[$cid]['child']==1 && $i>0) continue;
					$this->category($cid, $i);
				}
			}
		}
		if($r['status'] != 99) return true;
		$info = $this->url->show($r['contentid'], 0, $r['catid'], $r['inputtime']);
		$show_url_path = $info[0];
		unset($info);
		$show_url_path = str_replace('.'.$PHPCMS['fileext'],'',$show_url_path);
		$GLOBALS['show_url_path'] = $show_url_path;
		
        $C = cache_read('category_'.$r['catid'].'.php', '', 1);
		if($r['template'])
		{
			$GLOBALS['template_show_images'] = $r['template'];
		}
		else
		{
			$GLOBALS['template_show_images'] = $C['template_show'];
		}
		$data = $c->output($r);
		extract($data);
		$template = $GLOBALS['template_show_images'];

		$head['keywords'] = str_replace(' ', ',', $r['keywords']);
		$head['description'] = $r['description'];
		
		$allow_priv = $allow_readpoint = true;
		$pages = $titles = '';
		if($paginationtype==1)
		{
			if(strpos($content, '[/page]')!==false)
			{
				$content = preg_replace("|\[page\](.*)\[/page\]|U", '', $content);
			}
			if(strpos($content, '[page]')!==false)
			{
				$content = str_replace('[page]', '', $content);
			}
			$content = contentpage($content, $maxcharperpage);
		}
		elseif($paginationtype==0)
		{
			if(strpos($content, '[/page]')!==false)
			{
				$content = preg_replace("|\[page\](.*)\[/page\]|U", '', $content);
			}
			if(strpos($content, '[page]')!==false)
			{
				$content = str_replace('[page]', '', $content);
			}
		}
		if(strpos($content, '[page]') !== false)
		{
			$contents = array_filter(explode('[page]', $content));
			$pagenumber = count($contents);
			for($i=1; $i<=$pagenumber; $i++)
			{
				$pageurls[$i] = $this->url->show($r['contentid'], $i, $r['catid'], $r['inputtime']);
			}
			if(strpos($content, '[/page]') !== false)
			{
				if(preg_match_all("|\[page\](.*)\[/page\]|U", $content, $m, PREG_PATTERN_ORDER))
				{
					foreach($m[1] as $k=>$v)
					{
						$page = $k+1;
						$titles .= '<a href="'.$pageurls[$page][0].'">'.$page.'、'.strip_tags($v).'</a>';
					}
				}
			}
			$page = $filesize = 0;
			foreach($contents as $content)
			{
				$page++;
				$pages = $this->url->show_pages($page, $pagenumber, $pageurls);
				if($titles)
				{
					list($title, $content) = explode('[/page]', $content);
				}
				$title = strip_tags($title);
				$head['title'] = $title.'_'.$C['catname'].'_'.$PHPCMS['sitename'];
				ob_start();
				include template('phpcms', $template);
				$file = PHPCMS_ROOT.$pageurls[$page][0];
				$filesize += createhtml($file);
			}
			return $filesize;
		}
		else
		{
			$page = $page ? $page : 1;
			$images_number = $GLOBALS['images_number'];
			$array_images = $GLOBALS['array_images'];
			$title = strip_tags($title);
			$head['title'] = $title.'_'.$C['catname'].'_'.$PHPCMS['sitename'];
			$ishtml = 1;
			$info = $this->url->show($r['contentid'], 0, $r['catid'], $r['inputtime']);
			$file = PHPCMS_ROOT.$info[0];
			ob_start();
			include template('phpcms', $template);
			return createhtml($file);exit;
		}
	}

	function delete($contentid, $table)
	{
		global $db;
		$contentid = intval($contentid);
		if(!$contentid) return FALSE;
		$r = $db->get_one("SELECT * FROM `".DB_PRE."content` c, `$table` b WHERE c.contentid=b.contentid AND c.`contentid`=$contentid");
		if($r['paginationtype']==1)
		{
			$r['content'] = contentpage($r['content'], $r['maxcharperpage']);
		}
		$contents = array_filter(explode('[page]', $r['content']));
		$pagenumber = count($contents);
		for($i=1; $i<=$pagenumber; $i++)
		{
			$info = $this->url->show($contentid, $i, $r['catid'], $r['inputtime']);
			$fileurl = $info[0];
			unset($info);
			@unlink(PHPCMS_ROOT.$fileurl);
		}
		return TRUE;
	}
}
?>