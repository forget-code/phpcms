<?php
require_once "include/common.inc.php";

$voteid = intval($voteid);
if(!$voteid) showmessage($LANG['illegal_parameters'],"goback");
$r = $db->get_one("SELECT * FROM ".TABLE_VOTE_SUBJECT." WHERE voteid='$voteid' AND passed= 1 ");
if(!$r['voteid']) showmessage($LANG['not_exist_vote'],"goback");
@extract($r);
$todate = $todate>'0000-00-00' ? $todate : $LANG['unrestricted'];
$i=0;
$result = $db->query("SELECT * FROM ".TABLE_VOTE_OPTION." WHERE voteid='$voteid' ");
$ops = array();
while($r=$db->fetch_array($result))
{
	$per = $totalnumber ? round(100*$r['number']/$totalnumber) : 0;
	$r['per'] = $per ? $per."%" : "0";
	$r['lenth'] = 6*$per;
	$r['i'] = substr($i,-1,1);
	$ops[] = $r;
	$i++;
}
@extract($db->get_one("SELECT count(id) AS votenumber FROM ".TABLE_VOTE_DATA." WHERE voteid='$voteid' "));
$showmember = isset($showmember) ? $showmember : 0 ;
$showmember = intval($showmember);
if($showmember)
{
	$memberdata = array();
	$resultdata = $db->query("SELECT voteuser,votetime,count(voteuser) AS number FROM ".TABLE_VOTE_DATA." WHERE voteid='$voteid' AND voteuser != '' GROUP BY voteuser ORDER BY id DESC ");
	while($rdata=$db->fetch_array($resultdata))
	{
		$memberdata[] = $rdata;
	}
}
$seo_title = $subject;
$templateid = $templateid ? $templateid : "show";
include template('vote',$templateid);
?>