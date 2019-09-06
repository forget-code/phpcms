<?php
class content_form
{
	var $modelid;
	var $fields;
	var $contentid;

    function __construct($modelid)
    {
		global $db;
		$this->db = &$db;
		$this->modelid = $modelid;
		$this->fields = cache_read($this->modelid.'_fields.inc.php', CACHE_MODEL_PATH);
    }

	function content_form($modelid)
	{
		$this->__construct($modelid);
	}

	function get($data = array())
	{
		global $_roleid,$_groupid;
		if(isset($data['contentid'])) $this->contentid = $data['contentid'];
		$info = array();
		$this->content_url = $data['url'];
		foreach($this->fields as $field=>$v)
		{
			if(defined('IN_ADMIN'))
			{
				if($v['iscore'] || check_in($_roleid, $v['unsetroleids']) || check_in($_groupid, $v['unsetgroupids'])) continue;
			}
			else
			{
				if($v['iscore'] || !$v['isadd'] || check_in($_roleid, $v['unsetroleids']) || check_in($_groupid, $v['unsetgroupids'])) continue;
			}
			$func = $v['formtype'];
			$value = isset($data[$field]) ? htmlspecialchars($data[$field], ENT_QUOTES) : '';
			$form = $this->$func($field, $value, $v);
			if($form !== false)
			{
				$star = $v['minlength'] || $v['pattern'] ? 1 : 0;
				$info[$field] = array('name'=>$v['name'], 'tips'=>$v['tips'], 'form'=>$form, 'star'=>$star);
			}
		}
		return $info;
	}
	function areaid($field, $value, $fieldinfo)
	{
		global $AREA;
		extract($fieldinfo);
		$js = "<script type=\"text/javascript\">
					function area_load(id)
					{
						$.get('load.php', { field: 'areaid', id: id, value: '".$field."' },
							  function(data){
								$('#load_$field').append(data);
							  });
					}
					function area_reload()
					{
						$('#load_$field').html('');
						area_load(0);
					}
					area_load(0);
			</script>";
		if($value)
		{
			$areaname = $AREA[$value]['name'];
			return "<input type=\"hidden\" name=\"info[$field]\" id=\"$field\" value=\"$value\">
			<span onclick=\"this.style.display='none';\$('#reselect_$field').show();\" style=\"cursor:pointer;\">$areaname <font color=\"red\">点击重选</font></span>
			<span id=\"reselect_$field\" style=\"display:none;\">
			<span id=\"load_$field\"></span> 
			<a href=\"javascript:area_reload();\">重选</a>
			</span>$js";
		}
		else
		{
			return "<input type=\"hidden\" name=\"info[$field]\" id=\"$field\" value=\"$value\">
			<span id=\"load_$field\"></span>
			<a href=\"javascript:area_reload();\">重选</a>$js";
		}
	}
	function author($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		$infos = cache_read('author.php');
		$data = '<select name="" onchange="$(\'#'.$field.'\').val(this.value)" style="width:75px"><option>常用作者</option>';
		foreach($infos as $v)
		{
			$data .= "<option value='{$v}'>{$v}</option>\n";
		}
		$data .= '</select>';
		if(defined('IN_ADMIN')) $data .= ' <a href="###" onclick="SelectAuthor();">更多&gt;&gt;</a>';
		return form::text('info['.$field.']', $field, $value, 'text', $size, $css, $formattribute).$data;
	}
	function box($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		if($boxtype == 'radio')
		{
			return form::radio($options, 'info['.$field.']', $field, $value, $cols, $css, $formattribute, $width);
		}
		elseif($boxtype == 'checkbox')
		{
			return form::checkbox($options, 'info['.$field.']', $field, $value, $cols, $css, $formattribute, $width);
		}
		elseif($boxtype == 'select')
		{
			return form::select($options, 'info['.$field.']', $field, $value, $size, $css, $formattribute);
		}
		elseif($boxtype == 'multiple')
		{
			return form::multiple($options, 'info['.$field.']', $field, $value, $size, $css, $formattribute);
		}
	}
	
	function catid($field, $value, $fieldinfo)
	{
		global $CATEGORY,$action,$M;
		if($M['changemode']) return form::select_category('yp', 0, 'catid', 'catid', '请选择所属分类', $value,'onchange="check_catid(this.value)"',2,1);
		extract($fieldinfo);
		$catname = $CATEGORY[$value]['catname'];
		if($value)
		{
			$second_catid = $CATEGORY[$value]['parentid'];
			$firest_catid = $CATEGORY[$second_catid]['parentid'];
			if($firest_catid && $second_catid)
			{
				$catid= $firest_catid;
				$second_option = "<option value='$second_catid' selected>".$CATEGORY[$second_catid]['catname']."</option>";
				$third_option = "<option value='$value' selected>".$CATEGORY[$value]['catname']."</option>";
			}
			elseif($second_catid)
			{
				$catid= $second_catid;
				$second_option = "<option value='$second_catid' selected>".$CATEGORY[$value]['catname']."</option>";
			}
			else
			{
				$catid= $value;
			}
			
		}
		$categorys = '';
		$categorys = '<select name="'.$field.'" id="'.$field.'" onchange="change_f_'.$field.'(this.value)" size="8" style="width:195px;">';
		
		foreach($CATEGORY AS $k=>$v)
		{
			$selected = '';
			if($v['parentid']) continue;
			if($catid == $k) $selected = 'selected';
			$categorys .= "<option value='$k' $selected>$v[catname]</option>";
		}
		$categorys .= '</select>';
		$hava_checked = $value ? 1 : 0;
		$categorys .= ' <select name="secondcatid" size="8" style="width: 195px;" id="secondcatid"  onchange="change_s_'.$field.'(this.value);">'.$second_option.'</select> <select id="thirdcatid" name="thirdcatid" size="8" style="width:195px;" onchange="change_t_'.$field.'(this.value);">'.$third_option.'</select><input type="hidden" id="hava_checked" value="'.$hava_checked.'">';
		return $categorys;
	}
	function copyfrom($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		$infos = cache_read('copyfrom.php');
		$data = '<select name="select_copyfrom" onchange="$(\'#'.$field.'\').val(this.value)" style="width:75px"><option>常用来源</option>';
		foreach($infos as $info)
		{
			$data .= "<option value='{$info[name]}|{$info[url]}'>{$info[name]}</option>\n";
		}
		$data .= '</select>';
		if(defined('IN_ADMIN')) $data .= ' <a href="###" onclick="SelectCopyfrom();">更多&gt;&gt;</a>';
		return form::text('info['.$field.']', $field, $value, $type, $size, $css, $formattribute).$data;
	}
	function datetime($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if(!$value)
		{
			if($defaulttype == 0)
			{
				$value = '';
			}
			elseif($defaulttype == 1)
			{
				$df = $dateformat == 'datetime' ? 'Y-m-d H:i:s' : 'Y-m-d';
				$value = date($df, TIME);
			}
			else
			{
				$value = $defaultvalue;
			}
		}
		if(substr($value, 0, 10) == '0000-00-00') $value = '';
		$isdatetime = $dateformat == 'datetime' ? 1 : 0;
		$str = form::date("info[$field]", $value, $isdatetime);
		return $str;
	}
	function downfile($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		return form::downfile('info['.$field.']', $field, $value, $size, $mode, $css, $formattribute);
	}
	function downfiles($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		$string = "<textarea name='info[$field]' cols='70' rows='6' id='$field' $formattribute>".$value."</textarea>";
		if(defined('IN_ADMIN'))
		{
			$string .= "<iframe id='uploads' name='uploads' src='?mod=phpcms&file=downfiles&uploadtext={$id}' border='0' vspace='0' hspace='0' marginwidth='0' marginheight='0' framespacing='0' frameborder='0' scrolling='no' width='100%' height='50'></iframe>";
		}
		return $string;
	}
	function editor($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		if($this->contentid && $this->fields[$field]['storage'] == 'file') $value = content_get($this->contentid, $field);
		$data = "<textarea name=\"info[$field]\" id=\"$field\" style=\"display:none\">$value</textarea>\n";
		return $data.form::editor($field, $toolbar, $width, $height,0);
	}
	function file($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		$data = '<input type="hidden" name="info['.$field.']" value="'.$value.'"/>';
		$data .= form::file($field, $field, $size, $css, $formattribute);
		if($value) $data .= " <a href='$value' title='$value'>查看文件</a>";
		return $data;
	}
	function groupid($field, $value, $fieldinfo)
	{
	    global $priv_group;
		extract($fieldinfo);
		$groupids = '';
		if($value && $this->contentid) 
		{
			$groupids = $priv_group->get_groupid('contentid', $this->contentid, $priv);
			$groupids = implode(',', $groupids);
		}
		return form::select_group('info['.$field.']', $field, $groupids, $cols, $width);
	}
	function image($field, $value, $fieldinfo)
	{
		global $catid,$PHPCMS;
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		$data = $isselectimage ? " <input type='button' value='浏览...' style='cursor:pointer;' onclick=\"file_select('$field', $catid, 1)\">" : '';
		$getimg = $get_img ? '<input type="checkbox" name="info[getpictothumb]" value="1" checked /> 保存文章第一张图片为缩略图' : '';
		if(defined('IN_ADMIN'))
		{
			return "<input type=\"text\" name=\"info[$field]\" id=\"$field\" value=\"$value\" size=\"$size\" class=\"$css\" $formattribute/> <input type=\"hidden\" name=\"{$field}_aid\" value=\"0\"> <input type=\"button\" name=\"{$field}_upimage\" id=\"{$field}_upimage\" value=\"上传图片\" style=\"width:60px\" onclick=\"javascript:openwinx('?mod=phpcms&file=upload_field&uploadtext={$field}&modelid={$modelid}&fieldid={$fieldid}','upload','450','350')\"/> $data <input name=\"cutpic\" type=\"button\" id=\"cutpic\" value=\"裁剪图片\" onclick=\"CutPic('$field','$PHPCMS[siteurl]')\"/>{$getimg}";
		}
		else
		{
			return "<input type=\"text\" name=\"info[$field]\" id=\"$field\" value=\"$value\" size=\"$size\" class=\"$css\" $formattribute/> <input type=\"hidden\" name=\"{$field}_aid\" value=\"0\"> <input type=\"button\" name=\"{$field}_upimage\" id=\"{$field}_upimage\" value=\"上传图片\" style=\"width:60px\" onclick=\"javascript:openwinx('".PHPCMS_PATH."upload_field.php?uploadtext={$field}&modelid={$modelid}&fieldid={$fieldid}','upload','450','350')\"/> <input name=\"cutpic\" type=\"button\" id=\"cutpic\" value=\"裁剪图片\" onclick=\"CutPic('$field','$PHPCMS[siteurl]')\"/>";
		}
	}
	function images($field, $value, $fieldinfo)
	{
	    global $attachment;
		extract($fieldinfo);
		$data = '';
		$data .= "<div id='FilePreview' style='Z-INDEX: 1000; LEFT: 0px; WIDTH: 10px; POSITION: absolute; TOP: 0px; HEIGHT: 10px; display: none;'></div>\n";
		if(!$value)
		{
		    $value = $defaultvalue;
		}
		else
		{
            $data .= "<div id='file_uploaded'>\n";
			$attachments = $attachment->listinfo("`contentid`=$this->contentid AND `field`='$field'", '`aid`,`filename`,`filepath`,`description`,`listorder`,`isthumb`');
			foreach($attachments as $k=>$v)
			{
			    $aid = $v['aid'];
			    $url = $v['isthumb'] ? $attachment->get_thumb($v['filepath']) : $v['filepath'];
			    $data .= "<div id='file_uploaded_$aid'><span style='width:30px'><input type='checkbox' name='{$field}_delete[]' value='$aid' title='删除'></span><span style='width:40px'><input type='text' name='{$field}_listorder[$aid]' value='$v[listorder]' size='3' title='排序'></span> <a href='###' onMouseOut='javascript:FilePreview(\"$url\", 0);' onMouseOver='javascript:FilePreview(\"$url\", 1);'>$v[filename] ".($v['description'] ? '('.$v['description'].')' : '')."</a></div>\n";
			}
		    $data .= "</div>\n";
		}
		$addmorepic = '';
		if(defined('IN_ADMIN')) $addmorepic = '<input type="button" onclick="AddMorePic(\'addmore_'.$field.'\');" value="批量添加">';
		$data .= "<div id='addmore_$field'></div>";
		$data .= '<input type="hidden" name="info['.$field.']" value="'.$value.'"/>';
        $data .= '<div id="file_div">';
		$data .= '<div id="file_1"><input type="file" name="'.$field.'[1]" size="20" onchange="javascript:AddInputFile(\''.$field.'\')"> <input type="text" name="'.$field.'_description[1]" size="20" title="名称"> <input type="button" value="删除" name="Del" onClick="DelInputFile(1);"> 
		'.$addmorepic.'</div>';
		$data .= '</div>';
		$_SESSION['field_images'] = 1;
		return $data;
	}
	function islink($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if($value)
		{
			$linkurl = $this->content_url;
			$disabled = '';
			$checked = 'checked';
		}
		else
		{
			$value = $defaultvalue;
			$disabled = 'disabled';	
			$checked = '';
		}
		$strings = '<input type="hidden" name="info['.$field.']" value="99"><input type="text" name="info[linkurl]" id="linkurl" value="'.$linkurl.'" size="50" maxlength="255" '.$disabled.'> <input name="info['.$field.']" type="checkbox" id="islink" value="1" onclick="ruselinkurl();" '.$checked.'> <font color="#FF0000">转向链接</font><br/><font color="#FF0000">如果使用转向链接则点击标题就直接跳转而内容设置无效</font>';
		return $strings;
	}
	function keyword($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		$infos = cache_read('keyword.php');
		$data = "<input type=\"button\" value=\"自动获取\" onclick=\"$.post('api/get_keywords.php?number=3&sid='+Math.random()*5, {data:$('#title').val()}, function(data){ $('#keywords').val(data); })\">";
		return form::text('info['.$field.']', $field, $value, $type, $size, $css, $formattribute).$data;
	}
	function number($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		return form::text('info['.$field.']', $field, $value, 'text', 10, $css, $formattribute, $minlength, $maxlength, $pattern, $errortips);
	}
	function posid($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		$result = $this->db->select("SELECT `posid` FROM `".DB_PRE."content_position` WHERE `contentid`='$this->contentid'", 'posid');
		$posids = implode(',', array_keys($result));
		return form::select_pos('info['.$field.']', $field, $posids, $cols, $width);
	}
	function style($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		return form::style("info[$field]", $value);
	}
	function template($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		return form::select_template('phpcms','info['.$field.']', $field, $value, '', 'show');
	}
	function text($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		$type = $ispassword ? 'password' : 'text';
		return form::text('info['.$field.']', $field, $value, $type, $size, $css, $formattribute, $minlength, $maxlength, $pattern, $errortips);
	}
	function textarea($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		return form::textarea('info['.$field.']', $field, $value, $rows, $cols, $css, $formattribute);
	}
	function title($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		return form::text('info['.$field.']', $field, $value, 'text', $size, $css, $formattribute, $minlength, $maxlength);
	}
	function typeid($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		return form::select_type('yp', 'info['.$field.']', $field, '请选择', $value, '');
	}
}
?>