<?php
function caturl()
{
	global $URLRULE,$catid,$page;
	if(!$page) $page = 1;
	$M = cache_read('module_video.php');
	$urlrule = $URLRULE[$M['categoryUrlRuleid']];
	if(strpos($urlrule, '|'))
	{
		$urlrules = explode('|', $urlrule);
        $urlrule = $page < 2 ? $urlrules[0] : $urlrules[1];
	}
	eval("\$url = \"$urlrule\";");
	$url = $M['url'].$url;
	return $url;
}

function special_ajax_page($num, $curr_page, $perpage = 20, $specialid = 0)
{

		$multipage = '';
		if($num > $perpage)
		{
			$page = 11;
			$offset = 4;
			$pages = ceil($num / $perpage);
			$from = $curr_page - $offset;
			$to = $curr_page + $offset;
			$more = 0;
			if($page >= $pages)
			{
				$from = 2;
				$to = $pages-1;
			}
			else
			{
				if($from <= 1)
				{
					$to = $page-1;
					$from = 2;
				}
				elseif($to >= $pages)
				{
					$from = $pages-($page-2);
					$to = $pages-1;
				}
				$more = 1;
			}

			$multipage .= '总数：<b>'.$num.'</b>&nbsp;&nbsp;';

			if($curr_page>0)
			{
				$multipage .= '<a href="javascript:void(0)" onclick="ajax_page('.$specialid.','.($curr_page-1).')">上一页</a>';
				if($curr_page==1)
				{
					$multipage .= '<u><b>1</b></u> ';
				}
				elseif($curr_page>6 && $more)
				{
					$multipage .= '<a href="javascript:void(0)" onclick="ajax_page('.$specialid.',1)">1</a>..';
				}
				else
				{
					$multipage .= '<a href="javascript:void(0)" onclick="ajax_page('.$specialid.',1)">1</a>';
				}
			}
			for($i = $from; $i <= $to; $i++)
			{
				if($i != $curr_page)
				{
					$multipage .= '<a href="javascript:void(0)" onclick="ajax_page('.$specialid.','.$i.')">'.$i.'</a>';
				}
				else
				{
					$multipage .= ' <u><b>'.$i.'</b></u> ';
				}
			}
			if($curr_page<$pages)
			{
				if($curr_page<$pages-5 && $more)
				{

					$multipage .= '..<a href="javascript:void(0)" onclick="ajax_page('.$specialid.','.$pages.')">'.$pages.'</a> <a href="javascript:void(0)" onclick="ajax_page('.$specialid.','.($curr_page+1).')">下一页</a>';
				}
				else
				{
					$multipage .= '<a href="javascript:void(0)" onclick="ajax_page('.$specialid.','.$pages.')">'.$pages.'</a> <a href="javascript:void(0)" onclick="ajax_page('.$specialid.','.($curr_page+1).')">下一页</a>';
				}
			}
			elseif($curr_page==$pages)
			{
				$multipage .= ' <u><b>'.$pages.'</b></u><a href="javascript:void(0)" onclick="ajax_page('.$specialid.','.$curr_page.')">下一页</a>';
			}
		}
		return $multipage;
	
}

?>