<?php
define('WEB_ROOT', str_replace("\\", '/',dirname(__FILE__)).'/');
require '../include/common.inc.php';
require WEB_ROOT.'include/common.inc.php';
$id = intval($id);
include MOD_ROOT.'include/yp.class.php';
$c = new yp();
$c->set_model($category);
if($infos = $c->get($id))
{
	if($infos['status']==99)
	{
		extract($infos);
		$c->hits($id);
		$head['title'] = $title.' - '.$companyname;
		$head['keywords'] = $keywords;
		$head['description'] = str_cut(strip_tags($content),200,'');
		include template('yp','com_'.TPL.'-'.$category.'_show');
	}
	else
	{
		showmessage("该信息未通过审核");
	}
}
else
{
	showmessage("该信息不存在");
}
?>