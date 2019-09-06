<?php
defined('IN_YP') or exit('Access Denied');
if(!isset($action)) $action = 'manage';
require_once 'form.class.php';
require_once MOD_ROOT.'include/guestbook.class.php';
$c = new guestbook();
$c->set_userid($userid);
switch($action)
{
	case 'manage':
		
		$infos = $c->listinfo("WHERE userid='$userid'",'`gid` DESC',$page);
		$pages = $c->pages;
	break;
	case 'answer':
		if($dosubmit)
		{
			$style = htmlspecialchars($style);
			
			$c->sign($id,$style);
			showmessage('操作成功！',$forward);
		}
		else
		{
			$info = $c->get($id);
			$c->status($id);
			if($info['id'] && in_array($info['label'],array('product','buy','job','news')))
			{
				$table = DB_PRE.'yp_'.$info['label'];
				$r = $db->get_one("SELECT `title` FROM `$table` WHERE `id`='$info[id]'");
				$title = $r['title'];
			}
		}
	break;

	case 'delete':
		$c->delete($gid);
		$infos = $c->listinfo("WHERE userid='$userid'",'`gid` DESC',$page);
		$pages = $c->pages;
		$action = 'manage';
	break;
	
	case 'batdo':
		foreach($gid as $id)
		{
			if($batmethod == 'delete')
			{
				if($id)$c->delete(intval($id));
			}
			elseif($batmethod == 'bookmark')
			{
				if($id)$c->status(intval($id));
			}
		}
		exit('ok');
	break;
}
include template('yp', 'center_guestbook');
?>