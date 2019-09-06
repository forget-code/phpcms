<?php
require '../include/common.inc.php';
require 'admin/content.class.php';
header('Content-type: text/html; charset=utf-8');
$userid = intval($userid);
if($order != '' && !in_array($order,array('contentid','listorder','inputtime','updatetime'))) exit;
$content = new content();
$arr_content = $content->listinfo("userid='$userid' AND status=99", $order, 1, 10);
if (is_array($arr_content))
{
	foreach ($arr_content as $v) 
	{
		$v['date'] = date('Y-m-d', $v['updatetime']);
		if(strtolower(CHARSET) != 'utf-8') $v = str_charset(CHARSET, 'utf-8', $v);
		$array[] = $v;
	}
}
$article['words'] = $array;
$more_url['moreurl'] = $MODULE['space']['url'].'blog.php?userid='.$userid;
unset($array);
$array = array_merge($article, $more_url);
$array = json_encode($array);
echo $array;
?>