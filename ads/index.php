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
require "common.php";

$action = $action ? $action : "list";

switch($action)
{
	case 'add':

		if(!$_userid) message("请您先登录或注册！" , PHPCMS_PATH."member/login.php");

		$ads[username] = $_username;

		if($_money< ($_adsplaces[$ads[placeid]][price]*$ads[longtime])) message("您的资金不足！请补充预留款！","goback");

		if($submit) {
			if(strlen($ads[adsname])<2 || strlen($ads[adsname])>30){
				message("名称不能为空且不得少于2个字符或超过30个字符！请返回！");
			}
	  
			$badwords=array("\\",'&',"'",'"','/','*','<','>',"\r","\t","\n",'#');
			foreach ($badwords as $value) {
				if(strpos($ads[adsname],$value)!==false) { 
					message('名称中不得包含非法字符！请返回！'); 
				}
			}
	  
			foreach ($badwords as $value) {
				if(strpos($ads[introduce],$value)!==false) { 
					message('广告说明中不得包含非法字符！请返回！'); 
				}
			}
	  
			$badwords=array("\\",'&',' ',"'",'"','*',',','<','>',"\r","\t","\n",'#');
			foreach ($badwords as $value) {
				if(strpos($ads[linkurl],$value)!==false) { 
					message('名称中不得包含非法字符！请返回！'); 
				}
			}
	  
			if(!$_adsplaces[$ads[placeid]][placename]){
				message("错误的发布位！请返回！请返回！");
			}

			if(!$ads[fromdate]){
				message("请输入广告发布日期！请返回！");
			}
			
			if(!$ads[longtime]){
				message("请输入广告投放时间！请返回！");
			} else {

					$date->set_date($ads[fromdate]);
					$date->monthadd($ads[longtime]);
					$ads[todate] =  $date->get_date();				
			}

		  if($ads[type]=="image") {
			if(!strlen($imageurl)) message("请输入广告图片文件位置！请返回！");
			$type_sql = ",type='$ads[type]',alt='$ads[alt]',linkurl='$ads[linkurl]',imageurl='$imageurl'";
		  }
		  if($ads[type]=="flash") {
			if(!$flashurl) message("请输入广告Flash文件位置！请返回！");
			$type_sql = ",type='$ads[type]',flashurl='$flashurl',wmode='".($ads[wmode]=="transparent"?"transparent":"")."'";
		  }
		  if($ads[type]=="text") {
			if(!$ads[text]) message("请输入广告文字内容！请返回！");
			$type_sql = ",type='$ads[type]',text='$ads[text]'";
		  }
		  if($ads[type]=="code") {
			if(!$ads[code]) message("请输入广告脚本内容！请返回！");
			$type_sql = ",type='$ads[type]',code='$ads[code]'";
		  }
		  
			$sql = "INSERT INTO ".TABLE_ADS." SET adsname='$ads[adsname]',introduce='$ads[introduce]',addtime='".time()."',placeid='$ads[placeid]',passed=".($ads[passed]?1:0).",username='$ads[username]',fromdate=".strtotime($ads[fromdate]).",todate=".strtotime($ads[todate]).$type_sql;
				
			$result=$db->query($sql);
			if($db->affected_rows()>0) {
				message('操作成功！管理员审核广告信息后即可发布！',"index.php");
			} else {
				message('操作失败！意外错误，请确认输入内容。');
			}  		

		}
		showmessage("请确认输入内容。", "index.php");
		break;

	case 'sign':
		if(!$_userid) message("请您先登录或注册！" , PHPCMS_PATH."member/login.php");

		$_month = "<SELECT NAME='ads[longtime]'>";		
		for ($i=1;$i<=12;$i++) {
			$_month .= "<option value='$i'>$i 个月</option>";
		}
		$_month .= "</SELECT>";

		include template('ads','signadsplace');
		break;

	default:
     $page = intval($page);
     $page = $page>0 ? $page : 1;
     $offset = ($page-1) *$_PHPCMS['pagesize'];
     $r = $db->get_one("SELECT count(*) as num FROM ".TABLE_ADS_PLACE." LEFT JOIN ".TABLE_ADS." ON (".TABLE_ADS_PLACE.".placeid=".TABLE_ADS.".placeid) where ".TABLE_ADS_PLACE.".passed=1");
     $number = $r["num"];
     $pages = phppages($number, $page, $_PHPCMS['pagesize']);
     $result = $db->query("SELECT ".TABLE_ADS_PLACE.".*,".TABLE_ADS.".ispassed as adspassed,".TABLE_ADS.".todate,max(todate) as today FROM ".TABLE_ADS_PLACE." LEFT JOIN ".TABLE_ADS." ON (".TABLE_ADS_PLACE.".placeid=".TABLE_ADS.".placeid) where ".TABLE_ADS_PLACE.".passed=1 GROUP BY ".TABLE_ADS_PLACE.".placeid order by ".TABLE_ADS_PLACE.".channelid,".TABLE_ADS_PLACE.".placeid desc limit $offset,$_PHPCMS[pagesize] ");
     $todaytime = time(date("Y-m-d"));
     while ($r = $db->fetch_array($result)) {
			$r[bgcolor] = ($r[todate] > $todaytime) ? "#efefef" : "#FFCC00";
			if($r[adspassed] && $r[todate] > $todaytime) {
			$r[status] = "√";
			} elseif (!$r[adspassed] && $r[todate] > $todaytime) {
			$r[status] = "<font color='red'>≈</font>";
			} else {
			$r[status] = "<font color='red'>×</font>";
			}

			$r[todate] = ($r[todate]>$todaytime) ? date("Y-m-d", $r[todate]) :"-";
			$places[] = $r;
     }

     include template('ads','placelists');

}
?>