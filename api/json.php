<?php 
require '../include/common.inc.php';

if($action == 'category')
{
	$category = '';
	foreach($CATEGORY AS $k=>$v)
	{
		if($v['type'] == 1) continue;
		$category[$k]['module'] = $v['module'];
		$category[$k]['catname'] = iconv('gbk','utf-8',$v['catname']);
		$category[$k]['catid'] = $v['catid'];
		$category[$k]['parentid'] = $v['parentid'];
		$category[$k]['arrparentid'] = $v['arrparentid'];
	}
	$category = json_encode($category);
	echo $category;
}
/*
[catid] => 23
[module] => phpcms
[type] => 0
[modelid] => 1
[catname] => 测试中
[style] => 
[image] => 
[catdir] => chz
[url] => /news/ceshi/chz/index.html
[parentid] => 22
[arrparentid] => 0,6,22
[parentdir] => news/ceshi/
[child] => 1
[arrchildid] => 23,25
[items] => 0
*/

//$category = json_encode($CATEGORY);
?>