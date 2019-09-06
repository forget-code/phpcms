<?php
/**
* 广告管理
* @version phpcms 3.0.0 build 20060424
* @package phpcms
* @subpackage ads
* @link http://dev.phpcms.cn phpcms模块开发网站
* @license http://www.phpcms.cn/license.html phpcms版权声明
* @copyright (C) 2005 - 2006 Phpcms Group
*/
defined('IN_PHPCMS') or exit(FORBIDDEN);

$submenu = array
(
	array("添加广告", "?mod=".$mod."&file=ads&action=add"),
	array("广告管理", "?mod=".$mod."&file=ads&action=manage"),
	array("广告订单管理", "?mod=".$mod."&file=ads&action=signlist"),
	array("添加广告位", "?mod=".$mod."&file=place&action=add"),
	array("广告位管理", "?mod=".$mod."&file=place&action=manage"),
	array("广告模板管理", "?mod=phpcms&file=template&action=manage&module=".$mod),
);
$menu = adminmenu("广告管理",$submenu);

$action = $action?$action:"manager";
switch($action)
{
	case 'signlist':
  	$page = intval($page)>0 ? $page : 1;
  	$offset=($page-1)*$_PHPCMS['pagesize'];
  	$result=$db->query("SELECT count(*) as num FROM ".TABLE_ADS." where ispassed = 0");
  	$r=$db->fetch_array($result);
  	$number=$r["num"];
  	$url='?mod='.$mod.'file=ads&action='.$action;
  	$pages = phppages($number,$page,$_PHPCMS['pagesize'],$url);
  
		$todaytime = time(date("Y-m-d"));
  	$result=$db->query("SELECT * FROM ".TABLE_ADS." where ispassed = 0 order by addtime desc,adsid limit $offset,$_PHPCMS[pagesize]");

  	while($r=$db->fetch_array($result)){
  		$r[fromdate] = $r[fromdate] ? date("Y-m-d",$r[fromdate]) : '';
  		$r[todate] = $r[todate] ? date("Y-m-d",$r[todate]) : '';
  		$r[addtime] = $r[addtime] ? date("Y-m-d",$r[addtime]) : '';
        $r[typename] = get_type($r[type]);
        $r[placename] = $_adsplaces[$r[placeid]][placename];
        $r[channelname] = $_CHANNEL[$_adsplaces[$r[placeid]][channelid]][channelname];
  		$adss[]=$r;
  	}

  	include admintpl('ads_signlist');
		break;

  case 'pass':
		if(is_numeric($adsid)){
	  	$adsid = array($adsid);
		} 
		if (is_array($adsid)) {
			$adsids = implode(",",$adsid);
			$result=$db->query("select u.userid as userid, a.placeid as placeid, a.adsid as adsid,a.fromdate as fromdate,a.todate as todate from ".TABLE_MEMBER." u, ".TABLE_ADS." a where adsid in ($adsids) and a.username=u.username and a.ispassed=0");
  		while($r=$db->fetch_array($result)) {
				$_money = ceil(($r[todate] - $r[fromdate])/(2592000))*abs($_adsplaces[$r[placeid]][price]);
				$db->query("update ".TABLE_MEMBER." SET money=money-".$_money." where userid=".$r[userid]." and money>=".$_money." limit 1");
				$_adsids = ",".$r[adsid];
			}
			$db->query("update ".TABLE_ADS." set ispassed=1,passed=1 where adsid in (".(($_adsids)?substr($_adsids,1):$adsids).")");
		}

		if ($db->affected_rows()>0) {
			showmessage('操作成功！',"?mod=ads&file=ads");
		} else {
			showmessage('操作完成！未能查询到需要的记录，已返回。',"?mod=ads&file=ads&action=listsign");
		}

		showmessage("错误参数！请返回！");
    break;

  case 'add':
    $date->set_date(date("Y-m-d"));
    $date->monthadd();
    $lastmonth =  $date->get_date();

    if ($submit) {
  		if(strlen($ads[adsname])<2 || strlen($ads[adsname])>30){
  			showmessage("名称不能为空且不得少于2个字符或超过30个字符！请返回！");
  		}
  
  		$badwords=array("\\",'&',"'",'"','/','*','<','>',"\r","\t","\n",'#');
  		foreach ($badwords as $value) {
  			if(strpos($ads[adsname],$value)!==false) { 
  				showmessage('名称中不得包含非法字符！请返回！'); 
  			}
  		}
  
  		foreach ($badwords as $value) {
  			if(strpos($ads[introduce],$value)!==false) { 
  				showmessage('广告说明中不得包含非法字符！请返回！'); 
  			}
  		}
  
  		$badwords=array("\\",'&',' ',"'",'"','*',',','<','>',"\r","\t","\n",'#');
  		foreach ($badwords as $value) {
  			if(strpos($ads[linkurl],$value)!==false) { 
  				showmessage('名称中不得包含非法字符！请返回！'); 
  			}
  		}
  
  		if(!$_adsplaces[$ads[placeid]][placename]){
  			showmessage("错误的发布位！请返回！请返回！");
  		}

  		if(!$ads[fromdate]){
  			showmessage("请输入广告发布日期！请返回！");
  		}
        
  		if(!$ads[todate]){
  			showmessage("请输入广告结束日期！请返回！");
  		}

      if($ads[type]=="image") {
        if(!strlen($imageurl)) showmessage("请输入广告图片文件位置！请返回！");
        $type_sql = ",type='$ads[type]',alt='$ads[alt]',linkurl='$ads[linkurl]',imageurl='$imageurl'";
      }
      if($ads[type]=="flash") {
        if(!$flashurl) showmessage("请输入广告Flash文件位置！请返回！");
        $type_sql = ",type='$ads[type]',flashurl='$flashurl',wmode='".($ads[wmode]=="transparent"?"transparent":"")."'";
      }
      if($ads[type]=="text") {
        if(!$ads[text]) showmessage("请输入广告文字内容！请返回！");
        $type_sql = ",type='$ads[type]',text='$ads[text]'";
      }
      if($ads[type]=="code") {
        if(!$ads[code]) showmessage("请输入广告脚本内容！请返回！");
        $type_sql = ",type='$ads[type]',code='$ads[code]'";
      }
      
      $ads[username] = $ads[username]?$ads[username]:$_username;
      
      $sql = "INSERT INTO ".TABLE_ADS." SET adsname='$ads[adsname]',introduce='$ads[introduce]',ispassed=1,addtime='".time()."',placeid='$ads[placeid]',passed=".($ads[passed]?1:0).",username='$ads[username]',fromdate=".strtotime($ads[fromdate]).",todate=".strtotime($ads[todate]).$type_sql;

  		$result=$db->query($sql);
  		if($db->affected_rows()>0) {
  			showmessage('操作成功！广告信息已经记录！',"?mod=".$mod."&file=ads");
  		} else {
  			showmessage('操作失败！意外错误，请确认输入内容。');
  		}  		

  	}
    
    include admintpl("ads_add");
    break;

  case 'edit':
		if ($submit) {
  		if(strlen($ads[adsname])<2 || strlen($ads[adsname])>30){
  			showmessage("名称不能为空且不得少于2个字符或超过30个字符！请返回！");
  		}
  
  		$badwords=array("\\",'&',"'",'"','/','*','<','>',"\r","\t","\n",'#');
  		foreach ($badwords as $value) {
  			if(strpos($ads[adsname],$value)!==false) { 
  				showmessage('名称中不得包含非法字符！请返回！'); 
  			}
  		}
  
  		foreach ($badwords as $value) {
  			if(strpos($ads[introduce],$value)!==false) { 
  				showmessage('广告说明中不得包含非法字符！请返回！'); 
  			}
  		}
  
  		$badwords=array("\\",'&',' ',"'",'"','*',',','<','>',"\r","\t","\n",'#');
  		foreach ($badwords as $value) {
  			if(strpos($ads[linkurl],$value)!==false) { 
  				showmessage('名称中不得包含非法字符！请返回！'); 
  			}
  		}
  
  		if(!$_adsplaces[$ads[placeid]][placename]){
  			showmessage("错误的发布位！请返回！请返回！");
  		}

  		if(!$ads[fromdate]){
  			showmessage("请输入广告发布日期！请返回！");
  		}
        
  		if(!$ads[todate]){
  			showmessage("请输入广告结束日期！请返回！");
  		}

      if($ads[type]=="image") {
        if(!strlen($imageurl)) showmessage("请输入广告图片文件位置！请返回！");
        $type_sql = ",type='$ads[type]',alt='$ads[alt]',linkurl='$ads[linkurl]',imageurl='$imageurl'";
      }
      if($ads[type]=="flash") {
        if(!$flashurl) showmessage("请输入广告Flash文件位置！请返回！");
        $type_sql = ",type='$ads[type]',flashurl='$flashurl',wmode='".($ads[wmode]=="transparent"?"transparent":"")."'";
      }
      if($ads[type]=="text") {
        if(!$ads[text]) showmessage("请输入广告文字内容！请返回！");
        $type_sql = ",type='$ads[type]',text='$ads[text]'";
      }
      if($ads[type]=="code") {
        if(!$ads[code]) showmessage("请输入广告脚本内容！请返回！");
        $type_sql = ",type='$ads[type]',code='$ads[code]'";
      }
      
      $ads[username] = $ads[username]?$ads[username]:$_username;
      
        $sql = "UPDATE ".TABLE_ADS." SET adsname='$ads[adsname]',introduce='$ads[introduce]',placeid='$ads[placeid]',passed=".($ads[passed]?1:0).",username='$ads[username]',fromdate=".strtotime($ads[fromdate]).",todate=".strtotime($ads[todate]).$type_sql." where adsid=$ads[adsid] limit 1";

  		$result=$db->query($sql);
  		if($db->affected_rows()>0) {
  			showmessage('操作成功！记录已被修改。',"?mod=".$mod."&file=ads");
  		} else {
  			showmessage('操作失败！意外错误，请确认输入内容。');
  		}  		
		}

		$ads = $db->get_one("SELECT * FROM ".TABLE_ADS." where adsid = $adsid limit 1");
		if (count($ads)<1) showmessage("未能查询到需要的记录，已返回。","?mod=ads&file=ads");

		$ads[fromdate] = date("Y-n-j",$ads[fromdate]);
		$ads[todate] = date("Y-n-j",$ads[todate]);

    include admintpl("ads_edit");
    break;

	case 'view':
    include admintpl("ads_view");
		break;

	case 'loadjs':
		include admintpl("ads_loadjs");
		break;

  case 'lock':
		if (is_array($adsid) && is_numeric($val)) {
			$adsids = implode(",",$adsid);
			$db->query("update ".TABLE_ADS." set passed = $val where adsid in (".$adsids.")");
		}

		if ($db->affected_rows()>0) {
			showmessage('操作成功！',"?mod=ads&file=ads");
		} else {
			showmessage('操作完成！未能查询到需要的记录，已返回。',"?mod=ads&file=ads");
		}

		showmessage("错误参数！请返回！");
    break;

  case 'delete':
		if(is_numeric($adsid)){
	  	$result=$db->query("delete from ".TABLE_ADS." where adsid=".$adsid);
		} elseif (is_array($adsid)) {
			$adsids = implode(",",$adsid);
			$db->query("delete from ".TABLE_ADS." where adsid in ($adsids)");
		}

		if($db->affected_rows()>0) {
			showmessage('操作成功！',"?mod=".$mod."&file=ads");
		} else {
			showmessage("操作完成！未能查询到需要的记录，已返回。","?mod=ads&file=ads");
		}

		showmessage("错误参数！请返回！");
    break;
  
  default:
  	$page = intval($page)>0 ? $page : 1;
  	$offset=($page-1)*$_PHPCMS['pagesize'];
  	$result=$db->query("SELECT count(*) as num FROM ".TABLE_ADS." where ispassed = 1");
  	$r=$db->fetch_array($result);
  	$number=$r["num"];
  	$url='?mod='.$mod.'&file=ads&action='.$action;
  	$pages = phppages($number,$page,$_PHPCMS['pagesize'],$url);
  
	$todaytime = time(date("Y-m-d"));
  	$result=$db->query("SELECT * FROM ".TABLE_ADS." where ispassed = 1 order by addtime desc,adsid limit $offset,$_PHPCMS[pagesize]");
  	while($r=$db->fetch_array($result)){
		if(($r[todate] > $todaytime) && ($r[fromdate] < $todaytime) && $r[passed] && $_adsplaces[$r[placeid]][passed])
		{
			$r[overtime] = "<span style='color:red'>√</span>";
			$r[status] = 1;
		}
		else
		{
			$r[overtime] = "×";
			$r[status] = 0;
		}
  		$r[validdatenum] = $date->get_diff(date("Y-m-d",$r[todate]),date("Y-m-d"));
  		$r[fromdate] = $r[fromdate] ? date("Y-m-d",$r[fromdate]) : '';
  		$r[todate] = $r[todate] ? date("Y-m-d",$r[todate]) : '';
  		$r[addtime] = $r[addtime] ? date("Y-m-d",$r[addtime]) : '';
        $r[typename] = get_type($r[type]);
        $r[placename] = $_adsplaces[$r[placeid]][placename];
        $r[channelname] = $_CHANNEL[$_adsplaces[$r[placeid]][channelid]][channelname];
  		$adss[]=$r;
  	}
  
  	include admintpl('ads_list');
}

?>