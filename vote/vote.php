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
require_once "common.php";

if(!$voteoption) message("请选择投票选项！","goback");

$referer = $referer ? $referer : $PHP_REFERER;

$_username = $_username ? $_username : $PHP_IP;

$voteid = intval($voteid);

$r = $db->get_one("select usernames from ".TABLE_VOTESUBJECT." where voteid='$voteid'");
$members = explode(",",$r['usernames']);
if(in_array($_username,$members)) message("你已经对该主题投过票了，不能重复投票！","goback");
$usernames = $r['usernames'].($r['usernames'] ? "," : "").$_username;

$optionids = is_array($voteoption) ? implode(",",$voteoption) : $voteoption;
$totalnumberadd = is_array($voteoption) ? count($voteoption) : 1;

$db->query("update ".TABLE_VOTEOPTION." set number=number+1 where optionid in ($optionids) ");
$db->query("update ".TABLE_VOTESUBJECT." set totalnumber=totalnumber+$totalnumberadd,usernames='$usernames' where voteid='$voteid'");
message("感谢您的投票！",$referer);
?>