<?php
defined('IN_PHPCMS') or exit('Access Denied');


$page = isset($page) ? intval($page) : 1;
$offset = ($page-1)*$PHPCMS['pagesize'];
$result = $db->query("SELECT count(formid) as num FROM ".TABLE_FORMGUIDE." WHERE 1");
$r = $db->fetch_array($result);
$number = $r['num'];
$pages = phppages($number,$page,$PHPCMS['pagesize']);

$query ="SELECT formid,formname,introduce,toemail,addtime,disabled".
		" FROM ".TABLE_FORMGUIDE.
		" WHERE 1 order by formid desc limit $offset,".$PHPCMS['pagesize'];

$result = $db->query($query);
$forms = array();
while($r=$db->fetch_array($result))
{
	$r['addtime'] = date('Y-m-d',$r['addtime']);
	$r['toemail'] = $r['toemail']?"<a href='?mod=mail&file=send&type=1&email=".$r['toemail']."'>".$r['toemail']."</a>":$LANG['no_send'].'email';
	$s = $db->get_one("SELECT count(formid) as submitnum FROM ".TABLE_FORMGUIDE_DATA." WHERE formid=".$r['formid']);
	$r['submitnum'] = $s ? $s['submitnum'] : 0;
	$forms[] = $r;
}

include admintpl('form_manage');
?>