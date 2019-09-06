<?php 
defined('IN_PHPCMS') or exit('Access Denied');
@set_time_limit(600);
require_once MOD_ROOT.'include/special.class.php';
require_once MOD_ROOT.'include/html.class.php';

$html = new html();
$special = new special();

$TYPE = subtype('special');

switch($action)
{
    case 'index':
        $filesize = $html->index();
	    showmessage('专题首页更新成功！<br />大小：'.sizecount($filesize));
		break;

    case 'type':
		if(!isset($count))
		{
			if(!isset($typeids) || $typeids[0] == 0) 
			{
				$typeids = array_keys($TYPE);
			}
			if($typeids)
			{
				cache_write('html_type_'.$_userid.'.php', $typeids);
				$count = count($typeids);
				showmessage('开始更新专题类别页...', URL."&count=$count");
			}
			else
			{
				showmessage('更新完成！', "?mod=$mod&file=$file");
			}
		}
		else
		{
			$page = max(intval($page), 1);
			$offset = $pagesize*($page-1);
			if($page == 1)
			{
				$typeids = cache_read('html_type_'.$_userid.'.php');
				$typeid = array_shift($typeids);
			}
			$typename = $TYPE[$typeid]['name'];
			if($page == 1)
			{
				$specials = cache_count("SELECT COUNT(*) AS `count` FROM `".DB_PRE."special` WHERE typeid=$typeid AND disabled=0");
				$total = ceil($specials/$PHPCMS['pagesize']);
				$pages = ceil($total/$pagesize);
			}
			$max = min($offset+$pagesize, $total);
			for($i=$offset; $i<$max; $i++)
			{
				$html->type($typeid, $i);
			}
			if($pages > $page)
			{
				$page++;
				$percent = round($max/$total, 2)*100;
				$message = "正在更新 $typename 类别，共需更新 <font color='red'>$total</font> 个网页<br />已更新 <font color='red'>{$max}</font> 个网页（<font color='red'>{$percent}%</font>）";
				$forward = $page == 1 ? URL."&typeid=$typeid&page=$page&pages=$pages&total=$total" : preg_replace("/&page=([0-9]+)&/", "&page=$page&", URL);
			}
			elseif($typeids)
			{
				cache_write('html_type_'.$_userid.'.php', $typeids);
				$message = "$typename 类别更新完成！";
				$forward = URL;
			}
			else
			{
				cache_delete('html_type_'.$_userid.'.php');
				$message = "更新完成！";
				$forward = '?mod=special&file=html';
			}
			showmessage($message, $forward);
		}
		break;

    case 'show':
		$page = max(intval($page), 1);
		$offset = $pagesize*($page-1);
		$where = ' WHERE disabled=0 ';
		if(isset($typeids) && $typeids[0] > 0) 
		{
			$typeids = implodeids($typeids);
			$where .= " AND typeid IN($typeids) ";
		}
		if(!isset($total))
		{
			$total = cache_count("SELECT COUNT(*) AS `count` FROM `".DB_PRE."special` $where");
			$pages = ceil($total/$pagesize);
		}
		$data = $db->select("SELECT `specialid`, `typeid`, `filename` FROM `".DB_PRE."special` $where ORDER BY `specialid` DESC LIMIT $offset,$pagesize");
		
		foreach($data as $r)
		{
			$html->show($r['specialid'], $r['filename'], $r['typeid']);
		}
		if($pages > $page)
		{
			$page++;
			$creatednum = $offset + count($data);
			$percent = round($creatednum/$total, 2)*100;
			$message = "共需更新 <font color='red'>$total</font> 条信息<br />已完成 <font color='red'>{$creatednum}</font> 条（<font color='red'>{$percent}%</font>）";
			$forward = URL."&page=$page&pages=$pages&total=$total";		
		}
		else
		{
			$message = "更新完成！";
			$forward = '?mod=special&file=html';
		}
		showmessage($message, $forward);
		break;

    default :
		include admin_tpl('html');
}
?>