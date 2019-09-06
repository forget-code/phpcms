<?php
require './include/common.inc.php';

if(!$_userid) showmessage($LANG['login_website'] , $MODULE['member']['linkurl'].'login.php?forward='.urlencode($PHP_URL));

$head['title'] = $LANG['promote_award'];
$head['keywords'] = $LANG['promote_award'];
$head['description'] = $LANG['promote_award'];

$reflink = linkurl($MOD['linkurl'], 1).'?'.$_userid;
@extract($MOD);
if(!isset($type))
{
	$type = 'points';
}
if(!isset($number))
{
	$number = 0;
}
switch ($type)
{
	case 'points':
		$number .= $LANG['points'];
		break;
	case 'days':
		$number .= $LANG['days_of_membership_valid'];
		break;
	case 'money':
		$number .= $LANG['funds_for_consumer'];
}

$page = $page ? intval($page) : 1;
$pagesize = $PHPCMS['pagesize'];
$offset = ($page-1)*$pagesize;
$r = $db->get_one("SELECT count(*) as num FROM ".TABLE_BILL." WHERE userid=$_userid");
$pages = phppages($r['num'], $page, $pagesize);

$bills = array(); 
$result = $db->query("SELECT * FROM ".TABLE_BILL." WHERE userid=$_userid LIMIT $offset,$pagesize");
while($r = $db->fetch_array($result))
{
	$r['addtime'] = date('Y-m-d h:i:s', $r['addtime']);
	$bills[] = $r;
}

include template($mod, 'reflink');
?>