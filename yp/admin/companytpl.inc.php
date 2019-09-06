<?php
defined('IN_PHPCMS') or exit('Access Denied');
if($dosubmit)
{
	$companytpl_config = array();
	foreach($stylegroup AS $k=>$v)
	{
		$groupids = '';
		$groupid = 'group'.$k;
		$thumburl = 'thumb'.$k;
		if(is_array($$groupid))
		{
			foreach($$groupid AS $g)
			{
				$groupids .=  $g.',';
			}
		}
		$putsdefaulttpl = 0;
		if($defaulttpl == $k) $putsdefaulttpl = 1;
		$companytpl_config[$tplname[$k]][] = $tplname[$k];
		$companytpl_config[$tplname[$k]]['groupid'] = $groupids;
		$companytpl_config[$tplname[$k]]['thumb'] = $$thumburl;
		$companytpl_config[$tplname[$k]]['defaulttpl'] = $putsdefaulttpl;
		$companytpl_config[$tplname[$k]]['filename'] = $filename[$k];	
	}
	array_save($companytpl_config, "\$companytpl_config", PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/'.$mod.'/companytplnames.php');
	showmessage($LANG['template_update_complate'],$forward);
}
else
{
	require PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/'.$mod.'/templatenames.php';
	require PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/'.$mod.'/companytplnames.php';

	$temp = array();
	$string = '';
	$tmpgroupid = 0;
	foreach($templatenames AS $k=>$v)
	{
		$pos = strpos($k,'-');
		if(!preg_match('/^com_([\s\S]*?)/i',$k)) continue;
		if($pos) continue;
		$tplname = preg_replace("/\[([\s\S]*?)\]/i","",$v);
		$ks = substr($k,0,-5);
		$selected = '';
		if(empty($companytpl_config[$tplname]['filename']))
		{
			
			$f = "<a href=\"?mod=phpcms&file=template&action=manage&module=yp&searchtype=filename&keyword=".$ks."\" title='$LANG[edit]'>".$ks."</a>";
			$tdstyle = "bgcolor='#D6E4D6'";
			$arrgroupid_browse = '1';
			$thumb = '';
		}
		else
		{
			$f = "<a href=\"?mod=phpcms&file=template&action=manage&module=yp&searchtype=filename&keyword=".$companytpl_config[$tplname]['filename']."\" title='".$LANG['edit']."'>".$companytpl_config[$tplname]['filename']."</a>";
			if($companytpl_config[$tplname]['defaulttpl'])	$selected = "checked='checked'";
			$tdstyle = "class='tablerow'";
			$arrgroupid_browse = $companytpl_config[$tplname]['groupid'];
			$thumb = $companytpl_config[$tplname]['thumb'];
		}	
		$string .= "<tr align='center'>";
		$string .= "<td $tdstyle rowspan='2'><input type='radio' name='defaulttpl' $selected value='$tmpgroupid'></td>";
		$string .= "<td $tdstyle>$tplname</td>";
		$string .= "<td $tdstyle>$f</td>";
		$string .= "<td $tdstyle>";
		
		$arrgroupid_used = showgroup("checkbox","group".$tmpgroupid."[]",$arrgroupid_browse);
		$string .= $arrgroupid_used;
		$string .= "<input type='hidden' name='stylegroup[]'><input type='hidden' name='tplname[]' value='$tplname'><input type='hidden' name='filename[]' value='$ks'></td></tr>";
		$string .= "<tr><td $tdstyle align='center' onmouseover=\"this.className='mover';ShowADPreview('<img src=$thumb border=0>');\" onmouseout=\"this.className='mout';hideTooltip('dHTMLADPreview');\">预览</td><td colspan='3' $tdstyle>";
		$string .= " <input name='thumb$tmpgroupid' type='text' id='thumb$tmpgroupid' size='70' value='$thumb'>  <input type='button' value='上传缩略图' onclick=\"javascript:openwinx('?mod=yp&file=uppic&keyid=yp&uploadtext=thumb$tmpgroupid&type=thumb&width=600&height=300','upload_thumb','350','350')\">";
		$string .= "</td></tr>";
		$tmpgroupid++;
	}

	include admintpl('companytpl');
}

?>