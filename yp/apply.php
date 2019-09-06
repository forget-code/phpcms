<?php
require './include/common.inc.php';
require_once MOD_ROOT.'include/apply.class.php';
$a = new apply();
$a->set_userid($_userid);
$avatar = avatar($_userid);
$r = $a->get($applyid, 1);
if($r)
{
	extract($r);
}
else
{
	header("Location: myjob.php?action=add");
	exit;
}
if($status != 3)
{
	if(!$company_user_infos)
	{

		$MS['title'] = '当前简历已经被锁定，不能查看！';
		$MS['description'] = '你可以做下面操作';
		$MS['urls'][0] = array(
			'name'=>'返回进入前的页面',
			'url'=>'javascript:history.back(-1)',
			);
		msg($MS);
	}
}
$montharr = array('01','02','03','04','05','06','07','08','09','10','11','12');
$dayarr = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
$station = $TYPE[$station][name];
if($_userid)
{
	if(in_array($_groupid,$M['priv_roleid']))
	{
		$allowview = 1;
	}
	else
	{
		$r = $a->get_stock_by_useridandapplyid($_userid,$applyid);
		if($r)$allowview = 1;
		else $allowview = NULL;
	}
}
include template('yp','apply');
?>