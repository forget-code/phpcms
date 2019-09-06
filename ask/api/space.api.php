<?php
require '../include/common.inc.php';
require '../include/ask.class.php';
header('Content-type: text/html; charset=utf-8');
$userid = intval($userid);
if($userid < 1) return false;
if($order != '' && !in_array($order,array('askid','addtime','endtime','answercount','hits','flag'))) exit;
$ask = new ask();
$arr_ask = $ask->listinfo("userid=$userid", $order, 1, 10);
if (is_array($arr_ask))
{
	foreach ($arr_ask as $v) 
	{
		$v['date'] = date('Y-m-d', $v['addtime']);
		if(strtolower(CHARSET) != 'utf-8') $v = str_charset(CHARSET, 'utf-8', $v);
		$array[] = $v;
	}
}
$article['words'] = $array;
$more_url['moreurl'] = $M[url];
unset($array);
$array = array_merge($article, $more_url);
$array = json_encode($array);
echo $array;
?>