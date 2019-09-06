<?php
require_once './include/common.inc.php';
$voteid = intval($voteid);

if(!$voteid) showmessage($LANG['illegal_parameters']);
$info = $admin_vote->check($voteid);

if($info['viewgroups']) $info['viewgroups'] = explode(',', $info['viewgroups']);
if(is_array($info['viewgroups']) && !in_array($_groupid,$info['viewgroups'])) showmessage($LANG['viewgroup_disabled'], $forward);

@extract($admin_vote->get_vote($voteid));
$head['title'] = $LANG['vote_result'].':'.$subject.'-'.$PHPCMS['sitename'];
if($parentid || !$subject) showmessage($LANG['illegal_parameters']);
if($action == 'js')
{
	$template = 'vote_show';
    ob_start();
    vote_show($template, $voteid, 1);
    $data = ob_get_contents();
    ob_clean();
    exit(format_js($data));
}
include template('vote','show');
?>