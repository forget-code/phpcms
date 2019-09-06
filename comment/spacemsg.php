<?php
require './include/common.inc.php';
if(!$M['ischecklogin']) {if(!$_userid) showmessage('请先登陆后在发表',$MODULE['member']['url'].'login.php?forward='.urlencode(URL));}
$head['keywords'] = $PHPCMS['keywords'];
$head['description'] = $PHPCMS['description'];
require_once  MOD_ROOT.'/include/comment.class.php';
$comments = new comment();
switch ( $action )
{
	case 'list':
        include template('comment', 'spacemsg');
	break;
    case 'add':
    break;
    case 'del':
    break;
}
?>