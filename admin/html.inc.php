<?php 
defined('IN_PHPCMS') or exit('Access Denied');
@set_time_limit(600);
$html = load('html.class.php');

switch($action)
{
    case 'index':
        $filesize = $html->index();
	    showmessage('网站首页更新成功！<br />大小：'.sizecount($filesize));
		break;

    case 'category':
		if($dosubmit)
		{
			if(!isset($count))
			{
				$cids = array();
				if(!isset($catids) || $catids[0] == 0) 
				{
					foreach($CATEGORY as $cid=>$v)
					{
						if($v['type'] <= 1) $catids[] = $cid;
					}
				}
                foreach($catids as $k=>$id)
                {
					if($CATEGORY[$id]['type'] == 0)
					{
						$cids[] = $id;
					}
					elseif($CATEGORY[$id]['type'] == 1)
					{
						$html->category($id);
					}
                }
				if($cids)
				{
					cache_write('html_category_'.$_userid.'.php', $cids);
					$count = count($cids);
					$forward = urlencode($forward);
					showmessage('开始更新栏目页...', "?mod=$mod&file=$file&action=$action&forward=$forward&pagesize=$pagesize&dosubmit=1&count=$count");
				}
				else
				{
					showmessage('更新完成！', "?mod=$mod&file=$file&action=$action");
				}
            }
			else
			{

				$catids = cache_read('html_category_'.$_userid.'.php');
				$page = max(intval($page), 1);
				if($page == 1)
				{
				    $catid = array_shift($catids);
					cache_write('html_category_'.$_userid.'.php', $catids);
                }
				$catname = $CATEGORY[$catid]['catname'];

				if($CATEGORY[$catid]['child'])
				{	
					$pages = 1;
					$html->category($catid);
				}
				else
				{
					$offset = $pagesize*($page-1);
					if($page == 1)
					{
						$contents = cache_count("SELECT COUNT(*) AS `count` FROM `".DB_PRE."content` WHERE catid=$catid AND status=99");
						$total = ceil($contents/$PHPCMS['pagesize'])+1;
						$pages = ceil($total/$pagesize);
					}
					$max = min($offset+$pagesize, $total);
					for($i=$offset; $i<$max; $i++)
					{
						$html->category($catid, $i);
					}
				}
				if($pages > $page)
				{
					$page++;
					$percent = round($max/$total, 2)*100;
					$message = "正在更新 <font color='blue'>$catname</font> 栏目，共需更新 <font color='red'>$total</font> 个网页<br />已更新 <font color='red'>{$max}</font> 个网页（<font color='red'>{$percent}%</font>）";
					$forward = url_par("catid=$catid&page=$page&pages=$pages&total=$total");
				}
				elseif($catids)
				{
					$message = "<font color='blue'>$catname</font> 栏目更新完成！";
					$forward = url_par("catid=0&page=0&pages=0&total=0");
				}
				else
				{
					cache_delete('html_category_'.$_userid.'.php');
					$message = "更新完成！";
					$forward = '?mod=phpcms&file=html&action=category';
				}
				showmessage($message, $forward);
			}
		}
		else
		{
			include admin_tpl('html_category');
        }
		break;

    case 'show':
		if($dosubmit)
		{
			require_once 'attachment.class.php';
			require_once CACHE_MODEL_PATH.'content_output.class.php';
			require_once 'admin/content.class.php';

			$attachment = new attachment($mod, $catid);
			$c = new content();
			$coutput = new content_output();
			if($type == 'lastinput')
			{
				$offset = 0;
			}
			else
			{
				$page = max(intval($page), 1);
				$offset = $pagesize*($page-1);
			}
		    $where = ' WHERE status=99 ';
			$order = 'ASC';
			
			if(!isset($first) && is_array($catids) && $catids[0] > 0) 
			{
				cache_write('html_show_'.$_userid.'.php', $catids);
				$catids = implodeids($catids);
				$where .= " AND catid IN($catids) ";
				$first = 1;
			}
			elseif($first)
			{
				$catids = cache_read('html_show_'.$_userid.'.php');
				$catids = implodeids($catids);
				$where .= " AND catid IN($catids) ";
			}
			else
			{
				$first = 0;
			}

			if($type == 'lastinput' && $number)
			{
				$offset = 0;
				$pagesize = $number;
				$order = 'DESC';
			}
			elseif($type == 'date')
			{
				if($fromdate)
				{
					$fromtime = strtotime($fromdate.' 00:00:00');
					$where .= " AND `inputtime`>=$fromtime ";
				}
				if($todate)
				{
					$totime = strtotime($todate.' 23:59:59');
					$where .= " AND `inputtime`<=$totime ";
				}
			}
			elseif($type == 'id')
			{
				$fromid = intval($fromid);
				$toid = intval($toid);
				if($fromid) $where .= " AND `contentid`>=$fromid ";
				if($toid) $where .= " AND `contentid`<=$toid ";
			}
			if(!isset($total) && $type != 'lastinput')
			{
				$total = cache_count("SELECT COUNT(*) AS `count` FROM `".DB_PRE."content` $where");
				$pages = ceil($total/$pagesize);
				$start = 1;
			}
			$data = $db->select("SELECT `contentid` FROM `".DB_PRE."content` $where ORDER BY `contentid` $order LIMIT $offset,$pagesize");
			foreach($data as $r)
			{
				$html->show($r['contentid']);
			}
			if($pages > $page)
			{
				$page++;
				$creatednum = $offset + count($data);
				$percent = round($creatednum/$total, 2)*100;
				$message = "共需更新 <font color='red'>$total</font> 条信息<br />已完成 <font color='red'>{$creatednum}</font> 条（<font color='red'>{$percent}%</font>）";
				$forward = $start ? "?mod=phpcms&file=html&type=$type&dosubmit=1&firest=$first&action=$action&fromid=$fromid&toid=$toid&fromdate=$fromdate&todate=$todate&pagesize=$pagesize&page=$page&pages=$pages&total=$total" : preg_replace("/&page=([0-9]+)&pages=([0-9]+)&total=([0-9]+)/", "&page=$page&pages=$pages&total=$total", URL);;
			}
			else
			{
				cache_delete('html_show_'.$_userid.'.php');
				$message = "更新完成！";
				$forward = '?mod=phpcms&file=html&action=show';
			}
			showmessage($message, $forward);
		}
		else
		{
			include admin_tpl('html_show');
        }
		break;

    default :
}

?>