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

$voteid = intval($voteid);
if(!$voteid) message("非法参数","goback");

$r = $db->get_one("select * from ".TABLE_VOTESUBJECT." where voteid='$voteid' ");
if(!$r['voteid']) message("该投票不存在或者已经被删除！","goback");

@extract($r);
if($usernames)
{
	$members = explode(",",$usernames);
    $votemembers = count($members);
	if($showmember)
	{
		$usernames = "";
		foreach($members as $i=>$username)
		{
			$usernames .= "<a href='".PHPCMS_PATH."member/member.php?username=".urlencode($username)."' class='username' target='_blank'>".$username."</a>&nbsp;&nbsp;";
			if($i && $i%15==0) $usernames .= "<br>";
		}
	}
}
else
{
    $votemembers = 0;
}

$voteoption = $type=="radio" ? "voteoption" : "voteoption[]";
$todate = $todate>'0000-00-00' ? $todate : "不限";

$i=0;
$result = $db->query("select * from ".TABLE_VOTEOPTION." where voteid='$voteid' ");
while($r=$db->fetch_array($result))
{
	$per = $totalnumber ? round(100*$r['number']/$totalnumber) : 0;
	$r['per'] = $per ? $per."%" : "0";
	$r['lenth'] = 6*$per;
	$r[i] = substr($i,-1,1);
	$ops[] = $r;
	$i++;
}

$meta_title = $subject;

$templateid = $templateid ? $templateid : "show";
$skindir = $skinid ? PHPCMS_PATH."templates/".$defaulttemplate."/skins/".$skinid : $skindir;

include template('vote',$templateid);
?>