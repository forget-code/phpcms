<?php
require './include/common.inc.php';
cache_page_start();

$readproid = get_cookie('readproid');
if(intval($readproid)) $prowhere = $readproid;
require_once MOD_ROOT.'include/yp.class.php';
require_once MOD_ROOT.'include/company.class.php';
$company = new company();
$yp = new yp();
$newsid = intval($id);
if(!$newsid) exit('非法参数');
$yp->set_model('news');
$rs = $yp->get($newsid);
if($rs['status'] != 99) showmessage('信息正在审核中...');
$head['keywords'] .= $rs['keywords'].'_新闻';
$head['description'] .= $rs['title'].'_新闻'.'_'.$PHPCMS['sitename'];
$head['title'] .= $rs['title'].'_新闻'.'_'.$PHPCMS['sitename'];
$c = $company->get($rs['userid']);
$key_words_array = explode(" ",$rs['keywords']);
$key_words_array = array_unique($key_words_array);
if(count($key_words_array))
{
	$news_where = '';
	foreach($key_words_array as $nid => $np)
	{
		$np = addslashes(htmlspecialchars($np));
		if($np)
		{
			$news_where .= $nid ? " OR keywords LIKE '%{$np}%'" : " keywords LIKE '%{$np}%'";
		}
	}		
}
if(!$news_where)
{
	$news_where .= "status = '99'";
}
else
{
	$news_where .= " AND status = '99'";
}
include template('yp', 'news_show');
cache_page(intval($M['cache_list']));
?>