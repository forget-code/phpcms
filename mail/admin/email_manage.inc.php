<?php
defined('IN_PHPCMS') or exit('Access Denied');


$typeid = isset($typeid) ? $typeid : 0;
$condition = '';
if(isset($searchemail)) $condition =" AND email like '%$searchemail%' ";
if($typeid) $condition.=" AND typeids like '%,$typeid,%' ";
$page = isset($page) ? intval($page) : 1;
$offset = ($page-1)*$PHPCMS['pagesize'];
$result = $db->query("SELECT count(emailid) as num FROM ".TABLE_MAIL_EMAIL." WHERE 1  $condition");
$r = $db->fetch_array($result);
$number = $r['num'];
$pages = phppages($number,$page,$PHPCMS['pagesize']);

$query ="SELECT emailid,email,username,typeids,ip,addtime,disabled,authcode     ".
		"FROM ".TABLE_MAIL_EMAIL.
		" WHERE 1 $condition order by emailid desc limit $offset,".$PHPCMS['pagesize'];

$result = $db->query($query);
$emails = array();
while($r = $db->fetch_array($result))
{
	$r['addtime'] = date('Y-m-d',$r['addtime']);
	$r['authcode'] = $r['authcode'] ? $LANG['wrong_sign']  : $LANG['right_sign'] ;	
	$r['username'] = $r['username'] ? $r['username'] : $LANG['guest_subscription'];
	$r['typeids'] = array_filter(explode(',',$r['typeids']));
	$r['type'] = '';
	$n = 0;
	foreach($r['typeids'] as $i=>$k)
	{	
		$r['type'].= $i++.'、'.$TYPE[$k]['name'].'&#10;';	
	}
	$emails[] = $r;
}
$typeid_select = type_select('typeid',$LANG['view_current_type'],$typeid,"onchange=\"location='?mod=$mod&file=$file&action=manage&typeid='+this.value\"");
include admintpl('email_manage');
?>