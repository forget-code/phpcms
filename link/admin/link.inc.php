<?php
defined('IN_PHPCMS') or exit('Access Denied');

$g = $db->get_one("SELECT count(linkid) AS number FROM ".TABLE_LINK." WHERE passed=0 ");
if($g['number'])
{
	$submenu = array(
		array("<font color=\"blue\">".$LANG['add_link']."</font>","?mod=$mod&file=$file&action=add"),
		array("<font color=\"red\">".$LANG['link_manage']."</font>","?mod=$mod&file=$file&action=manage"),
		array("<font color=\"red\">".$LANG['link_checked']."($g[number])</font>","?mod=$mod&file=$file&action=manage&passed=0"),
		array("<font color=\"blue\">".$LANG['link_type_list']."</font>","?mod=$mod&file=$file&action=typelist")
	);
}
else
{
	$submenu = array(
		array("<font color=\"blue\">".$LANG['add_link']."</font>","?mod=$mod&file=$file&action=add"),
		array("<font color=\"red\">".$LANG['link_manage']."</font>","?mod=$mod&file=$file&action=manage"),
		array($LANG['link_checked'],"?mod=$mod&file=$file&action=manage&passed=0"),
		array("<font color=\"blue\">".$LANG['link_type_list']."</font>","?mod=$mod&file=$file&action=typelist")

	);
}
$menu = adminmenu($LANG['link_manage'],$submenu);
$action = $action ? $action : 'manage';
switch($action)
{
	case 'add':
		
		if(isset($submit))
		{
			if(!ereg('^[01]+$',$linktype))
			{
				showmessage($LANG['illegal_parameters']); 
			}   
			if(empty($name))
			{
				showmessage($LANG['input_domain_name'],"goback");
			}
			if(empty($url) || $url=='http://')
			{
				showmessage($LANG['input_url'],"goback");
			}
			
			$db->query("INSERT INTO ".TABLE_LINK." (`typeid` , `linktype` , `style` , `name` , `url` , `logo` , `introduce` , `username` , `elite` , `passed` , `addtime` )  VALUES('$typeid','$linktype','$style_color','$name','$url','$logo','$introduce','$username','$elite','$passed','$PHP_TIME')");
			if($db->affected_rows()>0)
			{
				$linkid = $db->insert_id();
				$db->query("UPDATE ".TABLE_LINK." SET `listorder`=$linkid WHERE linkid=$linkid");
				showmessage($LANG['operation_success'], "?mod=link&file=createhtml&forward=".urlencode($forward));
			}
			else
			{
				showmessage($LANG['operation_failure']);
			}
		}
		else
		{			
			$style_edit = style_edit("style","");
			include admintpl('link_add');
		}
		break;

	case 'manage':
		$passed = isset($passed) ? intval($passed) : 1;
		$pagesize = $PHPCMS['pagesize'];
		$page = isset($page) ? intval($page) : 1;
		$offset = ($page-1)*$pagesize;

		$condition = '';
		if(isset($typeid)) $condition = ' AND typeid='.intval($typeid);
		if(isset($linktype)) $condition = ' AND linktype='.intval($linktype);
		if(isset($elite)) $condition = ' AND elite='.intval($elite);
		if(isset($keyword))
		{
			$keyword = trim($keyword);
			$keyword = str_replace(' ','%',$keyword);
			$keyword = str_replace('*','%',$keyword);
			$condition .= " AND name LIKE '%$keyword%' ";
		}		
		$r = $db->get_one("SELECT COUNT(linkid) AS num FROM ".TABLE_LINK." WHERE passed=$passed $condition");
		$number = $r['num'];
		$pages = phppages($number,$page,$pagesize);
		$links = array();
		$result = $db->query("SELECT linkid,typeid,linktype,style,name,url,logo,introduce,username,listorder,elite,hits,passed FROM ".TABLE_LINK." WHERE passed=$passed $condition ORDER BY listorder,elite DESC LIMIT $offset,$pagesize");		
		while($r = $db->fetch_array($result))
		{
			$links[] = $r;
		}
		include admintpl('link_manage');
		break;
		
	case 'typelist':
		include admintpl('link_typelist');
		break;
		
	case 'pass' :
		if(empty($linkid))
		{
			showmessage($LANG['illegal_parameters']);
		}
		if(!ereg('^[0-1]+$',$passed))
		{
			showmessage($LANG['illegal_parameters']);
		}
		$linkids=is_array($linkid) ? implode(',',$linkid) : $linkid;
		$db->query("UPDATE ".TABLE_LINK." SET passed=$passed WHERE linkid IN ($linkids)");
		if($db->affected_rows()>0)
		{
			showmessage($LANG['operation_success'],$forward);
		}
		else
		{
			showmessage($LANG['operation_failure']);
		}
	break;

	case 'elite' :
		if(empty($linkid))
		{
			showmessage($LANG['illegal_parameters']);
		}
		if(!ereg('^[0-1]+$',$elite))
		{
			showmessage($LANG['illegal_parameters']);
		}
		$linkids=is_array($linkid) ? implode(',',$linkid) : $linkid;
		$db->query("UPDATE ".TABLE_LINK." SET elite=$elite WHERE linkid IN ($linkids)");
		if($db->affected_rows()>0)
		{
			showmessage($LANG['operation_success'],$forward);
		}
		else
		{
			showmessage($LANG['operation_failure']);
		}
	break;

	case 'delete' :
		if(empty($linkid))
		{
			showmessage($LANG['illegal_parameters']);
		}
		$linkids=is_array($linkid) ? implode(',',$linkid) : $linkid;
		$db->query("DELETE FROM ".TABLE_LINK." WHERE linkid IN ($linkids)");
		if($db->affected_rows()>0)
		{
			showmessage($LANG['operation_success'],$forward);
		}
		else
		{
			showmessage($LANG['operation_failure']);
		}
	break;
	
	case 'updatelistorderid':

		if(empty($listorder) || !is_array($listorder))
		{
			showmessage($LANG['illegal_parameters']);
		}

		foreach($listorder as $key=>$val)
		{
			$db->query("UPDATE ".TABLE_LINK." SET `listorder`='$val' WHERE linkid=$key ");
		}

		showmessage($LANG['order_update_success'],$forward);

	break;

	case 'edit':

		if(isset($submit))
		{
			if(!ereg('^[01]+$',$linktype))
			{
				showmessage($LANG['illegal_parameters']); 
			}    
			$query="UPDATE ".TABLE_LINK." SET typeid = '$typeid' , linktype = '$linktype' , style = '$style' , name = '$name' , url = '$url' , logo = '$logo' , introduce = '$introduce' , username = '$username' , elite = '$elite' , passed = '$passed' WHERE linkid=$linkid ";
			$db->query($query);
			if($db->affected_rows()>0)
			{
				showmessage($LANG['operation_success'],$forward);
			}
			else
			{
				showmessage($LANG['operation_failure_content']);
			}
		}
		else
		{		
			@extract($db->get_one("select * from ".TABLE_LINK." where linkid='$linkid' "));
			$style_edit = style_edit("style",$style);			
			include admintpl('link_edit');
		}
		break;
}
?>