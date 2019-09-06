<?php
defined('IN_PHPCMS') or exit('Access Denied');
define('WEB_SKIN', 'templates/'.TPL_NAME.'/yp/css/');
if(!$action) $action = 'manage';

switch($action)
{
	case 'add':
		if($dosubmit)
		{
			$companytpl_config = include PHPCMS_ROOT.'templates/'.TPL_NAME.'/yp/companytplnames.php';
			$number = count($companytpl_config);
			$keys = $tplname.$number;
			$groupids = '';
			if(is_array($group))
			{
				foreach($group AS $g)
				{
					$groupids .=  $g.',';
				}
			}
			$arr[$keys]['tplname'] = $tplname;
			$arr[$keys]['groupid'] = $groupids;
			$arr[$keys]['thumb'] = $thumb;
			$arr[$keys]['style'] = $style;
			$arr[$keys]['defaulttpl'] = 0;
			$arr[$keys]['filename'] = $filename;
			$companytpl_config = array_merge($companytpl_config,$arr);
			cache_write('companytplnames.php', $companytpl_config,PHPCMS_ROOT.'templates/'.TPL_NAME.'/yp/');
			showmessage('添加成功！');
		}
		else
		{
			unset($GROUP[2],$GROUP[3]);
			$arrgroupid_used = '';
			foreach($GROUP AS $groups=>$v)
			{
				$checked = '';
				$ids = explode(',',$companytpl_config[$key]['groupid']);
				if(in_array($groups,$ids)) $checked = 'checked';
				$arrgroupid_used .= ' <input type="checkbox" name="group[]" value="'.$groups.'" '.$checked.'/>'.$v;
			}
			$templatelist = glob(PHPCMS_ROOT.'templates/'.TPL_NAME."/yp/com_*.html");
			foreach($templatelist AS $v)
			{
				if(preg_match('/com_([a-zA-Z_-]+)-index/i', $v, $regs))
				{
					$tplname = $regs[1];
					$list_names[] = $tplname;
				}
			}
			
			include admin_tpl('template_add');
		}
		break;

	case 'manage':
		if($dosubmit)
		{
			$companytplnames = include PHPCMS_ROOT.'templates/'.TPL_NAME.'/yp/companytplnames.php';
			$companytpl_config = array();
			foreach($stylegroup AS $k=>$v)
			{
				$groupids = '';
				$groupid = 'group'.$k;
				$thumburl = 'thumb'.$k;
				$styleurl = 'style'.$k;
				$keys = $k;
				if(is_array($$groupid))
				{
					foreach($$groupid AS $g)
					{
						$groupids .=  $g.',';
					}
				}
				$putsdefaulttpl = 0;
				if($defaulttpl == $k) $putsdefaulttpl = 1;
				$companytpl_config[$keys]['tplname'] = $tplname[$k];
				$companytpl_config[$keys]['groupid'] = $groupids;
				$companytpl_config[$keys]['thumb'] = $$thumburl;
				$companytpl_config[$keys]['style'] = $$styleurl;
				$companytpl_config[$keys]['defaulttpl'] = $putsdefaulttpl;
				$companytpl_config[$keys]['filename'] = $companytplnames[$k]['filename'];	
			}
			cache_write('companytplnames.php', $companytpl_config,PHPCMS_ROOT.'templates/'.TPL_NAME.'/yp/');
			showmessage($LANG['template_update_complate'],$forward);
		}
		else
		{
			unset($GROUP[2],$GROUP[3]);
			$templatenames = include PHPCMS_ROOT.'templates/'.TPL_NAME.'/yp/name.inc.php';
			$companytpl_config = include PHPCMS_ROOT.'templates/'.TPL_NAME.'/yp/companytplnames.php';
			//print_r($companytpl_config);
			$list_names = $list_names2 = array();
			foreach($companytpl_config AS $k=>$value)
			{
				$list_names2[] = "com_$value[tplname]-index.html";
			}
			$temp = array();
			$string = '';
			$tmpgroupid = 0;
			$templatelist = glob(PHPCMS_ROOT.'templates/'.TPL_NAME."/yp/com_*.html");
			
			foreach($templatelist AS $v)
			{
				$list_names[] = basename($v);
			}
			//Array ( [0] => com_default-index.html [1] => com_xhtml-index.html ) 
			//$list_names = array_merge($list_names,$list_names2);
			foreach($companytpl_config AS $key=>$_v)
			{
				$checked = '';
				//preg_match('/com_([a-zA-Z_-]+)-index/i', $v, $regs);
				//$tplname = $regs[1];
				if(empty($v))
				{
					$tdstyle = "bgcolor='#D6E4D6'";
					$arrgroupid_browse = '1';
					$thumb = '';
				}
				else
				{
					if($companytpl_config[$tplname]['defaulttpl'])	$selected = "checked='checked'";
					$tdstyle = "class='align_c'";
					$arrgroupid_browse = $companytpl_config[$tplname]['groupid'];
				}
				if($_v['defaulttpl']) $checked = 'checked';
				$string .= "<tr align='center'>";
				$string .= "<td $tdstyle rowspan='3'><input type='radio' name='defaulttpl' $checked value='$key'></td>";
				$string .= "<td $tdstyle><B>$_v[filename]</B></td>";
				$string .= "<td $tdstyle>$_v[tplname]</td>";
				$string .= "<td $tdstyle>";
				$arrgroupid_used = '';
				foreach($GROUP AS $groups=>$v)
				{
					$checked = '';
					$ids = explode(',',$companytpl_config[$key]['groupid']);
					if(in_array($groups,$ids)) $checked = 'checked';
					$arrgroupid_used .= ' <input type="checkbox" name="group'.$key.'[]" value="'.$groups.'" '.$checked.'/>'.$v;
				}
				$string .= $arrgroupid_used;
				$string .= "<input type='hidden' name='stylegroup[$key]'><input type='hidden' name='tplname[$key]' value='$_v[tplname]'><input type='hidden' name='filename[$key]' value='$_v[tplname]'></td></tr>";
				$string .= "<tr><td $tdstyle onmouseover=\"ShowADPreview('<img src=$_v[thumb] border=0>');\" onmouseout=\"hideTooltip('dHTMLADPreview');\">预览</td><td colspan='3'>";
				$string .= " <input name='thumb$key' type='text' id='thumb$key' size='70' value='$_v[thumb]'>  <input type='button' value='上传缩略图' onclick=\"javascript:openwinx('?mod=phpcms&file=upload&uploadtext=thumb$key&type=thumb&width=600&height=300','upload_thumb','350','350')\">";
				$string .= "</td></tr>";
				$string .= "<tr><td $tdstyle>CSS 路径 -→</td><td colspan='3'>";
				$string .= "<font color='red'>".WEB_SKIN."</font> <input name='style$key' type='text' id='style$key' size='70' value='$_v[style]'>
				<input name='k$key' type='hidden' value='$key'>";
				$string .= "</td></tr>";
				$tmpgroupid++;
			}
			include admin_tpl('template');
		}
		break;
}
?>