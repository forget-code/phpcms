<?php
/**
* 广告位管理
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

$action = $action ? $action : "manage";
switch ($action) {
  case 'add':
     if($submit) {
		if(strlen($place[placename]) <2 || strlen($place[placename]) >30) {
		   showmessage("名称不能为空且不得少于2个字符或超过30个字符！请返回！");
		}
		$badwords = array("\\", '&', "'", '"', '/', '*', '<', '>', "\r", "\t", "\n", '#');
		foreach($badwords as $value) {
		  if(strpos($place[placename], $value) !== false) {
		     showmessage('名称中不得包含非法字符！请返回！');
		  }
		}
		foreach($badwords as $value) {
		  if(strpos($place[introduce], $value) !== false) {
		     showmessage('说明中不得包含非法字符！请返回！');
		  }
		}
		if(!$templateid) {
		 showmessage("请输入广告位模版！请返回！");
		}
		if (!is_numeric($place[price])) {
		 showmessage("请输入广告位价格！请返回！");
		}
		if (!is_numeric($place[height]) && !is_numeric($place[weight])) {
		 showmessage("请确认输入广告位高度和宽度格式为数值！请返回！");
		}
		$sql = "INSERT INTO ".TABLE_ADS_PLACE." SET placename='$place[placename]',introduce='$place[introduce]',templateid='$templateid',price='$place[price]',channelid='$place[channelid]',passed=".($place[passed] ? 1 : 0) .",width='$place[width]',height='$place[height]'";
		$result = $db->query($sql);
		if ($db->affected_rows() >0) {
		 showmessage('操作完成！', "?mod=$mod&file=$file&action=manage");
		} else {
		 showmessage('操作失败！意外错误，请确认输入内容。');
		}
   }
   $template_select = showtpl($mod, "ads", "templateid");
   include admintpl("place_add");
  break;

  case 'loadjs':
   include admintpl("place_loadjs");
  break;

  case 'view':
   include admintpl("place_view");
  break;

  case 'edit':
   if ($submit) {
    if (strlen($place[placename]) <2 || strlen($place[placename]) >30) {
     showmessage("名称不能为空且不得少于2个字符或超过30个字符！请返回！");
    }
    $badwords = array("\\", '&', "'", '"', '/', '*', '<', '>', "\r", "\t", "\n", '#');
    foreach($badwords as $value) {
     if (strpos($place[placename], $value) !== false) {
      showmessage('名称中不得包含非法字符！请返回！');
     }
    }
    foreach($badwords as $value) {
     if (strpos($place[introduce], $value) !== false) {
      showmessage('说明中不得包含非法字符！请返回！');
     }
    }
    if (!$templateid) {
     showmessage("请输入广告位模版！请返回！");
    }
    if (!is_numeric($place[price])) {
     showmessage("请输入广告位价格！请返回！");
    }
    if (!is_numeric($place[height]) && !is_numeric($place[weight])) {
     showmessage("请确认输入广告位高度和宽度格式为数值！请返回！");
    }
    $sql = "update ".TABLE_ADS_PLACE." SET placename='$place[placename]',introduce='$place[introduce]',templateid='$templateid',price='$place[price]',channelid='$place[channelid]',passed=".($place[passed] ? 1 : 0) .",width='$place[width]',height='$place[height]' where placeid=".$place[placeid]." limit 1";
    $result = $db->query($sql);
    if ($db->affected_rows() >0) {
     showmessage('操作完成！', "?mod=$mod&file=$file");
    } else {
     showmessage('操作失败！意外错误，请确认输入内容。');
    }
   }
   $place = $db->get_one("SELECT * FROM ".TABLE_ADS_PLACE." where placeid = $placeid limit 1");
   if (count($place) <1) showmessage("未能查询到需要的记录，已返回。", "?mod=ads&file=place");
   $template_select = showtpl($mod, "ads", "templateid", $place[templateid]);
   include admintpl("place_edit");
   break;

   case 'lock':
    if (is_numeric($placeid) && is_numeric($val)) {
     $db->query("update ".TABLE_ADS_PLACE." set passed = $val where placeid=$placeid limit 1");
    } elseif (is_array($placeid)) {
     $placeids = implode(",", $placeid);
     $db->query("update ".TABLE_ADS_PLACE." set passed = $val where placeid in ($placeids)");
    }
    if ($db->affected_rows() >0) {
     showmessage('操作成功！', "?mod=ads&file=place");
    } else {
     showmessage('操作完成！未能查询到符合的记录，已返回。', "?mod=ads&file=place");
    }
    showmessage("错误参数！请返回！");
   break;

   case 'delete':
    if (is_numeric($placeid)) {
     $db->query("delete from ".TABLE_ADS." where placeid=".$placeid);
     $db->query("delete from ".TABLE_ADS_PLACE." where placeid=".$placeid." limit 1");
    } elseif (is_array($placeid)) {
     $placeids = implode(",", $placeid);
     $db->query("delete from ".TABLE_ADS." where placeid in ($placeids)");
     $db->query("delete from ".TABLE_ADS_PLACE." where placeid in ($placeids)");
    }
    if ($db->affected_rows() >0) {
     showmessage('操作成功！', "?mod=".$mod."&file=place");
    } else {
     showmessage("操作完成！未能查询到符合的记录，已返回。", "?mod=ads&file=place");
    }
    showmessage("错误参数！请返回！");
   break;

   default:

    @include PHPCMS_ROOT."/templates/".$defaulttemplate."/ads/templatenames.php";
    $page = intval($page);
    $page = $page>0 ? $page : 1;
    $offset = ($page-1) *$_PHPCMS['pagesize'];
    $result = $db->query("SELECT count(*) as num FROM ".TABLE_ADS_PLACE);
    $r = $db->fetch_array($result);
    $number = $r["num"];
    $url = '?mod='.$mod.'&file=place&action='.$action;
    $pages = phppages($number, $page, $_PHPCMS['pagesize'], $url);
    $result = $db->query("SELECT * FROM ".TABLE_ADS_PLACE." order by placeid desc limit $offset,$_PHPCMS[pagesize] ");
    while ($r = $db->fetch_array($result))
	{
		$places[] = $r;
    }
    reset($places);
    $today = time(date("Y-m-d"));
    while ($place = current($places))
	{
		$result = $db->get_one("SELECT * FROM ".TABLE_ADS." where placeid=$place[placeid] AND passed=1 and fromdate<='$today' and todate>='$today' limit 1");
		$places[key($places) ][todate] = $result[todate] ? date("Y-m-d", $result[todate]) : "-";
		$places[key($places) ][username] = $result[username] ? $result[username] : "-";
		next($places);
    }
    include admintpl("place_list");
}
?>