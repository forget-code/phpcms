<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$action = $action ? $action : 'manage';
$pagesize = $M[pagesize] && $M[pagesize]<500 ? $M[pagesize] : 20;
switch($action)
{
	case 'add':
		if(isset($submit))
		{

			if(empty($typeid))
			{
				showmessage('请选择分类');
			}
			if(empty($name))
			{
				showmessage('请填写网站名称');
			}
			if(empty($url))
			{
				showmessage('请填写网站地址');
			}
			if(!preg_match('/\b((?#protocol)https?|ftp):\/\/((?#domain)[-A-Z0-9.]+)((?#file)\/[-A-Z0-9+&@#\/%=~_|!:,.;]*)?((?#parameters)\?[-A-Z0-9+&@#\/%=~_|!:,.;]*)?/i', $url))
			{
				showmessage('请填写正确的网站地址');
			}
			if($linktype && empty($logo))
			{
				showmessage('请填写网站的logo');
			}

			$arr = array('typeid'=>$typeid,'linktype'=>$linktype,'style'=>$style,'name'=>$name,'url'=>$url,'logo'=>$logo,'introduce'=>$introduce,'username'=>$username,'elite'=>$elite,'passed'=>$passed,'addtime'=>TIME);
			if($link->add($arr))
			{
				//showmessage($LANG['operation_success'], "?mod=link&file=createhtml&forward=".urlencode($forward));
				showmessage($LANG['operation_success'],"?mod=$mod&file=$file&action=manage");
			}
			else
			{
				showmessage($LANG['operation_failure'],$forward);
			}
		}
		else
		{
			include admin_tpl('link_add');
		}
	break;

	case 'delete':
		if(isset($submit6))
		{
		if(empty($linkid))
			{
				showmessage('请选择要删除的记录',$forward);
			}
			else
			{
				if($link->del($linkid))
				{	
					//showmessage($LANG['operation_success'], "?mod=link&file=createhtml&forward=".urlencode($forward));
					showmessage($LANG['operation_success'],"?mod=$mod&file=$file&action=manage");
				}
				else
				{
					showmessage($LANG['operation_failure'],$forward);
				}
			}
		}
		else
		{
			include admin_tpl('link_del');
		}
	break;

	case 'pass':
		if(isset($passed))
		{
			if($link->check($linkid,$passed))
			{	
			//	showmessage($LANG['operation_success'], "?mod=link&file=createhtml&forward=".urlencode($forward));
				showmessage($LANG['operation_success'],$forward);
			}
			else
			{
				showmessage($LANG['operation_failure'],$forward);
			}
		}
		else
		{	$links = $link->listinfo('where passed=0');
			include admin_tpl('link_manage');
		}
	break;

	case 'elite':
		if(isset($elite))
		{
			if($link->elite($linkid,$elite))
			{
				showmessage($LANG['operation_success'],$forward);
			}
			else
			{
				showmessage($LANG['operation_failure'],$forward);
			}
		}
		else
		{
			$links = $link->listinfo();
			include admin_tpl('link_manage');
		}
		break;

	case 'manage':
		if(!isset($passed)) $passed=1;
		$condition = "where passed='$passed'";
		if(isset($typeid)) $condition .= ' AND typeid='.intval($typeid);
		if(isset($linktype)) $condition .= ' AND linktype='.intval($linktype);
		if(isset($elite)) $condition .= ' AND elite='.intval($elite);
		if(isset($keyword))
		{
			$keyword = trim($keyword);
			$keyword = str_replace(' ','%',$keyword);
			$keyword = str_replace('*','%',$keyword);
			$condition .= " AND name LIKE '%$keyword%' ";
		}	
		$links = $link->listinfo($condition,$order,$page);
		$pages = $link->pages;
		include admin_tpl('link_manage');
	break;

	case 'edit':
		if(isset($submit))
		{
			if(empty($typeid))
			{
				showmessage('请选择分类');
			}
			if(empty($name))
			{
				showmessage('请填写网站名称');
			}
			if(empty($url))
			{
				showmessage('请填写网站地址');
			}
			if(!preg_match('/\b((?#protocol)https?|ftp):\/\/((?#domain)[-A-Z0-9.]+)((?#file)\/[-A-Z0-9+&@#\/%=~_|!:,.;]*)?((?#parameters)\?[-A-Z0-9+&@#\/%=~_|!:,.;]*)?/i', $url))
			{
				showmessage('请填写正确的网站地址');
			}
			if($linktype && empty($logo))
			{
				showmessage('请填写网站的logo');
			}


			$arr = array('typeid'=>$typeid,'linktype'=>$linktype,'style'=>$style,'name'=>$name,'url'=>$url,'logo'=>$logo,'introduce'=>$introduce,'username'=>$username,'elite'=>$elite,'passed'=>$passed,'addtime'=>TIME);
			if(isset($linkid))
			{
				if($link->update($arr,$linkid))
				{
					showmessage($LANG['operation_success'],"?mod=$mod&file=$file&action=manage");
				}
				else
				{
					showmessage($LANG['operation_failure'],$forward);
				}
			}
		}
		else
		{	
			$links = $link->listinfo("where linkid=$linkid");
			$links = $links[0];
			include admin_tpl('link_edit');
		}
		break;

	case 'updatelistorderid':
		$result = $link->listorder($listorder);
		if($result)
		{
			showmessage('操作成功！', $forward);
		}
		else
		{
			showmessage('操作失败！',$forward);
		}

}
?>