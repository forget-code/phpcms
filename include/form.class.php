<?php
class form
{
	function editor($textareaid = 'content', $toolbar = 'standard', $width = '100%', $height = 400, $isshowext = 1)
	{
		global $PHPCMS, $mod, $file, $catid, $_userid;
		$str = "<script type=\"text/javascript\" src=\"fckeditor/fckeditor.js\"></script>\n<script language=\"JavaScript\" type=\"text/JavaScript\">var SiteUrl = \"".SITE_URL."\"; var Module = \"".$mod."\"; var sBasePath = \"".SITE_URL."\" + 'fckeditor/'; var oFCKeditor = new FCKeditor( '".$textareaid."' ) ; oFCKeditor.BasePath = sBasePath ; oFCKeditor.Height = '".$height."'; oFCKeditor.Width	= '".$width."' ; oFCKeditor.ToolbarSet	= '".$toolbar."' ;oFCKeditor.ReplaceTextarea();";
		if($_userid && $isshowext)
		{
			$str .= "editor_data_id += '".$textareaid."|';if(typeof(MM_time)=='undefined'){MM_time = setInterval(update_editor_data,".($PHPCMS['editor_interval_data']*1000).");}";
		}
		$str .= "</script>";
		if($isshowext)
		{
			$str .= "<div style='width:$width;text-align:left'>";
			if($_userid)
			{
				$str .= "<span style='float:right;height:22px'>";
				if(defined('IN_ADMIN') && $mod == 'phpcms' && $file == 'content')
				{
					$str .= "<span style='padding:1px;margin-right:10px;background-color: #fefe;border:#006699 solid 1px;'><a href='javascript:insert_page(\"$textareaid\")' title='在光标处插入分页标记'>分页</a></span>";
					$str .= "<span style='padding:1px;margin-right:10px;background-color: #fefe;border:#006699 solid 1px;'><a href='javascript:insert_page_title(\"$textareaid\")' title='在光标处插入带子标题的分页标记'>子标题</a></span>";
				}
				$str .= "<span style='padding:1px;margin-right:10px;background-color: #fefe;border:#006699 solid 1px;'><div id='page_title_div' style='background-color: #fff;border:#006699 solid 1px;position:absolute;z-index:10;padding:1px;display:none;right:80px;'>
				<table cellpadding='0' cellspacing='1' border='0'><tr><td >请输入子标题名称：<span id='msg_page_title_value'></span></td><td><span style='cursor:pointer;float:right;' onclick='javascript:$(\"#page_title_div\").hide()'>×</span></td>
				<tr><td colspan='2'><input name='page_title_value' id='page_title_value' value='' size='40'>&nbsp;<input type='button' value=' 确定 ' onclick=insert_page_title(\"$textareaid\",1)></td></tr>
				</table></span></div>";

				$str .= "<span style='padding:1px;margin-right:10px;background-color: #fefe;border:#006699 solid 1px;'><div id='".$textareaid."_div' style='background-color: #fff;border:#006699 solid 1px;position:absolute;z-index:10;padding:5px;display:none;right:60px;'>
						<table cellpadding='0' cellspacing='1' border='0'><tr><td>		
						<div>";
				for($i=1; $i<=$PHPCMS['editor_max_data_hour']; $i++)
				{
					$bold = $i==1 ? "font-weight: bold;" : '';
					$str .= "<a href='javascript:get_editor_data_list(\"".$textareaid."\",$i)' class='hour' style='border:#cccccc solid 1px;margin:2px;padding-left:4px;padding-right:4px;$bold' title='$i 小时'>$i</a>";	
				}
				$str .= "</div></td><td><span style='cursor:pointer;' onclick='javascript:$(\"#".$textareaid."_div\").hide()'>×</span></td></tr></table><ul id='".$textareaid."_lists' style='height:200px;width:140px;overflow:auto;'></ul></div><a href='javascript:get_editor_data_list(\"".$textareaid."\",1)' title='点击恢复数据'>恢复数据</a></span></span>";
			}
			$str .= "<img src=\"".SITE_URL."images/editor_add.jpg\" title='增加编辑器高度' tag='1' fck=\"".$textareaid."\"/>&nbsp;  <img src=\"".SITE_URL."images/editor_diff.jpg\" title='减少编辑器高度' tag='0' fck=\"".$textareaid."\"/></div>";
		}
		$str .= "<div id=\"MM_file_list_".$textareaid."\" style=\"text-align:left\"></div><div id='FilePreview' style='Z-INDEX: 1000; LEFT: 0px; WIDTH: 10px; POSITION: absolute; TOP: 0px; HEIGHT: 10px; display: none;'></div><div id='".$textareaid."_save'></div>";
		return $str;
	}

	function date($name, $value = '', $isdatetime = 0)
	{
		if($value == '0000-00-00 00:00:00') $value = '';
		$id = preg_match("/\[(.*)\]/", $name, $m) ? $m[1] : $name;
		if($isdatetime)
		{
			$size = 21;
			$format = '%Y-%m-%d %H:%M:%S';
			$showsTime = 'true';
		}
		else
		{
			$size = 10;
			$format = '%Y-%m-%d';
			$showsTime = 'false';
		}
		$str = '';
		if(!defined('CALENDAR_INIT'))
		{
			define('CALENDAR_INIT', 1);
			$str .= '<link rel="stylesheet" type="text/css" href="images/js/calendar/calendar-blue.css"/>
			        <script type="text/javascript" src="images/js/calendar/calendar.js"></script>';
		}
		$str .= '<input type="text" name="'.$name.'" id="'.$id.'" value="'.$value.'" size="'.$size.'" readonly>&nbsp;';
		$str .= '<script language="javascript" type="text/javascript">
					date = new Date();document.getElementById ("'.$id.'").value="'.$value.'";
					Calendar.setup({
						inputField     :    "'.$id.'",
						ifFormat       :    "'.$format.'",
						showsTime      :    '.$showsTime.',
						timeFormat     :    "24"
					});
				 </script>';
		return $str;
	}

	function checkcode($name = 'checkcode', $size = 4, $extra = '')
	{
		return '<input name="'.$name.'" id="'.$name.'" type="text" size="'.$size.'" '.$extra.' style="ime-mode:disabled;"> <img src="checkcode.php" id="checkcode" onclick="this.src=\'checkcode.php?id=\'+Math.random()*5;" style="cursor:pointer;" alt="验证码,看不清楚?请点击刷新验证码" align="absmiddle"/>';
	}

	function style($name = 'style', $style = '')
	{
		global $styleid, $LANG;
		if(!$styleid) $styleid = 1; else $styleid++;
		$color = $strong = '';
		if($style)
		{
			list($color, $b) = explode(' ', $style);
		}
		$styleform = "<option value=\"\">".$LANG['color']."</option>\n";
		for($i=1; $i<=15; $i++)
		{
			$styleform .= "<option value=\"c".$i."\" ".($color == 'c'.$i ? "selected=\"selected\"" : "")." class=\"bg".$i."\"></option>\n";
		}
		$styleform = "<select name=\"style_color$styleid\" id=\"style_color$styleid\" onchange=\"document.all.style_id$styleid.value=document.all.style_color$styleid.value;if(document.all.style_strong$styleid.checked)document.all.style_id$styleid.value += ' '+document.all.style_strong$styleid.value;\">\n".$styleform."</select>\n";
		$styleform .= " <input type=\"checkbox\" name=\"style_strong$styleid\" id=\"style_strong$styleid\" value=\"b\" ".($b == 'b' ? "checked=\"checked\"" : "")." onclick=\"document.all.style_id$styleid.value=document.all.style_color$styleid.value;if(document.all.style_strong$styleid.checked)document.all.style_id$styleid.value += ' '+document.all.style_strong$styleid.value;\"> ".$LANG['bold'];
		$styleform .= "<input type=\"hidden\" name=\"".$name."\" id=\"style_id$styleid\" value=\"".$style."\">";
		return $styleform;
	}

	function text($name, $id = '', $value = '', $type = 'text', $size = 50, $class = '', $ext = '', $minlength = '', $maxlength = '', $pattern = '', $errortips = '')
	{
		if(!$id) $id = $name;
		$checkthis = '';
		$showerrortips = "字符长度必须为".$minlength."到".$maxlength."位";
		if($pattern)
		{
			$pattern = 'regexp="'.substr($pattern,1,-1).'"';
		}
		$require = $minlength ? 'true' : 'false';
		if($pattern && ($minlength || $maxlength))
		{
			$string_datatype = substr($string_datatype, 1);
			$checkthis = "require=\"$require\" $pattern datatype=\"limit|custom\" min=\"$minlength\" max=\"$maxlength\" msg='$showerrortips|$errortips'";
		}
		elseif($pattern)
		{
			$checkthis = "require=\"$require\" $pattern datatype=\"custom\" msg='$errortips'";
		}
		elseif($minlength || $maxlength)
		{
			$checkthis = "require=\"$require\" datatype=\"limit\" min=\"$minlength\" max=\"$maxlength\" msg='$showerrortips'";
		}
		return "<input type=\"$type\" name=\"$name\" id=\"$id\" value=\"$value\" size=\"$size\" class=\"$class\" $checkthis $ext/> ";
	}

	function textarea($name, $id = '', $value = '', $rows = 10, $cols = 50, $class = '', $ext = '')
	{
		if(!$id) $id = $name;
		return "<textarea name=\"$name\" id=\"$id\" rows=\"$rows\" cols=\"$cols\" class=\"$class\" $ext>$value</textarea>";
	}

	function select($options, $name, $id = '', $value = '', $size = 1, $class = '', $ext = '')
	{
		if(!$id) $id = $name;
		if(!is_array($options)) $options = form::_option($options);
		if($size >= 1) $size = " size=\"$size\"";
		if($class) $class = " class=\"$class\"";
		$data .= "<select name=\"$name\" id=\"$id\" $size $class $ext>";
		foreach($options as $k=>$v)
		{
			$selected = $k == $value ? 'selected' : '';
			$data .= "<option value=\"$k\" $selected>$v</option>\n";
		}
		$data .= '</select>';
		return $data;
	}

	function multiple($options, $name, $id = '', $value = '', $size = 3, $class = '', $ext = '')
	{
		if(!$id) $id = $name;
		if(!is_array($options)) $options = form::_option($options);
		$size = max(intval($size), 3);
		if($class) $class = " class=\"$class\"";
		$value = strpos($value, ',') ? explode(',', $value) : array($value);
		$data .= "<select name=\"$name\" id=\"$id\" multiple=\"multiple\" size=\"$size\" $class $ext>";
		foreach($options as $k=>$v)
		{
			$selected = in_array($k, $value) ? 'selected' : '';
			$data .= "<option value=\"$k\" $selected>$v</option>\n";
		}
		$data .= '</select>';
		return $data;
	}

	function checkbox($options, $name, $id = '', $value = '', $cols = 5, $class = '', $ext = '', $width = 100)
	{
		if(!$options) return '';
		if(!$id) $id = $name;
		if(!is_array($options)) $options = form::_option($options);
		$i = 1;
		$data = '<input type="hidden" name="'.$name.'" value="-99">';
		if($class) $class = " class=\"$class\"";
		if($value != '') $value = strpos($value, ',') ? explode(',', $value) : array($value);
		foreach($options as $k=>$v)
		{
			$checked = ($value && in_array($k, $value)) ? 'checked' : '';
			$data .= "<span style=\"width:{$width}px\"><input type=\"checkbox\" boxid=\"{$id}\" name=\"{$name}[]\" id=\"{$id}\" value=\"{$k}\" style=\"border:0px\" $class {$ext} {$checked}/> {$v}</span>\n ";
			if($i%$cols == 0) $data .= "<br />\n";
			$i++;
		}
		return $data;
	}

	function radio($options, $name, $id = '', $value = '', $cols = 5, $class = '', $ext = '', $width = 100)
	{
		if(!$id) $id = $name;
		if(!is_array($options)) $options = form::_option($options);
		$i = 1;
		$data = '';
		if($class) $class = " class=\"$class\"";
		foreach($options as $k=>$v)
		{
			$checked = $k == $value ? 'checked' : '';
			$data .= "<span style=\"width:{$width}px\"><input type=\"radio\" name=\"{$name}\" id=\"{$id}\" value=\"{$k}\" style=\"border:0px\" $class {$ext} {$checked}/> {$v}</span> ";
			if($i%$cols == 0) $data .= "<br />\n";
			$i++;
		}
		return $data;
	}

	function _option($options, $s1 = "\n", $s2 = '|')
	{
		$options = explode($s1, $options);
		foreach($options as $option)
		{
			if(strpos($option, $s2))
			{
				list($name, $value) = explode($s2, trim($option));
			}
			else
			{
				$name = $value = trim($option);
			}
			$os[$value] = $name;
		}
		return $os;
	}

	function image($name, $id = '', $value = '', $size = 50, $class = '', $ext = '', $modelid = 0, $fieldid = 0)
	{
		if(!$id) $id = $name;
		return "<input type=\"text\" name=\"$name\" id=\"$id\" value=\"$value\" size=\"$size\" class=\"$class\" $ext/> <input type=\"hidden\" name=\"{$id}_aid\" value=\"0\"> <input type=\"button\" name=\"{$name}_upimage\" id=\"{$id}_upimage\" value=\"上传图片\" style=\"width:60px\" onclick=\"javascript:openwinx('?mod=phpcms&file=upload_field&uploadtext={$id}&modelid={$modelid}&fieldid={$fieldid}','upload','350','350')\"/>";
	}

	function file($name, $id = '', $size = 50, $class = '', $ext = '')
	{
		if(!$id) $id = $name;
		return "<input type=\"file\" name=\"$name\" id=\"$id\" size=\"$size\" class=\"$class\" $ext/> ";
	}

	function downfile($name, $id = '', $value = '', $size = 50, $mode, $class = '', $ext = '')
	{
		if(!$id) $id = $name;
		$mode = "&mode=".$mode;
		if(defined('IN_ADMIN'))
		{
			return "<input type=\"text\" name=\"$name\" id=\"$id\" value=\"$value\" size=\"$size\" class=\"$class\" $ext/> <input type=\"hidden\" name=\"{$id}_aid\" value=\"0\"> <input type=\"button\" name=\"{$name}_upfile\" id=\"{$id}_upfile\" value=\"上传文件\" style=\"width:60px\" onclick=\"javascript:openwinx('?mod=phpcms&file=upload&uploadtext={$id}{$mode}','upload','390','180')\"/>";
		}
		else
		{
			return true;
		}
	}

	function upload_image($name, $id = '', $value = '', $size = 50, $class = '', $property = '')
	{
		if(!$id) $id = $name;
		return "<input type=\"text\" name=\"$name\" id=\"$id\" value=\"$value\" size=\"$size\" class=\"$class\" $property/> <input type=\"button\" name=\"{$name}_upimage\" id=\"{$id}_upimage\" value=\"上传图片\" style=\"width:60px\" onclick=\"javascript:openwinx('?mod=phpcms&file=upload&uploadtext={$id}','upload','380','350')\"/>";
	}

	function select_template($module, $name, $id = '', $value = '', $property = '', $pre = '')
	{
		if(!$id) $id = $name;
		$templatedir = TPL_ROOT.TPL_NAME.'/'.$module.'/';
		$files = array_map('basename', glob($templatedir.$pre.'*.html'));
		$names = cache_read('name.inc.php', $templatedir);
		$templates = array(''=>'请选择');
		foreach($files as $file)
		{
			$key = substr($file, 0, -5);
			$templates[$key] = isset($names[$file]) ? $names[$file].'('.$file.')' : $file;
		}
		ksort($templates);
		return form::select($templates, $name, $id, $value, $property);
	}

	function select_file($name, $id = '', $value = '', $size = 30, $catid = 0, $isimage = 0)
	{
		if(!$id) $id = $name;
		return "<input type='text' name='$name' id='$id' value='$value' size='$size' /> <input type='button' value='浏览...' style='cursor:pointer;' onclick=\"file_select('$id', $catid, $isimage)\">";
	}

	function select_module($name = 'module', $id ='', $alt = '', $value = '', $property = '')
	{
		global $MODULE;
		if($alt) $arrmodule = array('0'=>$alt);
		foreach($MODULE as $k=>$v)
		{
			$arrmodule[$k] = $v['name'];
		}
		if(!$id) $id = $name;
		return form::select($arrmodule, $name, $id, $value, 1, '', $property);
	}

	function select_model($name = 'modelid', $id ='', $alt = '', $modelid = '', $property = '')
	{
		global $MODEL;
		if($alt) $arrmodel = array('0'=>$alt);
		foreach($MODEL as $k=>$v)
		{
			if($v['modeltype'] > 0) continue;
			$arrmodel[$k] = $v['name'];
		}
		if(!$id) $id = $name;
		return form::select($arrmodel, $name, $id, $modelid, 1, '', $property);
	}

	function select_member_model($name = 'modelid', $id = '', $alt = '', $modelid = '', $property = '')
	{
		global $MODEL;
		if($alt) $arrmodel = array('0'=>$alt);
		foreach($MODEL as $k=>$v)
		{
			if($v['modeltype'] == '2')
			{
				$arrmodel[$k] = $v['name'];
			}
		}
		if(!$id) $id = $name;
		return form::select($arrmodel, $name, $id, $modelid, 1, '', $property);
	}

	function select_category($module = 'phpcms', $parentid = 0, $name = 'catid', $id ='', $alt = '', $catid = 0, $property = '', $type = 0, $optgroup = 0)
	{
		global $tree, $CATEGORY;
		if(!is_object($tree))
		{
			require_once 'tree.class.php';
			$tree = new tree;
		}
		if(!$id) $id = $name;
		if($optgroup) $optgroup_str = "<optgroup label='\$name'></optgroup>";
		$data = "<select name='$name' id='$id' $property>\n<option value='0'>$alt</option>\n";
		if(is_array($CATEGORY))
		{
			$categorys = array();
			foreach($CATEGORY as $id=>$cat)
			{
				if(($type == 2 && $cat['type'] ==2) || ($type == 1 && $cat['type'])) continue;
				if($cat['module'] == $module) $categorys[$id] = array('id'=>$id, 'parentid'=>$cat['parentid'], 'name'=>$cat['catname']);
			}
			$tree->tree($categorys);
			$data .= $tree->get_tree($parentid, "<option value='\$id' \$selected>\$spacer\$name</option>\n", $catid, '' , $optgroup_str);
		}
		$data .= '</select>';
		return $data;
	}

	function select_pos($name = 'posid', $id ='', $posids = '', $cols = 1, $width = 100)
	{
		global $db,$priv_role, $POS;
		if(!$id) $id = $name;
		$pos = array();
		foreach($POS as $posid=>$posname)
		{
			if($priv_role->check('posid', $posid)) $pos[$posid] = str_cut($posname, 16, '');
		}
		return form::checkbox($pos, $name, $id, $posids, $cols, '', '', $width);
	}

	function select_group($name = 'groupid', $id ='', $groupids = '', $cols = 1, $width = 100)
	{
		global $db, $GROUP;
		if(!$id) $id = $name;
		return form::checkbox($GROUP, $name, $id, $groupids, $cols, '', '', $width);
	}

	function select_type($module = 'phpcms', $name = 'typeid', $id ='', $alt = '', $typeid = 0, $property = '')
	{
		$types = subtype($module);
		if(!$id) $id = $name;
		$data = "<select name='$name' id='$id' $property>\n<option value='0'>$alt</option>\n";
		foreach($types as $id=>$t)
		{
			$selected = $id == $typeid ? 'selected' : '';
			$data .= "<option value='$id' $selected>$t[name]</option>\n";
		}
		$data .= '</select>';
		return $data;
	}

	function select_area($name = 'areaid', $id ='', $alt = '', $parentid = 0, $areaid = 0, $property = '')
	{
		global $tree, $AREA;
		if(!is_object($tree))
		{
			require_once 'tree.class.php';
			$tree = new tree;
		}
		if(!$id) $id = $name;
		$data = "<select name='$name' id='$id' $property>\n<option value='0'>$alt</option>\n";
		if(is_array($AREA))
		{
			$areas = array();
			foreach($AREA as $id=>$a)
			{
				$areas[$id] = array('id'=>$id, 'parentid'=>$a['parentid'], 'name'=>$a['name']);
			}
			$tree->tree($areas);
			$data .= $tree->get_tree($parentid, "<option value='\$id' \$selected>\$spacer\$name</option>\n", $areaid);
		}
		$data .= '</select>';
		return $data;
	}

	function select_urlrule($module = 'phpcms', $file = 'category', $ishtml = 1, $name = 'urlruleid', $id ='', $urlruleid = 0, $property = '')
	{
		global $db;
		$urlrules = array();
		$result = $db->query("SELECT `urlruleid`,`example` FROM `".DB_PRE."urlrule` WHERE `module`='$module' AND `file`='$file' AND `ishtml`='$ishtml' ORDER BY `urlruleid`");
		while($r = $db->fetch_array($result))
		{
			$urlrules[$r['urlruleid']] = $r['example'];
		}
		$db->free_result($result);
		if(!$id) $id = $name;
		return form::select($urlrules, $name, $id, $urlruleid, 1, '', $property);
	}
}

?>