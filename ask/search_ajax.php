<?php 
require './include/common.inc.php';
require_once MOD_ROOT.'include/ask.class.php';
$ask = new ask();
header('Content-type: text/html; charset=utf-8');
if(strtolower(CHARSET) != 'utf-8') $q = iconv(CHARSET, 'utf-8', $q);
$q = addslashes($q);
if($q)
{
	$where = " title LIKE '%$q%' AND status = 5";
}
else 
{
	exit('null');
}
$infos = $ask->listinfo($where, 'askid DESC', '', 10);

foreach($infos as $key=>$val) 
{
	$val['title'] = str_replace($q, '<span class="c_orange">'.$q.'</span>', $val['title']);
	$info[$key]['title'] = CHARSET != 'utf-8' ? iconv(CHARSET, 'utf-8', $val['title']) : $val['title'];
	$info[$key]['url'] = $val['url'];
}

echo(json_encode($info));
?>