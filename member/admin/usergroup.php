<?php
/*
*####################################################
* PHPCMS v3.0.0 - Advanced Content Manage System.
* Copyright (c) 2005-2006 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*####################################################
*/
defined('IN_PHPCMS') or exit('Access Denied');

$referer = $referer ? $referer : $PHP_REFERER;

$submenu = array
(
array("管理首页", "?mod=".$mod."&file=".$file."&channelid=".$channelid."&action=manage"),
array("添加会员组", "?mod=".$mod."&file=".$file."&channelid=".$channelid."&action=add"),
);

$menu = adminmenu("会员组管理",$submenu);

$action=$action ? $action : 'manage';

switch($action)
{
    case 'manage':
        $result=$db->query("SELECT * FROM ".TABLE_USERGROUP." order by groupid","CACHE");
		while($r=$db->fetch_array($result))
		{
			$r['charge'] = $r['chargetype'] ? ($r['defaultvalidday']==-1 ? "无限期" : $r['defaultvalidday']."天"): $r['defaultpoint']."点";
			$r['chargetype'] = $r['chargetype'] ? "有效期" : "扣点数";
			$r['enableaddalways'] = $r['enableaddalways'] ? "<font color=red>是</font>" : "否";
			$r['type'] = $r['grouptype']=="system" ? "系统组" : "自定义";
			$groups[]=$r;
		}
		include admintpl('usergroup_manage');
		break;

    case 'add':
      if($submit){
            $db->query("insert into ".TABLE_USERGROUP."(groupname,introduce,grouptype,chargetype,defaultpoint,defaultvalidday,discount,enableaddalways) values('$groupname','$introduce','$grouptype','$chargetype','$defaultpoint','$defaultvalidday','$discount','$enableaddalways')");
            if($db->affected_rows()>0)
			{
				cache_usergroup();
                showmessage('操作成功！',$referer);
            }
			else
			{
                showmessage('操作失败！请返回！');
            }
      }else{
            include admintpl('usergroup_add');
      }
      break;

    case 'edit':
      if($submit){
            $db->query("update ".TABLE_USERGROUP." set groupname='$groupname',introduce='$introduce',chargetype='$chargetype',defaultpoint='$defaultpoint',defaultvalidday='$defaultvalidday',discount='$discount',enableaddalways='$enableaddalways' where groupid='$groupid'");
            if($db->affected_rows()>0)
			{
                cache_usergroup();
                showmessage('操作成功！',$referer);
            }
			else
			{
                showmessage('操作失败！请返回！');
            }
      }else{
            $r=$db->get_one("select * from ".TABLE_USERGROUP." where groupid='$groupid'");
            @extract($r);
            include admintpl('usergroup_edit');
      }
      break;

	case 'delete':
		if(!$groupid) showmessage("参数错误！",$PHP_REFERER);
	    $db->query("delete from ".TABLE_USERGROUP." where groupid=$groupid");
		cache_usergroup();
		showmessage("操作成功！",$PHP_REFERER);
}
?>