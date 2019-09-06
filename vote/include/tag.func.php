<?php
function vote($template, $voteid = '', $embed = 1)
{
	global $db,$M,$MODULE,$admin_vote,$title,$LANG,$votable,$vote_msg;
	$subject_lists = $admin_vote->get_subjects($voteid);
	$vote_info = $admin_vote->get_vote($voteid);
	if(!$vote_info) return false;
    extract($vote_info);
    if($ismultiple) unset($subject_lists[$voteid]);
	if(!$template) $template = 'vote_submit';
	include template('vote', $template);
}

function vote_show($template, $voteid = '', $embed = 0)
{
	global $db, $M, $MODULE, $admin_vote, $title, $LANG;
	$subjectid = intval($voteid);
	$vote_data = $admin_vote->get_vote_data($subjectid);
	$subs = $db->select("select subjectid,subject from ".DB_PRE."vote_subject where (subjectid='$voteid' and ismultiple<>'1') or parentid='$voteid' order by listorder desc",'subjectid');
	foreach($subs as $sid=>$data)
	{
		$subs[$sid]['options'] = $db->select("select optionid,`option` from ".DB_PRE."vote_option where subjectid='$sid' order by listorder",'optionid');
	}
	include template('vote', 'vote_show');
}
?>