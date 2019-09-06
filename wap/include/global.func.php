<?php
function wmlHeader($title) 
{
	header("Content-type: text/vnd.wap.wml; charset=utf-8");
	echo "<?xml version=\"1.0\"?>\n".
	"<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.3//EN\" \"http://www.wapforum.org/DTD/wml_1.1.xml\">\n".
	"<wml>\n".
	"<head>\n".
	"<meta http-equiv=\"cache-control\" content=\"max-age=180,private\" />\n".
	"</head>\n".
	"<card id=\"phpcmsWml\" title=\"$title\">\n".
	"<p>\n";
}

function menus() 
{
	global $lang, $cats;
	$html = $lang['channel_news'].'<br/>';
	foreach($cats['news'] as $key=>$val) 
	{
		$html .= '<a href="?action=list&amp;catid='.$val['catid'].'">'.$val['catname'].'</a> ';
	}
	$html .= '<br/>'.$lang['channel_info'].'<br/>';

	foreach($cats['info'] as $key=>$val) 
	{
		$html .= '<a href="?action=list&amp;catid='.$val['catid'].'">'.$val['catname'].'</a> ';
	}
	$html .= "<br/><br/>";
	return $html;
}

function wmlFooter() 
{
	echo "<small>Powered by Phpcms2008</small>\n".
	"</p>\n".
	"</card>\n".
	"</wml>";
}

function submodelcats($modelid = 1, $parentid = NULL, $type = NULL)
{
	global $CATEGORY;
	$subcat = array();
	foreach($CATEGORY as $id=>$cat)
	{
		if($cat['modelid'] == $modelid && ($parentid === NULL || $cat['parentid'] == $parentid) && $cat['parentid'] !=0 && ($type === NULL || $cat['type'] == $type) && $cat['child'] == 0) $subcat[$id] = $cat;
	}

	return $subcat;
}

function  wml_pages($num, $curr_page, $mpurl, $perpage = 20) 
{ 
	global $lang;
	if($num > $perpage) 
	{ 
		$page = 10; 
		$offset = 2; 
		$pages = ceil($num / $perpage); 
		$from = $curr_page - $offset; 
		$to = $curr_page + $page - $offset - 1; 
		if($page > $pages) 
		{ 
			$from = 1; 
			$to = $pages; 
		} 
		else 
		{ 
			if($from < 1) 
			{ 
				$to = $curr_page + 1 - $from; 
				$from = 1; 
				if(($to - $from) < $page && ($to - $from) < $pages) 
				{ 
					$to = $page; 
				} 
			} 
			elseif($to > $pages) 
			{ 
				$from = $curr_page - $pages + $to; 
				$to = $pages; 
				if(($to - $from) < $page && ($to - $from) < $pages) 
				{ 
					$from = $pages - $page + 1; 
				} 
			} 
		} 
		$multipage .= '<a href="'.$mpurl.'1">&lt;&lt;</a>  '; 
		for($i = $from; $i <= $to; $i++) 
		{ 
			if($i != $curr_page) 
			{ 
				$multipage .= '<a href="'.$mpurl.$i.'">['.$i.']</a> '; 
			} 
			else 
			{ 
				$multipage .= '<u><b>['.$i.']</b></u> '; 
			} 
		} 
		$multipage .= $pages > $page ? "...<a href=\"$mpurl$pages\"> [$pages] &gt;&gt;</a>" : "<a href=\"$mpurl$pages\">&gt;&gt;</a>"; 
	}
	return $multipage; 
}

function wml_strip($string)
{
	$string = str_replace(array('&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;', '&'), array(' ', '&', '"', "'", '“', '”', '—', '{<}', '{>}', '·', '…', '&amp;'), strip_tags($string,'<img><br>'));
	return str_replace(array('{<}', '{>}'), array('&lt;', '&gt;'), $string);
}
?>