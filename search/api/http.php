<?php 
require '../include/common.inc.php';

if($action != 'output')
{
	$apis = cache_read('search_api.php');
	if(!isset($apis[$type])) exit('-1');
    if($verify != md5($type.$apis[$type])) exit('-2');
}

switch($action)
{
    case 'input':
		$search->set_type($type);
	    $searchid = $search->add($title, $content, $url);
		echo $searchid;
		break;

    case 'output':
		$q = strip_tags($q);
		$order = isset($order) ? intval($order) : 0;
		$page = max(intval($page), 1);
		$pagesize = max(intval($pagesize), 1);
		$search->set($M['titlelen'], $M['descriptionlen'], 'red');
		$search->set_type($type);
		$data = $search->q($q, $order, $page, $pagesize);
		$total = $search->total;
		if($format == 'json')
	    {
			if(CHARSET != 'utf-8')
			{
				$data = str_charset(CHARSET, 'utf-8', $data);
			    header('Content-type: text/html; charset=utf-8');
			}
			$array = array('total'=>$total, 'page'=>$page, 'pagesize'=>$pagesize, 'data'=>$data);
			echo json_encode($array);
		}
		elseif($format == 'xml')
	    {
			if(CHARSET != 'utf-8')
			{
				$data = str_charset(CHARSET, 'utf-8', $data);
			    header('Content-type: text/html; charset=utf-8');
			}
			include template($mod, 'xml');
		}
		break;

    case 'update':
		$search->set_type($type);
		$search->update($searchid, $title, $content, $url);
		break;

    case 'delete':
		$search->set_type($type);
		$search->delete($searchid);
		break;
}
?>