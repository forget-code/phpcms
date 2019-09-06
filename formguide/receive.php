<?php 
require './include/common.inc.php';
include_once PHPCMS_ROOT."/include/upload.class.php";

if(!isset($formid)) showmessage($LANG['illegal_submit'] ,'goback');
$formid = intval($formid);
if(!isset($dopost) || !$dosubmit) showmessage($LANG['illegal_submit'] ,'goback');
if(empty($itemstr)) showmessage($LANG['templete_edit_error']);
$itemstr = stripslashes($itemstr);
$formitems = unserialize($itemstr);

if(!$MOD['allowmultisubmit'])
{
	$r = $db->get_one("SELECT formid,ip FROM ".TABLE_FORMGUIDE_DATA." WHERE ip='$PHP_IP' AND formid='$formid' limit 1");
	if($r) showmessage($LANG['not_allowed_to_resubmit'],"close");
}

if($formitems)
{
	$receive = array();
	foreach($formitems['itemname'] as $k=>$item)
	{
		if($formitems['formtype'][$k]!=6)
		{
			if($formitems['ismust'][$k]==1 && ${'f'.$k}=='')
			{
				showmessage($LANG['confirm_all_form_complete']);
			}			
		}
		else if($formitems['ismust'][$k]==1 && empty($_FILES['f'.$k]['tmp_name']))
		{
			showmessage($LANG['must_upload_file']);
		}
	}
	foreach($formitems['itemname'] as $k=>$item)
	{
		if($formitems['formtype'][$k]==6)
		{
			$fileArr = array('file'=>$_FILES['f'.$k]['tmp_name'],'name'=>$_FILES['f'.$k]['name'],'size'=>$_FILES['f'.$k]['size'],'type'=>$_FILES['f'.$k]['type'],'error'=>$_FILES['f'.$k]['error']);
			$savepath = "$mod/".$MOD['uploaddir']."/".date("Ym")."/";
			dir_create($savepath);
			$upload = new upload($fileArr,'',$savepath,$MOD['uploadfiletype'],1,$MOD['maxfilesize']);
		    if($upload->up())
			{
				$receive[] = $upload->saveto;
		    }
			else
			{
				if(strpos($upload->errmsg(),'File upload fail')===0) $receive[] = $LANG['no_post_file'];
				else $receive[] = $upload->errmsg();
			}
			
		}
		else if($formitems['formtype'][$k]==4 || $formitems['formtype'][$k]==5)
		{
			if(!isset(${'f'.$k})) $receive[] = array();
			else $receive[] = ${'f'.$k};
		}
		else 
		{
			if(!isset(${'f'.$k})) $receive[] = '';
			else $receive[] = ${'f'.$k};
		}
	}
}
$receive['itemname'] = $formitems['itemname'];
$receive['formtype'] = $formitems['formtype'];
$receiveser = serialize($receive);
$query = "INSERT INTO ".TABLE_FORMGUIDE_DATA." (content,ip,username,addtime,formid) VALUES('$receiveser','$PHP_IP','$_username','$PHP_TIME','$formid')";
$db->query($query);

$query = "SELECT toemail,formname FROM ".TABLE_FORMGUIDE." WHERE formid=$formid";
$r = $db->get_one($query);
if($r && $r['toemail']!='')
{
$mailhtml = <<<Locoy
<table width="98%"  cellspacing="1" cellpadding="3" align="center" bgcolor="#333333">
Locoy;
foreach($formitems['itemname'] as $k=>$item)
{
$mailhtml.= <<<Locoy
      <tr bgcolor="#FFFFFF">
      <td width="20%" class="tablerow"  align="center">$item</td>
      <td class="tablerow" align="left">
Locoy;
	$j = $k-1;
	$content = $receive[$j];
	if(is_array($content)) $content = implode(",",$content);
	$content = str_replace("\r\n","<br>",$content);
	if($formitems['formtype'][$k] == 6 && $content!=$LANG['no_post_file']) $content = "<a href='".$PHP_SITEURL.$content."' target='_blank'><font color='red'>".$LANG['click_view_file']."</font></a>";
$mailhtml.=$content."</td></tr>";
}
$mailhtml.="</table>";
include PHPCMS_ROOT.'/include/mail.inc.php';
sendmail($r['toemail'],$LANG['post_form_from_formguide'].$r['formname']."",stripslashes($mailhtml));
}

showmessage($LANG['post_success_view_your_content'],"close");
?>