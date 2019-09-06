<?php 
require './include/common.inc.php';
$applyid = isset($item) ? intval($item) : showmessage($LANG['illegal_operation']);
extract($db->get_one("SELECT * FROM ".TABLE_YP_APPLY." WHERE applyid='$applyid'"));
extract($db->get_one("SELECT m.userid,m.email,i.userface,i.truename,i.birthday,i.idcard,i.gender,i.province,i.city,i.address,i.edulevel,i.telephone FROM ".TABLE_MEMBER." m, ".TABLE_MEMBER_INFO." i WHERE m.username='$username' AND m.userid=i.userid"));
$isbn = $applyid;
$edittime = date('Y-m-d',$edittime);
$idcard = substr($idcard,0,12);
$arrgroupidview_apply = explode(',',$MOD['arrgroupidview_apply']);
if(in_array($_groupid,$arrgroupidview_apply)) $arrgroupidview = true;
$db->query("UPDATE ".TABLE_YP_APPLY." SET hits=(hits+1) WHERE applyid='$applyid'");
include template($mod, 'apply');
?>