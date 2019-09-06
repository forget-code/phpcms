<?php 
require './include/common.inc.php';
if(!$_userid) showmessage($LANG['please_login'],$MODULE['member']['url'].'login.php?forward='.urlencode(URL));
require_once MOD_ROOT.'include/ask.class.php';
$ask = new ask();
require_once MOD_ROOT.'include/answer.class.php';
$answer = new answer();
$id = intval($id);
if(!isset($action)) $action = '';
switch($action)
{
	case 'accept_answer':
	$ask->accept_answer($id, $pid);
	$forward = $forward ? $forward : '';
	showmessage($LANG['optimal_answer'], ask_url($id));
	break;

	case 'over':
	$ask->status($id, 6, $_userid);
	if($M['return_credit'])
	{
		extract($db->get_one("SELECT userid,ischeck FROM $ask->table WHERE askid=$id"));
		if($ischeck) $ask->pay->update_exchange('ask', 'point', $M['return_credit'], $LANG['return_credit'], $userid);
	}
	showmessage($LANG['ask_finish'], ask_url($id));
	break;

	case 'vote':
	if($answer->vote($id, $pid))
	{
		echo $LANG['thinks_your_vote'];
	}
	else
	{
		echo $LANG['your_have_vote'];
	}
	break;

	case 'edit_answer':
	if($dosubmit)
	{
		$posts = array();
		if(strlen($answertext) > 10000) showmessage('回答字数不能超过10000个字符');
		$posts['message'] = $M['use_editor'] ? filter_xss($answertext) : strip_tags($answertext);
		
		$answer->edit($pid, $posts, $_userid);
		showmessage($LANG['operation_success'], $forward);
	}
	break;

	case 'edit_ask':
	if($dosubmit)
	{
		$info = $posts = array();
		$info['title'] = htmlspecialchars($title);
		if(strlen($title)<2) showmessage($LANG['title_is_short']);
		$posts['message'] = $M['use_editor'] ? filter_xss($message) : strip_tags($message);
		$ask->edit($id, $info, $posts, $_userid);
		showmessage($LANG['operation_success'], $forward);
	}
	break;

	case 'addscore':
	if($dosubmit)
	{
		$ask->addscore($id, $point);
		showmessage($LANG['operation_success'], $forward);
	}
	break;	
}

?>