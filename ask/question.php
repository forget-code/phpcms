<?php 
require './include/common.inc.php';
if(!$_userid) showmessage($LANG['please_login'],$MODULE['member']['url'].'login.php?forward='.urlencode(URL));
require MOD_ROOT.'include/ask.class.php';
$ask = new ask();
if(!$forward) $forward = HTTP_REFERER;

switch($action)
{
	case 'getcheckcode':
		echo form::checkcode('checkcodestr',5);
	break;
	default:
		if($dosubmit)
		{
			checkcode($checkcodestr, $M['publish_code']);
			$info['catid'] = intval($info['catid']);
			$info['reward'] = intval($info['reward']);
			$info['title'] = htmlspecialchars($info['title']);
			if($info['title'] == '') showmessage($LANG['title_no_allow_blank'],'goback');
			if(!$info['catid']) showmessage($LANG['select_category'],'goback');
			if($info['reward'] > $_point) showmessage($LANG['credit_is_poor'],'goback');
			$posts['isask'] = 1;
			foreach($info AS $key=>$val)
			{
				if(!in_array($key,array('title','catid','reward','anonymity'))) unset($info[$key]);
			}
			$posts['message'] = $M['use_editor'] ? $message : strip_tags($message);
			$info['addtime'] = $posts['addtime'] = TIME;
			$info['endtime'] = TIME+1296000;
			$info['userid'] = $posts['userid'] = $_userid;
			$info['username'] = $posts['username'] = $_username;

			if($posts['anonymity'] && intval($M['anybody_score']+$info['reward'])>$_point)
			{
				$posts['anonymity'] = 0;
			}
			if(file_exists(CACHE_PATH.'cache_ask_update.php'))
			{
				$cache_ask_update = file_get_contents(CACHE_PATH.'cache_ask_update.php');
				if(!empty($cache_ask_update) && $cache_ask_update < (TIME-intval($M['autoupdate'])))
				{
					require 'cache.func.php';
					cache_common();
					file_put_contents(CACHE_PATH.'cache_ask_update.php',TIME);
					@chmod(CACHE_PATH.'cache_ask_update.php');
				}
			}
			else
			{
				file_put_contents(CACHE_PATH.'cache_ask_update.php',TIME);
				@chmod(CACHE_PATH.'cache_ask_update.php');
			}
			if($M['publish_check'])
			{
				$info['status'] = $posts['status'] = 1;
				$id = $ask->add($info,$posts);
				showmessage($LANG['waiting_check'],$forward);
			}
			else
			{
				$info['status'] = $posts['status'] = 3;
				if($info['reward'] >= $M['height_score']) $info['flag'] = 2;
				$id = $ask->add($info,$posts);
				$url = ask_url($id);
				showmessage($LANG['publish_success'],$url);
			}
		}
		else
		{
			$title = stripslashes($title);
			if($ask->check_status()>0) showmessage($LANG['please_solve_expired_ask'], $M['url']."center.php?action=ask&flag=-1");
			$head['title'] = '我要提问';
			include template('ask', 'question');
		}
	break;
}
?>