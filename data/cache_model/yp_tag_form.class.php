<?php
class yp_tag_form
{
	var $modelid;
	var $fields;
	var $contentid;

    function __construct($modelid)
    {
		global $db;
		$this->db = &$db;
		$this->modelid = $modelid;
		$this->fields = $this->modelid ? cache_read($this->modelid.'_fields.inc.php', CACHE_MODEL_PATH) : cache_read('common_fields.inc.php', 'fields/');
    }

	function yp_tag_form($modelid)
	{
		$this->__construct($modelid);
	}

	function get($data = array())
	{
		$info = array();
		foreach($this->fields as $field=>$v)
		{
			if(!$v['iswhere']) continue;
			$func = $v['formtype'];
			$value = isset($data[$field]) ? $data[$field] : '';
			$form = $this->$func($field, $value, $v);
			$info[$field] = array('name'=>$v['name'], 'tips'=>$v['tips'], 'form'=>$form, 'star'=>$v['minlength']);
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
						\$.get('load.php', { field: 'areaid', id: id },
							  function(data){
								\$('#load_$field').append(data);
							  });
					}
					function area_reload()
					{
						\$('#load_$field').html('');
						area_load(0);
					}
					area_load(0);
			</script>";
		if($value)
		{
			$areaname = $AREA[$value]['name'];
			return "<input type=\"text\" name=\"info[$field]\" id=\"$field\" value=\"$value\" size=\"10\">
			<span onclick=\"this.style.display='none';\$('reselect_$field').style.display='';\" style=\"cursor:pointer;\">$areaname <font color=\"red\">点击重选</font></span>
			<span id=\"reselect_$field\" style=\"display:none;\">
			<span id=\"load_$field\"></span> 
			<a href=\"javascript:area_reload();\">重选</a>
			</span>$js";
		}
		else
		{
			return "<input type=\"text\" name=\"info[$field]\" id=\"$field\" value=\"$value\" size=\"10\">
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
		foreach($infos as $info)
		{
			$data .= "<option value='{$info[name]}'>{$info[name]}</option>\n";
		}
		$data .= '</select> <a href="###" onclick="SelectAuthor();">更多&gt;&gt;</a>';
		return form::text('info['.$field.']', $field, $value, 'text', $size, $css, $formattribute).$data;
	}
	function box($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
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
		global $CATEGORY;
		extract($fieldinfo);
		$js = "<script type=\"text/javascript\">
					function category_load(id)
					{
						\$.get('load.php', { field: 'catid', id: id },
							  function(data){
								\$('#load_$field').append(data);
							  });
					}
					function category_reload()
					{
						\$('#load_$field').html('');
						category_load(0);
					}
					category_load(0);
			</script>";
		if($value)
		{
			$catname = $CATEGORY[$value]['catname'];
			return "<input type=\"text\" name=\"info[$field]\" id=\"$field\" value=\"$value\" size=\"10\">
			<span onclick=\"this.style.display='none';\$('#reselect_$field').show();\" style=\"cursor:pointer;\">$catname <font color=\"red\">点击重选</font></span>
			<span id=\"reselect_$field\" style=\"display:none;\">
			<span id=\"load_$field\"></span> 
			<a href=\"javascript:category_reload();\">重选</a>
			</span>$js";
		}
		else
		{
			return "<input type=\"text\" name=\"info[$field]\" id=\"$field\" value=\"$value\" size=\"10\">
			<span id=\"load_$field\"></span>
			<a href=\"javascript:category_reload();\">重选</a>$js";
		}
    }
	function datetime($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		$isdatetime = $dateformat == 'datetime' ? 1 : 0;
		$str = form::date("info[$field]", $value, $isdatetime);
		return $str;
    }
	function image($field, $value, $fieldinfo)
	{
		$checked = $value ? 'checked': '';
		return "<input type=\"checkbox\" name=\"info[$field]\" id=\"$field\" value=\"1\" $checked> 是";
	}
	function keyword($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		$infos = cache_read('keyword.php');
		$data = '<select name="select_keyword" onchange="if($(\'#'.$field.'\').val()){$(\'#'.$field.'\').val(this.value);}else{$(\'#'.$field.'\').val(this.value);}" style="width:85px"><option>常用关键词</option>';
		foreach($infos as $info)
		{
			$data .= "<option value='{$info}'>{$info}</option>\n";
		}
		$data .= '</select> <a href="###" onclick="SelectKeyword();">更多&gt;&gt;</a>';
		return form::text('info['.$field.']', $field, $value, $type, 20, $css, $formattribute).$data;
	}
	function number($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		return form::text('info['.$field.']', $field, $value, 'text', 10, $css, $formattribute);
	}
	function posid($field, $value, $fieldinfo)
	{
	    $POS = cache_read('position.php');
		extract($fieldinfo);
		$POS[0] = '请选择';
		ksort($POS);
		return form::select($POS, 'info['.$field.']', $field, $value);
	}	function text($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		return form::text('info['.$field.']', $field, $value, 'text', 10, $css, $formattribute);
	}
	function textarea($field, $value, $fieldinfo)
	{
		extract($fieldinfo);
		if(!$value) $value = $defaultvalue;
		return form::textarea('info['.$field.']', $field, $value, $rows, $cols, $css, $formattribute);
	}
	function typeid($field, $value, $fieldinfo)
	{
		return "<input type=\"text\" name=\"info[$field]\" id=\"$field\" value=\"$value\" size=\"10\"> ".form::select_type('phpcms', 'select_'.$field, 'select_'.$field, '请选择', $value, 'onchange="$(\'#'.$field.'\').val(this.value)"');
	}
	function userid($field, $value, $fieldinfo)
	{
		return "<input type=\"text\" name=\"info[$field]\" id=\"$field\" value=\"$value\" size=\"10\">";
	}
}
?>