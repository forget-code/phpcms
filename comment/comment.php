<?php
require './include/common.inc.php';
$action = trim($action) ? $action : '';
if($action != 'ajaxcheckcode')
{
    if(!$M['ischecklogin']) {if(!$_userid) showmessage('请先登陆后在发表',$MODULE['member']['url'].'login.php?forward='.urlencode(URL));}
}
$head['keywords'] = $PHPCMS['keywords'];
$head['description'] = $PHPCMS['description'];
require_once PHPCMS_ROOT.'/include/form.class.php';
require_once  MOD_ROOT.'/include/comment.class.php';
$comments = new comment();
switch ( $action )
{
	case 'vote':
		if(!preg_match('/([a-z0-9\_\-]+)/',$field)) showmessage('非法操作');
		if(!preg_match('/([a-z0-9\_\-]+)/',$id)) showmessage('非法操作');
	
		$count = $comments->ajaxupdate($field, $id);
		echo ' '.$LANG[$field].'('.$count[$field].')';
	break;
	case 'add':
        $url = "?keyid=$keyid&verify=$verify";
		$content = new_htmlspecialchars($contenttext);
        $content = trim($content);
        if(strlen($content) >= 1000) showmessage('内容太长，最多1000个文字',$url);
		if(empty($content)) showmessage('内容不能为空',$url);
		$keyid = trim($keyid);
		if($comments->add($commentid, $content, $keyid)) showmessage('回复成功',$url);
	break;
	case 'comment':
		$post = $comments->ajaxpost();
		echo $post;
	break;
	default:
        $keyid = trim($keyid);
        $verify = trim($verify);
        if(empty($keyid) || !keyid_verify($keyid, $verify)) showmessage('非法操作');
		$setting = cache_read('module_comment.php');
		$content = keyid_get($keyid);
        $url      = $content['url'];
		$head['title'] = $title   = $content['title'];
		$pagesize	= $setting['maxnum'] ? $setting['maxnum'] : 10;
		$page		= isset($page) ? intval($page) : 1;
		$comments = $comments->get_list($keyid,$page, $pagesize);
		$pages = $comments['pages'];
		include template('comment', 'list');//reply
	break;
	case 'addpost':
        checkcode($checkcode,$M['enablecheckcode']);
		$content = new_htmlspecialchars($comment);
        $content = trim($content);
        if(strlen($content) >= 1000)
        {
            showmessage('内容太长，最多1000个文字');
        }
		if(empty($content)) showmessage('内容不能为空');
        $keyid = trim($keyid);
		if($comments->addpost($content, $keyid))
        showmessage('发表成功', $M['url'].'?keyid='.$keyid.'&verify='.$verify);
	break;
    case 'ajaxpost':
        if(empty($keyid) || !keyid_verify($keyid, $verify)) showmessage('非法操作');
        $content = keyid_get($keyid);
        $title   = $content['title'];
        include template('comment', 'load');
    break;
    case 'ajaxcheckcode':
        if($M['enablecheckcode'])
        {
            $code = form::checkcode('checkcode',5);
            echo $code;
        }
        else
        {
            $code = '';
            echo $code;
        }
    break;
}
?>